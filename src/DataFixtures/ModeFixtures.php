<?php

namespace App\DataFixtures;

use App\Entity\Mode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ModeFixtures extends Fixture
{
    public const SIMPLE_REFERENCE = 'simple';

    public function load(ObjectManager $manager)
    {
        $simple = new Mode();
        $simple->setName('Simple');
        $manager->persist($simple);
        $manager->flush();
        $this->addReference(self::SIMPLE_REFERENCE, $simple);

        $scientist = new Mode();
        $scientist->setName('Scientist');
        $manager->persist($scientist);
        $manager->flush();
    }
}
