<?php

namespace App\DataFixtures;
use App\Entity\ClassifiedCard;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CardFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $path = 'public/uploads/images';
      if (!file_exists($path)) {
          mkdir($path, 0777, true);
      }
      $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);

        for($c=0; $c<1; $c++) {
          $card = new ClassifiedCard();
          $image_count = $faker->numberBetween(4,9);
          for($i=0; $i<$image_count; $i++) {
            $image = new Image();
            $file = $faker->image($path, 400, 400, null, false);
            $label = $faker->word;
            $image->setLabel($label);
            $image->setName($file);
            $card->addImage($image);
          }
          $manager->persist($card);
        }

        $manager->flush();
    }
}
