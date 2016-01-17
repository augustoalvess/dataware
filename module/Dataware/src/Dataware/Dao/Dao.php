<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dao
 *
 * @author augusto
 */
namespace Dataware\Dao;

use Doctrine\ORM\EntityManager;

class Dao 
{
    public $em;
    
    public function __construct(EntityManager $em) 
    {
        $this->em = $em;
    }
}

?>
