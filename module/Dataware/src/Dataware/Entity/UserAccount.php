<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Adm_User
 *
 * @author augusto
 */

namespace Dataware\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="useraccount")
 */
class UserAccount
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "IDENTITY")
     * @ORM\SequenceGenerator(sequenceName = "usuario_id_seq", initialValue = 1)
     */
    private $id;
    
    /** 
     * @ORM\Column(type = "string", length = 45, unique = true)
     * 
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Login", "labelAttributes":{"required":true}})
     * @Annotation\Attributes({"class":"form-control username"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Login', é requerido!");
     */
    private $login;
    
    /** 
     * @ORM\Column(type = "string", length = 45) 
     * 
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Senha", "labelAttributes":{"required":true}})
     * @Annotation\Attributes({"class":"form-control password"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":45}})
     * @Annotation\ErrorMessage("O preenchimento do campo 'Senha', é requerido!");
     */
    private $password = null;
    
    /**
     * @ORM\Column(type = "string", nullable = false)
     */
    private $name;
        
    /**
     * @ORM\Column(type="boolean", options={"default":true}, nullable = false)
     */
    private $active;
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getLogin() 
    {
        return $this->login;
    }

    public function setLogin($login) 
    {
        $this->login = $login;
    }
    
    public function getPassword() 
    {
        return $this->password;
    }

    public function setPassword($password) 
    {
        $this->password = !empty($password) ? MD5($password) : $this->password;
    }
    
    public function getName() 
    {
        return $this->name;
    }

    public function setName($name) 
    {
        $this->name = $name;
    }
    
    public function isActive() 
    {
        return $this->active;
    }

    public function setActive($active) 
    {
        $this->active = $active;
    }
}

?>
