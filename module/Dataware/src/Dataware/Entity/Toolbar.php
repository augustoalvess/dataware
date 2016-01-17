<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Toolbar
 *
 * @author augusto
 */
namespace Dataware\Entity;

class Toolbar 
{    
    const TB_ACTION_NEW = 'tb_action_new';
    const TB_ACTION_EDIT = 'tb_action_edit';
    const TB_ACTION_SAVE = 'tb_action_save';
    const TB_ACTION_VIEW = 'tb_action_view';
    const TB_ACTION_DELETE = 'tb_action_delete';
    const TB_ACTION_SEARCH = 'tb_action_search';
    const TB_ACTION_UNIFY = 'tb_action_unify';
    const TB_ACTION_CLONE = 'tb_action_clone';    
    const TB_ACTION_PRINT = 'tb_action_print';
    const TB_ACTION_BACK = 'tb_action_back';
    const TB_ACTION_ATTACHMENTS = 'tb_action_attachments';
    
    /**
     * @var boolean
     */
    private $showDefaultToolbarActions = true;
    
    /**
     * @var array
     */
    private $addCustomToolbarActions = array();
    
    /**
     * @var array
     */
    private $disableToolbarActions = array();
    
    /**
     *
     * @var array
     */
    private $enableToolbarActions = array();
    
    /**
     * @var array
     */
    private $removeToolbarActions = array();
    
    /**
     * @var array
     */
    private $toolbarActions = array();
    
    public function __construct($toobarActions = array())
    {
        $this->toolbarActions = $toobarActions;
    }
    
    public function getShowDefaultToolbarActions() 
    {
        return $this->showDefaultToolbarActions;
    }

    public function setShowDefaultToolbarActions($showDefaultToolbarActions) 
    {
        $this->showDefaultToolbarActions = $showDefaultToolbarActions;
    }

    public function getAddCustomToolbarActions() 
    {
        return $this->addCustomToolbarActions;
    }

    public function setAddCustomToolbarActions($addCustomToolbarActions) 
    {
        $this->addCustomToolbarActions = $addCustomToolbarActions;
    }

    public function getDisableToolbarActions() 
    {
        return $this->disableToolbarActions;
    }

    public function setDisableToolbarActions($disableToolbarActions) 
    {
        $this->disableToolbarActions = $disableToolbarActions;
    }
    
    public function getEnableToolbarActions() 
    {
        return $this->enableToolbarActions;
    }

    public function setEnableToolbarActions($enableToolbarActions) 
    {
        $this->enableToolbarActions = $enableToolbarActions;
    }

    public function getRemoveToolbarActions() 
    {
        return $this->removeToolbarActions;
    }

    public function setRemoveToolbarActions($removeToolbarActions) 
    {
        $this->removeToolbarActions = $removeToolbarActions;
    }

    public function getToolbarActions() 
    {
        return $this->toolbarActions;
    }

    public function setToolbarActions(Array $toolbarActions) 
    {
        $this->toolbarActions = $toolbarActions;
    }
    
    public function addToolbarAction(ToolbarAction $toolbarAction)
    {
        $this->toolbarActions[$toolbarAction->getId()] = $toolbarAction;
    }
    
    public function disableToolbarAction($toolbarActionId)
    {        
        if ( $this->toolbarActions[$toolbarActionId] instanceof ToolbarAction )
        {
            $this->toolbarActions[$toolbarActionId]->setEnabled(false);
        }
    }
    
    public function enableToolbarAction($toolbarActionId)
    {        
        if ( $this->toolbarActions[$toolbarActionId] instanceof ToolbarAction )
        {
            $this->toolbarActions[$toolbarActionId]->setEnabled(true);
        }
    }
    
    public function removeToolbarAction($toolbarActionId)
    {
        unset($this->toolbarActions[$toolbarActionId]);
    }
}

?>
