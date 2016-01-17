<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClienteController
 *
 * @author augusto
 */
namespace Register\Controller;

use Zend\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Dataware\Controller\LoginController;
use Register\Entity\Cliente;
use Dataware\Entity\UserAccount;
use Register\Dao\PessoaDao;
use Register\Dao\EstadoDao;
use Register\Dao\CidadeDao;
use Register\Entity\Cidade;

class ClienteController extends LoginController
{
    public function addAction()
    {
        $formCliente = $this->getFormCliente();
        $formUsuario = $this->getFormUsuario();    
        
        $request = $this->getRequest();
        $queryData = $this->params()->fromQuery();
        
        if ( !empty($queryData) )
        {
            $formCliente->setData($queryData);
            $formUsuario->setData($queryData);
        }
        
        $this->adjustOfSpecialElements($formCliente);
        $args = array(
            "formCliente" => $formCliente, 
            "formUsuario" => $formUsuario,
            "action" => $this->getEvent()->getRouteMatch()->getParam('action', 'add')
        );
        
        if ( $request->isPost() ) 
        {
            $postData = $request->getPost()->toArray();
            $formCliente->setData($postData);
            $formUsuario->setData($postData);
            
            $formClienteIsValid = $formCliente->isValid();
            $formUsuarioIsValid = $formUsuario->isValid();
            
            if ( $formClienteIsValid && $formUsuarioIsValid )
            {
                $cliente = new Cliente();
                $cliente->setNome($request->getPost("nome"));
                $cliente->setRg($request->getPost("rg"));
                $cliente->setCpf($request->getPost("cpf"));
                $cliente->setDataNascimento($request->getPost("dataNascimento"));
                $cliente->setSexo($request->getPost("sexo"));
                $cliente->setObservacao($request->getPost("observacao"));
                $cliente->setCep($request->getPost("cep"));
                $cliente->setBairro($request->getPost("bairro"));
                $cliente->setEndereco($request->getPost("endereco"));
                $cliente->setNumero($request->getPost("numero"));
                $cliente->setComplemento($request->getPost("complemento"));
                $cliente->setEmail($request->getPost("email"));
                $cliente->setTelefoneCelular($request->getPost("telefoneCelular"));
                $cliente->setTelefoneResidencial($request->getPost("telefoneResidencial"));
                $cliente->setTelefoneTrabalho($request->getPost("telefoneTrabalho"));
                
                $usuario = new UserAccount();
                $usuario->setLogin($request->getPost("login"));
                $usuario->setPassword($request->getPost("password"));
                $usuario->setName($request->getPost("nome"));
                $usuario->setActive(true);
                $cliente->setUsuario($usuario);
                
                $em = $this->getEntityManager();
                $cidadeRep = $em->getRepository('Register\Entity\Cidade');
                $cidade = $cidadeRep->findOneBy(array('id' => $request->getPost("cidade")));
                $cliente->setCidade($cidade);
                
                $em->persist($cliente);
                $em->flush();
                
                $this->flashMessenger()->addSuccessMessage("Seja bem vindo ao Gesatec, o seu sistema paciente!");
                $postData["id"] = $cliente->getUsuario()->getId();
                $this->authenticate($postData);
            }
            else
            {
                $formClienteMsgs = $formCliente->getMessages();
                $formUsuarioMsgs = $formUsuario->getMessages();
                $formMessages = array_merge_recursive($formClienteMsgs, $formUsuarioMsgs);
                $this->displayErrorMessages($formMessages, $args, array('query' => $postData));
            }
        }
        
        return new ViewModel($args);
    }
    
