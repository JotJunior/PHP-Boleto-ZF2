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

namespace PhpBoletoZf2\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DOMPDFModule\View\Model\PdfModel;
use PhpBoletoZf2\Model\BoletoCaixa;
use PhpBoletoZf2\Model\Sacado;

class CaixaSigcbController extends AbstractActionController
{

    public function indexAction()
    {
        /**
         * Definindo o layout padrão do boleto
         */
        $this->layout('layout/boleto');

        $request = $this->getRequest();

        $form = new \PhpBoletoZf2\Form\Boleto;

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                $boleto = new BoletoCaixa($data);
                $sacado = new Sacado($data);

                $caixa = $this->getServiceLocator()
                        ->get('Boleto\CaixaSigcb');
                $caixa->setSacado($sacado)
                        ->setBoleto($boleto);

                $dados = $caixa->prepare();
            }
        }

        switch ($this->params()->fromRoute('format')) {
            case 'html' :
            default :
                return new ViewModel(array('dados' => $dados));
                break;
            case 'pdf' :
                $pdf = new PdfModel();
                $pdf->setOption('filename', 'boleto-caixa-sigcb');
                $pdf->setOption('enable_remote', true);
                $pdf->setOption('paperSize', 'a4'); // Defaults to "8x11" 
                $pdf->setVariables(array('boleto' => $boleto));
                return $pdf;

                break;
        }
    }

    public function demoAction()
    {
        $form = new \PhpBoletoZf2\Form\Boleto;

        return new ViewModel(array('form' => $form));
    }

}
