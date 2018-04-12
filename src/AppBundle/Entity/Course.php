<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Course.
 *
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Course implements HasOwnerInterface
{
    /**
     * @var int
     *
     * @JMS\Expose
     * @JMS\Groups({"default", "auth"})
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    protected $title;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="string", length=150, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="150")
     */
    protected $subTitle;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $category;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="string", length=200, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="200")
     */
    protected $language;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="enum_course_status_type", nullable=true)
     */
    protected $status;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="enum_instructional_level_type", nullable=true)
     */
    protected $instructionalLevel;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="text", length=3000, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="3000")
     */
    protected $summary;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="string", nullable=true)
     */
    protected $logo;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="string", nullable=true)
     */
    protected $video;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="enum_session_type", nullable=true)
     */
    protected $session;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default"})
     * @ORM\Column(type="datetime")
     */
    protected $creationDate;

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Course
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return User[]
     */
    public function getOwners()
    {
        return [$this->getUser()];
    }



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Course
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subTitle
     *
     * @param string $subTitle
     *
     * @return Course
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * Get subTitle
     *
     * @return string
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Course
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set status
     *
     * @param enum_course_status_type $status
     *
     * @return Course
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return enum_course_status_type
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set instructionalLevel
     *
     * @param enum_instructional_level_type $instructionalLevel
     *
     * @return Course
     */
    public function setInstructionalLevel($instructionalLevel)
    {
        $this->instructionalLevel = $instructionalLevel;

        return $this;
    }

    /**
     * Get instructionalLevel
     *
     * @return enum_instructional_level_type
     */
    public function getInstructionalLevel()
    {
        return $this->instructionalLevel;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return Course
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Course
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return Course
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set session
     *
     * @param enum_session_type $session
     *
     * @return Course
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return enum_session_type
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Course
     * @ORM\PrePersist()
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = new \DateTime();

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Course
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
