<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\CompanyAdditionalInfo;
use App\Entity\CompanyAddress;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $roles = ['ROLE_ADMIN', 'ROLE_EMPLOYEE', 'ROLE_OWNER'];

        $this->faker = Factory::create();
        //create 10 companies and add 10 users to each company and
        // to each company add from 1 to 2 addresses and from 1 to 2 additional info
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
                    $user->setRoles($roles);
                } else {
                    $user->setRoles(['ROLE_EMPLOYEE']);
                }
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
                $companyAdditionalInfo->setPhone($this->faker->phoneNumber);
                //add data randomly email, facebook, instagram, website
                if (random_int(0, 1) === 1) {
                    $companyAdditionalInfo->setEmail($this->faker->email);
                }
                if (random_int(0, 1) === 1) {
                    $companyAdditionalInfo->setFacebook($this->faker->url);
                }
                if (random_int(0, 1) === 1) {
                    $companyAdditionalInfo->setInstagram($this->faker->url);
                }
                if (random_int(0, 1) === 1) {
                    $companyAdditionalInfo->setWebsite($this->faker->url);
                }

                $companyAdditionalInfo->setCompany($company);
                $manager->persist($companyAdditionalInfo);
            }
        }

        $manager->flush();
    }
}
