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

namespace Boleto\Service;

use Boleto\Lib\Bradesco as BradescoLib;
use Boleto\Model\Bradesco as BoletoModel;

class Bradesco {

	protected $config;
	protected $banco = 'bradesco';
	protected $boleto;

	public function __construct(array $config) {
		$this->config = $config;

		// instanciando a LIB do boleto para cálculos necessários
		$bradesco = new BradescoLib;

		// instanciando o MODEL para guardar os dados do boleto
		$this->boleto = new BoletoModel;

		// montando dados provenientes do CONFIG
		$this->boleto->setCodigoBanco($config['bancos'][$this->banco]['codigo']);
		$this->boleto->setCodigoBancoComDV($bradesco->geraCodigoBanco($config['bancos'][$this->banco]['codigo']));
		$this->boleto->setNumMoeda(9);
		$this->boleto->setAgencia($bradesco->formataNumero($config['bancos'][$this->banco]['agencia'], 10, 0));
		$this->boleto->setAgenciaDV($bradesco->formataNumero($config['bancos'][$this->banco]['agenciaDV'], 1, 0));
		$this->boleto->setConta($bradesco->formataNumero($config['bancos'][$this->banco]['conta'], 6, 0));
		$this->boleto->setContaDV($bradesco->formataNumero($config['bancos'][$this->banco]['contaDV'], 1, 0));
		$this->boleto->setCarteira($config['bancos'][$this->banco]['carteira']);
		$this->boleto->setContaCedente($bradesco->formataNumero($config['bancos'][$this->banco]['contaCedente'], 7, 0));
		$this->boleto->setContaCedenteDV($bradesco->formataNumero($config['bancos'][$this->banco]['contaCedenteDV'], 1, 0));
		$this->boleto->setCpfCnpj($config['dados_cedente']['cpf_cnpj']);
		$this->boleto->setIdentificacao($config['dados_cedente']['identificacao']);
		$this->boleto->setEnderecoCedente($config['dados_cedente']['endereco']);
		$this->boleto->setCidadeUfCedente($config['dados_cedente']['cidade_uf']);
		$this->boleto->setInstrucoes1($config['instrucoes']['instrucoes1']);
		$this->boleto->setInstrucoes2($config['instrucoes']['instrucoes2']);
		$this->boleto->setInstrucoes3($config['instrucoes']['instrucoes3']);
		$this->boleto->setInstrucoes4($config['instrucoes']['instrucoes4']);
		$this->boleto->setLogoBanco($config['bancos'][$this->banco]['logo']);
		$this->boleto->setLogoCedente($config['dados_cedente']['logo']);
		$this->boleto->setCodigoBanco($config['bancos'][$this->banco]['codigo']);
		$this->boleto->setCedente($config['dados_cedente']['cedente']);
		$this->boleto->setEspecie($config['bancos'][$this->banco]['especie']);
		$this->boleto->setEspecieDoc($config['bancos'][$this->banco]['especie_doc']);
		$this->boleto->setTaxaBoleto($config['bancos'][$this->banco]['taxa_boleto']);
	}

	public function prepare($data) {

		// instanciando a LIB do boleto para cálculos necessários
		$bradesco = new BradescoLib;

		$this->boleto->setNossoNumero($data['nossoNumero']);

		$nossoNumeroProcessado = $bradesco->formataNumero($this->config['bancos'][$this->banco]['carteira'], 2, 0) . $bradesco->formataNumero($data["nossoNumero"], 11, 0);
		$nossoNumeroDV = $bradesco->digitoVerificadorNossoNumero($nossoNumeroProcessado);

		$this->boleto->setDataVencimento($data['dataVencimento']);
		$fatorVencimento = $bradesco->fatorVencimento($data['dataVencimento']);

		$valor = preg_replace("/[^\d]/", "", $data['valor']);
		$taxa = preg_replace("/[^\d]/", "", $this->boleto->getTaxaBoleto());
		$this->boleto->setValor($valor + (float) $taxa);
		$this->boleto->setValorBoleto(number_format(($valor + (float) $taxa) / 100, 2, ",", "."));
		$this->boleto->setValorCobrado($valor / 100);

		$valorProcessado = $bradesco->formataNumero(($valor + (float) $taxa), 10, 0, "valor");

		$DV = $bradesco->digitoVerificadorBarra($this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $fatorVencimento . $valorProcessado . $this->boleto->getAgencia() . $nossoNumeroProcessado . $this->boleto->getContaCedente() . '0');

		$strLinha = $this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $DV . $fatorVencimento . $valorProcessado . $this->boleto->getAgencia() . $nossoNumeroProcessado . $this->boleto->getContaCedente() . '0';

		$nossoNumeroFormatado = substr($nossoNumeroProcessado, 0, 2) . '/' . substr($nossoNumeroProcessado, 2) . '-' . $nossoNumeroDV;

		$agenciaCodigo = $this->boleto->getAgencia() . '-' . $this->boleto->getAgenciaDV() . ' / ' . $this->boleto->getContaCedente() . '-' . $this->boleto->getContaCedenteDV();

		$this->boleto->setCodigoDeBarras($bradesco->formataCodigoDeBarras($strLinha));
		$this->boleto->setLinhaDigitavel($bradesco->montaLinhaDigitavel($strLinha));
		$this->boleto->setAgenciaCodigo($agenciaCodigo);
		$this->boleto->setNossoNumeroFormatado($nossoNumeroFormatado);

		$this->boleto->setSacado($data['sacado']);
		$this->boleto->setendereco1($data['endereco1']);
		$this->boleto->setEndereco2($data['endereco2']);

		$this->boleto->setNumeroDocumento($data['numeroDocumento']);
		$this->boleto->setDataDocumento($data['dataDocumento']);
		$this->boleto->setDataProcessamento($data['dataProcessamento']);
		$this->boleto->setQuantidade($data['quantidade']);
		$this->boleto->setValorUnitario(number_format($data['valorUnitario'] / 100, 2, ",", "."));

		return $this->boleto;
	}

}

