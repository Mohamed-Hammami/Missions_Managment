<?php

namespace MP\TimeSheetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TimeSheet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MP\TimeSheetBundle\Entity\TimeSheetRepository")
 *
 * @UniqueEntity(fields={ "day", "associate"}, message="il y a déja une feuille de temps à cette date")
 */
class TimeSheet
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
     * @ORM\Column(name="day", type="datetime")
     *
     * @Assert\Range(
     *      min = " now -2 days",
     *      max = "now",
     *      minMessage = "fin de delai"
     *
     * )
     *
     */
    private $day;

    /**
     * @var float
     *
     * @ORM\Column(name="hourNumber", type="float")
     */
    private $hourNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validated", type="boolean", nullable=true)
     *
     *
     */
    private $validated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="holiday", type="boolean")
     */
    private $holiday;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="Associate")
     * @ORM\JoinColumn(nullable=false)
     */
    private $associate;

    /**
     * @ORM\ManyToOne(targetEntity="Mission")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mission;

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
     * Set day
     *
     * @param \DateTime $day
     * @return TimeSheet
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set hourNumber
     *
     * @param float $hourNumber
     * @return TimeSheet
     */
    public function setHourNumber($hourNumber)
    {
        $this->hourNumber = $hourNumber;

        return $this;
    }

    /**
     * Get hourNumber
     *
     * @return float 
     */
    public function getHourNumber()
    {
        return $this->hourNumber;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     * @return TimeSheet
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set holiday
     *
     * @param boolean $holiday
     * @return TimeSheet
     */
    public function setHoliday($holiday)
    {
        $this->holiday = $holiday;

        return $this;
    }

    /**
     * Get holiday
     *
     * @return boolean 
     */
    public function getHoliday()
    {
        return $this->holiday;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return TimeSheet
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set associate
     *
     * @param \MP\TimeSheetBundle\Entity\Associate $associate
     * @return TimeSheet
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

    /**
     * Set mission
     *
     * @param \MP\TimeSheetBundle\Entity\Mission $mission
     * @return TimeSheet
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

    function __construct()
    {
        $currentDate = new \DateTime();
        $currentDate->setTime(0, 0);

        $this->setValidated(false);
        $this->setComment('');
        $this->setDay($currentDate);
    }
}
