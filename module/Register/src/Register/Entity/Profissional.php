<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profissional
 *
 * @author augusto
 */
namespace Register\Entity;
use Doctrine\ORM\Mapping as ORM,
    Zend\Form\Annotation;

/** 
 * @ORM\Entity
 * @ORM\Table(name="profissional")
 */
class Profissional extends Pessoa
{
    
}

?>
