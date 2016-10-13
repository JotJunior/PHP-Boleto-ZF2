<?php

/**
 * PHP Boleto ZF2 - Versão Beta 
 * 
 * Este arquivo está disponível sob a Licença GPL disponível pela Web
 * em http://pt.wikipedia.org/wiki/GNU_General_Public_License 
 * Você deve ter recebido uma cópia da GNU Public License junto com
 * este pacote; se não, escreva para: 
 * 
 * Free Software Foundation, Inc.
 * 59 Temple Place - Suite 330
 * Boston, MA 02111-1307, USA.
 * 
 * Originado do Projeto BoletoPhp: http://www.boletophp.com.br 
 * 
 * Adaptação ao Zend Framework 2: João G. Zanon Jr. <jot@jot.com.br>
 * 
 */

namespace PhpBoletoZf2;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Boleto\Bradesco'   => 'PhpBoletoZf2\Factory\Bradesco',
                'Boleto\BB'         => 'PhpBoletoZf2\Factory\BB',
                'Boleto\Caixa'      => 'PhpBoletoZf2\Factory\Caixa',
                'Boleto\CaixaSigcb' => 'PhpBoletoZf2\Factory\CaixaSigcb',
                'Boleto\Itau'       => 'PhpBoletoZf2\Factory\Itau',
                'Boleto\santander'  => 'PhpBoletoZf2\Factory\Santander',
                'Boleto\Bancoob'     => 'PhpBoletoZf2\Factory\Bancoob',
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        );
    }

}
