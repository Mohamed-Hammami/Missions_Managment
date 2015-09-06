<?php

namespace MP\TimeSheetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssociateMission
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MP\TimeSheetBundle\Entity\AssociateMissionRepository")
 */
class AssociateMission
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
     * @var float
     *
     * @ORM\Column(name="hourNum", type="float")
     */
    private $hourNum;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MP\TimeSheetBundle\Entity\Mission", inversedBy="associate", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $mission;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MP\TimeSheetBundle\Entity\Associate", inversedBy="mission", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $associate;

    public function __construct()
    {
        $this->setStatus("en cours");
        $this->setHourNum(0);
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
     * Set hourNum
     *
     * @param float $hourNum
     * @return AssociateMission
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
     * Set status
     *
     * @param string $status
     * @return AssociateMission
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
     * Set mission
     *
     * @param \MP\TimeSheetBundle\Entity\Mission $mission
     * @return AssociateMission
     */
    public function setMission(Mission $mission)
    {
        $this->mission = $mission;

        return $this;
    }

    /**
     * Get mission
     *
     * @return \MP\TimeSheetBundle\Entity\Mission 
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * Set associate
     *
     * @param \MP\TimeSheetBundle\Entity\Associate $associate
     * @return AssociateMission
     */
    public function setAssociate(Associate $associate)
    {
        $this->associate = $associate;

        return $this;
    }

    /**
     * Get associate
     *
     * @return \MP\TimeSheetBundle\Entity\Associate 
     */
    public function getAssociate()
    {
        return $this->associate;
    }
}
