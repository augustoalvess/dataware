<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TreeMenu
 *
 * @author augusto
 */
namespace Dataware\Entity;

class TreeMenu 
{
    private $content;
    private $selectedItemId;
    
    public function __construct(Array $content, $selectedItemId = null)
    {
        $this->content = $content;
        $this->selectedItemId = $selectedItemId;
    }
    
    public function getContent() 
    {
        return $this->content;
    }

    public function setContent($content) 
    {
        $this->content = $content;
    }
    
    public function getSelectedItemId() 
    {
        return $this->selectedItemId;
    }

    public function setSelectedItemId($selectedItemId) 
    {
        $this->selectedItemId = $selectedItemId;
    }
}

?>
