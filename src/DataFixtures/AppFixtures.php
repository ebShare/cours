<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Lecon;
use Faker\Generator;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create("fr_FR");
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $lecon = new Lecon();
            $lecon->setTitre($this->faker->word())
                ->setCode(mt_rand(1, 199))
                ->setHeures(mt_rand(1, 199));

            $manager->persist($lecon);
        }

        $manager->flush();
    }
}
