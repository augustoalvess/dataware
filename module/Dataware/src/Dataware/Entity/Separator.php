<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Separator
 *
 * @author augusto
 */
namespace Dataware\Entity;

class Separator 
{
    private $style;
    
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
