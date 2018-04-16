<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserInputQuestion.
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class UserInputQuestion extends Question
{

}
