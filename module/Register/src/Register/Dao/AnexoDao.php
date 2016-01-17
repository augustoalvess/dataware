<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnexoDao
 *
 * @author augusto
 */
namespace Register\Dao;

use Dataware\Dao\Dao;

class AnexoDao extends Dao
{
    /**
     * Obtém todos agendamentos feitos pelo cliente.
     * 
     * @param int $fileId
     * @return array
     */
    public function obterAnexoPeloArquivoEUsuario($fileId, $usuarioId)
    {
        $repository = $this->em->getRepository('Register\Entity\Anexo');
        $query = $repository->createQueryBuilder('a')
                            ->innerJoin('Dataware\Entity\File', 'f', \Doctrine\ORM\Query\Expr\Join::WITH, 'f.id = a.arquivo')
                            ->andWhere("a.arquivo = :file_id")
                            ->andWhere("a.usuario = :usuario_id")
                            ->setParameter('file_id', $fileId)
                            ->setParameter('usuario_id', $usuarioId)
                            ->getQuery();
        
        return $query->getResult();
    }
}

?>
