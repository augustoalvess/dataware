<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdmAuthStorageController
 *
 * @author augusto
 */

namespace Dataware\Controller;
use Zend\Authentication\Storage;

class AuthStorageController extends Storage\Session 
{
    /**
     * Atribui o tempo de sessão do login efetuado.
     * 
     * @param type $rememberMe
     * @param type $time
     */
    public function setRememberMe($rememberMe = 0, $time = 1209600)
    {
         if ($rememberMe == 1) {
             $this->session->getManager()->rememberMe($time);
         }
    }
     
    /**
     * Termina a sessão do login.
     */
    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
    }
}

?>
