<?php
namespace App\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Util\TokenGenerator;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

use App\Entity\User;

class MyFOSUBUserProvider extends BaseFOSUBProvider
{

  protected $tokenGenerator;
  /**
   * Constructor.
   *
   * @param UserManagerInterface $userManager fOSUB user provider
   * @param array                $properties  property mapping
   */
  public function __construct(UserManagerInterface $userManager, TokenGenerator $tokenGenerator, array $properties)
  {
      $this->userManager = $userManager;
      $this->tokenGenerator = $tokenGenerator;
      $this->properties = array_merge($this->properties, $properties);
      $this->accessor = PropertyAccess::createPropertyAccessor();
  }
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $username = $response->getUsername(); // get the unique user identifier

        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy(array($property => $username));
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            // ...

            $this->userManager->updateUser($existingUser);
        }
        // we connect current user, set current user id and token
        // ...
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $userEmail = $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);
        $service = $response->getResourceOwner()->getName();
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';

        // if null just create new user and set it properties
        if (null === $user) {
            $username = $response->getRealName();
            $user = $this->userManager->createUser();
            $user->setUsername($username);
            $user->setEnabled(true);
            $user->setEmail($userEmail);
            $password = substr($this->tokenGenerator->generateToken(), 0, 8); // 8 chars
            print($password);
            $user->setPlainPassword($password);

            $user->$setter_id($response->getUsername());
            $user->$setter_token($response->getAccessToken());

            $this->userManager->updateUser($user);
            return $user;
        }
        // else update access token of existing user
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken());//update access token

        return $user;
    }
}
