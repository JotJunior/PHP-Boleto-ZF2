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

use Boleto\Lib\BB as BBLib;
use Boleto\Model\BB as BoletoModel;

class BB {

	protected $config;
	protected $banco = 'banco_do_brasil';
	protected $boleto;

	public function __construct(array $config) {
		$this->config = $config;

		// instanciando a LIB do boleto para cálculos necessários
		$bb = new BBLib;

		// instanciando o MODEL para guardar os dados do boleto
		$this->boleto = new BoletoModel;

		// montando dados provenientes do CONFIG
		$this->boleto->setCodigoBanco($config['bancos'][$this->banco]['codigo']);
		$this->boleto->setCodigoBancoComDV($bb->geraCodigoBanco($config['bancos'][$this->banco]['codigo']));
		$this->boleto->setNumMoeda(9);

		$this->boleto->setAgencia($bb->formataNumero($config['bancos'][$this->banco]['agencia'], 4, 0));
		$this->boleto->setConta($bb->formataNumero($config['bancos'][$this->banco]['conta'], 8, 0));
		$this->boleto->setCarteira($config['bancos'][$this->banco]['carteira']);
		$this->boleto->setVariacaoCarteira($config['bancos'][$this->banco]['variacao_carteira']);

		$this->boleto->setConvenio($config['bancos'][$this->banco]['convenio']);
		$this->boleto->setContrato($config['bancos'][$this->banco]['contrato']);

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

		// instanciando a LIB do boleto para cálculos necessários
		$bb = new BBLib;

		// definindo data de vencimento e calculando fator do vencimento
		$this->boleto->setDataVencimento($data['dataVencimento']);
		$fatorVencimento = $bb->fatorVencimento($data['dataVencimento']);

		// guardando valor do boleto somado à taxa do registro
		$valor = preg_replace("/[^\d]/", "", $data['valor']);
		$taxa = preg_replace("/[^\d]/", "", $this->boleto->getTaxaBoleto());
		$this->boleto->setValor($valor + (float) $taxa);
		$this->boleto->setValorBoleto(number_format(($valor + (float) $taxa) / 100, 2, ",", ""));
		$this->boleto->setValorCobrado($valor / 100);
		$valorProcessado = $bb->formataNumero(($valor + (float) $taxa), 10, 0, "valor");

		// agencia bancaria formatada
		$agenciaCodigo = $this->boleto->getAgencia() . '-' . $bb->modulo11($this->boleto->getAgencia()) . ' / ' . $this->boleto->getConta() . '-' . $bb->modulo11($this->boleto->getConta());

		// usado quando convenio tem 7 digitos
		$livreZeros = '000000';

		// setando nosso número
		$this->boleto->setNossoNumero($data['nossoNumero']);

		switch ($this->boleto->getFormatacaoConvenio()) {
			case 8 :
				$convenioProcessado = $bb->formataNumero($this->boleto->getConvenio(), 8, 0, 'convenio');
				$nossoNumeroProcessado = $bb->formataNumero($this->boleto->getNossoNumero(), 9, 0);
				$DV = $bb->modulo11($this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $fatorVencimento . $valorProcessado . $livreZeros . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getCarteira());
				$strLinha = $this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $DV . $fatorVencimento . $valorProcessado . $livreZeros . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getCarteira();
				$nossoNumeroFormatado = $convenioProcessado . $nossoNumeroProcessado . '-' . $bb->modulo11($convenioProcessado . $nossoNumeroProcessado);

				break;
				;
			case 7 :
				$convenioProcessado = $bb->formataNumero($this->boleto->getConvenio(), 7, 0, 'convenio');
				$nossoNumeroProcessado = $bb->formataNumero($this->boleto->getNossoNumero(), 10, 0);
				$DV = $bb->modulo11($this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $fatorVencimento . $valorProcessado . $livreZeros . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getCarteira());
				$strLinha = $this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $DV . $fatorVencimento . $valorProcessado . $livreZeros . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getCarteira();
				$nossoNumeroFormatado = $convenioProcessado . $nossoNumeroProcessado;

				break;
			case 6 :
				$convenioProcessado = $bb->formataNumero($this->boleto->getConvenio(), 6, 0, 'convenio');

				switch ($this->boleto->getFormatacaoNossoNumero()) {
					case 1 :
						$nossoNumeroProcessado = $bb->formataNumero($this->boleto->getNossoNumero(), 5, 0);
						$DV = $bb->modulo11($this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $fatorVencimento . $valorProcessado . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getAgencia() . $this->boleto->getConta() . $this->boleto->getCarteira());
						$strLinha = $this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $DV . $fatorVencimento . $valorProcessado . $convenioProcessado . $nossoNumeroProcessado . $this->boleto->getAgencia() . $this->boleto->getConta() . $this->boleto->getCarteira();
						$nossoNumeroFormatado = $convenioProcessado . $nossoNumeroProcessado . '-' . $bb->modulo11($convenioProcessado . $nossoNumeroProcessado);
						break;
					case 2 :
						$numeroServico = 21;
						$nossoNumeroProcessado = $bb->formataNumero($this->boleto->getNossoNumero(), 17, 0);
						$DV = $bb->modulo11($this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $fatorVencimento . $valorProcessado . $convenioProcessado . $nossoNumeroProcessado . $numeroServico);
						$strLinha = $this->boleto->getCodigoBanco() . $this->boleto->getNumMoeda() . $DV . $fatorVencimento . $valorProcessado . $convenioProcessado . $nossoNumeroProcessado . $numeroServico;
						$nossoNumeroFormatado = $nossoNumeroProcessado;
						break;
				}

				break;
		}

		$this->boleto->setCodigoDeBarras($bb->formataCodigoDeBarras($strLinha));
		$this->boleto->setLinhaDigitavel($bb->montaLinhaDigitavel($strLinha));
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

