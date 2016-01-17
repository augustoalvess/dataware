<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClienteDao
 *
 * @author augusto
 */
namespace Register\Dao;

use Dataware\Dao\Dao;

class PessoaDao extends Dao
{
    public function findByUserId($usuario_id)
    {
        $repository = $this->em->getRepository('Register\Entity\Pessoa');
        $query = $repository->createQueryBuilder('p')
                            ->select("p.id")
                            ->innerJoin('Dataware\Entity\UserAccount', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 'u.id = p.usuario')
                            ->andWhere("p.usuario = :id")
                            ->setParameter('id', $usuario_id)
                            ->getQuery();
        
        $result = $query->getResult();
        return $result[0];
    }
}

?>
