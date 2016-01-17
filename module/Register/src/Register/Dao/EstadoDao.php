<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginDao
 *
 * @author augusto
 */

namespace Register\Dao;

use Dataware\Dao\Dao;

class EstadoDao extends Dao
{
    /**
     * Obtém lista de estados de um país.
     * 
     * @param int $paisId
     * @return array
     */
    public function listarEstadosDoPais($paisId)
    {
        $estados = $this->em->getRepository('Register\Entity\Estado')->findBy(array('pais' => $paisId));   
        return $estados;
    }
}

?>
