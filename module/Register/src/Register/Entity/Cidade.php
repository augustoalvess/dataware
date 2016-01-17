<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cidade
 *
 * @author augusto
 */

namespace Register\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="cidade")
 */
class Cidade 
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\SequenceGenerator(sequenceName = "cidade_id_seq", initialValue = 1)
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Register\Entity\Estado", fetch="EAGER")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable = false)
     */
    private $estado;
    
    /**
     * @ORM\Column(type = "string", nullable = false)
     */
    private $nome;
    
    /**
     * @ORM\Column(type = "integer")
     */
    private $ibge_id;
    
    /**
     * @ORM\Column(type = "integer", nullable = true)
     */
    private $populacao_2010;
    
    /**
     * @ORM\Column(type = "float", nullable = true)
     */
    private $densidade_demo;
    
    /**
     * @ORM\Column(type = "string", nullable = true)
     */
    private $gentilico;
    
    /**
     * @ORM\Column(type = "float", nullable = true)
     */
    private $area;
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getEstado() 
    {
        return $this->estado;
    }

    public function setEstado($estado) 
    {
        $this->estado = $estado;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function setNome($nome) 
    {
        $this->nome = $nome;
    }

    public function getIbge_id() 
    {
        return $this->ibge_id;
    }

    public function setIbge_id($ibge_id) 
    {
        $this->ibge_id = $ibge_id;
    }
    
    public function getPopulacao_2010() 
    {
        return $this->populacao_2010;
    }

    public function setPopulacao_2010($populacao_2010) 
    {
        $this->populacao_2010 = $populacao_2010;
    }

    public function getDensidade_demo() 
    {
        return $this->densidade_demo;
    }

    public function setDensidade_demo($densidade_demo) 
    {
        $this->densidade_demo = $densidade_demo;
    }

    public function getGentilico() 
    {
        return $this->gentilico;
    }

    public function setGentilico($gentilico) 
    {
        $this->gentilico = $gentilico;
    }

    public function getArea() 
    {
        return $this->area;
    }

    public function setArea($area) 
    {
        $this->area = $area;
    }
}

?>
