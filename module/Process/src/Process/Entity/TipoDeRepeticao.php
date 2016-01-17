<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoDeRepeticao
 *
 * @author augusto
 */
namespace Process\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="tipoderepeticao")
 */
class TipoDeRepeticao 
{
    const TIPO_DE_REPETICAO_NENHUMA = 1;
    const TIPO_DE_REPETICAO_DIARIA = 2;
    const TIPO_DE_REPETICAO_SEMANAL = 3;
    const TIPO_DE_REPETICAO_MENSAL = 4;
    const TIPO_DE_REPETICAO_ANUAL = 5;
    
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\SequenceGenerator(sequenceName = "tipoderepeticao_id_seq", initialValue = 1)
     */
    private $id;
    
    /**
     * @ORM\Column(type = "string")
     */
    private $nome;
    
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
}

?>
