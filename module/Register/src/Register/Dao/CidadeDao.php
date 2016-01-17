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

class CidadeDao extends Dao
{
    /**
     * Obtém lista de cidades de um estado.
     * 
     * @param int $estadoId
     * @return array
     */
    public function listarCidadesDoEstado($estadoId)
    {
        $cidades = $this->em->getRepository('Register\Entity\Cidade')->findBy(array('estado' => $estadoId));
        return $cidades;
    }
}

?>
