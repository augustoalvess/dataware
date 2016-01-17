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
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Session\Container;
 
use Dataware\Entity\UserAccount;
use Dataware\Dao\LoginDao;

class LoginController extends Controller
{
    protected $form;
    protected $storage;
     
    /**
     * Retorna o controle de armazenamento da sessão.
     * 
     * @return type
     */
    public function getSessionStorage()
    {
        if ( !$this->storage ) 
        {
            $this->storage = $this->getServiceLocator()->get('Dataware\Controller\AuthStorageController');
        }
         
        return $this->storage;
    }
    
    /**
     * @param \Zend\Mvc\MvcEvent $e
     * @return mixed
     */
    public function onDispatch(\Zend\Mvc\MvcEvent $e) 
    {
        return parent::onDispatch($e, false);
    }
     
    /**
     * Ação de login no sistema.
     * 
     * @return array
     */    
    public function loginAction()
    {
        $data = $this->getRequest()->getPost();
        $form = $this->getFormLogin();        
        $form->setData($data);
        
        if ( $this->getServiceLocator()->get('ServiceLocator')->hasIdentity() )
        {
            $this->redirect()->toRoute("start");
        }
        else if ( array_key_exists('login', $data) )
        {
            if ( $form->isvalid() )
            {
                $em = $this->getEntityManager();
                $loginDao = new LoginDao($em);
                $dataLogin = $loginDao->findLoginByUsername($data['login']);
                $data['id'] = $dataLogin['id'];
                
                $this->authenticate($data);
            }
            
            $this->displayErrorMessages($form->getMessages());
        }
        
        return array('form' => $form);
    }
    
    /**
     * Método de autenticação do sistema.
     * 
     * @param String $login
     * @param String $senha
     * @return boolean
     */
    public function authenticate($data)
    {
        $authService = $this->getServiceLocator()->get('ServiceLocator');
        
        $adapter = $authService->getAdapter();
        $adapter->setIdentityValue($data['login']);
        $adapter->setCredentialValue($data['password']);
        $authResult = $authService->authenticate();
        
        if ( $authResult->isValid() ) 
        {
            $userSession = new Container('Login');
            $userSession->login = $data['login'];
            $userSession->iduser = $data['id'];

            $this->redirect()->toRoute("start");
        }
        else
        {
            $this->flashMessenger()->addErrorMessage("Usuário e(ou) senha inválidos.");
            $this->redirect()->toRoute('login');
        }
    }
    
    /**
     * Gera o formulário de login/autenticação no sistema.
     * 
     * @return type
     */
    private function getFormLogin()
    {
        if ( !$this->form ) 
        {
            $login = new UserAccount();
            $builder = new AnnotationBuilder();
            
            $this->form = $builder->createForm($login);
        }
         
        return $this->form;
    }
     
    /**
     * Ação de logout.
     * 
     * @return type
     */
    public function logoutAction()
    {
        //$this->getSessionStorage()->forgetMe();
        $this->getServiceLocator()->get('AuthenticationService')->clearIdentity();
        
        $userSession = new Container('Login');
        unset($userSession->login);
        unset($userSession->iduser);
        
        $this->flashMessenger()->addInfoMessage("Você foi desconectado.");
        return $this->redirect()->toRoute('login');
    }
}
