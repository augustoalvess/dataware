<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TreeMenuHelper
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Dataware\Model\TreeMenu;

class TreeMenuHelper extends ViewHelper
{
    public function __invoke(TreeMenu $treeMenu) 
    {
        $selectedItemId = $treeMenu->getSelectedItemId();
        $openParentId = "";
        
        $treeMenuContent = "<ul class='treeview'>";
        
        foreach ( $treeMenu->getContent() as $content )
        {
            $title = $content['title'];
            
            if ( !is_null($content['href']) )
            {
                $title = "<a href='{$content['href']}'>$title</a>";
            }
            
            $treeMenuContent .= "<li id='tree_item_{$content['id']}'>{$title}";
            
            if ( count($content['subitens']) > 0 )
            {
                $treeMenuContent .= "<ul>";
                
                foreach ( $content['subitens'] as $subitem )
                {
                    $subtitle = $subitem['title'];
                    $itemSelectedCss = "";
                    
                    if ( !is_null($subitem['href']) )
                    {
                        $subtitle = "<a href='{$subitem['href']}'>$subtitle</a>";
                    }
                    
                    if ( $selectedItemId == $subitem['id'] )
                    {
                        $openParentId = $content['id'];
                        $itemSelectedCss = "tree_item_selected";
                    }
                    
                    $treeMenuContent .= "<li id='tree_item_{$subitem['id']}' class='{$itemSelectedCss}'>{$subtitle}</li>";
                }
                
                $treeMenuContent .= "</ul>";
            }
            
            $treeMenuContent .= "</li>";
        }
        
        $treeMenuContent .= "</ul>
                             <script>
                                 $('.treeview').treeView();
                                 document.getElementById('tree_item_{$openParentId}').click();
                             </script>";
        
        return $treeMenuContent;
    }
}

?>
