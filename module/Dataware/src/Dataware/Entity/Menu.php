<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author augusto
 */

namespace Dataware\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="menu")
 */
class Menu 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="menu_id_seq", initialValue=1)
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Menu", fetch="EAGER")
     * @ORM\JoinColumn(name="fathermenu_id", referencedColumnName="id", nullable=true)
     */
    private $fathermenu;
    
    /**
     * @ORM\Column(type="string", length=255, nullable = false)
     */
    private $title;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $action;
    
    /**
     * @ORM\Column(type="string", length=45, nullable = false)
     */
    private $icon;
    
    /**
     * @ORM\Column(type="boolean", options={"default":true})
     */
    protected $active;
    
    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $favorite;
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }
    
    public function getFathermenu() 
    {
        return $this->fathermenu;
    }

    public function setFathermenu($fathermenu) 
    {
        $this->fathermenu = $fathermenu;
    }

    public function getTitle() 
    {
        return $this->title;
    }

    public function setTitle($title) 
    {
        $this->title = $title;
    }

    public function getAction() 
    {
        return $this->action;
    }

    public function setAction($action) 
    {
        $this->action = $action;
    }

    public function getIcon() 
    {
        return $this->icon;
    }

    public function setIcon($icon) 
    {
        $this->icon = $icon;
    }
    
    public function getActive() 
    {
        return $this->active;
    }

    public function setActive($active) 
    {
        $this->active = $active;
    }
    
    public function getFavorite() 
    {
        return $this->favorite;
    }

    public function setFavorite($favorite) 
    {
        $this->favorite = $favorite;
    }
}

?>
