<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * ReadingQuestion.
 *
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ReadingSubQuestion extends Question
{
    /**
     * @ORM\ManyToOne(targetEntity="ReadingQuestion")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\ReadingQuestion $parent
     *
     * @return ReadingSubQuestion
     */
    public function setParent(\AppBundle\Entity\ReadingQuestion $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\ReadingQuestion
     */
    public function getParent()
    {
        return $this->parent;
    }
}
