<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AgendaController
 *
 * @author augusto
 */
namespace Process\Controller;

use Dataware\Controller\CrudController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Process\Entity\Agendamento;
use Process\Entity\StatusAgendamento;
use Process\Entity\TipoDeRepeticao;
use Register\Dao\ProfissionalDao;
use Process\Dao\AgendamentoDao;
use Zend\Session\Container;
use Dataware\Entity\DiaryEvent;
use Zend\Form\Element\Select;

class AgendamentoController extends CrudController
{
    /**
     * @var \Register\Entity\Cliente
     */
    private $cliente;
    
    /**
     * Retorna objeto Cliente, referente ao usuário logado,
     * que está acessando o processo de agendamento.
     * 
     * @return \Register\Entity\Cliente
     */
    public function getCliente() 
    {
        if ( empty($this->cliente) )
        {
            $userSession = new Container('Login');
            $rep = $this->getEntityManager()->getRepository("Register\Entity\Cliente");
            $cliente = $rep->findBy(array('usuario' => $userSession->iduser));
            $this->cliente = $cliente[0];
        }
        
        return $this->cliente;
    }
    
    /**
     * Ação de renderização da interface do calendário
     * para agendamentos.
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $agendamentoDao = new AgendamentoDao($this->getEntityManager());
        $agendamentosDoCliente = $agendamentoDao->obterAgendamentosDoCliente($this->getCliente()->getId());
        $agendamentos = array();
        
        if ( !empty($agendamentosDoCliente) )
        {
            foreach ( $agendamentosDoCliente as $agendamento )
            {
                $tipoDeAtendimento = $agendamento->getTipoDeAtendimento()->getNome();
                $horarioAgendado = $agendamento->getHorarioAgendado();
                $dataAgendada = $agendamento->getDataAgendada();
                $dataAgendada->setTime($horarioAgendado->format("H"), $horarioAgendado->format("i"), $horarioAgendado->format("s"));                
                
                $diaryEvent = new DiaryEvent($tipoDeAtendimento, $dataAgendada->format("c"));
                $diaryEvent->setId($agendamento->getId());
                $diaryEvent->setColor($agendamento->getStatusAgendamento()->getCor());
                
                $agendamentos[] = $diaryEvent;
            }
        }
        
        return new ViewModel(array("agendamentos" => $agendamentos));
    }
    
    /**
     * Sobrescrito método addAction.
     * Valida ao acessar o formulário de agendamento,
     * se ainda existem hoŕarios disponíveis para a data optada,
     * caso não exita, informa ao usuário.
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction() 
    {
        $queryData = parent::getQueryData();
        $agendamentoDao = new AgendamentoDao($this->getEntityManager());
        
        $dataAgendada = !empty($queryData["selected_date"]) ? $queryData["selected_date"] : $queryData["dataAgendada"];
        $horarios = $agendamentoDao->obterHorariosParaAgendamento($dataAgendada);
        
        if ( empty($horarios) )
        {
            $msg = "Desculpe, não existem mais horários disponíveis para esta data, tente talvez para um outro dia!";
            $this->flashMessenger()->addErrorMessage($msg);
            $this->redirect()->toRoute($this->getCurrentRoute());
        }
        
        return parent::addAction();
    }
    
    /**
     * Retorna os dados recebidos via GET.
     * 
     * @return array
     */
    public function getQueryData() 
    {
        $queryData = parent::getQueryData();
        
        if ( $this->getCurrentAction() == "add" )
        {
            $queryData["dataAgendada"] = empty($queryData["dataAgendada"]) ? $queryData["selected_date"] : $queryData["dataAgendada"];
        }
        
        return $queryData;
    }
    
    /**
     * Retorna os dados recebidos via POST.
     * 
     * @return array
     */
    public function getPostData() 
    {
        $postData = parent::getPostData();        
        $postData["tipoDeRepeticao"] = TipoDeRepeticao::TIPO_DE_REPETICAO_NENHUMA;
        $postData["cliente"] = $this->getCliente()->getId();
        unset($postData["atendente"]);
        
        if ( $this->getCurrentAction() == "add" )
        {
            $postData["statusAgendamento"] = StatusAgendamento::STATUS_AGENDA_AGUARDANDO_CONFIRMACAO;
        }
        
        return $postData;
    }
    
