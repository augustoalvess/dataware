<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Anexo
 *
 * @author augusto
 */
namespace Register\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="anexo")
 */

class Anexo 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="anexo_id_seq", initialValue=1)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"ID"})
     * @Annotation\Attributes({"class":"input-numeric form-control", "readOnly":"true"})
     * @Annotation\AllowEmpty(true)
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=45, columnDefinition="VARCHAR(45) NOT NULL")
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Título", "labelAttributes":{"required":true}})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Título', é requerido!")
     */
    protected $titulo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Dataware\Entity\File", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumn(name="arquivo_id", referencedColumnName="id", nullable=false)
     * 
     * @Annotation\Type("Zend\Form\Element\File")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Arquivo", "labelAttributes":{"required":true}, "entity":"Dataware\Entity\File"})
     * @Annotation\Attributes({"class":"input-text form-control"})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Arquivo', é requerido!")
     */
    protected $arquivo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Dataware\Entity\UserAccount", fetch="EAGER", cascade = {"persist", "merge"})
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     * 
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @Annotation\Options({"entity":"Dataware\Entity\UserAccount", "current_user":true})
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
    
    public function getTitulo() 
    {
        return $this->titulo;
    }

    public function setTitulo($titulo) 
    {
        $this->titulo = $titulo;
    }
    
    public function getArquivo() 
    {
        return $this->arquivo;
    }

    public function setArquivo($arquivo) 
    {
        $this->arquivo = $arquivo;
    }
    
    public function getUsuario() 
    {
        return $this->usuario;
    }

    public function setUsuario($usuario) 
    {
        $this->usuario = $usuario;
    }
}

?>
