<?php

namespace App\DataFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\ClassifiedCard;
use App\Entity\Card;
use App\Entity\Image;
use App\Entity\Nomenclature;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

use Faker;

class CardFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
      $faker = Faker\Factory::create('fr_FR');

      for($c=0; $c<5; $c++) {
        $nomenclature = new Nomenclature();
        $name = $faker->word;
        $nomenclature->setName($name);
        $nomenclature->setCreatedBy($this->getReference(UserFixtures::SIMPLE_USER_REFERENCE));

        // add at least 4 cards
        $card_count = $faker->numberBetween(4,9);
        for($i=0; $i<$card_count; $i++) {

          $card = $this->generateCard( $faker);
          $nomenclature->addCard($card);
        }
        $manager->persist($nomenclature);
      }

        $manager->flush();
    }

    /**
     * Generate a fake card
     */
    private function generateCard( $faker) {
      $card = new Card();
      $label = $faker->word;
      $description = $faker->text;

      // the card image
      $image = new Image();
      
      $filename = $faker->image(sys_get_temp_dir(), 400, 400, null);
      //$filename = "/home/babs/Images/2705-wuwei-gnu-meditate.jpg"; // temp when no internet connection
      $mimetype = MimeTypeGuesser::getInstance()->guess($filename);
      $size     = filesize($filename);
      $file = new UploadedFile($filename, basename($filename), $mimetype, $size, null, true);
      $image->setFile($file);

      $card->setLabel($label);
      $card->setDescription($description);
      $card->setDescriptionWithGaps($description);
      $card->setImage($image);

      return $card;
    }

    public function getDependencies()
    {
        return array(
          UserFixtures::class,
        );
    }
}
