<?php

namespace App\DataFixtures;
use App\Entity\ClassifiedCard;
use App\Entity\Card;
use App\Entity\Image;
use App\Entity\Nomenclature;
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

      for($c=0; $c<1; $c++) {
        $nomenclature = new Nomenclature();
        $name = $faker->word;
        $nomenclature->setName($name);
  
        // add at least 4 cards
        $card_count = $faker->numberBetween(4,9);
        for($i=0; $i<$card_count; $i++) {

          $card = $this->generateCard($path, $faker);
          $nomenclature->addCard($card);
        }
        $manager->persist($nomenclature);
      }

        $manager->flush();
    }

    /**
     * Generate a fake card
     */
    private function generateCard($path, $faker) {
      $card = new Card();
      $label = $faker->word;
      $description = $faker->text;

      // the card image
      $image = new Image($path);
      $file = $faker->image($path, 400, 400, null, false);
      $image->setName($file);
      
      $card->setLabel($label);
      $card->setDescription($description);
      $card->setDescriptionWithGaps($description);
      $card->setImage($image);

      return $card;
    }
}
