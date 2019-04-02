<?php

namespace App\DataFixtures;
use App\Entity\ClassifiedCard;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CardFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);
        for($i=0; $i<10; $i++) {
          $card = new ClassifiedCard();
          // $card->
        }

        $manager->flush();
    }
}
