<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MultipleChoiceQuestion.
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class MultipleChoiceQuestion extends Question
{

}
