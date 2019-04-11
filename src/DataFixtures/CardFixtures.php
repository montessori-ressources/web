<?php

namespace App\DataFixtures;
use App\Entity\ClassifiedCard;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Faker;

class CardFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $faker = Faker\Factory::create('fr_FR');
        for($c=0; $c<1; $c++) {
          $card = new ClassifiedCard();
          $image_count = $faker->numberBetween(4,9);
          for($i=0; $i<$image_count; $i++) {
            $image = new Image();
            $filename = $faker->image(sys_get_temp_dir(), 400, 400, null);
            $mimetype = MimeTypeGuesser::getInstance()->guess($filename);
            $size     = filesize($filename);
            $file = new UploadedFile($filename, basename($filename), $mimetype, $size, null, true);

            $label = $faker->word;
            $image->setLabel($label);
            $image->setFile($file);
            $card->addImage($image);
          }
          $manager->persist($card);
        }

        $manager->flush();
    }
}
