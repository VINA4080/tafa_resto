<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Food;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use FakerRestaurant\Provider\fr_FR\Restaurant;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create();
        $faker->addProvider(new Restaurant($faker));
        
        for ($i = 0; $i < 20; $i++) { 
            $food = new Food();
            $food->setName($faker->foodName());
            $food->setDescription($faker->sentence());
            $food->setIngredients(join("/", $faker->words()));
            $food->setPrice($faker->numberBetween(10000,50000));

            $manager->persist($food);
        }
        

        
        $manager->flush();
    }
}
