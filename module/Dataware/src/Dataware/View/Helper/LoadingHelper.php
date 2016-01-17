<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Loading
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Dataware\View\Helper\ViewHelper;

class LoadingHelper extends ViewHelper
{    
    public function __invoke()
    {
        return "<div id='obscure-loading'>
                    <div class='contentBar'>
                        <div id='block_1' class='barlittle'></div>
                        <div id='block_2' class='barlittle'></div>
                        <div id='block_3' class='barlittle'></div>
                        <div id='block_4' class='barlittle'></div>
                        <div id='block_5' class='barlittle'></div>
                    </div>
                </div>";
    }
}
