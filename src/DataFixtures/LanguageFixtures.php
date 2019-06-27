<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;

class LanguageFixtures extends Fixture
{
    public const FRENCH_REFERENCE = 'french';

    public function load(ObjectManager $manager)
    {
        // Add French
        $french = new Language();
        $french->setName('Français');
        $french->setIso2Char('fr');
        $manager->persist($french);
        $manager->flush();
        $this->addReference(self::FRENCH_REFERENCE, $french);

        // Add English
        $english = new Language();
        $english->setName('English');
        $english->setIso2Char('en');
        $manager->persist($english);
        $manager->flush();

        // Add Spanish
        $spanish = new Language();
        $spanish->setName('Español');
        $spanish->setIso2Char('es');
        $manager->persist($spanish);
        $manager->flush();
    
    }
}
