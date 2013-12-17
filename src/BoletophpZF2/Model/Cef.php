<?php

namespace BoletophpZF2\Model;

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
class Cef extends Boleto {

	protected $agencia;
	protected $conta;
	protected $contaDv;
	protected $contaCedente;
	protected $contaCedenteDv;
	protected $carteira = 'SR';

	public function getContaCedente() {
		return $this->contaCedente;
	}

	public function setContaCedente($contaCedente) {
		$this->contaCedente = $contaCedente;
		return $this;
	}

	public function getContaCedenteDv() {
		return $this->contaCedenteDv;
	}

	public function setContaCedenteDv($contaCedenteDv) {
		$this->contaCedenteDv = $contaCedenteDv;
		return $this;
	}

}
