<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SeparatorHelper
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Dataware\View\Helper\ViewHelper;
use Dataware\Model\Separator;

class SeparatorHelper extends ViewHelper
{
    public function __invoke(Separator $separator = null) 
    {
        $style = ($separator instanceof Separator) ? $separator->getStyle() : "";

        return "<hr style='{$style}'>";
    }
}

?>
