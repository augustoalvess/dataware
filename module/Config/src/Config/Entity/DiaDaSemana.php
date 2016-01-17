<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DiaDaSemana
 *
 * @author augusto
 */
namespace Config\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="diadasemana")
 */
class DiaDaSemana 
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\SequenceGenerator(sequenceName = "diadasemana_id_seq", initialValue = 1)
     */
    private $id;
    
    /**
     * @ORM\Column(type = "string")
     */
    private $nome;
    
    /**
     * @ORM\Column(type = "string", length = 45)
     */
    private $abreviatura;
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function setNome($nome) 
    {
        $this->nome = $nome;
    }

    public function getAbreviatura() 
    {
        return $this->abreviatura;
    }

    public function setAbreviatura($abreviatura) 
    {
        $this->abreviatura = $abreviatura;
    }
}

?>
