<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoDeAtendimento
 *
 * @author augusto
 */
namespace Config\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="tipodeatendimento")
 */
class TipoDeAtendimento 
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\SequenceGenerator(sequenceName = "statusagendamento_id_seq", initialValue = 1)
     */
    private $id;
    
    /**
     * @ORM\Column(type = "string")
     */
    private $nome;
    
    /**
     * @ORM\Column(type="boolean", options={"default":true}, nullable = false)
     */
    private $ativo = true;
    
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

    public function getAtivo() 
    {
        return $this->ativo;
    }

    public function setAtivo($ativo) 
    {
        $this->ativo = $ativo;
    }
}

?>
