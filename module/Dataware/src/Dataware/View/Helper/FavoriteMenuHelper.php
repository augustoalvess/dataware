<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FavoriteMenuHelper
 *
 * @author augusto
 */

namespace Dataware\View\Helper;

use Zend\Session\Container;
use Dataware\View\Helper\ViewHelper;
use Dataware\Entity\Menu;

class FavoriteMenuHelper extends ViewHelper
{
    public function __invoke(Menu $menu)
    {
        $usuarioSession = new Container('Login');
        $usuario_id = (strlen($usuarioSession->iduser) > 0) ? $usuarioSession->iduser : 0;
        $action = str_replace('$usuario_id', $usuario_id, $menu->getAction());
        
        return "<div class='col-xs-6 col-md-3 manager-link'>
                    <a href='{$action}' class='thumbnail loading'>
                        <div class='link-content'>
                            <i class='fa {$menu->getIcon()} fa-5x'></i>
                            <h3>{$menu->getTitle()}</h3>
                        </div>
                    </a>
                </div>";
    }
}

?>
