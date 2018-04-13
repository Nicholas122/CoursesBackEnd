<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * User.
 *
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("email", groups={"registration", "default"})
 * @ORM\EntityListeners({"AppBundle\EventListener\UserEntityListener"})
 *
 */
class User implements HasOwnerInterface, UserInterface
{
    /**
     * @var int
     *
     * @JMS\Expose
     * @JMS\Groups({"default", "Default", "auth", "user"})
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default", "auth"})
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    protected $username;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default", "auth"})
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     */
    protected $firstName;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default", "auth"})
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     */
    protected $lastName;

    /**
     * @JMS\Expose
     * @JMS\Groups({"user", "auth"})
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Email()
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Length(min = 5)
     */
    protected $plainPassword = null;

    /**
     * @JMS\Expose
     * @JMS\Groups({"user", "auth"})
     * @ORM\Column(type="string", nullable=true, options={"default" : "ROLE_USER"})
     */
    protected $role;

    /**
     * @JMS\Expose
     * @JMS\Groups({"auth"})
     */
    protected $accessToken;

    /**
     * @JMS\Expose
     * @JMS\Groups({"auth"})
     */
    protected $refreshToken;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $salt;

    /**
     * @JMS\Expose
     * @JMS\Groups({"auth"})
     */
    protected $expirationDate;

    /**
     * @JMS\Expose
     * @JMS\Groups({"user", "auth"})
     * @ORM\Column(type="datetime", nullable=true)
     *
     */
    protected $registrationDate;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default", "auth"})
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $isStudent;

    /**
     * @JMS\Expose
     * @JMS\Groups({"default", "auth"})
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $isTeacher;

    /**
     *  @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $googleId;

    /**
     *  @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $photo;

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array($this->role ? $this->role : 'ROLE_USER');
    }

    /**
     * @return User[]
     */
    public function getOwners()
    {
        return array(
            $this,
        );
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUsername($username)
    {
        $this->username = $this->getEmail();

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return User
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Set plain password recieved from user input.
     *
     * @param string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        // this is used to trigger doctirne's update event.
        $this->password = null;

        return $this;
    }

    /**
     * Get plain password.
     *
     * @return string|null
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set isStudent
     *
     * @param integer $isStudent
     *
     * @return User
     */
    public function setIsStudent($isStudent)
    {
        $this->isStudent = $isStudent;

        return $this;
    }

    /**
     * Get isStudent
     *
     * @return integer
     */
    public function getIsStudent()
    {
        return $this->isStudent;
    }

    /**
     * Set isTeacher
     *
     * @param integer $isTeacher
     *
     * @return User
     */
    public function setIsTeacher($isTeacher)
    {
        $this->isTeacher = $isTeacher;

        return $this;
    }

    /**
     * Get isTeacher
     *
     * @return integer
     */
    public function getIsTeacher()
    {
        return $this->isTeacher;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return User
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
