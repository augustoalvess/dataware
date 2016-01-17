<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TabHelper
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Dataware\View\Helper\ViewHelper;
use Dataware\Entity\Tab;

class TabHelper extends ViewHelper
{
    public function __invoke(Array $tabs) 
    {
        $tabRender = "<div class='tabs'>
                          <ul class='nav nav-tabs'>";
        
        $tabContent = "";
        
        if ( count($tabs) > 0 )
        {
            foreach ( $tabs as $tab )
            {
                if ( $tab instanceof Tab)
                {
                    $activeTabCssClass = $tab->getActive() ? "active" : "";
                    $tabRender .= "<li role='presentation' class='{$activeTabCssClass}'>
                                       <a href='#{$tab->getId()}' aria-controls='{$tab->getId()}' role='tab' data-toggle='tab'>{$tab->getTitle()}</a>
                                   </li>";
                            
                    $tabContent .= "<div role='tabpanel' class='tab-pane {$activeTabCssClass}' id='{$tab->getId()}'>
                                        {$tab->getContent()}
                                    </div>";
                }
            }
        }
        
        $tabRender .= "   </ul>
                      </div> 
                      <fieldset>
                          <div class='tab-content'>
                              {$tabContent}
                          </div>
                      </fieldset>";
        
        return $tabRender;
    }
}

?>
