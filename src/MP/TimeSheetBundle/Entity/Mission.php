<?php

namespace MP\TimeSheetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mission
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MP\TimeSheetBundle\Entity\MissionRepository")
 *
 */
class Mission
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
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * @var float
     *
     * @ORM\Column(name="hourNum", type="float")
     */
    private $hourNum;

    /**
     * @var float
     *
     * @ORM\Column(name="realHourNum", type="float")
     */
    private $realHourNum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime")
     *
     *
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="realEndDate", type="datetime", nullable=true)
     */
    private $realEndDate;

    /**
     * @ORM\ManyToOne(targetEntity="Nature")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nature;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity="AssociateMission", mappedBy="mission")
     */
    private $associate;


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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Mission
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Mission
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     *
     * @Assert\Valid()
     *
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $currentDate = new \DateTime();
        $currentDate->setTime(0, 0);

        $this->setRealHourNum(0);
        $this->setStartDate($currentDate);
        $this->setEndDate($currentDate);
        $this->setStatus('en cours');
    }

    /**
     * Set nature
     *
     * @param \MP\TimeSheetBundle\Entity\Nature $nature
     * @return Mission
     */
    public function setNature(Nature $nature)
    {
        $this->nature = $nature;

        return $this;
    }

    /**
     * Get nature
     *
     * @return \MP\TimeSheetBundle\Entity\Nature 
     */
    public function getNature()
    {
        return $this->nature;
    }

    public function __toString()
    {
       $missionYear = $this->getStartDate()->format('Y');
       $client = $this->getClients();
       $displayName = 'Mission '.$client.' '.$missionYear;
        return $displayName;
    }


    /**
     * Set hourNum
     *
     * @param float $hourNum
     * @return Mission
     */
    public function setHourNum($hourNum)
    {
        $this->hourNum = $hourNum;

        return $this;
    }

    /**
     * Get hourNum
     *
     * @return float 
     */
    public function getHourNum()
    {
        return $this->hourNum;
    }

    /**
     * Set realHourNum
     *
     * @param float $realHourNum
     * @return Mission
     */
    public function setRealHourNum($realHourNum)
    {
        $this->realHourNum = $realHourNum;

        return $this;
    }

    /**
     * Get realHourNum
     *
     * @return float 
     */
    public function getRealHourNum()
    {
        return $this->realHourNum;
    }


    /**
     * Set realEndDate
     *
     * @param \DateTime $realEndDate
     * @return Mission
     */
    public function setRealEndDate($realEndDate)
    {
        $this->realEndDate = $realEndDate;

        return $this;
    }

    /**
     * Get realEndDate
     *
     * @return \DateTime 
     */
    public function getRealEndDate()
    {
        return $this->realEndDate;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Mission
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set clients
     *
     * @param \MP\TimeSheetBundle\Entity\Client $clients
     * @return Mission
     */
    public function setClients(Client $clients)
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * Get clients
     *
     * @return \MP\TimeSheetBundle\Entity\Client 
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     *
     * @Assert\True(message = "La date de fin doit être aprés celle de début")
     *
     */
    public function isEndDateValid()
    {
        return ($this->getStartDate() < $this->getEndDate());
    }



    /**
     * Add associate
     *
     * @param \MP\TimeSheetBundle\Entity\AssociateMission $associate
     * @return Mission
     */
    public function addAssociate(AssociateMission $associate)
    {
        $this->associate[] = $associate;

        return $this;
    }

    /**
     * Remove associate
     *
     * @param \MP\TimeSheetBundle\Entity\AssociateMission $associate
     */
    public function removeAssociate(AssociateMission $associate)
    {
        $this->associate->removeElement($associate);
    }

    /**
     * Get associate
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssociate()
    {
        return $this->associate;
    }
}
