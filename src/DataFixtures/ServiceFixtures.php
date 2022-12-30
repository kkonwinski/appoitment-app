<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ServiceFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create('pl_PL');

        //create 1000 services names
        for ($i = 0; $i < 1000; $i++) {
            $service = new Service();
            $service->setName($this->faker->word);
            $manager->persist($service);
        }

        $manager->flush();
    }
}
