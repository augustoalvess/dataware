<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File
 *
 * @author augusto
 */
namespace Dataware\Entity;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="file")
 */
class File 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="file_id_seq", initialValue=1)
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255, columnDefinition="VARCHAR(255) NOT NULL")
     */
    private $title;
    
    /**
     * @ORM\Column(type="string", length=255, columnDefinition="VARCHAR(255) NOT NULL")
     */
    private $type;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $size;
    
    /**
     * @ORM\Column(type="string", length=255, columnDefinition="VARCHAR(255) NOT NULL")
     */
    private $folder;
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getTitle() 
    {
        return $this->title;
    }

    public function setTitle($title) 
    {
        $this->title = $title;
    }
    
    public function getType() 
    {
        return $this->type;
    }

    public function setType($type) 
    {
        $this->type = $type;
    }

    public function getSize() 
    {
        return $this->size;
    }

    public function setSize($size) 
    {
        $this->size = $size;
    }
    
    public function getFolder() 
    {
        return $this->folder;
    }

    public function setFolder($folder) 
    {
        $this->folder = $folder;
    }
}

?>
