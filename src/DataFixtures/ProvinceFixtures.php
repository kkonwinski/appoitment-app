<?php

namespace App\DataFixtures;

use App\Entity\ProvinceDictionary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProvinceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $provinces = array(
            "Dolnośląskie",
            "Kujawsko-pomorskie",
            "Lubelskie",
            "Lubuskie",
            "Łódzkie",
            "Małopolskie",
            "Mazowieckie",
            "Opolskie",
            "Podkarpackie",
            "Podlaskie",
            "Pomorskie",
            "Śląskie",
            "Świętokrzyskie",
            "Warmińsko-mazurskie",
            "Wielkopolskie",
            "Zachodniopomorskie"
        );
        foreach ($provinces as $province1) {
            $province = new ProvinceDictionary();
            $province->setName($province1);
            $manager->persist($province);
        }

        $manager->flush();
    }
}
