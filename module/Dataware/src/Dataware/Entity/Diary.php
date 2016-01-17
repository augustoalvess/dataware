<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Documentação em http://fullcalendar.io/docs/
 *
 * @author augusto
 */
namespace Dataware\Entity;

class Diary 
{
    /**
     * @var String
     */
    private $defaultDate;
    
    /**
     * @var String
     */
    private $lang;
    
    /**
     * @var String
     */
    private $headerLeft;
    
    /**
     * @var String
     */
    private $headerCenter;
    
    /**
     * @var String
     */
    private $headerRight;
    
    /**
     * @var boolean
     */
    private $selectable = true;
    
    /**
     *
     * @var boolean
     */
    private $selectHelper = true;
    
    /**
     * @var boolean
     */
    private $editable = true;
    
    /**
     * @var boolean
     */
    private $eventLimit = true; // Allow "more" link when too many events
    
    /**
     * @var Dataware\Entity\DiaryEvent[] 
     */
    private $events = array();
    
    /**
     * @var String
     */
    private $addAction;
    
    /**
     * @var String
     */
    private $editAction;
    
    public function __construct($addAction, $editAction, $events = array()) 
    {
        $this->addAction = $addAction;
        $this->editAction = $editAction;
        $this->events = $events;
        $this->defaultDate = date("Y-m-d");
        $this->lang = "pt-br";
        $this->headerLeft = "title";
        $this->headerCenter = "";
        $this->headerRight = "prev, next today";
    }
    
    public function getDefaultDate() 
    {
        return $this->defaultDate;
    }

    public function setDefaultDate($defaultDate) 
    {
        $this->defaultDate = $defaultDate;
    }

    public function getLang() 
    {
        return $this->lang;
    }

    public function setLang($lang) 
    {
        $this->lang = $lang;
    }

    public function getHeaderLeft() 
    {
        return $this->headerLeft;
    }

    public function setHeaderLeft($headerLeft) 
    {
        $this->headerLeft = $headerLeft;
    }

    public function getHeaderCenter() 
    {
        return $this->headerCenter;
    }

    public function setHeaderCenter($headerCenter) 
    {
        $this->headerCenter = $headerCenter;
    }

    public function getHeaderRight() 
    {
        return $this->headerRight;
    }

    public function setHeaderRight($headerRight) 
    {
        $this->headerRight = $headerRight;
    }

    public function getSelectable() 
    {
        return $this->selectable;
    }

    public function setSelectable($selectable) 
    {
        $this->selectable = $selectable;
    }

    public function getSelectHelper() 
    {
        return $this->selectHelper;
    }

    public function setSelectHelper($selectHelper) 
    {
        $this->selectHelper = $selectHelper;
    }

    public function getEditable() 
    {
        return $this->editable;
    }

    public function setEditable($editable) 
    {
        $this->editable = $editable;
    }

    public function getEventLimit() 
    {
        return $this->eventLimit;
    }

    public function setEventLimit($eventLimit) 
    {
        $this->eventLimit = $eventLimit;
    }

    public function getEvents() 
    {
        return $this->events;
    }

    public function setEvents($events) 
    {
        $this->events = $events;
    }
    
    public function getAddAction() 
    {
        return $this->addAction;
    }

    public function setAddAction($addAction) 
    {
        $this->addAction = $addAction;
    }

    public function getEditAction() 
    {
        return $this->editAction;
    }

    public function setEditAction($editAction) 
    {
        $this->editAction = $editAction;
    }
}

?>
