<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GridAction
 *
 * @author augusto
 */
namespace Dataware\Entity;

class GridAction 
{
    const GRID_ACTION_EDIT_ID = 'action_edit';
    const GRID_ACTION_DELETE_ID = 'action_delete';
    const GRID_ACTION_VIEW_ID = 'action_view';
    const GRID_ACTION_ATTACHMENT_ID = 'action_attachment';
    
    /**
     *
     * @var String 
     */
    private $id;
    
    /**
     *
     * @var String
     */
    private $title;
    
    /**
     *
     * @var String
     */
    private $cssClass;
    
    /**
     *
     * @var String
     */
    private $route;
    
    /**
     *
     * @var String
     */
    private $action;
    
    /**
     *
     * @var String
     */
    private $onClick;
    
    /**
     *
     * @var boolean
     */
    private $enable;
    
    /**
     *
     * @var boolean
     */
    private $visible;
    
    /**
     *
     * @var array
     */
    private $args;
    
    public function __construct($id, $title, $route, $action, $cssClass = null, $enable = true, $onClick = null, $visible = true) 
    {
        $this->id = $id;
        $this->title = $title;
        $this->route = $route;
        $this->action = $action;
        $this->cssClass = $cssClass;
        $this->enable = $enable;
        $this->onClick = $onClick;
        $this->visible = $visible;
        $this->args = array();
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

    public function getCssClass() 
    {
        return $this->cssClass;
    }

    public function setCssClass($cssClass) 
    {
        $this->cssClass = $cssClass;
    }
    
    public function getRoute() 
    {
        return $this->route;
    }

    public function setRoute($route) 
    {
        $this->route = $route;
    }

    public function getAction() 
    {
        return $this->action;
    }

    public function setAction($action) 
    {
        $this->action = $action;
    }
    
    public function getOnClick() 
    {
        return $this->onClick;
    }

    public function setOnClick($onClick) 
    {
        $this->onClick = $onClick;
    }

    public function getEnable() 
    {
        return $this->enable;
    }

    public function setEnable($enable) 
    {
        $this->enable = $enable;
    }

    public function getVisible() 
    {
        return $this->visible;
    }

    public function setVisible($visible) 
    {
        $this->visible = $visible;
    }
    
    public function getArgs() 
    {
        return $this->args;
    }

    public function setArgs($args) 
    {
        $this->args = $args;
    }
}

?>
