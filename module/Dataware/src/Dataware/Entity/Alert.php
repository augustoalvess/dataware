<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alert
 *
 * @author augusto
 */
namespace Dataware\Entity;

class Alert 
{
    private $message;
    private $type;
    private $showButtonClose;
    private $style;
    
    public function __construct($message, $type = 'danger', $showButtonClose = true, $style = null) 
    {
        $this->message = $message;
        $this->type = $type;
        $this->showButtonClose = $showButtonClose;
        $this->style = $style;
    }
    
    public function getMessage() 
    {
        return $this->message;
    }

    public function setMessage($message) 
    {
        $this->message = $message;
    }

    public function getType() 
    {
        return $this->type;
    }

    public function setType($type) 
    {
        $this->type = $type;
    }

    public function getShowButtonClose() 
    {
        return $this->showButtonClose;
    }

    public function setShowButtonClose($showButtonClose) 
    {
        $this->showButtonClose = $showButtonClose;
    }
    
    public function getStyle() 
    {
        return $this->style;
    }

    public function setStyle($style) 
    {
        $this->style = $style;
    }
}

?>
