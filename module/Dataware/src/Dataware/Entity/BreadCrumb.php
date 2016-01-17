<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tree
 *
 * @author augusto
 */
namespace Dataware\Entity;

class BreadCrumb 
{
    private $module;
    
    private $route;
    
    private $action;
    
    public function __construct($module, $route, $action) 
    {
        $this->module = $module;
        $this->route = $route;
        $this->action = $action;
    }
    
    public function getModule() 
    {
        return $this->module;
    }

    public function setModule($module) 
    {
        $this->module = $module;
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
}

?>
