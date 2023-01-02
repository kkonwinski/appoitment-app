<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\CompanyAdditionalInfo;
use App\Entity\CompanyAddress;
use App\Entity\EmployeeSchedule;
use App\Entity\Service;
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

        $this->faker = Factory::create('pl_PL');

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
                    if ($i === 0) {
                        $user->setEmail('k.konwinski@onet.pl');
                        $user->setRoles(['ROLE_ADMIN','ROLE_OWNER']);
                    } else {
                        $user->setRoles(['ROLE_OWNER']);
                    }
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
                $companyAddress->setStreet($this->faker->streetName);
                $companyAddress->setPostCode($this->faker->postcode);
                $companyAddress->setCountry($this->faker->country);
                $companyAddress->setBuildingNumber($this->faker->randomNumber(3));
                $companyAddress->setCompany($company);
                $manager->persist($companyAddress);
                for ($h = 0; $h < 40; $h++) {
                    //create one or two services for company address
                    $service = new Service();
                    $service->setName($this->faker->text(10));
                    $service->setPrice($this->faker->randomFloat(2, 10, 100));
                    //duration is random from 10 to 120 minutes
                    $service->setDuration(random_int(10, 120));
                    //add description as random words 10
                    $service->setDescription($this->faker->words(10, true));
//                    $service->setDescription($this->faker->text(100));
                    $service->addCompanyAddress($companyAddress);
                    $manager->persist($service);
                }
                for ($k = 0; $k < random_int(1, 2); $k++) {
                    $companyAdditionalInfo = new CompanyAdditionalInfo();
                    if (random_int(0, 1) === 1) {
                        $companyAdditionalInfo->setEmail(
                            $this->slugify($user->getFullName()) .
                            '@' .
                            $this->slugify($company->getName()) .
                            $this->faker->domainName
                        );
                    }
                    if (random_int(0, 1) === 1) {
                        $companyAdditionalInfo->setFacebook(
                            'https://facebook.com/' .
                            $this->slugify($user->getFullName())
                        );
                    }
                    if (random_int(0, 1) === 1) {
                        $companyAdditionalInfo->setInstagram(
                            'https://instagram.com/' .
                            $this->slugify($user->getFullName())
                        );
                    }
                    if (random_int(0, 1) === 1) {
                        $companyAdditionalInfo->setWebsite(
                            'https://' .
                            $this->slugify($company->getName()) .
                            $this->faker->domainName
                        );
                    }
                    //set phone number
                    $companyAdditionalInfo->setPhone($this->faker->phoneNumber);

                    $companyAdditionalInfo->setCompanyAddress($companyAddress);
                    $manager->persist($companyAdditionalInfo);
                }
            }


            $manager->flush();
            //create 40 services for each company address
        }
    }

    private function slugify(string $string): string
    {
        $string = preg_replace('/\s+/', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        $string = strtolower($string);
        return trim($string, '-');
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
