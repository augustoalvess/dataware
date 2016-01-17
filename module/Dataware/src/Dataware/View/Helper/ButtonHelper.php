<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ButtonHelper
 *
 * @author augusto
 */

namespace Dataware\View\Helper;

use Dataware\View\Helper\ViewHelper;
use Dataware\Entity\Button;

class ButtonHelper extends ViewHelper
{
    public function __invoke(Button $button) 
    {   
        if ( !is_null($button->getAction()) )
        {
            $button->setOnClick("window.location = '{$button->getAction()}';");
            $button->setHref("void(0)");
        }
        
        return "<button type='{$button->getType()}' 
                        href='{$button->getHref()}' 
                        onClick=\"{$button->getOnClick()}\" 
                        class='btn {$button->getClass()} loading'>
                    <i class='fa {$button->getIcon()}'></i>&nbsp;{$button->getValue()}
                </button>";
    }
}

?>
