<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dataware;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class Module
{
    const ENTITY_MANAGER = 'Doctrine\ORM\EntityManager';
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e)
        {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config = $e->getApplication()->getServiceManager()->get('config');
            
            if ( isset($config['module_layouts'][$moduleNamespace]) ) 
            {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'ServiceLocator' => function($sm) 
                {
                    return $sm->get('doctrine.authenticationservice.orm_default');
                },
                'AuthenticationService' => function($sm) 
                {
                    return $sm->get('doctrine.authenticationservice.orm_default');
                }
            )
        );
    }
    
    public function getViewHelperConfig()
    {
    	return array(
            'factories' => array(
                'LoadingHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);
                    return new View\Helper\LoadingHelper($em);
                },
                        
                'AlertHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);
                    return new View\Helper\AlertHelper($em);
                },
                        
                'SimpleAlertHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);
                    return new View\Helper\SimpleAlertHelper($em);
                },
                        
                'MenuHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);
                    return new View\Helper\MenuHelper($em);
                },
                        
                'FavoriteMenuHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);
                    return new View\Helper\FavoriteMenuHelper($em);
                },
                        
                'ViewHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);
                    return new View\Helper\ViewHelper($em);
                },
                        
                'PanelHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);
                    return new View\Helper\PanelHelper($em);
                },
                        
                'GridHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);
                    return new View\Helper\GridHelper($em);
                },
                        
                'GridActionHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);
                    return new View\Helper\GridActionHelper($em);
                },
                        
                'BreadCrumbHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\BreadCrumbHelper($em);
                },
                        
                'ToolbarHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\ToolbarHelper($em);
                },
                        
                'TabHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\TabHelper($em);
                },
                        
                'MultiUploaderHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\MultiUploaderHelper($em);
                },
                        
                'ListAttachmentFilesHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\ListAttachmentFilesHelper($em);
                },
                        
                'SeparatorHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\SeparatorHelper($em);
                },
                        
                'TreeMenuHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\TreeMenuHelper($em);
                },
                        
                'ButtonHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\ButtonHelper($em);
                },
                        
                'ButtonGroupHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\ButtonGroupHelper($em);
                },
                        
                'DiaryHelper' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\DiaryHelper($em);
                },
                        
                'fieldCollection' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\FieldCollection($em);
                },
                        
                'fieldRow' => function ($sm) 
                {
                    $em = $sm->getServiceLocator()->get(Module::ENTITY_MANAGER);   				
                    return new View\Helper\FieldRow($em);
                },
            )
    	);
    }
}
