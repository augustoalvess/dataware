<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Documentação em http://fullcalendar.io/docs/event_data/events_array/
 *
 * @author augusto
 */
namespace Dataware\Entity;

class DiaryEvent 
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var String 
     */
    private $title;
    
    /**
     * ex.: 2015-10-16T16:00:00
     * 
     * @var String
     */
    private $start;
    
    /**
     * ex.: 2015-10-16T16:00:00
     * 
     * @var String
     */
    private $end;
    
    /**
     * @var boolean
     */
    private $allDay = false;
    
    /**
     * @var String
     */
    private $color;
    
    public function __construct($title, $start, $end = null) 
    {
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
    }
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getTitle() 
    {
        return $this->title;
    }

    public function setTitle($title) 
    {
        $this->title = $title;
    }

    public function getStart() 
    {
        return $this->start;
    }

    public function setStart($start) 
    {
        $this->start = $start;
    }

    public function getEnd() 
    {
        return $this->end;
    }

    public function setEnd($end) 
    {
        $this->end = $end;
    }

    public function getAllDay() 
    {
        return $this->allDay;
    }

    public function setAllDay($allDay) 
    {
        $this->allDay = $allDay;
    }
    
    public function getColor() 
    {
        return $this->color;
    }

    public function setColor($color) 
    {
        $this->color = $color;
    }
}

?>
