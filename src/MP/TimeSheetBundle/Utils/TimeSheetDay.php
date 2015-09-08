<?php
/**
 * Created by PhpStorm.
 * User: Pegasus
 * Date: 07/09/2015
 * Time: 15:38
 */

namespace MP\TimeSheetBundle\Utils;


class TimeSheetDay
{
    /**
     * @var \DateTime
     */
    private $day;
    /**
     * @var \MP\TimeSheetBundle\Entity\TimeSheet
     */
    private $timeSheet;
    /**
     * @var string
     */
    private $weekDay;

    /**
     * @return boolean
     */
    public function getCreatable()
    {
        return $this->creatable;
    }

    /**
     * @param boolean $creatable
     */
    public function setCreatable($creatable)
    {
        $this->creatable = $creatable;
    }
    /**
     * @var string
     */
    private $month;

    /**
     * @return int
     */
    public function getDiffId()
    {
        return $this->diffId;
    }

    /**
     * @param int $diffId
     */
    public function setDiffId($diffId)
    {
        $this->diffId = $diffId;
    }

    /**
     * @var int
     */
    private $diffId;
    /**
     * @var boolean
     */
    private $creatable;

    /**
     * @return string
     */
    public function getMonth()
    {
        switch( $this->month ){

            case 1:
                $monthName = 'Janvier';
                break;
            case 2:
                $monthName = 'Fervrier';
                break;
            case 3:
                $monthName = 'Mars';
                break;
            case 4:
                $monthName = 'Avril';
                break;
            case 5:
                $monthName = 'Mai';
                break;
            case 6:
                $monthName = 'Juin';
                break;
            case 7:
                $monthName = 'Juillet';
                break;
            case 8:
                $monthName = 'Août';
                break;
            case 9:
                $monthName = 'Septembre';
                break;
            case 10:
                $monthName = 'Octobre';
                break;
            case 11:
                $monthName = 'Novembre';
                break;
            case 12:
                $monthName = 'Decembre';
                break;
            default:
                $monthName = 'erreur';
        }

        return $monthName;
    }

    /**
     * @param string $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @return string
     */
    public function getWeekDay()
    {
        switch( $this->weekDay ){
            case 0:
                $dayName = 'Dimanche';
                break;
            case 1:
                $dayName = 'Lundi';
                break;
            case 2:
                $dayName = 'Mardi';
                break;
            case 3:
                $dayName = 'Mercredi';
                break;
            case 4:
                $dayName = 'Jeudi';
                break;
            case 5:
                $dayName = 'Vendredi';
                break;
            case 6:
                $dayName = 'Samedi';
                break;
            default:
                $dayName = 'erreur';
        }

        return $dayName;
    }

    /**
     * @param string $weekDay
     */
    public function setWeekDay($weekDay)
    {
        $this->weekDay = $weekDay;
    }

    /**
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param \DateTime $day
     */
    public function setDay($day)
    {
        $this->day = $day;
        $this->weekDay = date('w', $day->getTimestamp());
        $this->month = date('m', $day->getTimestamp());
    }

    /**
     * @return \MP\TimeSheetBundle\Entity\TimeSheet
     */
    public function getTimeSheet()
    {
        return $this->timeSheet;
    }

    /**
     * @param \MP\TimeSheetBundle\Entity\TimeSheet $timeSheet
     */
    public function setTimeSheet($timeSheet)
    {
        $this->timeSheet = $timeSheet;
    }

    public function __construct()
    {
        $this->setCreatable(false);
    }

} 