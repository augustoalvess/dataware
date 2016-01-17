<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dataware\Controller;

use Dataware\Controller\Controller;
use Zend\View\Model\ViewModel;

use Dataware\Dao\MenuDao;

class StartController extends Controller
{
    public function startAction()
    {
        if ( !$this->getServiceLocator()->get('AuthenticationService')->hasIdentity() )
        {
            $this->redirect()->toRoute('login');
        }
        
        $menuDao = new MenuDao($this->getEntityManager());
        $favoritesMenuItems = $menuDao->getActiveFavoritesMenuItemsList();
         
        return new ViewModel(array('favorites' => $favoritesMenuItems));
    }
}
