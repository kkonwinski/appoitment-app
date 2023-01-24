<?php

namespace App\DataFixtures;

use App\Entity\CountryDictionary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $countries = array(
            array(
                'name' => 'Polska',
                'code' => 'PL',
                'slug' => 'poland',
            ),
            array(
                'name' => 'Niemcy',
                'code' => 'DE',
                'slug' => 'germany',
            ),
            array(
                'name' => 'Francja',
                'code' => 'FR',
                'slug' => 'france',
            ),
            array(
                'name' => 'Włochy',
                'code' => 'IT',
                'slug' => 'italy',
            ),
            array(
                'name' => 'Hiszpania',
                'code' => 'ES',
                'slug' => 'spain',
            ),
            array(
                'name' => 'Rosja',
                'code' => 'RU',
                'slug' => 'russia',
            ),
            array(
                'name' => 'Szwecja',
                'code' => 'SE',
                'slug' => 'sweden',
            ),
            array(
                'name' => 'Czechy',
                'code' => 'CZ',
                'slug' => 'czech-republic',
            ),
            array(
                'name' => 'Belgia',
                'code' => 'BE',
                'slug' => 'belgium',
            ),
            array(
                'name' => 'Ukraina',
                'code' => 'UA',
                'slug' => 'ukraine',
            )
        );

        foreach ($countries as $key => $value) {
            $country = new CountryDictionary();

            $country->setName($value['name']);
            $country->setCode($value['code']);
            $country->setSlug($value['slug']);
            $manager->persist($country);
            $manager->flush();
        }
    }
}
