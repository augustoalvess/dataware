<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AgendamentoDao
 *
 * @author augusto
 */
namespace Process\Dao;

use Dataware\Dao\Dao;

class AgendamentoDao extends Dao
{
    /**
     * Obtém todos os horários disponíveis do profissional,
     * no dia recebido por parâmetro.
     * 
     * @param String $data
     * @param int $profissionalId
     * @param int $agendamentoId
     * @return array
     */
    public function obterHorariosParaAgendamento($data, $profissionalId = null, $agendamentoId = null)
    {        
        $sql =  "SELECT * 
                   FROM obterHorariosParaAgendamento(:data, :profissional_id, NULL, :agendamento_id)
                  WHERE esta_disponivel = TRUE";
        
        $conn = $this->em->getConnection();        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue("data", $data);
        $stmt->bindValue("profissional_id", $profissionalId);
        $stmt->bindValue("agendamento_id", $agendamentoId);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    
    /**
     * Obtém todos agendamentos feitos pelo cliente.
     * 
     * @param int $clienteId
     * @return array
     */
    public function obterAgendamentosDoCliente($clienteId)
    {
        $repository = $this->em->getRepository('Process\Entity\Agendamento');
        $query = $repository->createQueryBuilder('a')
                            ->innerJoin('Config\Entity\TipoDeAtendimento', 't', \Doctrine\ORM\Query\Expr\Join::WITH, 't.id = a.tipoDeAtendimento')
                            ->andWhere("a.cliente = :cliente_id")
                            ->setParameter('cliente_id', $clienteId)
                            ->getQuery();
        
        return $query->getResult();
    }
}

?>