    /**
     * Monta e retorna o formulário da entidade.
     * 
     * @param \Process\Entity\Agendamento $agendamento
     * @return \Zend\Form\Form
     */
    public function getForm($agendamento) 
    {  
        $form = parent::getForm($agendamento);
        $request = $this->getRequest();
        
        if ( $this->getCurrentAction() == "edit" )
        {
            // Dependente a situação, deverá ficar ou não desabilitado.
            $campoStatusAgendamento = $form->get("statusAgendamento");
            $campoStatusAgendamento->setAttribute("disabled", NULL);
        }
        
        // Obtém a data do agendamento.
        $dataAgendamento = !is_null($agendamento->getDataAgendada()) ? $agendamento->getDataAgendada()->format("Y-m-d") : null;
        $data = $request->getQuery("dataAgendada", $dataAgendamento);
        
        // Popula opções do combobox de profissionais, conforme tipo de atendimento recebido.
        $tipoDeAtendimentoId = $request->getQuery("tipoDeAtendimento", $agendamento->getTipoDeAtendimento());
        $profissionalAgendamento = !is_null($agendamento->getProfissional()) ? $agendamento->getProfissional()->getId() : null;
        $profissionalId = $request->getQuery("profissional", $profissionalAgendamento);
        $profissionalDao = new ProfissionalDao($this->getEntityManager());
        $profissionais = $profissionalDao->listarProfissionaisDoTipoDeAtendimento($tipoDeAtendimentoId);
        $listProfissionais = $this->listarProfissionais($profissionais);
        $campoProfissional = $form->get('profissional');
        $campoProfissional->setValueOptions($listProfissionais);
        $campoProfissional->setValue($profissionalId);
        
        // Popula opções do combobox de horários.
        $horarioAgendamento = (!is_null($agendamento->getDataAgendada()) && !is_null($agendamento->getHorarioAgendado())) ? $data . " " . $agendamento->getHorarioAgendado()->format("H:i:s") : null;
        $horario = $request->getQuery("horario", $horarioAgendamento);
        $agendamentoDao = new AgendamentoDao($this->getEntityManager());
        $horarios = $agendamentoDao->obterHorariosParaAgendamento($data, (empty($profissionalId) ? null : $profissionalId), $agendamento->getId());
        $listHorarios = $this->listarHorarios($horarios);
        $campoHorario = $form->get('horarioAgendado');
        $campoHorario->setValueOptions($listHorarios);
        $campoHorario->setValue($horario);
        
        return $form;
    }
    
    /**
     * Ação ajax para popular combobox de profissionais,
     * do respectivo tipo de atendimento selecionado.
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function obterprofissionaisAction()
    {
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $tipoDeAtendimentoId = $request->getPost('tipodeatendimento_id');
            $profissionalDao = new ProfissionalDao($this->getEntityManager());
            $profissionaisDoTipoDeAtendimento = $profissionalDao->listarProfissionaisDoTipoDeAtendimento($tipoDeAtendimentoId);
            $list = $this->listarProfissionais($profissionaisDoTipoDeAtendimento);
            
            $form = $this->getForm(new Agendamento());
            $campo = $form->get("profissional");
            $campo->setValueOptions($list);
            
            $fieldRow = $this->getServiceLocator()->get('viewhelpermanager')->get('fieldRow');
            $combobox = $fieldRow($campo);
            
            echo json_encode(array('success' => true, 'result' => $combobox));
            exit;
        }
    }
    
    /**
     * Ação ajax para popular combobox de horários disponíveis,
     * do respectivo profisisonal selecionado.
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function obterhorariosAction()
    {
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $profissionalId = $request->getPost('profissional_id');
            $data = $request->getPost('data');
            
            $agendamentoDao = new AgendamentoDao($this->getEntityManager());
            $horarios = $agendamentoDao->obterHorariosParaAgendamento($data, $profissionalId);
            $list = $this->listarHorarios($horarios);
            
            $form = $this->getForm(new Agendamento());
            $campo = $form->get("horarioAgendado");
            $campo->setValueOptions($list);
            
            $fieldRow = $this->getServiceLocator()->get('viewhelpermanager')->get('fieldRow');
            $combobox = $fieldRow($campo);
            
            echo json_encode(array('success' => true, 'result' => $combobox));
            exit;
        }
    }
    
    /**
     * Prepara os dados da listagem de profissionais,
     * para popular combobos
     * 
     * @param array $profissionaisDoTipoDeAtendimento
     * @return array
     */
    public function listarProfissionais($profissionaisDoTipoDeAtendimento)
    {
        $list = array(null => \Dataware\Controller\Controller::STR_NENHUM_REGISTRO);
        
        if ( !empty($profissionaisDoTipoDeAtendimento) )
        {
            foreach ( $profissionaisDoTipoDeAtendimento as $profissionalDoTipoDeAtendimento )
            {
                $list[$profissionalDoTipoDeAtendimento->getProfissional()->getId()] = $profissionalDoTipoDeAtendimento->getProfissional()->getNome();
            }
        }
        
        return $list;
    }
    
    /**
     * Prepara os dados da listagem de horários,
     * para popular combobos
     * 
     * @param array $horarios
     * @return array
     */
    public function listarHorarios($horarios)
    {
        $list = array(null => \Dataware\Controller\Controller::STR_NENHUM_REGISTRO);
        
        if ( !empty($horarios) )
        {   
            foreach ( $horarios as $horario )
            {
                $list[$horario["data"] . " " . $horario["horario"]] = $horario["horario"] . " - " . $horario["descricao_horario"];
            }
        }
        
        return $list;
    }
    
    /**
     * Sobrescrito método de listagem dos combos,
     * para listar os status de agendamentos corretos.
     * 
     * @param \Zend\Form\Element\Select $element
     * @return array
     */
    public function getListValuesToSelectElement(Select $element) 
    {
        $id = (int) $this->params()->fromRoute('id');
        $result = parent::getListValuesToSelectElement($element);
        
        if ( $element->getName() == "statusAgendamento" && !empty($id) )
        {
            $agendamento = $this->getEntityManager()->find("Process\Entity\Agendamento", $id);
            $proximosStatus = $agendamento->getStatusAgendamento()->obterProximosStatusPossiveisDoCliente();
            
            foreach ( $result as $pos => $item )
            {
                if ( !in_array($item["id"], $proximosStatus) )
                {
                    unset($result[$pos]);
                }
            }
        }
        
        return $result;
    }
}

?>
