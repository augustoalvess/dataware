<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FieldCollection
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Zend\Form\View\Helper\FormCollection;

class FieldCollection extends FormCollection
{
    protected $defaultElementHelper = 'fieldRow';
}

?>
