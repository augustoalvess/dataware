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

namespace Dataware\Dao;

use Dataware\Dao\Dao;

class LoginDao extends Dao
{
    /**
     * Obtém dados do login, pelo login.
     * 
     * @param String $login
     * @return array
     */
    public function findLoginByUsername($login)
    {
        $repository = $this->em->getRepository('Dataware\Entity\UserAccount');
        $query = $repository->createQueryBuilder('u')
                            ->select("u.id, u.login, u.name")
                            ->andWhere("u.login = :login")
                            ->setParameter('login', $login)
                            ->getQuery();
        
        $result = $query->getResult();
        
        return $result[0];
    }
}

?>
