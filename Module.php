<?php

/**
 * Sportos IBJJF Database
 *
 * @link      http://www.ibjjf.org
 * @copyright Copyright (c) 2013 Jot (http://www.jot.com,br) and Adron (http://www.adron.com.br)
 * @author João G. "Jot" Zanon Jr. <jot@jot.com.br>
 */

namespace Boleto;

class Module {

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getServiceConfig() {
		return array(
			'factories' => array(
				'Boleto\Service\Bradesco' => function($sm) {
					$config = $sm->get('config');
					return new Service\Bradesco($config['boleto']);
				},
			)
		);
	}

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

}
