<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pessoa
 *
 * @author augusto
 */

namespace Register\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="pessoa")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="tipo", type="string")
 * @ORM\DiscriminatorMap({"pessoa" = "Pessoa", "cliente" = "Cliente", "profissional" = "Profissional", "atendente" = "Atendente"})
 */
class Pessoa 
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\SequenceGenerator(sequenceName = "pessoa_id_seq", initialValue = 1)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"ID"})
     * @Annotation\Attributes({"class":"input-numeric form-control", "readOnly":"true"})
     * @Annotation\AllowEmpty(true)
     */
    protected $id;
    
    /**
     * @ORM\Column(type = "string")
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Nome", "labelAttributes":{"required":true}})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Nome', é requerido!")
     */
    protected $nome;
    
    /**
     * @ORM\Column(type = "date", nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Date")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Data de nascimento"})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\AllowEmpty(true)
     */
    protected $dataNascimento = null;
    
    /**
     * @ORM\Column(type = "string", length = 1, nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Sexo", "labelAttributes":{"required":true}, "type":"boolean", "value_options":{"M":"Masculino", "F":"Feminino"}})
     * @Annotation\Attributes({"class":"input-checkbox form-control", "value":"M"})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Sexo', é requerido!")
     */
    protected $sexo = 'M';
    
    /**
     * @ORM\Column(type = "string", nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"E-mail"})
     * @Annotation\Attributes({"class":"input-text form-control", "onBlur":"ValidaEmail(this)"})
     * @Annotation\AllowEmpty(true)
     */
    protected $email;
    
    /**
     * @ORM\Column(type = "string", length = 14, nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"CPF"})
     * @Annotation\Attributes({"class":"input-text form-control", "maxlength":"14", "onKeyPress":"MascaraCPF(this)", "onBlur":"ValidarCPF(this)"})
     * @Annotation\AllowEmpty(true)
     */
    protected $cpf;
    
    /**
     * @ORM\Column(type = "string", length = 45, nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"RG"})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\AllowEmpty(true)
     */
    protected $rg;
    
    /**
     * @ORM\Column(type = "string", nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Observação"})
     * @Annotation\Attributes({"class":"input-textarea form-control"})
     * @Annotation\AllowEmpty(true)
     */
    protected $observacao;
    
    /**
     * @ORM\Column(type = "string", length = 45)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Telefone celular", "labelAttributes":{"required":true}})
     * @Annotation\Attributes({"class":"input-text form-control", "maxlength":"14", "onKeyPress":"MascaraTelefone(this)", "onBlur":"ValidaTelefone(this)"})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Telefone celular', é requerido!")
     */
    protected $telefoneCelular;
    
    /**
     * @ORM\Column(type = "string", length = 45, nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Telefone residencial"})
     * @Annotation\Attributes({"class":"input-text form-control", "maxlength":"14", "onKeyPress":"MascaraTelefone(this)", "onBlur":"ValidaTelefone(this)"})
     * @Annotation\AllowEmpty(true)
     */
    protected $telefoneResidencial;
    
    /**
     * @ORM\Column(type = "string", length = 45, nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Telefone de trabalho"})
     * @Annotation\Attributes({"class":"input-text form-control", "maxlength":"14", "onKeyPress":"MascaraTelefone(this)", "onBlur":"ValidaTelefone(this)"})
     * @Annotation\AllowEmpty(true)
     */
    protected $telefoneTrabalho;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"País", "disable_inarray_validator":true, "empty_option":null, "entity":"Register\Entity\Pais"})
     * @Annotation\Attributes({"class":"input-text form-control", "onChange":"ajax_call('/register/cliente/estadosajax', 'estado', {'id' : this.value})"})
     * @Annotation\AllowEmpty(true)
     */
    protected $pais;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Estado", "disable_inarray_validator":true, "empty_option":null})
     * @Annotation\Attributes({"class":"input-text form-control", "onChange":"ajax_call('/register/cliente/cidadesajax', 'cidade', {'id' : this.value})"})
     * @Annotation\AllowEmpty(true)
     */
    protected $estado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Cidade", fetch="EAGER", cascade={"all"})
     * @ORM\JoinColumn(name="cidade_id", referencedColumnName="id")
     * 
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Cidade", "disable_inarray_validator":true, "empty_option":null})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\AllowEmpty(true)
     */
    protected $cidade;
    
    /**
     * @ORM\Column(type = "string", length = 45, nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Cep"})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\AllowEmpty(true)
     */
    protected $cep;
    
    /**
     * @ORM\Column(type = "string", nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Bairro"})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\AllowEmpty(true)
     */
    protected $bairro;
    
    /**
     * @ORM\Column(type = "string", nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Endereço"})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\AllowEmpty(true)
     */
    protected $endereco;
    
    /**
     * @ORM\Column(type = "integer", nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Number")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Número"})
     * @Annotation\Attributes({"class":"input-numeric form-control"})
     * @Annotation\AllowEmpty(true)
     */
    protected $numero = null;
    
    /**
     * @ORM\Column(type = "string", length = 45, nullable = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Complemento"})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\AllowEmpty(true)
     */
    protected $complemento;    
    
    /**
     * @ORM\OneToOne(targetEntity="Dataware\Entity\UserAccount", fetch="EAGER", cascade = {"all"})
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     */
    protected $usuario;

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

    public function getDataNascimento() 
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento($dataNascimento) 
    {        
        if ( !empty($dataNascimento) )
        {            
            if ( !($dataNascimento instanceof \DateTime) )
            {
                $dataNascimento = new \DateTime($dataNascimento);
            }
            
            $this->dataNascimento = $dataNascimento;
        }
    }

    public function getSexo() 
    {
        return $this->sexo;
    }

    public function setSexo($sexo) 
    {
        $this->sexo = $sexo;
    }

    public function getEmail() 
    {
        return $this->email;
    }

    public function setEmail($email) 
    {
        $this->email = $email;
    }

    public function getCpf() 
    {
        return $this->cpf;
    }

    public function setCpf($cpf) 
    {
        $this->cpf = $cpf;
    }

    public function getRg() 
    {
        return $this->rg;
    }

    public function setRg($rg) 
    {
        $this->rg = $rg;
    }

    public function getObservacao() 
    {
        return $this->observacao;
    }

    public function setObservacao($observacao) 
    {
        $this->observacao = $observacao;
    }

    public function getTelefoneCelular() 
    {
        return $this->telefoneCelular;
    }

    public function setTelefoneCelular($telefoneCelular) 
    {
        $this->telefoneCelular = $telefoneCelular;
    }

    public function getTelefoneResidencial() 
    {
        return $this->telefoneResidencial;
    }

    public function setTelefoneResidencial($telefoneResidencial) 
    {
        $this->telefoneResidencial = $telefoneResidencial;
    }

    public function getTelefoneTrabalho() 
    {
        return $this->telefoneTrabalho;
    }

    public function setTelefoneTrabalho($telefoneTrabalho) 
    {
        $this->telefoneTrabalho = $telefoneTrabalho;
    }

    public function getCidade() 
    {
        return $this->cidade;
    }

    public function setCidade($cidade) 
    {
        $this->cidade = $cidade;
    }

    public function getCep() 
    {
        return $this->cep;
    }

    public function setCep($cep) 
    {
        $this->cep = $cep;
    }

    public function getBairro() 
    {
        return $this->bairro;
    }

    public function setBairro($bairro) 
    {
        $this->bairro = $bairro;
    }

    public function getEndereco() 
    {
        return $this->endereco;
    }

    public function setEndereco($endereco) 
    {
        $this->endereco = $endereco;
    }

    public function getNumero() 
    {
        return $this->numero;
    }

    public function setNumero($numero) 
    {
        $this->numero = !empty($numero) ? $numero : null;
    }

    public function getComplemento() 
    {
        return $this->complemento;
    }

    public function setComplemento($complemento) 
    {
        $this->complemento = $complemento;
    }
    
    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
}

?>
