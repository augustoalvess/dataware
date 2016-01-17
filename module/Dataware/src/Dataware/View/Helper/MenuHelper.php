<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TecnonMenuView
 *
 * @author augusto
 */

namespace Dataware\View\Helper;

use Dataware\View\Helper\ViewHelper;
use Dataware\Dao\MenuDao;
use Zend\Session\Container;
use Zend\View\Helper\BasePath;

class MenuHelper extends ViewHelper
{    
    public function __invoke()
    {
        $userSession = new Container('Login');
        $idUser = (strlen($userSession->iduser) > 0) ? $userSession->iduser : 0;
        $userAccount = $this->getEntityManager()->find('Dataware\Entity\UserAccount', $idUser);
        
        if ( $userAccount instanceof \Dataware\Entity\UserAccount )
        {            
            $menu .= "<nav class='menu' role='navigation'>
                          <div class='container'>
                              <div class='collapse navbar-collapse'>
                                  <a href='/' title='Home' class='loading'>
                                      <div class='home'>
                                          <i class='img-home fa fa-home fa-3x'></i>
                                      </div>
                                  </a>
                                  
                                  {$this->getItemsMenu()}
                                  
                                  <ul class='nav navbar-nav' style='float:right; min-width:160px;'>
                                      <li class='dropdown' style='width:100%'>
                                          <a href='' class='dropdown-toggle' data-toggle='dropdown' style='text-align: right'>
                                              {$userAccount->getName()}&nbsp;&nbsp;<i class='fa fa-user'></i>
                                              <b class='caret'></b>
                                          </a>
                                          <ul class='dropdown-menu'>
                                              <li>
                                                  <a class='loading' href='/manager/user/edit/{$userAccount->getId()}'>Editar perfil</a>
                                              </li>
                                              <li>
                                                  <a href='javascript:void(0)' onclick='javascript:logoutMessage()'>
                                                      Efetuar logout&nbsp;<i class='img-logout fa fa-power-off'></i>
                                                  </a>
                                              </li>
                                          </ul>
                                      </li>
                                  </ul>
                                  
                              </div>
                          </div>
                      </nav>";
        }
        
        return $menu;
    }
    
    /**
     * Retorna os módulos para popular o menu conforme permições do usuário.
     * 
     * @return string html
     */
    private function getItemsMenu()
    {   
        $menuDao = new MenuDao($this->getEntityManager());
        $menuItems = $menuDao->getActiveFatherMenuItemsList();
        
        if ( count($menuItems) > 0 )
        {
            foreach ( $menuItems as $key => $menuItem )
            {
                $menuItems[$key]['suns'] = $menuDao->getActiveSubMenuItemsList($menuItem['id']);
            }
        }
        
        return $this->getOptionsMenu($menuItems);
    }
    
    /**
     * Monta as opções do menu.
     * 
     * @param type $options
     * @return type
     */
    public function getOptionsMenu($options)
    {
        $optionsMenu = "<ul class='nav navbar-nav'>";
        
        if ( count($options) > 0 )
        {
            foreach ( $options as $option )
            {   
                // Monta o pai.
                $optionsMenu .= "<li class='dropdown'>
                                     <a href='' class='dropdown-toggle' data-toggle='dropdown'>
                                         <i class='fa {$option['icon']}'></i>&nbsp;
                                         {$option['title']}
                                         <b class='caret'></b>
                                     </a>";

                // Monta os filhos.
                if ( count($option['suns']) > 0 )
                {
                    $optionsMenu .= "<ul class='dropdown-menu'>";

                    foreach ( $option['suns'] as $sun )
                    {
                        $optionsMenu .= "<li>
                                             <a class='loading' href='{$sun['action']}'>
                                                 <i class='fa {$sun['icon']}'></i>&nbsp;
                                                 {$sun['title']}
                                             </a>
                                         </li>";
                    }

                    $optionsMenu .= "</ul>";
                }

                $optionsMenu .= "</li>";
            }
        }
        
        $optionsMenu .= "</ul>";
        
        return $optionsMenu;
    }
}

?>
