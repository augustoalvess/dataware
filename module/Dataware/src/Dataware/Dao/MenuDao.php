<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuDao
 *
 * @author augusto
 */
namespace Dataware\Dao;

use Dataware\Dao\Dao;

class MenuDao extends Dao
{    
    /**
     * Retorna os itens de menu pais, ativos.
     * 
     * @return array
     */
    public function getActiveFatherMenuItemsList()
    {
        $repository = $this->em->getRepository('Dataware\Entity\Menu');
        $query = $repository->createQueryBuilder('m')
                            ->select("m.id, m.title, m.icon")
                            ->andWhere("m.active = TRUE")
                            ->andWhere("m.fathermenu IS NULL")
                            ->orderBy('m.title')
                            ->getQuery();
        
        $result = $query->getResult();
        
        return $result;
    }
    
    /**
     * Retorna os itens de menu filhos, ativos.
     * 
     * @param int $fatherMenuId
     * @return array
     */
    public function getActiveSubMenuItemsList($fatherMenuId)
    {
        $repository = $this->em->getRepository('Dataware\Entity\Menu');
        
        $query = $repository->createQueryBuilder('m')
                            ->select("m.id, m.title, m.action, m.icon")
                            ->andWhere("m.active = TRUE")
                            ->andWhere("m.fathermenu = :fathermenu")
                            ->setParameter('fathermenu', $fatherMenuId)
                            ->orderBy('m.title')
                            ->getQuery();
        
        $result = $query->getResult();
        
        return $result;
    }
    
    /**
     * Retorna os itens de menu favoritos, ativos.
     * 
     * @return array
     */
    public function getActiveFavoritesMenuItemsList()
    {   
        $repository = $this->em->getRepository('Dataware\Entity\Menu');
        $result = $repository->findBy(array('active' => 'TRUE', 'favorite' => 'TRUE'), array('title' => 'ASC')); 
        
        return $result;
    }
}

?>
