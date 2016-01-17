<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TecnonView
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Helper\ServerUrl;
use Dataware\Entity\View;
use Dataware\Entity\Toolbar;
use Dataware\Entity\Panel;

class ViewHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * Recebe EntityManager do Doctrine.
     * 
     * @var EntityManegr
     */
    protected $entityManager;
    
    public $serviceLocator;
	
    /**
     * Retorna uma Entidade de trabalho para doctrine.
     * 
     * @return EntityManager.
     */
    public function __construct(EntityManager $em) 
    {
        $this->entityManager = $em;      
    }
    
    public function getServiceLocator() 
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) 
    {
        $this->serviceLocator = $serviceLocator;
    }
    
    /**
     * Retorna uma Entidade de trabalho para doctrine.
     * 
     * @return EntityManager.
     */
    public function getEntityManager()
    {
        if ( !$this->entityManager ) 
        {
            $this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        
        return $this->entityManager;
    }
    
    /**
     * Cria nova view recebendo o conteúdo por parâmetro
     * 
     * @param String html $insideElements
     */
    public function __invoke(View $view)
    {
        $viewRender = "";
        
        if ( $view->getToolbar() instanceof Toolbar )
        {
            $toolbar = $this->view->ToolbarHelper($view->getToolbar());
        }
        
        if ( $view->getPanel() instanceof Panel )
        {
            $panelContent = $view->getPanel()->getBody();
            $view->getPanel()->setBody($toolbar . $panelContent);
            
            $viewRender .= $this->view->PanelHelper($view->getPanel());
        }
        
        return $viewRender;
    }
    
    /**
     * Retorna a url atual.
     * 
     * @return String
     */
    public function getCurrentUrl()
    {
        $serverUrl = new ServerUrl();
        $currentUrl = $serverUrl->__invoke(true);
        
        return $currentUrl;
    }
    
    /**
     * Retorna instância de RouteMatch da rota atual.
     * Utilizado para obtenção de parâmetros configurados
     * na rota.
     * 
     * @return RouteMatch
     */
    public function getCurrentRouteMatch()
    {
        $sm = $this->getView()->getHelperPluginManager()->getServiceLocator();
        $router = $sm->get('Router');
        $request = $sm->get('Request');
        $routeMatch = $router->match($request);
        
        return $routeMatch;
    }
    
    /**
     * Retorna o caminho da rota atual.
     * 
     * @return String
     */
    public function getCurrentViewRoute()
    {
        $routeMatch = $this->getCurrentRouteMatch();
        $viewRoute = $routeMatch->getParam('module') . '/' . $routeMatch->getMatchedRouteName() . '/';
        
        return $viewRoute;
    }
    
    /**
     * Retorna a rota atual.
     */
    public function getCurrentRoute()
    {
        $routeMatch = $this->getCurrentRouteMatch();
        return $routeMatch->getMatchedRouteName();
    }
    
    /**
     * Retorna a ação atual executada da rota.
     * 
     * @return string
     */
    public function getCurrentAction()
    {
        $routeMatch = $this->getCurrentRouteMatch();
        $action = $routeMatch->getParam('action', 'index');
        
        return $action;
    }
    
    /**
     * Retorna a url completa da rota atual.
     * 
     * @return string
     */
    public function getCurrentRouteUrl()
    {
        $currentUrl = $this->getCurrentUrl();
        $expCurrentUrl = explode('/', $currentUrl);
        $baseUrl = $expCurrentUrl[0] . '//' . $expCurrentUrl[2] . '/';
        
        return $baseUrl . $this->getCurrentViewRoute();
    }
    
    /**
     * Retorna o id do registro atual sendo trabalhado
     * na interface.
     * 
     * @return int
     */
    public function getCurrentRegisterId()
    {
        $id = 0;
        $currentUrl = $this->getCurrentUrl();
        $urlExplode = explode('/', $currentUrl);
        
        if ( is_integer((int)$urlExplode[count($urlExplode) - 1]) )
        {
            $id = $urlExplode[count($urlExplode) - 1];
        }
        
        return $id;
    }
    
    /**
     * Retorna a entidade atual da rota.
     * 
     * @return type
     */
    public function getCurrentEntity()
    {
        $routeMatch = $this->getCurrentRouteMatch();
        $entity = $routeMatch->getParam('entity');
        
        return $entity;
    }
    
    /**
     * Retorna o nome da entidade, pela rota.
     * 
     * @return string
     */
    public function getCurrentEntityName()
    {
        $entity = $this->getCurrentEntity();
        $entityExplode = explode("\\", $entity);
        $entityName = $entityExplode[count($entityExplode) - 1];
        
        return $entityName;
    }
    
    public function getUrlHelper()
    {
        return $this->view->plugin('url');
    }
}

?>
