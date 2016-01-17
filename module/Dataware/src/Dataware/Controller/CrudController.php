<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CrudController
 *
 * @author augusto
 */
namespace Dataware\Controller;

use Dataware\Controller\Controller;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;

class CrudController extends Controller
{    
    /**
     * Primeira ação a ser executada.
     * Por padrão, executa a ação de busca, responsável por carregar
     * a grid.
     */
    public function indexAction($args = array())
    {
        $warningConfirm = $this->params()->fromQuery('warningConfirm');
        
        if ( (boolean)$warningConfirm )
        {
            $this->deleteAction();
        }
        
        $dataGrid = $this->getEntityManager()->getRepository($this->getCurrentEntity())->findBy($args);
        $argsAction = array(
            'entity' => $this->getCurrentEntity(),
            'caption' => $this->getCurrentCaption(),
            'icon' => $this->getCurrentIcon(),
            'dataGrid' => $dataGrid
        );
        
        $viewModel = $this->defineViewModelTemplate(new ViewModel($argsAction), 'index');
        
        return $viewModel;
    }
    
    /**
     * Ação padrão para adicionar novos registros.
     */
    public function addAction()
    {
        $request = $this->getRequest();
        $caption = $this->getCurrentCaption();
        $icon = $this->getCurrentIcon();
        
        $entityClass = $this->getCurrentEntity();        
        $entity = new $entityClass();
        $form = $this->getForm($entity);
        
        $args = array(
            'form' => $form, 
            'caption' => $caption,
            'icon' => $icon
        );
            
        if ( $request->isPost() ) 
        {
            $postData = $this->getPostData();
            $form->setData($postData);
            
            if ( $form->isValid() )
            {
                $this->populateEntityToMergeOrPersist($entity, $postData);

                $this->getEntityManager()->persist($entity);
                $this->getEntityManager()->flush();
                $id = $entity->getId();

                $this->flashMessenger()->addSuccessMessage("Registro inserido com sucesso!");
                return $this->redirect()->toRoute($this->getCurrentRoute(), array('id' => $id));
            }
            else
            {
                $this->displayErrorMessages($form->getMessages(), array(), array('query' => $postData));
            }
        }
        
        return $this->defineViewModelTemplate(new ViewModel($args), $this->getCurrentAction());
    }
    
    /**
     * Ação padrão para edição de registros.
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();
        
        $entityClass = $this->getCurrentEntity();
        $entity = $this->getEntityManager()->find($entityClass, $id);
        $form = $this->getForm($entity);
        
        $args = array(
            'id' => $id,
            'form' => $form,
            'caption' => $this->getCurrentCaption(),
            'icon' => $this->getCurrentIcon()
        );
        
        if ( $request->isPost() ) 
        {
            $postData = $this->getPostData();
            $form->setData($postData);
            
            if ( $form->isValid() )
            {
                $this->populateEntityToMergeOrPersist($entity, $postData);
                
                $this->getEntityManager()->persist($entity);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addSuccessMessage("Registro atualizado com sucesso!");
                return $this->redirect()->toRoute($this->getCurrentRoute());
            }
            else
            {
                $this->displayErrorMessages($form->getMessages(), $args, array('query' => $postData));
            }
        }
        
        return $this->defineViewModelTemplate(new ViewModel($args), $this->getCurrentAction());
    }
    
    /**
     * Ação padrão de exclusão de registros.
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $warningConfirm = $this->params()->fromQuery('warningConfirm');
        
        $entityClass = $this->getCurrentEntity();
        $entity = $this->getEntityManager()->find($entityClass, $id);

        if ( (boolean)$warningConfirm ) 
        {
            $rmFilesDir = array();
            
            // Remove os arquivos atrelados aos atributos da entidade.
            foreach ( (Array)$entity as $attribute )
            {
                if ( $attribute instanceof \Dataware\Entity\File )
                {
                    $rmFilesDir[] = dirname(__DIR__) . "/../../../../public/" . $attribute->getFolder() . "/" . $attribute->getId();
                }
            }           
            
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
            
            $rmFilesDir[] = dirname(__DIR__) . "/../../../../public/uploads/entities/" . strtolower($this->getCurrentRoute()) . "/" . $id;
            
            foreach ( $rmFilesDir as $rmFileDir )
            {
                if ( is_dir($rmFileDir) )
                {                
                    // Remove os anexos da entidade, caso existirem.
                    $this->rmdir_rf($rmFileDir);
                }
                else if ( file_exists($rmFileDir) )
                {
                    unlink($rmFileDir);
                }
            }

            $this->flashMessenger()->addSuccessMessage("Registro removido com sucesso!");
        }
        else
        {
            $this->flashMessenger()->addWarningMessage("Você têm certeza de que deseja remover este registro?");
        }
        
        $this->redirect()->toRoute($this->getCurrentRoute(), array('id' => $id));
    }
    
    /**
     * Interface de manutenção de arquivos e anexos.
     * 
     * @return type
     */
    public function attachmentsAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $entityExp = explode("\\", $this->getCurrentEntity());
        
        $attachment = $this->params()->fromQuery('attachment');
        $warningConfirm = $this->params()->fromQuery('warningConfirm');
        
        // Para remoção de anexos.
        if ( (boolean)$warningConfirm && strlen($attachment) > 0 )
        {
            $this->removeattachmentAction();
        }
        
        $argsAction = array(
            'id' => $id,
            'entity' => $entityExp[count($entityExp) -1],
            'caption' => $this->getCurrentCaption(),
            'icon' => $this->getCurrentIcon()
        );
        
        $viewModel = $this->defineViewModelTemplate(new ViewModel($argsAction), $this->getCurrentAction());
        
        return $viewModel;
    }
    
    /**
     * Remove um anexo do servidor.
     */
    public function removeattachmentAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0); // id proprietário do anexo.
        $attachment = $this->params()->fromQuery('attachment');  // From GET
        $warningConfirm = $this->params()->fromQuery('warningConfirm'); // Verificação de confirmação da remoção.
        
        if ( (boolean)$warningConfirm && strlen($attachment) > 0 )
        {
            $filePath = dirname(__DIR__) . "/../../../../public/uploads/entities/" . strtolower($this->getCurrentRoute()) . "/" . $id . "/" . $attachment;
            
            if ( file_exists($filePath) )
            {
                unlink($filePath);
                $this->flashMessenger()->addSuccessMessage("Anexo removido com sucesso!");
            }
            else
            {
                $this->flashMessenger()->addErrorMessage("Ocorreram alguns problemas ao tentar remover o anexo!");
            }
        }
        else
        {
            $this->flashMessenger()->addWarningMessage("Você têm certeza de que deseja remover o anexo \"{$attachment}\"?");
        }
        
        $args = array(
            'action' => 'attachments',
            'id' => $id,
            'attachment' => $attachment
        );
        $this->redirect()->toRoute($this->getCurrentRoute(), $args);
    }
    
    /**
     * Ação padrão de visualização de registros.
     */
    public function viewAction()
    {
    }
    
    /**
     * Ação padrão de impressão de registros.
     */
    public function printAction()
    {   
    }
}

?>
