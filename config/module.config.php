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

return array(
    'router' => array(
        'routes' => array(
            'boleto' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/boleto',
                    'defaults' => array(
                        'lang' => 'en_US',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:controller[/:format]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'format' => '(pdf|html)',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'PhpBoletoZf2\Controller',
                                'action' => 'index',
                                'format' => '.html',
                            ),
                        ),
                    ),
                    'demo' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '[/:controller]/demo',
                            'defaults' => array(
                                '__NAMESPACE__' => 'PhpBoletoZf2\Controller',
                                'controller' => 'boleto',
                                'action' => 'demo',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'PhpBoletoZf2\Controller\Bradesco'   => 'PhpBoletoZf2\Controller\BradescoController',
            'PhpBoletoZf2\Controller\BB'         => 'PhpBoletoZf2\Controller\BBController',
            'PhpBoletoZf2\Controller\Caixa'      => 'PhpBoletoZf2\Controller\CaixaController',
            'PhpBoletoZf2\Controller\CaixaSigcb' => 'PhpBoletoZf2\Controller\CaixaSigcbController',
            'PhpBoletoZf2\Controller\Itau'       => 'PhpBoletoZf2\Controller\ItauController',
            'PhpBoletoZf2\Controller\Bancoob'     => 'PhpBoletoZf2\Controller\BancoobController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => array(
            'layout/boleto'                    => __DIR__ . '/../view/layout/boleto.phtml',
            'php-boleto-zf2/bb/demo'           => __DIR__ . '/../view/php-boleto-zf2/bb/demo.phtml',
            'php-boleto-zf2/bb/index'          => __DIR__ . '/../view/php-boleto-zf2/bb/index.phtml',
            'php-boleto-zf2/bradesco/demo'     => __DIR__ . '/../view/php-boleto-zf2/bradesco/demo.phtml',
            'php-boleto-zf2/bradesco/index'    => __DIR__ . '/../view/php-boleto-zf2/bradesco/index.phtml',
            'php-boleto-zf2/caixa-sigcb/demo'  => __DIR__ . '/../view/php-boleto-zf2/caixa-sigcb/demo.phtml',
            'php-boleto-zf2/caixa-sigcb/index' => __DIR__ . '/../view/php-boleto-zf2/caixa-sigcb/index.phtml',
            'php-boleto-zf2/itau/demo'         => __DIR__ . '/../view/php-boleto-zf2/itau/demo.phtml',
            'php-boleto-zf2/itau/index'        => __DIR__ . '/../view/php-boleto-zf2/itau/index.phtml',
            'php-boleto-zf2/sandanter/index'   => __DIR__ . '/../view/php-boleto-zf2/santander/index.phtml',
            'php-boleto-zf2/bancoob/index'      => __DIR__ . '/../view/php-boleto-zf2/bancoob/index.phtml',
        ),
        'template_path_stack'      => array(
            __DIR__ . '/../view',
        ),
    ),
);
