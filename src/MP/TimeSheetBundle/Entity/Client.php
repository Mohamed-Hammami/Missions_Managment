<?php

namespace MP\TimeSheetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Client
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MP\TimeSheetBundle\Entity\ClientRepository")
 */
class Client
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
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="secteurActivite", type="string", length=255)
     */
    private $secteurActivite;

    /**
     * @ORM\OneToOne(targetEntity="MainContact", cascade={"all"})
     */
    private  $mainContact;


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
     * Set adresse
     *
     * @param string $adresse
     * @return Client
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set secteurActivite
     *
     * @param string $secteurActivite
     * @return Client
     */
    public function setSecteurActivite($secteurActivite)
    {
        $this->secteurActivite = $secteurActivite;

        return $this;
    }

    /**
     * Get secteurActivite
     *
     * @return string 
     */
    public function getSecteurActivite()
    {
        return $this->secteurActivite;
    }

    /**
     * Set mainContact
     *
     * @param \MP\TimeSheetBundle\Entity\MainContact $mainContact
     * @return Client
     */
    public function setMainContact(\MP\TimeSheetBundle\Entity\MainContact $mainContact = null)
    {
        $this->mainContact = $mainContact;

        return $this;
    }

    /**
     * Get mainContact
     *
     * @return \MP\TimeSheetBundle\Entity\MainContact 
     */
    public function getMainContact()
    {
        return $this->mainContact;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Client
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

    public function __toString()
    {
        return $this->getName();
    }
}
