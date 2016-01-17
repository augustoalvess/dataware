<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StatusAgenda
 *
 * @author augusto
 */
namespace Process\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="statusagendamento")
 */
class StatusAgendamento
{
    const STATUS_AGENDA_AGUARDANDO_CONFIRMACAO = 1;
    const STATUS_AGENDA_AGENDADO = 2;
    const STATUS_AGENDA_REJEITADO = 3;
    const STATUS_AGENDA_CANCELADO = 4;
    const STATUS_AGENDA_EM_ANDAMENTO = 5;
    const STATUS_AGENDA_FINALIZADO = 6;
    
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
     * @ORM\Column(type="boolean", options={"default":false}, nullable = false)
     */
    private $encerraAgendamento;
    
    /**
     * @ORM\Column(type="boolean", options={"default":false}, nullable = false)
     */
    private $liberaHorario;
    
    /**
     * @ORM\Column(type = "string", length = 7, nullable = true)
     */
    private $cor;
    
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
    
    public function getEncerraAgendamento() 
    {
        return $this->encerraAgendamento;
    }

    public function setEncerraAgendamento($encerraAgendamento) 
    {
        $this->encerraAgendamento = $encerraAgendamento;
    }
    
    public function getLiberaHorario() 
    {
        return $this->liberaHorario;
    }

    public function setLiberaHorario($liberaHorario) 
    {
        $this->liberaHorario = $liberaHorario;
    }
    
    public function getCor() 
    {
        return $this->cor;
    }

    public function setCor($cor) 
    {
        $this->cor = $cor;
    }
            
    /**
     * Retorna os próximos status possíveis, a partir
     * do status atual do agendamento.
     * 
     * @return type
     */
    public function obterProximosStatusPossiveisDoCliente()
    {
        $proximosStatus = array();
            
        switch ( $this->id )
        {
            case StatusAgendamento::STATUS_AGENDA_AGUARDANDO_CONFIRMACAO:
                $proximosStatus[] = StatusAgendamento::STATUS_AGENDA_AGUARDANDO_CONFIRMACAO;
                $proximosStatus[] = StatusAgendamento::STATUS_AGENDA_CANCELADO;
                break;

            case StatusAgendamento::STATUS_AGENDA_AGENDADO:
                $proximosStatus[] = StatusAgendamento::STATUS_AGENDA_AGENDADO;
                $proximosStatus[] = StatusAgendamento::STATUS_AGENDA_CANCELADO;
                break;

            default:
                $proximosStatus[] = $this->id;
                break;
        }
        
        return $proximosStatus;
    }
}

?>
