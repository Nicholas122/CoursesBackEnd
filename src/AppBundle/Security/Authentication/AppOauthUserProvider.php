<?php

namespace AppBundle\Security\Authentication;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AppOauthUserProvider extends OAuthUserProvider
{
    /** @var EntityManager $em */
    protected $em;

    /**
     * ApiKeyUserProvider constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $username
     *
     * @return null|object
     */
    public function loadUserByUsername($username)
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['googleId' => $username]);

        if (!$user instanceof User) {
            $user = new User();
            $user->setIsStudent(1);
        }

        return $user;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $googleId = $response->getUsername();
        $email = $response->getEmail();
        $firstName = $response->getFirstName();
        $lastName = $response->getLastName();
        $avatar = $response->getProfilePicture();

        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['googleId' => $googleId]);
        $userByEmail = $this->em->getRepository('AppBundle:User')->findOneBy(['email' => $email]);

        $user = $user ?: $userByEmail;
        if (!$user instanceof User) {
            $user = new User();
            $user->setUsername($googleId);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setGoogleId($googleId);
            $user->setRole('ROLE_USER');
            $user->setPassword($googleId);
            $user->setPhoto($avatar);
            $user->setIsStudent(1);
            $this->em->persist($user);
            $this->em->flush();
        }

        if (empty($user->getGoogleId()) || empty($user->getPhoto())) {
            $user->setGoogleId($googleId);
            $user->setPhoto($avatar);

            $this->em->persist($user);
            $this->em->flush();
        }

        return $this->loadUserByUsername($response->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {

        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['googleId' => $user->getUsername()]);

        return $user;
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return 'AppBundle\Entity\User' === $class;
    }
}
