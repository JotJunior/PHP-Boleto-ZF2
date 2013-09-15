<?php

/**
 * BoletoPhp ZF2 - Versão Beta 
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
 * Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel
 * William Schultz e Leandro Maniezo que por sua vez foi derivado do
 * PHPBoleto de João Prado Maia e Pablo Martins F. Costa
 * 
 * Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)
 * Acesse o site do Projeto BoletoPhp: www.boletophp.com.br 
 * 
 * Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br> 
 * 
 * Adaptação ao Zend Framework 2: João G. Zanon Jr. <jot@jot.com.br>
 * 
 */
namespace Boleto;

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
								'__NAMESPACE__' => 'Boleto\Controller',
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
								'__NAMESPACE__' => 'Boleto\Controller',
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
			'Boleto\Controller\Bradesco' => 'Boleto\Controller\BradescoController',
		),
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => array(
			'layout/boleto' => __DIR__ . '/../view/layout/boleto.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
