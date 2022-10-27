<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\CompanyAdditionalInfo;
use App\Entity\CompanyAddress;
use App\Entity\EmployeeSchedule;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    protected $faker;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $roles = ['ROLE_ADMIN', 'ROLE_EMPLOYEE', 'ROLE_OWNER'];

        $this->faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $company = new Company();
            $company->setName($this->faker->company);
            $manager->persist($company);
            for ($j = 0; $j < 10; $j++) {
                $user = new User();
                $user->setEmail($this->faker->email);
                $user->setPassword($this->hasher->hashPassword($user, '123456'));
                $user->setFirstname($this->faker->firstName);
                $user->setLastname($this->faker->lastName);
                if ($j === 0) {
                    $user->setRoles(['ROLE_OWNER']);
                } else {
                    $user->setRoles(['ROLE_EMPLOYEE']);
                }
                $user->setIsVerified(true);
                $user->setCompany($company);
                $manager->persist($user);
            }
            for ($j = 0; $j < random_int(1, 2); $j++) {
                $companyAddress = new CompanyAddress();
                $companyAddress->setCompany($company);
                $companyAddress->setCity($this->faker->city);
                $companyAddress->setStreet($this->faker->streetAddress);
                $companyAddress->setPostCode($this->faker->postcode);
                $companyAddress->setCountry($this->faker->country);
                $companyAddress->setBuildingNumber($this->faker->buildingNumber);
                $companyAddress->setCompany($company);
                $manager->persist($companyAddress);
            }
            for ($j = 0; $j < random_int(1, 2); $j++) {
                $companyAdditionalInfo = new CompanyAdditionalInfo();
                // $companyAdditionalInfo->setPhone($this->faker->phoneNumber);
                //add data randomly email, facebook, instagram, website
                if (random_int(0, 1) === 1) {
                    //set email  firstname lastname @ company name random domain
                    $companyAdditionalInfo->setEmail(
                        $user->getFullName() . '@' . $company->getName() . '.' . $this->faker->domainName
                    );
                }
                if (random_int(0, 1) === 1) {
                    //set facegoow by facebook.com/company name
                    $companyAdditionalInfo->setFacebook('https://facebook.com/' . $company->getName());
                }
                if (random_int(0, 1) === 1) {
                    $companyAdditionalInfo->setInstagram($this->faker->url);
                }
                if (random_int(0, 1) === 1) {
                    $companyAdditionalInfo->setWebsite(
                        'https://' .
                        $company->getName()
                        . '.' .
                        $this->faker->domainName
                    );
                }

                $companyAdditionalInfo->setCompany($company);
                $manager->persist($companyAdditionalInfo);
            }
            //to each company add  5 schedules for employees, set dayFrom
            // radomly from now to end as new weekend  and dayTo from now to end as new weekend
            for ($j = 0; $j < 5; $j++) {
                $employeeSchedule = new EmployeeSchedule();
                //set title as first name and last name user and random text

                $employeeSchedule->setTitle(
                    $user->getFirstname() . ' ' .
                    $user->getLastname() . ' ' .
                    $this->faker->text(5)
                );
                $employeeSchedule->setDayFrom($this->faker->dateTimeBetween('now', '+1 week'));

                $employeeSchedule->setTimeFrom($this->createRandomlyTime());
//set setTimeTo if setRepeatInfinity is false
                $employeeSchedule->setRepeatInfinity(random_int(0, 1));

                if ($employeeSchedule->isRepeatInfinity() === false) {
                    $employeeSchedule->setTimeTo($this->createRandomlyTime());
                    $employeeSchedule->setDayTo($this->faker->dateTimeBetween('now', '+1 week'));
                }
                //dd($repeatInfinity);
                $this->checkDayFromAndDayTo($employeeSchedule);
                $employeeSchedule->setUser($user);
                $manager->persist($employeeSchedule);
            }
        }

        $manager->flush();
    }

    /**
     * @throws Exception
     */
    private function createRandomlyTime(): \DateTime
    {
        $hours = random_int(0, 23);
        $minutes = random_int(0, 59);
        $seconds = random_int(0, 59);
        return new \DateTime($hours . ':' . $minutes . ':' . $seconds);
    }

    /**
     * @throws Exception
     */
    private function checkDayFromAndDayTo(EmployeeSchedule $employeeSchedule): void
    {
        if (!$employeeSchedule->getDayTo() || !$employeeSchedule->getTimeTo()) {
            return;
        }
        //$employeeSchedule->getDayFrom()->format('Y-m-d H:i:s') > $employeeSchedule->getDayTo()->format('Y-m-d H:i:s')
        if ($employeeSchedule->getDayFrom()->format('Y-m-d H:i:s') > $employeeSchedule->getDayTo()->format('Y-m-d H:i:s')) {
            $employeeSchedule->setDayFrom($this->faker->dateTimeBetween('now', '+1 week'));
            $employeeSchedule->setDayTo($this->faker->dateTimeBetween('now', '+1 week'));
            $this->checkDayFromAndDayTo($employeeSchedule);
        }
        if ($employeeSchedule->getTimeFrom()->format('H:i:s') > $employeeSchedule->getTimeTo()->format('H:i:s')) {
            $employeeSchedule->setTimeFrom($this->createRandomlyTime());
            $employeeSchedule->setTimeTo($this->createRandomlyTime());
            $this->checkDayFromAndDayTo($employeeSchedule);
        }
    }
}
