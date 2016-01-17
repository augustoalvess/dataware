<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoDeAtendimentoDoProfissional
 *
 * @author augusto
 */
namespace Register\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="tipodeatendimentodoprofissional", uniqueConstraints={@ORM\UniqueConstraint(name="tipodeatendimentodoprofissional_uk", columns={"profissional_id", "tipodeatendimento_id"})})
 */
class TipoDeAtendimentoDoProfissional 
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\SequenceGenerator(sequenceName = "tipodeatendimentodoprofissional_id_seq", initialValue = 1)
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Register\Entity\Profissional", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="profissional_id", referencedColumnName="id", nullable=false)
     */
    private $profissional;
    
    /**
     * @ORM\ManyToOne(targetEntity="Config\Entity\TipoDeAtendimento", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="tipodeatendimento_id", referencedColumnName="id", nullable=false)
     */
    private $tipoDeAtendimento;
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getProfissional() 
    {
        return $this->profissional;
    }

    public function setProfissional($profissional) 
    {
        $this->profissional = $profissional;
    }

    public function getTipoDeAtendimento() 
    {
        return $this->tipoDeAtendimento;
    }

    public function setTipoDeAtendimento($tipoDeAtendimento) 
    {
        $this->tipoDeAtendimento = $tipoDeAtendimento;
    }
}

?>
