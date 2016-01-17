<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ButtonGroupHelper
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Dataware\View\Helper\ViewHelper;
use Dataware\Entity\Button;

class ButtonGroupHelper extends ViewHelper
{
    public function __invoke($buttons = array()) 
    {
        $buttonGroupRender = "<div class='buttongroup'>";
        
        if ( !empty($buttons) )
        {
            foreach ( $buttons as $button )
            {
                if ( $button instanceof Button )
                {
                    $buttonGroupRender .= $this->view->ButtonHelper($button);
                }
            }
        }
        
        $buttonGroupRender .= "</div>";
        
        return $buttonGroupRender;
    }
}

?>
