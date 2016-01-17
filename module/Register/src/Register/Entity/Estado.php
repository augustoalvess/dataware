<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Estado
 *
 * @author augusto
 */

namespace Register\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="estado")
 */
class Estado 
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\SequenceGenerator(sequenceName = "estado_id_seq", initialValue = 1)
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Register\Entity\Pais", fetch="EAGER")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id", nullable = false)
     */
    private $pais;
    
    /**
     * @ORM\Column(type = "string", nullable = false)
     */
    private $nome;
    
    /**
     * @ORM\Column(type = "string", nullable = false)
     */
    private $sigla;
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getPais() 
    {
        return $this->pais;
    }

    public function setPais($pais) 
    {
        $this->pais = $pais;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function setNome($nome) 
    {
        $this->nome = $nome;
    }
    
    public function getSigla() 
    {
        return $this->sigla;
    }

    public function setSigla($sigla) 
    {
        $this->sigla = $sigla;
    }
}

?>
