<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\HasOwnerInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SetOwnerListener
{
    private $tokenStorage;

    /**
     * SparePartTypeListener constructor.
     *
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Set user.
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     * @param HasOwnerInterface  $entity
     * @param LifecycleEventArgs $args
     */
    public function setOwner(HasOwnerInterface $entity, LifecycleEventArgs $args)
    {
        $token = $this->tokenStorage->getToken();

        if (null === $entity->getUser() && isset($token)) {
            $user = $token->getUser();
            $entity->setUser($user);
        } elseif (empty($entity->getUser())) {
            throw new UnprocessableEntityHttpException();
        }
    }
}
