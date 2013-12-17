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

namespace BoletophpZF2\Service;

use BoletophpZF2\Lib\Cef as CefLib;
use BoletophpZF2\Model\Cef as BoletoModel;

class Cef {

	protected $config;
	protected $banco = 'caixa';
	protected $boleto;

	public function __construct(array $config) {
		$this->config = $config;

		// instanciando o MODEL para guardar os dados do boleto
		$this->boleto = new BoletoModel;

		// montando dados provenientes do CONFIG
		$this->boleto->setCodigoBanco($config['bancos'][$this->banco]['codigo']);
		$this->boleto->setCodigoBancoComDV(cefLib::geraCodigoBanco($config['bancos'][$this->banco]['codigo']));
		$this->boleto->setNumMoeda(9);

		$this->boleto->setAgencia(cefLib::formataNumero($config['bancos'][$this->banco]['agencia'], 4, 0));
		$this->boleto->setConta(cefLib::formataNumero($config['bancos'][$this->banco]['conta'], 8, 0));
		$this->boleto->setCarteira($config['bancos'][$this->banco]['carteira']);
		
		$this->boleto->setContaCedente($config['bancos'][$this->banco]['conta_cedente']);
		$this->boleto->setContaCedenteDv($config['bancos'][$this->banco]['conta_cedente_dv']);

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

		$this->boleto->setFormatacaoConvenio($config['bancos'][$this->banco]['formatacao_convenio']);
		$this->boleto->setFormatacaoNossoNumero($config['bancos'][$this->banco]['formatacao_nosso_numero']);
	}

	public function prepare($data) {

		// definindo data de vencimento e calculando fator do vencimento
		$this->boleto->setDataVencimento($data['dataVencimento']);
		$fatorVencimento = cefLib::fatorVencimento($data['dataVencimento']);

		// guardando valor do boleto somado à taxa do registro
		$valor = preg_replace("/[^\d]/", "", $data['valor']);
		$taxa = preg_replace("/[^\d]/", "", $this->boleto->getTaxaBoleto());
		$this->boleto->setValor($valor + (float) $taxa);
		$this->boleto->setValorBoleto(number_format(($valor + (float) $taxa) / 100, 2, ",", ""));
		$this->boleto->setValorCobrado($valor / 100);
		$valorProcessado = cefLib::formataNumero(($valor + (float) $taxa), 10, 0, "valor");

		// agencia bancaria formatada
		$agenciaCodigo = $this->boleto->getAgencia() . '-' . cefLib::modulo11($this->boleto->getAgencia()) . ' / ' . $this->boleto->getConta() . '-' . cefLib::modulo11($this->boleto->getConta());

		// usado quando convenio tem 7 digitos
		$livreZeros = '000000';

		// setando nosso número
		$this->boleto->setNossoNumero($data['nossoNumero']);

		switch ($this->boleto->getFormatacaoConvenio()) {
			case 8 :
				$convenioProcessado = cefLib::formataNumero($this->boleto->getConvenio(), 8, 0, 'convenio');
				$nossoNumeroProcessado = cefLib::formataNumero($this->boleto->getNossoNumero(), 9, 0);
				$DV = cefLib::modulo11($this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $fatorVencimento . $valorProcessado . $livreZeros . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getCarteira());
				$strLinha = $this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $DV . $fatorVencimento . $valorProcessado . $livreZeros . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getCarteira();
				$nossoNumeroFormatado = $convenioProcessado . $nossoNumeroProcessado . '-' . cefLib::modulo11($convenioProcessado . $nossoNumeroProcessado);

				break;
				;
			case 7 :
				$convenioProcessado = cefLib::formataNumero($this->boleto->getConvenio(), 7, 0, 'convenio');
				$nossoNumeroProcessado = cefLib::formataNumero($this->boleto->getNossoNumero(), 10, 0);
				$DV = cefLib::modulo11($this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $fatorVencimento . $valorProcessado . $livreZeros . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getCarteira());
				$strLinha = $this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $DV . $fatorVencimento . $valorProcessado . $livreZeros . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getCarteira();
				$nossoNumeroFormatado = $convenioProcessado . $nossoNumeroProcessado;

				break;
			case 6 :
				$convenioProcessado = cefLib::formataNumero($this->boleto->getConvenio(), 6, 0, 'convenio');

				switch ($this->boleto->getFormatacaoNossoNumero()) {
					case 1 :
						$nossoNumeroProcessado = cefLib::formataNumero($this->boleto->getNossoNumero(), 5, 0);
						$DV = cefLib::modulo11($this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $fatorVencimento . $valorProcessado . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getAgencia() . $this->boleto->getConta() . $this->boleto->getCarteira());
						$strLinha = $this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $DV . $fatorVencimento . $valorProcessado . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getAgencia() . $this->boleto->getConta() . $this->boleto->getCarteira();
						$nossoNumeroFormatado = $convenioProcessado . $nossoNumeroProcessado . '-' . cefLib::modulo11($convenioProcessado . $nossoNumeroProcessado);
						break;
					case 2 :
						$numeroServico = 21;
						$nossoNumeroProcessado = cefLib::formataNumero($this->boleto->getNossoNumero(), 17, 0);
						$DV = cefLib::modulo11($this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $fatorVencimento . $valorProcessado . $convenioProcessado . $nossoNumeroProcessado . $numeroServico);
						$strLinha = $this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $DV . $fatorVencimento . $valorProcessado . $convenioProcessado . $nossoNumeroProcessado . $numeroServico;
						$nossoNumeroFormatado = $nossoNumeroProcessado;
						break;
				}

				break;
		}

		$this->boleto->setCodigoDeBarras(cefLib::formataCodigoDeBarras($strLinha));
		$this->boleto->setLinhaDigitavel(cefLib::montaLinhaDigitavel($strLinha));
		$this->boleto->setAgenciaCodigo($agenciaCodigo);
		$this->boleto->setNossoNumeroFormatado($nossoNumeroFormatado);

		$this->boleto->setSacado($data['sacado']);
		$this->boleto->setendereco1($data['endereco1']);
		$this->boleto->setEndereco2($data['endereco2']);

		$this->boleto->setNumeroDocumento($data['numeroDocumento']);
		$this->boleto->setDataDocumento($data['dataDocumento']);
		$this->boleto->setDataProcessamento($data['dataProcessamento']);
		$this->boleto->setQuantidade($data['quantidade']);
		$this->boleto->setValorUnitario(number_format($data['valorUnitario'] / 100, 2, ",", ""));

		return $this->boleto;
	}

}

