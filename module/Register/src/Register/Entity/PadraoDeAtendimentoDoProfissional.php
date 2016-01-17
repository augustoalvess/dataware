<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PadraoDeAtendimentoDoProfissional
 *
 * @author augusto
 */
namespace Register\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="padraodeatendimentodoprofissional", uniqueConstraints={@ORM\UniqueConstraint(name="padraodeatendimentodoprofissional_uk", columns={"profissional_id", "padraodeatendimento_id"})})
 */
class PadraoDeAtendimentoDoProfissional 
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
     * @ORM\ManyToOne(targetEntity="Config\Entity\PadraoDeAtendimento", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="padraodeatendimento_id", referencedColumnName="id", nullable=false)
     */
    private $padraoDeAtendimento;
    
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

    public function getPadraoDeAtendimento() 
    {
        return $this->padraoDeAtendimento;
    }

    public function setPadraoDeAtendimento($padraoDeAtendimento) 
    {
        $this->padraoDeAtendimento = $padraoDeAtendimento;
    }
}

?>
