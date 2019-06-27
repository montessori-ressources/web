<?php

namespace App\DataFixtures;

use App\Entity\IllustrationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class IllustrationTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $watercolor = new IllustrationType();
        $watercolor->setName('Aquarelle');
        $manager->persist($watercolor);
        $manager->flush();
        
        $photo = new IllustrationType();
        $photo->setName('Photo');
        $manager->persist($photo);
        $manager->flush();

        $drawing = new IllustrationType();
        $drawing->setName('Dessin');
        $manager->persist($drawing);
        $manager->flush();

        $clipArt = new IllustrationType();
        $clipArt->setName('Clip art');
        $manager->persist($clipArt);
        $manager->flush();
    }
}