    public function editAction()
    {
        $usuarioSession = new Container('Login');
        $usuario_id = $usuarioSession->iduser;
        
        $em = $this->getEntityManager();
        $pessoaDao = new PessoaDao($em);
        $findPessoa = $pessoaDao->findByUserId($usuario_id);
        
        $clienteParam = $em->find('Register\Entity\Cliente', $findPessoa['id']);
        $usuarioParam = $em->find('Dataware\Entity\UserAccount', $usuario_id);
        
        $formCliente = $this->getFormCliente($clienteParam);
        $formUsuario = $this->getFormUsuario($usuarioParam); 
        
        $request = $this->getRequest();
        $queryData = $this->params()->fromQuery();
        
        if ( !empty($queryData) )
        {
            $formCliente->setData($queryData);
            $formUsuario->setData($queryData);
        }
        
        $this->adjustOfSpecialElements($formCliente);
        $args = array(
            "formCliente" => $formCliente, 
            "formUsuario" => $formUsuario,
            "action" => $this->getEvent()->getRouteMatch()->getParam('action', 'add')
        );
        
        if ( $request->isPost() ) 
        {
            $postData = $request->getPost()->toArray();
            $formCliente->setData($postData);
            $formUsuario->setData($postData);
            $formUsuario->setValidationGroup("login"); // Ao atualizar, somente valida o login, senha não precisa.
            
            $formClienteIsValid = $formCliente->isValid();
            $formUsuarioIsValid = $formUsuario->isValid();
            
            if ( $formClienteIsValid && $formUsuarioIsValid )
            {
                $cliente = new Cliente();
                $cliente->setId($clienteParam->getId());                
                $cliente->setNome($request->getPost("nome"));
                $cliente->setRg($request->getPost("rg"));
                $cliente->setCpf($request->getPost("cpf"));
                $cliente->setDataNascimento($request->getPost("dataNascimento"));
                $cliente->setSexo($request->getPost("sexo"));
                $cliente->setObservacao($request->getPost("observacao"));
                $cliente->setCep($request->getPost("cep"));
                $cliente->setBairro($request->getPost("bairro"));
                $cliente->setEndereco($request->getPost("endereco"));
                $cliente->setNumero($request->getPost("numero"));
                $cliente->setComplemento($request->getPost("complemento"));
                $cliente->setEmail($request->getPost("email"));
                $cliente->setTelefoneCelular($request->getPost("telefoneCelular"));
                $cliente->setTelefoneResidencial($request->getPost("telefoneResidencial"));
                $cliente->setTelefoneTrabalho($request->getPost("telefoneTrabalho"));
                
                $usuarioRep = $em->getRepository('Dataware\Entity\UserAccount');
                $usuario = $usuarioRep->findOneBy(array('id' => $usuarioParam->getId()));
                $usuario->setPassword($request->getPost("password"));
                $usuario->setName($request->getPost("nome"));
                $cliente->setUsuario($usuario);                
                
                $cidadeRep = $em->getRepository('Register\Entity\Cidade');
                $cidade = $cidadeRep->findOneBy(array('id' => $request->getPost("cidade")));
                $cliente->setCidade($cidade);
                
                $em->merge($cliente);
                $em->flush();
                
                $this->flashMessenger()->addSuccessMessage("Perfil atualizado com sucesso!");
                $this->redirect()->toRoute("cliente", $args, array("query" => $postData));
            }
            else
            {
                $formClienteMsgs = $formCliente->getMessages();
                $formUsuarioMsgs = $formUsuario->getMessages();
                $formMessages = array_merge_recursive($formClienteMsgs, $formUsuarioMsgs);
                $this->displayErrorMessages($formMessages, $args, array('query' => $postData));
            }
        }
        
        return new ViewModel($args);
    }
    
