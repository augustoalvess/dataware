<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grid
 *
 * @author augusto
 */
namespace Dataware\Entity;

use Dataware\Entity\GridColumn;
use Dataware\Entity\GridAction;

class Grid 
{
    /**
     * @var ObjClass
     */
    private $entity;
    
    /**
     * @var array
     */
    private $columns = array();
    
    /**
     *
     * @var ArrayObject
     */
    private $data;
    
    /**
     * 
     * @var type 
     */
    private $hasEntity = true;
    
    /**
     *
     * @var type 
     */
    private $generateFieldset = true;
    
    /**
     *
     * @var array
     */
    private $gridActions = array();
    
    /**
     *
     * @var type 
     */
    private $gridHideActions = array();
    
    /**
     *
     * @var boolean
     */
    private $hideDefaultGridActions = false;
    
    /**
     *
     * @var array
     */
    private $identityColumns;
    
    /**
     *
     * @var type 
     */
    private $disableActions = array();
    
    public function __construct($data = null) 
    {
        if ( !is_null($data) )
        {
            $this->data = $data;
        }
        
        $this->identityColumns[] = GridColumn::GRID_IDENTITY_COLUMN_DEFAULT;
    }
    
    public function addColumn(GridColumn $gridColumn)
    {
        $this->columns[] = $gridColumn;
    }
    
    public function getEntity() 
    {
        return $this->entity;
    }

    public function setEntity($entity) 
    {
        $this->entity = $entity;
    }
        
    public function getColumns() 
    {
        return $this->columns;
    }

    public function setColumns($columns) 
    {
        $this->columns = $columns;
    }
        
    public function getData() 
    {
        return $this->data;
    }

    public function setData($data) 
    {
        $this->data = $data;
    }
    
    public function hasEntity() 
    {
        return $this->hasEntity;
    }

    public function setHasEntity($hasEntity) 
    {
        $this->hasEntity = $hasEntity;
    }
    
    public function getGenerateFieldset() 
    {
        return $this->generateFieldset;
    }

    public function setGenerateFieldset($generateFieldset) 
    {
        $this->generateFieldset = $generateFieldset;
    }
    
    public function getGridActions() 
    {
        return $this->gridActions;
    }

    public function setGridActions($gridActions) 
    {
        $this->gridActions = $gridActions;
    }
    
    public function getGridHideActions() 
    {
        return $this->gridHideActions;
    }

    public function setGridHideActions($gridHideActions) 
    {
        $this->gridHideActions = $gridHideActions;
    }
    
    public function defaultGridActionsAreHidden() 
    {
        return $this->hideDefaultGridActions;
    }

    public function hideDefaultGridActions($hideDefaultGridActions) 
    {
        $this->hideDefaultGridActions = $hideDefaultGridActions;
    }
    
    public function addGridAction(GridAction $gridAction)
    {
        $this->gridActions[] = $gridAction;
    }
    
    public function clearActions()
    {
        unset($this->gridActions);
    }
    
    public function getIdentityColumns() 
    {
        return $this->identityColumns;
    }

    public function setIdentityColumns($identityColumns) 
    {
        $this->identityColumns = $identityColumns;
    }
    
    public function getDisableActions() 
    {
        return $this->disableActions;
    }

    public function setDisableActions($disableActions) 
    {
        $this->disableActions = $disableActions;
    }
}

?>
