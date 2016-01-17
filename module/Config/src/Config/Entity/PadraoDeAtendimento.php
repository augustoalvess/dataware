<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PadraoDeAtendimento
 *
 * @author augusto
 */
namespace Config\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="padraodeatendimento", uniqueConstraints={@ORM\UniqueConstraint(name="padraodeatendimento_uk", columns={"diadasemana_id", "horarioinicioexpediente", "horariofimexpediente"})})
 */
class PadraoDeAtendimento 
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\SequenceGenerator(sequenceName = "padraodeatendimento_id_seq", initialValue = 1)
     */
    private $id;
    
    /**
     * @ORM\Column(type = "string")
     */
    private $nome;
    
    /**
     * @ORM\ManyToOne(targetEntity="Config\Entity\DiaDaSemana", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="diadasemana_id", referencedColumnName="id", nullable = false)
     */
    private $diaDaSemana;
    
    /**
     * @ORM\Column(type = "time")
     */
    private $horarioInicioExpediente;
    
    /**
     * @ORM\Column(type = "time")
     */
    private $horarioFimExpediente;
    
    /**
     * @ORM\Column(type = "integer")
     */
    private $tempoMedioConsulta;
    
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

    public function getDiaDaSemana() 
    {
        return $this->diaDaSemana;
    }

    public function setDiaDaSemana($diaDaSemana) 
    {
        $this->diaDaSemana = $diaDaSemana;
    }

    public function getHorarioInicioExpediente() 
    {
        return $this->horarioInicioExpediente;
    }

    public function setHorarioInicioExpediente($horarioInicioExpediente) 
    {
        $this->horarioInicioExpediente = $horarioInicioExpediente;
    }

    public function getHorarioFimExpediente() 
    {
        return $this->horarioFimExpediente;
    }

    public function setHorarioFimExpediente($horarioFimExpediente) 
    {
        $this->horarioFimExpediente = $horarioFimExpediente;
    }

    public function getTempoMedioConsulta() 
    {
        return $this->tempoMedioConsulta;
    }

    public function setTempoMedioConsulta($tempoMedioConsulta) 
    {
        $this->tempoMedioConsulta = $tempoMedioConsulta;
    }
}

?>
