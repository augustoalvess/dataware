<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pais
 *
 * @author augusto
 */

namespace Register\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="pais")
 */
class Pais 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="pais_id_seq", initialValue=1)
     */
    private $id;
    
    /**
     * @ORM\Column(type = "string", length = 45)
     */
    private $nome;

    /**
     * @ORM\Column(type = "string", length = 45, nullable = false)
     */
    private $sigla;
    
    /**
     * @ORM\Column(type = "string", length = 45, nullable = false)
     */
    private $nacionalidade;
    
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

    public function getSigla()
    {
        return $this->sigla;
    }

    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    }

    public function getNacionalidade() 
    {
        return $this->nacionalidade;
    }

    public function setNacionalidade($nacionalidade) 
    {
        $this->nacionalidade = $nacionalidade;
    }
}

?>
