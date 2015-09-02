<?php

namespace MP\TimeSheetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MainContact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MP\TimeSheetBundle\Entity\MainContactRepository")
 */
class MainContact
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\Email(
     *      message = " '{{value}}' n'est pas un mail valide.",
     *      )
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="telNum", type="integer")
     */
    private $telNum;

    /**
     * @var string
     *
     * @ORM\Column(name="contactPost", type="string", length=255)
     */
    private $contactPost;


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
     * Set name
     *
     * @param string $name
     * @return MainContact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return MainContact
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return MainContact
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
     * Set telNum
     *
     * @param integer $telNum
     * @return MainContact
     */
    public function setTelNum($telNum)
    {
        $this->telNum = $telNum;

        return $this;
    }

    /**
     * Get telNum
     *
     * @return integer 
     */
    public function getTelNum()
    {
        return $this->telNum;
    }

    /**
     * Set contactPost
     *
     * @param string $contactPost
     * @return MainContact
     */
    public function setContactPost($contactPost)
    {
        $this->contactPost = $contactPost;

        return $this;
    }

    /**
     * Get contactPost
     *
     * @return string 
     */
    public function getContactPost()
    {
        return $this->contactPost;
    }

    public function __toString()
    {
        $displayName = $this->getName().' '.$this->getSurname();
        return $displayName;
    }
}
