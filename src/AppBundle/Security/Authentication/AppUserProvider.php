<?php

namespace AppBundle\Security\Authentication;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AppUserProvider implements UserProviderInterface
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
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['email' => $username]);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {

        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['email' => $user->getUsername()]);

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
