<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MultiUpload
 *
 * @author augusto
 */
namespace Dataware\Entity;

class Attachment
{
    /**
     *
     * @var int
     */
    private $entityId;
    
    /**
     *
     * @var String
     */
    private $entityName;
    
    public function __construct($entityId, $entityName) 
    {
        $this->entityId = $entityId;
        $this->entityName = $entityName;
    }
    
    public function getEntityId() 
    {
        return $this->entityId;
    }

    public function setEntityId($entityId) 
    {
        $this->entityId = $entityId;
    }

    public function getEntityName() 
    {
        return strtolower($this->entityName);
    }

    public function setEntityName($entityName) 
    {
        $this->entityName = $entityName;
    }
}

?>