    /**
     * Ação ajax para popular combobox de estados,
     * do respectivo país selecionado.
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function estadosajaxAction()
    {
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $formCliente = $this->getFormCliente();
            $campo = $formCliente->get('estado');
            
            $paisId = $request->getPost('id');
            $estadoDao = new EstadoDao($this->getEntityManager());
            $estados = $estadoDao->listarEstadosDoPais($paisId);
            
            $campo->setValueOptions($this->listarEstados($estados));
            $fieldRow = $this->getServiceLocator()->get('viewhelpermanager')->get('fieldRow');
            $combobox = $fieldRow($campo);
            
            echo json_encode(array('success' => true, 'result' => $combobox));
            exit;
        }
    }
    
    /**
     * Ação ajax para popular combobox de cidades,
     * do respectivo estado selecionado.
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function cidadesajaxAction()
    {
        $request = $this->getRequest();
        
        if ( $request->isPost() )
        {
            $formCliente = $this->getFormCliente();
            $campo = $formCliente->get('cidade');
            
            $estadoId = $request->getPost('id');
            $cidadeDao = new CidadeDao($this->getEntityManager());
            $cidades = $cidadeDao->listarCidadesDoEstado($estadoId);
            
            $campo->setValueOptions($this->listarCidades($cidades));
            $fieldRow = $this->getServiceLocator()->get('viewhelpermanager')->get('fieldRow');
            $combobox = $fieldRow($campo);
            
            echo json_encode(array('success' => true, 'result' => $combobox));
            exit;
        }
    }
    
    /**
     * Retorna formulário de cliente.
     * 
     * @param \Register\Entity\Cliente $cliente
     * @return \Zend\Form\Form
     */
    private function getFormCliente(Cliente $cliente = null)
    {
        $request = $this->getRequest();
        $cliente = is_null($cliente) ? new Cliente() : $cliente;
        $instanceOfCidade = ($cliente->getCidade() instanceof Cidade);
        $paisId = $request->getQuery('pais', $instanceOfCidade ? $cliente->getCidade()->getEstado()->getPais()->getId() : null);
        $estadoId = $request->getQuery('estado', $instanceOfCidade ? $cliente->getCidade()->getEstado()->getId() : null);
        
        $builder = new AnnotationBuilder();    
        $formCliente = $builder->createForm($cliente); 
        $formCliente->setHydrator(new DoctrineHydrator($this->getEntityManager(), get_class($cliente)));
        $formCliente->bind($cliente);
        
        $campoPais = $formCliente->get('pais');
        $campoPais->setValue($paisId);
        
        // Popula opções do combobox de estados, conforme pais recebido.
        $estadoDao = new EstadoDao($this->getEntityManager());
        $estados = $estadoDao->listarEstadosDoPais($paisId);
        $listEstados = $this->listarEstados($estados);
        $campoEstado = $formCliente->get('estado');
        $campoEstado->setValueOptions($listEstados);
        $campoEstado->setValue($estadoId);
        
        // Popula opções do combobox de cidades, conforme estado recebido.
        $cidadeDao = new CidadeDao($this->getEntityManager());
        $cidades = $cidadeDao->listarCidadesDoEstado($estadoId);
        $listCidades = $this->listarCidades($cidades);
        $campoCidade = $formCliente->get('cidade');
        $campoCidade->setValueOptions($listCidades);
        
        return $formCliente;
    }
    
    /**
     * Retorna formulário de usuário.
     * 
     * @param \Dataware\Entity\UserAccount $usuario
     * @return \Zend\Form\Form
     */
    private function getFormUsuario(UserAccount $usuario = null)
    {
        $usuario = is_null($usuario) ? new UserAccount() : $usuario;
        $builder = new AnnotationBuilder();
        
        $formUsuario = $builder->createForm($usuario);
        $formUsuario->setHydrator(new DoctrineHydrator($this->getEntityManager(), get_class($usuario)));
        $formUsuario->bind($usuario);
        
        return $formUsuario;
    }
    
    /**
     * Prepara os dados da listagem de estados,
     * para popular combobos
     * 
     * @param array $estados
     * @return array
     */
    public function listarEstados($estados)
    {
        $list = array(null => \Dataware\Controller\Controller::STR_NENHUM_REGISTRO);
        
        if ( !empty($estados) )
        {
            foreach ( $estados as $estado )
            {
                $list[$estado->getId()] = $estado->getNome();
            }
        }
        
        return $list;
    }
    
    /**
     * Prepara os dados da listagem de cidades,
     * para popular combobos
     * 
     * @param array $cidades
     * @return array
     */
    public function listarCidades($cidades)
    {
        $list = array(null => \Dataware\Controller\Controller::STR_NENHUM_REGISTRO);
        
        if ( !empty($cidades) )
        {
            foreach ( $cidades as $cidade )
            {
                $list[$cidade->getId()] = $cidade->getNome();
            }
        }
            
        return $list;
    }
}

?>
