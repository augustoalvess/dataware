<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Agenda
 *
 * @author augusto
 */
namespace Process\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="agendamento", uniqueConstraints={@ORM\UniqueConstraint(name="agendamento_uk", columns={"cliente_id", "dataagendada", "horarioagendado"})})
 */
class Agendamento
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\SequenceGenerator(sequenceName = "agendamento_id_seq", initialValue = 1)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"ID"})
     * @Annotation\Attributes({"class":"input-numeric form-control", "readOnly":"true"})
     * @Annotation\AllowEmpty(true)
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Process\Entity\StatusAgendamento", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="statusagendamento_id", referencedColumnName="id", nullable=false)
     * 
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Status do agendamento", "labelAttributes":{"required":true}, "disable_inarray_validator":true, "entity":"Process\Entity\StatusAgendamento"})
     * @Annotation\Attributes({"class":"input-text form-control", "value":"1", "disabled":"true"})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Status do agendamento', é requerido!")
     */
    private $statusAgendamento;
    
    /**
     * @ORM\ManyToOne(targetEntity="Process\Entity\TipoDeRepeticao", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="tipoderepeticao_id", referencedColumnName="id", nullable=false)
     * 
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @Annotation\Options({"entity":"Process\Entity\TipoDeRepeticao"})
     */
    private $tipoDeRepeticao;
    
    /**
     * @ORM\Column(type = "date")
     * 
     * @Annotation\Type("Zend\Form\Element\Date")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Data", "labelAttributes":{"required":true}})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Data', é requerido!")
     */
    private $dataAgendada;
    
    /**
     * @ORM\ManyToOne(targetEntity="Config\Entity\TipoDeAtendimento", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="tipodeatendimento_id", referencedColumnName="id", nullable=false)
     * 
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Tipo de atendimento", "labelAttributes":{"required":true}, "disable_inarray_validator":true, "entity":"Config\Entity\TipoDeAtendimento"})
     * @Annotation\Attributes({"class":"input-text form-control", "onChange":"ajax_call('/process/agendamento/obterprofissionais', 'profissional', {'tipodeatendimento_id':this.value})"})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Tipo de atendimento', é requerido!")
     */
    private $tipoDeAtendimento;
    
    /**
     * @ORM\ManyToOne(targetEntity="Register\Entity\Cliente", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id", nullable = false)
     * 
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @Annotation\Options({"entity":"Register\Entity\Cliente"})
     */
    private $cliente;
    
    /**
     * @ORM\ManyToOne(targetEntity="Register\Entity\Profissional", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="profissional_id", referencedColumnName="id", nullable = false)
     * 
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Profissional", "labelAttributes":{"required":true}, "disable_inarray_validator":true, "entity":"Register\Entity\Profissional", "populate":"false"})
     * @Annotation\Attributes({"class":"input-text form-control", "onChange":"ajax_call('/process/agendamento/obterhorarios', 'horarioAgendado', {'data':$('input[name=dataAgendada]').val(), 'tipodeatendimento_id':$('select[name=tipoDeAtendimento]').val(), 'profissional_id':this.value})"})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Profissional', é requerido!")
     */
    private $profissional;
    
    /**
     * @ORM\ManyToOne(targetEntity="Register\Entity\Atendente", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="atendente_id", referencedColumnName="id")
     * 
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @Annotation\Options({"entity":"Register\Entity\Atendente"})
     */
    private $atendente;
    
    /**
     * @ORM\Column(type = "time")
     * 
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Horário", "labelAttributes":{"required":true}, "disable_inarray_validator":true})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Horário', é requerido!")
     */
    private $horarioAgendado;
    
    /**
     * @ORM\Column(type = "time", nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    private $horarioFimPrevisto = null;
    
    /**
     * @ORM\Column(type="text", columnDefinition="TEXT")
     * 
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Observação"})
     * @Annotation\Attributes({"class":"input-textarea form-control"})
     * @Annotation\AllowEmpty(true)
     */
    private $observacao;
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getStatusAgendamento() 
    {
        return $this->statusAgendamento;
    }

    public function setStatusAgendamento($statusAgendamento) 
    {
        $this->statusAgendamento = $statusAgendamento;
    }
    
    public function getTipoDeRepeticao() 
    {
        return $this->tipoDeRepeticao;
    }

    public function setTipoDeRepeticao($tipoDeRepeticao) 
    {
        $this->tipoDeRepeticao = $tipoDeRepeticao;
    }

    public function getDataAgendada() 
    {
        return $this->dataAgendada;
    }

    public function setDataAgendada($dataAgendada) 
    {
        if ( !empty($dataAgendada) )
        {            
            if ( !($dataAgendada instanceof \DateTime) )
            {
                $dataAgendada = new \DateTime($dataAgendada);
            }
            
            $this->dataAgendada = $dataAgendada;
        }
    }

    public function getTipoDeAtendimento() 
    {
        return $this->tipoDeAtendimento;
    }

    public function setTipoDeAtendimento($tipoDeAtendimento) 
    {
        $this->tipoDeAtendimento = $tipoDeAtendimento;
    }
    
    public function getCliente() {
        return $this->cliente;
    }

    public function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    public function getAtendente() 
    {
        return $this->atendente;
    }

    public function setAtendente($atendente) 
    {
        $this->atendente = $atendente;
    }

    public function getProfissional() 
    {
        return $this->profissional;
    }

    public function setProfissional($profissional) 
    {
        $this->profissional = $profissional;
    }

    public function getHorarioAgendado() 
    {
        return $this->horarioAgendado;
    }

    public function setHorarioAgendado($horarioAgendado) 
    {
        if ( !empty($horarioAgendado) )
        {   
            if ( !($horarioAgendado instanceof \DateTime) )
            {
                $horarioAgendado = new \DateTime($horarioAgendado);
            }
            
            $this->horarioAgendado = $horarioAgendado;
        }
    }

    public function getHorarioFimPrevisto() 
    {
        return $this->horarioFimPrevisto;
    }

    public function setHorarioFimPrevisto($horarioFimPrevisto) 
    {
        if ( !empty($horarioFimPrevisto) )
        {   
            if ( !($horarioFimPrevisto instanceof \DateTime) )
            {
                $horarioFimPrevisto = new \DateTime($horarioFimPrevisto);
            }
            
            $this->horarioFimPrevisto = $horarioFimPrevisto;
        }
    }

    public function getObservacao() 
    {
        return $this->observacao;
    }

    public function setObservacao($observacao) 
    {
        $this->observacao = $observacao;
    }    
}

?>
