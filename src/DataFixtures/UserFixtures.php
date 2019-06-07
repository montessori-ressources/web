<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;

class UserFixtures extends Fixture
{
    private $userManager;
    public const SIMPLE_USER_REFERENCE = 'user';

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager)
    {
      // admin user
      $user = $this->userManager->createUser();
      $user->setUsername('admin');
      $user->setEmail('admin@montessori');
      $user->setPlainPassword('admin');
      $user->setEnabled(true);
      $user->setRoles(array('ROLE_ADMIN'));
      $this->userManager->updateUser($user);

      // classic user
      $user = $this->userManager->createUser();
      $user->setUsername('user');
      $user->setEmail('user@montessori');
      $user->setPlainPassword('user');
      $user->setEnabled(true);
      $user->setRoles(array('ROLE_USER'));
      $this->userManager->updateUser($user);

      $this->addReference(self::SIMPLE_USER_REFERENCE, $user);
    }
}
