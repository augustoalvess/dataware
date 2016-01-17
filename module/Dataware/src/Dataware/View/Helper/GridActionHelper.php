<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GridActionHelper
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Dataware\Entity\GridAction;

class GridActionHelper extends ViewHelper
{
    public function __invoke(GridAction $gridAction) 
    {
        $urlHelper = $this->getUrlHelper();
        $args = $gridAction->getArgs();
        $args['action'] = $gridAction->getAction();
        
        $content = "<a class='action-grid' 
                       title='{$gridAction->getTitle()}' 
                       href='{$urlHelper($gridAction->getRoute(), $args)}' 
                       onClick='{$gridAction->getOnClick()}'>
                        <i class='fa {$gridAction->getCssClass()} fa-lg'></i>
                    </a>";
        
        return $content;
    }
}

?>
