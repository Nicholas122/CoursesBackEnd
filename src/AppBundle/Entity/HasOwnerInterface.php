<?php

namespace AppBundle\Entity;

interface HasOwnerInterface
{
    /**
     * @return User[]
     */
    public function getOwners();
}
