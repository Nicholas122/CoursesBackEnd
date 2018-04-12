<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Doctrine\ORM\Mapping as ORM;

class UserEntityListener
{

    /**
     * @var UserPasswordEncoder $encoder
     */
    private $encoder;

    /**
     * UserEntityListener constructor.
     *
     * @param UserPasswordEncoder $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Encode password when peresisting new user.
     *
     * @param User      $user
     * @param LifecycleEventArgs $args
     *
     * @ORM\PrePersist
     */
    public function encodePasswordOnPrePersist(User $user, LifecycleEventArgs $args)
    {
        $this->encodePassword($user);
    }

    /**
     * Encode new password when updating a user.
     *
     * @param User      $user
     * @param PreUpdateEventArgs $args
     *
     * @ORM\PreUpdate
     */
    public function encodePasswordOnPreUpdate(User $user, LifecycleEventArgs $args)
    {
        $this->encodePassword($user);

        $om = $args->getObjectManager();
        $uow = $om->getUnitOfWork();
        $meta = $om->getClassMetadata(get_class($user));

        $uow->recomputeSingleEntityChangeSet($meta, $user);
    }

    /**
     * Encode the value of plainPassword property to password property.
     *
     * @param User $user
     */
    private function encodePassword(User $user)
    {
        if (null === $plainPassword = $user->getPlainPassword()) {
            return;
        }

        $encoded = $this->encoder->encodePassword(
            $user,
            $plainPassword
        );

        $user->setPassword($encoded);
    }
}
