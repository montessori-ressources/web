<?php

namespace App\DataFixtures;

use App\Entity\PictureSet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PictureSetFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $gospel = new PictureSet();
        $gospel->setName('Gospel');
        $manager->persist($gospel);
        $manager->flush();

        $chant = new PictureSet();
        $chant->setName('Chant');
        $manager->persist($chant);
        $manager->flush();

        $religieux = new PictureSet();
        $religieux->setName('Religieux');
        $manager->persist($religieux);
        $manager->flush();
    }
}
