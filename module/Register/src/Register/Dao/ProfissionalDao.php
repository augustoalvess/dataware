<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfissionalDao
 *
 * @author augusto
 */

namespace Register\Dao;

use Dataware\Dao\Dao;

class ProfissionalDao extends Dao
{
    /**
     * Obtém lista de estados de um país.
     * 
     * @param int $paisId
     * @return array
     */
    public function listarProfissionaisDoTipoDeAtendimento($tipoDeAtendimentoId)
    {
        $profissionais = array();
        
        if ( !empty($tipoDeAtendimentoId) )
        {
            $profissionais = $this->em->getRepository('Register\Entity\TipoDeAtendimentoDoProfissional')->findBy(array('tipoDeAtendimento' => $tipoDeAtendimentoId));
        }
        
        return $profissionais;
    }
}

?>
