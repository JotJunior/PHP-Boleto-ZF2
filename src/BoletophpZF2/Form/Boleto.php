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

namespace BoletophpZF2\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Boleto extends Form {

	public function __construct() {

		parent::__construct('boleto');

		$this->setAttribute('method', 'post')
				->setInputFilter(new BoletoFilter());

		$this->add((new Element\Text)->setName('sacado')->setLabel('Nome do Sacado')->setValue('João da Silva'));
		$this->add((new Element\Text)->setName('endereco1')->setLabel('Endereço 1')->setValue('Rua das Gretrudes, 25 - Apartamento 522'));
		$this->add((new Element\Text)->setName('endereco2')->setLabel('Endereço 2')->setValue('Bairro Blaster - São Paulo - SP'));
		$this->add((new Element\Text)->setName('dataVencimento')->setLabel('Data do Vencimento')->setValue(date("d/m/Y", strtotime('+1 week'))));
		$this->add((new Element\Text)->setName('dataDocumento')->setLabel('Data do Documento')->setValue(date("d/m/Y")));
		$this->add((new Element\Text)->setName('dataProcessamento')->setLabel('Data do Processamento')->setValue(date("d/m/Y")));
		$this->add((new Element\Number)->setName('nossoNumero')->setLabel('Nosso Número')->setValue(rand(100, 500)));
		$this->add((new Element\Number)->setName('numeroDocumento')->setLabel('Número do Documento')->setValue(rand(100, 500)));
		$this->add((new Element\Number)->setName('valor')->setLabel('Valor')->setValue($val = rand(1000, 2000) * 100));
		$this->add((new Element\Number)->setName('valorUnitario')->setLabel('Valor Unitário')->setValue($val));
		$this->add((new Element\Number)->setName('quantidade')->setLabel('Quantidade')->setValue(1));

		$this->add((new Element\Submit)->setName('enviar')->setValue('Enviar'));
	}

}

