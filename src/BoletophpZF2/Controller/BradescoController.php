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

namespace BoletophpZF2\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DOMPDFModule\View\Model\PdfModel;

class BradescoController extends AbstractActionController {

	/**
	 * Nome do banco que será processado no momento
	 * @var string
	 */
	protected $banco = 'bradesco';

	public function indexAction() {
		// definindo o layout
		$this->layout('layout/boleto');

		$request = $this->getRequest();

		$service = $this->getServiceLocator()->get('BoletophpZF2\Service\Bradesco');

		if ($request->isPost()) {
			$form = new \BoletophpZF2\Form\Boleto;
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$data = $form->getData();
			} else {
				print_r($form->getMessages());
				exit();
			}
		} else {
			$data = array(
				'sacado' => 'João da Silva',
				'endereco1' => 'Rua Blaster, 445',
				'endereco2' => 'Vila Gertrudes - São Paulo - SP',
				'dataVencimento' => date("d/m/Y", strtotime('+5 days')),
				'dataDocumento' => date("d/m/Y"),
				'dataProcessamento' => date("d/m/Y"),
				'nossoNumero' => 75896452,
				'numeroDocumento' => 75896452,
				'valor' => 295000,
				'valorUnitario' => 295000,
				'quantidade' => 1,
			);
		}

		$boleto = $service->prepare($data);

		switch ($this->params()->fromRoute('format')) {
			case 'html' :
			default :
				return new ViewModel(array('boleto' => $boleto));
				break;
			case 'pdf' :
				$pdf = new PdfModel();
				$pdf->setOption('filename', 'boleto-bradesco');
				$pdf->setOption('enable_remote', true);
				$pdf->setOption('paperSize', 'a4'); // Defaults to "8x11" 
				$pdf->setVariables(array('boleto' => $boleto));
				return $pdf;

				break;
		}
	}

	public function demoAction() {
		$form = new \BoletophpZF2\Form\Boleto;

		return new ViewModel(array('form' => $form));
	}

}
