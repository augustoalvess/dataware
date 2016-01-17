<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author augusto
 */
namespace Dataware\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Helper\ServerUrl;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\Form;
use Zend\Form\Element\Select;
use Zend\Form\Element\Password;
use Zend\Form\Element\Hidden;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class Controller extends AbstractActionController
{
    const ROUTE_DEFAULT = 'login';
    const ENTITY_PARAM = 'entity';
    const CONTROLLER_PARAM = 'controller';
    const MODULE_PARAM = 'module';
    const CUSTOM_TEMPLATE = 'template';
    const CAPTION = 'caption';
    const ICON = 'icon';
    const STR_NENHUM_REGISTRO = "";
    
    protected $route;
    protected $entityName;
    protected $em;

    public function getRoute() 
    {
        return $this->route;
    }

    public function setRoute($route) 
    {
        $this->route = $route;
    }
    
    public function getEntityName() 
    {
        $this->getEvent()->getRouteMatch()->getParam(self::ENTITY_PARAM);
        return $this->entityName;
    }

    public function setEntityName($entityName) 
    {
        $this->entityName = $entityName;
    }
    
    /**
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Retorna administrador de entidades para consultas diversas.
     * 
     * @return array|\Doctrine\ORM\EntityManager|object
     */
    public function getEntityManager()
    {
        if ( !$this->em ) 
        {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->em;
    }
    
    /**
     * @param \Zend\Mvc\MvcEvent $e
     * @return mixed
     */
    public function onDispatch(MvcEvent $e, $validate = true) 
    {
        if ( $validate && !$this->getServiceLocator()->get('ServiceLocator')->hasIdentity() )
        {
            $this->redirect()->toRoute(self::ROUTE_DEFAULT);
        }

        return parent::onDispatch($e);
    }
    
    /**
     * Retorna o módulo atual da rota.
     * 
     * @return String
     */
    public function getCurrentModule()
    {
        $entity = $this->getEvent()->getRouteMatch()->getParam(self::MODULE_PARAM);
        return $entity;
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
     * Retorna a rota atual.
     * 
     * @return String
     */
    public function getCurrentRoute()
    {   
        $route = $this->getEvent()->getRouteMatch()->getMatchedRouteName();
        return $route;
    }
    
    /**
     * Retorna a ação atual executada da rota.
     * 
     * @return string
     */
    public function getCurrentAction()
    {
        $action = $this->getEvent()->getRouteMatch()->getParam('action', 'index');
        return $action;
    }
    
    /**
     * Retorna a entidade atual.
     * 
     * @return String
     */
    public function getCurrentEntity()
    {
        $entity = $this->getEvent()->getRouteMatch()->getParam(self::ENTITY_PARAM);
        return $entity;
    }
    
    /**
     * Retorna a view para onde será redirecionada a entidade.
     * 
     * @return String
     */
    public function getCustomTemplate($action)
    {
        $template = $this->getEvent()->getRouteMatch()->getParam(self::CUSTOM_TEMPLATE);
        return $template[$action];
    }
    
    /**
     * Retorna a descrição da rota atual.
     * 
     * @return String
     */
    public function getCurrentCaption()
    {
        $caption = $this->getEvent()->getRouteMatch()->getParam(self::CAPTION);
        return $caption;
    }
    
    /**
     * Retorna a classe css do ícone atual.
     * 
     * @return String
     */
    public function getCurrentIcon()
    {
        $caption = $this->getEvent()->getRouteMatch()->getParam(self::ICON);
        return $caption;
    }
    
    /**
     * Retorna o controlador atual.
     * 
     * @return String
     */
    public function getCurrentController()
    {
        $controller = $this->getEvent()->getRouteMatch()->getParam(self::CONTROLLER_PARAM);
        return $controller;
    }
    
    /**
     * Popula os atributos de uma entidade, com os
     * valores recebidos pelo post.
     * 
     * @param ORM/Object $entity
     * @param array $data
     */
    protected function populateEntityToMergeOrPersist($entity, $data)
    {    
        $builder = new AnnotationBuilder();    
        $form = $builder->createForm($entity);
        
        // Percorre os dados dos atributos recebidos.
        foreach ( $data as $attribute => $value )
        {
            $lowerAttribute = strtolower($attribute);
            $setFunction = "set" . ucfirst($lowerAttribute);
            $getFunction = "get" . ucfirst($lowerAttribute);
            
            // Percorre os attributos da entidade, para reconhecimento de elementos especiais.
            foreach ( $form->getElements() as $element )
            {
                // Para registrar o usuário logado automáticamente, se configurado para isso.
                if ( $element->getOption("current_user") && ($element->getAttribute('name') == $attribute) )
                {
                    $userSession = new Container('Login');
                    $value = $this->getEntityByElementField($element, $userSession->iduser);
                    break;
                }   
                
                // Para campos de senha.
                if ( ( $element instanceof Password ) && ( $element->getAttribute('name') == $attribute ) )
                {
                    $value = md5($value);
                }
                
                /**
                 * Se estiver recebendo um arquivo nos dados do post, deverá primeiro efetuar o upload do arquivo
                 * e registrar o arquivo na system.file. Após o registro, então será populado o atributo referente ao relacionamento
                 * do arquivo, na entidade principal do registro.
                 */
                if ( ($element instanceof \Zend\Form\Element\File) && (!is_null($element->getOption('entity'))) && ($element->getAttribute('name') == $attribute) )
                {                    
                    /**
                     * Como deverá funcionar o algoritmo:
                     * -Verifica se a entidade principal, já possui um arquivo registrado para o attributo;
                     * -Se não existir, efetua o upload do arquivo, e monta a referencia normalmente;
                     * -Se já existir, remove o arquivo físico velho, faz o upload do arquivo físico novo, 
                     * e atualiza o registro do arquivo na base de dados, contemplando os dados do novo arquivo.
                     */                    
                    if ( method_exists($entity, $getFunction) )
                    {
                        $originalFile = $entity->$getFunction();
                    
                        // Verifica se a entidade principal, já possui um arquivo registrado para o attributo;
                        if ( $originalFile instanceof \Dataware\Entity\File && !is_null($originalFile->getId()) )
                        {                            
                            $fileId = $originalFile->getId();
                            
                            if ( (strlen($value['type']) > 0) )
                            {
                                // Remover o arquivo físico velho, sem remove-lo da base.
                                $this->removeFile($originalFile, false);

                                // Efetua upload do arquivo físico novo, sem registrá-lo na base.
                                // Ajusta os dados da base do arquivo velho, recebendo as informações do novo, e atualiza o registro na base.
                                $this->uploadFile($value, $fileId);
                            }
                        }
                        else
                        {   
                            $fileId = $this->uploadFile($value);
                        }
                        
                        $value = $this->getEntityByElementField($element, $fileId);
                    }
                    
                    break;
                }
                
                if ( (!is_null($element->getOption('entity'))) && ($element->getAttribute('name') == $attribute) )
                {   
                    $value = $this->getEntityByElementField($element, $value);                    
                    break;
                }
            }

            if ( method_exists($entity, $setFunction) )
            {
                $entity->$setFunction($value);
            }
        }
    }
    
    /**
     * Verifica se o elemento deve ser populado,
     * a partir de sua entidade concebida.
     * 
     * @param \Zend\Form\Element\Select $element
     * @return boolean
     */
    public function elementMustBePopulated($element)
    {
        return (!is_null($element->getOption('entity')) && !($element->getOption('populate') == "false"));
    }
    
    /**
     * Ajusta os registros populados na entidade,
     * para contemplar o formato requerido do formulário.
     * 
     * @param ORM/Object $entity
     * @return Form
     */
    public function getFormBindByEntity($entity)
    {
        $request = $this->getRequest();
        $builder  = new AnnotationBuilder();    
        $form = $builder->createForm($entity);
        
        if ( !$request->isPost() )
        {
            $this->adjustOfSpecialElements($form);

            foreach ( $form->getElements() as $element )
            {
                if ( $this->elementMustBePopulated($element) )
                {
                    $attributeName = $element->getAttribute('name');
                    $setFunction = "set" . $attributeName;
                    $getFunction = "get" . $attributeName;

                    if ( is_object($entity->$getFunction()) )
                    {
                        $entity->$setFunction($entity->$getFunction()->getId());
                    }
                }
            }

            if ( !is_null($entity->getId()) )
            {
                $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), get_class($entity)));
                $form->bind($entity);
            }
        }
        
        return $form;
    }
    
    /**
     * Ajusta os elementos especiais do formulário,
     * como por exemplo os campos de tipo select, que
     * deverão listar todos os registros de uma entidade
     * por padrão.
     * 
     * @param \Zend\Form\Form $form
     */
    public function adjustOfSpecialElements(Form $form)
    {
        foreach ( $form->getElements() as $element )
        {
            if ( ($element instanceof Select) && $this->elementMustBePopulated($element) )
            {
                // Obtém os registros de listagens padrões, a partir da entidade definida para o campo.
                $results = $this->getListValuesToSelectElement($element);
                $listValues = array($element->getEmptyOption() => self::STR_NENHUM_REGISTRO);
                $element->setEmptyOption(null);

                foreach ( $results as $result )
                {
                    $title = !empty($result['title']) ? $result['title'] : $result['nome'];
                    $listValues[$result['id']] = $title;
                }

                $form->get($element->getAttribute('name'))->setValueOptions($listValues);
            }
        }
    }
            
    /**
     * Retorna todos os registros para serem populados em campos de tipo select,
     * conforme registros padrões 'id' e 'title'.
     * 
     * @param Select $element
     * @return array
     */
    public function getListValuesToSelectElement(Select $element)
    {       
        $entityName = $element->getOption('entity');
        $entity = new $entityName();
        
        $repository = $this->getEntityManager()->getRepository($entityName);
        
        if ( method_exists($entity, "getTitle") )
        {
            $query = $repository->createQueryBuilder("list")
                                ->select("list.id, list.title")
                                ->orderBy("list.title")
                                ->getQuery();
        }
        else if ( method_exists($entity, "getNome") )
        {   
            $query = $repository->createQueryBuilder("list")
                                ->select("list.id, list.nome")
                                ->orderBy("list.nome")
                                ->getQuery();
        }
        else
        {
            exit("Atributo de descriçao nao definido para a entidade " . $entityName);
        }
        
        $result = $query->getResult();
        
        return $result;
    }
    
    /**
     * Gera e popula um objeto pela entidade registrada para
     * o elemento do formulário.
     * 
     * @param Element $element
     * @param int $id
     * @return Entity
     */
    private function getEntityByElementField($element, $id)
    {
        $entityName = $element->getOption('entity'); // Obter o namespace da entidade relacional do atributo.        
        $entityRep = $this->getEntityManager()->getRepository($entityName);        
        $value = $entityRep->findOneBy(array('id' => $id));
        
        return $value;
    }
    
    /**
     * Valida se o arquivo é um arquivo válido para upload.
     * 
     * @param array $fileArgs
     * @return boolean
     * @throws Exception
     */
    private function validateFile(array $fileArgs)
    {
        $size = new \Zend\Validator\File\Size(array('max' => 2000000, 'min' => 2000));
        $return = true;
        
        $adapter = new \Zend\File\Transfer\Adapter\Http(); 
        $adapter->setValidators(array($size), $fileArgs['name']);

        if ( !$adapter->isValid() )
        {
            $dataError = $adapter->getMessages();
            $errors = "";

            foreach ( $dataError as $key => $row )
            {
                $errors .= $row . "<br>";
            }

            $return = false;
            throw new \Exception($errors);
        } 
            
       return $return;
    }
    
    /**
     * Efetua o upload e registro de um arquivo.
     * 
     * @param array $fileArgs
     * @return int
     */
    private function uploadFile(array $fileArgs, $fileId = null)
    {
        try
        {
            if ( (strlen($fileArgs['type']) > 0) && $this->validateFile($fileArgs) )
            {   
                $year = date('Y');
                $month = date('m');
                $day = date('d');
                
                $folder = "uploads/" . $year . '/' . $month . '/' . $day;
                $filePath = dirname(__DIR__) . "/../../../../public/" . $folder;

                if ( !is_dir($filePath) )
                {
                    mkdir($filePath, 0777, true);
                }
                
                $file = new \Dataware\Entity\File();
                    
                if ( !is_null($fileId) )
                {
                    $file = $this->getEntityManager()->find('Dataware\Entity\File', $fileId);
                }

                $file->setTitle($fileArgs['name']);
                $file->setType($fileArgs['type']);
                $file->setSize($fileArgs['size']);
                $file->setFolder($folder);

                $this->getEntityManager()->persist($file);
                $this->getEntityManager()->flush();

                $fileId = $file->getId();
                
                if ( strlen($fileId) > 0 )
                {
                    $adapter = new \Zend\File\Transfer\Adapter\Http(); 
                    $adapter->setDestination($filePath);
                    
                    $adapter->receive($fileArgs['name']);
                    
                    rename("{$filePath}/{$fileArgs['name']}", "{$filePath}/{$fileId}");
                }
            } 

            return $fileId;
        }
        catch (Exception $err)
        {
            exit($err->getMessage());
        }
    }
    
    /**
     * Remove um arquivo de seu diretório atual.
     * 
     * @param \Dataware\Entity\File $file
     * @param $removeFromBase boolean
     */
    private function removeFile(\Dataware\Entity\File $file, $removeFromBase = true)
    {
        try
        {
            $filePath = dirname(__DIR__) . "/../../../../public/" . $file->getFolder();
            $fileName = $filePath . '/' . $file->getTitle();

            if ( file_exists($fileName) && unlink($fileName) )
            {
                if ( $removeFromBase )
                {                    
                    $this->getEntityManager()->remove($file);
                    $this->getEntityManager()->flush();
                }
            }
        }
        catch (Exception $err)
        {
            exit($err->getMessage());
        }
    }
    
    /**
     * Ação que efetua download de um arquivo anexado.
     */
    public function downloadfileAction()
    {
        $fileId = (int) $this->params()->fromRoute("id");
        
        if ( !empty($fileId) )
        {
            $file = $this->getEntityManager()->find("Dataware\Entity\File", $fileId);
            $filePath = dirname(__DIR__) . "/../../../../public/" . $file->getFolder();
            $fileName = $filePath . '/' . $file->getId();
            
            if ( file_exists($fileName) )
            {
                header('Cache-control: private');
                header('Content-Type: ' . $file->getType());
                header('Content-Length: ' . $file->getSize());
                header('Content-Disposition: filename=' . $file->getTitle());
                readfile($fileName);
            }
        }
        
        return true;
    }
    
    /**
     * Define o template que a visão irá utilizar,
     * caso tenha sido configurado um template costumizado,
     * o utiliza, se não, utiliza o padrão.
     * 
     * @param \Zend\View\Model\ViewModel $viewModel
     * @param $action String
     */
    public function defineViewModelTemplate(ViewModel $viewModel, $action)
    {
        $customTemplate = $this->getCustomTemplate($action);
        
        if ( !empty($customTemplate) )
        {
            $viewModel->setTemplate($customTemplate);
        }
        
        return $viewModel;
    }
    
    /**
     * Exibe as mensagens de erro ocasionadas no formulário,
     * ou em qualquer interface.
     * 
     * @param array $messages
     * @param String $action
     */
    public function displayErrorMessages(array $messages, $actionArgs = array(), $queryArgs = array())
    {
        foreach ( $messages as $errorTypes )
        {
            foreach ( $errorTypes as $errorType => $message )
            {                
                $this->flashMessenger()->addErrorMessage(str_replace("'", "\\'", $message));
            }
        }
        
        $actionArgs['action'] = $this->getCurrentAction();
        $this->redirect()->toRoute($this->getCurrentRoute(), $actionArgs, $queryArgs);
    }
    
    /**
     * Remove um diretório, junto com seus sub arquivos
     * e pastas.
     * 
     * @param String $dir
     */
    public function rmdir_rf($dir) 
    {
        if ( is_dir($dir) ) 
        {
            $objects = scandir($dir);

            if ( count($objects) > 0 )
            {
                foreach ( $objects as $object ) 
                {
                    if ( $object != "." && $object != ".." ) 
                    {
                        if ( filetype($dir . "/" . $object ) == "dir" ) 
                        {
                            rmdir_rf($dir . "/" . $object); 
                        }
                        else 
                        {
                            unlink($dir . "/" . $object);
                        }
                            
                    }
                }

                reset($objects);
            }
            
            rmdir($dir);
        }
    }
    
    /**
     * Monta e retorna o formulário da entidade.
     * 
     * @param String $objEntity
     * @return \Zend\Form\Form
     */
    public function getForm($objEntity)
    {        
        $form = $this->getFormBindByEntity($objEntity);
        $queryData = $this->getQueryData();
        
        if ( !empty($queryData) )
        {
            $form->setData($queryData);
        }
        
        return $form;
    }
    
    /**
     * Obtém dados do post.
     * 
     * @return array
     */
    public function getPostData()
    {
        $request = $this->getRequest();
        $postData = array_merge_recursive(
            $request->getPost()->toArray(),
            $request->getFiles()->toArray()
        );
        
        return $postData;
    }
    
    /**
     * Retorna os dados recebidos por GET
     * 
     * @return array
     */
    public function getQueryData()
    {
        return $this->params()->fromQuery();
    }
}

?>
