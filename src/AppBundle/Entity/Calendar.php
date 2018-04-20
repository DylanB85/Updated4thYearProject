<?php

namespace AppBundle\Entity;

/**
 * Calendar
 */
class Calendar
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $decription;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var string
     */
    private $endDate;


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
     * @return Calendar
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
     * Set decription
     *
     * @param string $decription
     *
     * @return Calendar
     */
    public function setDecription($decription)
    {
        $this->decription = $decription;

        return $this;
    }

    /**
     * Get decription
     *
     * @return string
     */
    public function getDecription()
    {
        return $this->decription;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Calendar
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
     * @param string $endDate
     *
     * @return Calendar
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}

