<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnexoController
 *
 * @author augusto
 */
namespace Register\Controller;

use Dataware\Controller\CrudController;
use Register\Dao\AnexoDao;
use Zend\Session\Container;

class AnexoController extends CrudController
{
    /**
     * Método sobrescrito para obter somente os registros
     * de anexos referente ao usuário logado.
     * 
     * @return type
     */
    public function indexAction()
    {
        $usuarioSession = new Container('Login');
        return parent::indexAction(array('usuario' => $usuarioSession->iduser));
    }
    
    /**
     * Sobrescrito método de download de arquivos,
     * para fazer a validação de permissão do usuário
     * com o anexo.
     */
    public function downloadfileAction()
    {
        $usuarioSession = new Container('Login');
        $fileId = (int) $this->params()->fromRoute("id");
        
        if ( !empty($fileId) )
        {
            $anexoDao = new AnexoDao($this->getEntityManager());
            $anexo = $anexoDao->obterAnexoPeloArquivoEUsuario($fileId, $usuarioSession->iduser);
            
            if ( !empty($anexo) )
            {
                parent::downloadfileAction();
            }
        }
    }
}

?>
