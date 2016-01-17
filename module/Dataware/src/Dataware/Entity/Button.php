<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Button
 *
 * @author augusto
 */
namespace Dataware\Entity;

class Button 
{
    const BUTTON_TYPE_SUBMIT = "submit";
    const BUTTON_TYPE_RESET = "reset";
    const BUTTON_TYPE_BUTTON = "button";
    
    const BUTTON_CLASS_DEFAULT = "btn-default";
    const BUTTON_CLASS_PRIMARY = "btn-primary";
    const BUTTON_CLASS_SUCCESS = "btn-success";
    const BUTTON_CLASS_INFO = "btn-info";
    const BUTTON_CLASS_WARNING = "btn-warning";
    const BUTTON_CLASS_DANGER = "btn-danger";
    
    private $id;
    private $class;
    private $value;
    private $type;
    private $href;
    private $onClick;
    private $icon;
    private $action = null;
    
    public function __construct($id, $value, $icon = "", $type = self::BUTTON_TYPE_BUTTON) 
    {
        $this->id = $id;
        $this->type = $type;
        $this->value = $value;
        $this->class = self::BUTTON_CLASS_DEFAULT;
        $this->icon = $icon;
    }
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getClass() 
    {
        return $this->class;
    }

    public function setClass($class) 
    {
        $this->class = $class;
    }
    
    public function addClass($class)
    {
        $this->class .= " " . $class;
    }

    public function getValue() 
    {
        return $this->value;
    }

    public function setValue($value) 
    {
        $this->value = $value;
    }

    public function getType() 
    {
        return $this->type;
    }

    public function setType($type) 
    {
        $this->type = $type;
    }

    public function getHref() 
    {
        return $this->href;
    }

    public function setHref($href) 
    {
        $this->href = $href;
    }
    
    public function getOnClick() 
    {
        return $this->onClick;
    }

    public function setOnClick($onClick) 
    {
        $this->onClick = $onClick;
    }

    public function getIcon() 
    {
        return $this->icon;
    }

    public function setIcon($icon) 
    {
        $this->icon = $icon;
    }
    
    public function getAction() 
    {
        return $this->action;
    }

    public function setAction($action) 
    {
        $this->action = $action;
    }
}

?>
