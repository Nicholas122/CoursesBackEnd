<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ReadingQuestion.
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ReadingQuestion extends Question
{
    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank()
     */
    protected $text;

    /**
     * Set text
     *
     * @param string $text
     *
     * @return ReadingQuestion
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
