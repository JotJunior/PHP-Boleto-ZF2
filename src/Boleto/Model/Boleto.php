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

namespace Boleto\Model;


class Boleto {

	/**
	 * Dias a contar da data atual para o vencimento do boleto
	 * @var int 
	 */
	protected $diasPrazoPagamento;

	/**
	 * Taxa do boleto bancário
	 * @var float 
	 */
	protected $taxaBoleto;

	/**
	 * Data de vencimento do boleto
	 * @var string
	 */
	protected $dataVencimento;

	/**
	 * Valor do boleto bancário
	 * @var float 
	 */
	protected $valorCobrado;

	/**
	 * Valor final do boleto, acrescido das taxas
	 * @var float 
	 */
	protected $valorBoleto;

	/**
	 * Identificador único do boleto
	 * @var int 
	 */
	protected $nossoNumero;

	/**
	 * Dígito verificador do NossoNumero
	 * @var int 
	 */
	protected $nossoNumeroDV;

	/**
	 * Nosso número formatado para impressão do boleto
	 * @var int 
	 */
	protected $nossoNumeroFormatado;

	/**
	 * Número do documento que originou o boleto
	 * @var int|string
	 */
	protected $numeroDocumento;

	/**
	 * Data da emissão do documento
	 * @var string 
	 */
	protected $dataDocumento;

	/**
	 * Data em que foi processado o boleto
	 * @var string 
	 */
	protected $dataProcessamento;

	/**
	 * Nome do Sacado (responsável pelo pagamento do boleto)
	 * @var string 
	 */
	protected $sacado;

	/**
	 * Primeira linha do endereço do sacado
	 * @var string 
	 */
	protected $endereco1;

	/**
	 * Segunda linha do endereço do sacado
	 * @var string 
	 */
	protected $endereco2;

	/**
	 * Primeira linha do texto demonstrativo do boleto
	 * @var string 
	 */
	protected $demonstrativo1;

	/**
	 * Segunda linha do texto demonstrativo do boleto
	 * @var string 
	 */
	protected $demonstrativo2;

	/**
	 * Terceira linha do texto demonstrativo do boleto
	 * @var string 
	 */
	protected $demonstrativo3;

	/**
	 * Primeira linha das instruções do boleto
	 * @var string 
	 */
	protected $instrucoes1;

	/**
	 * Segunda linha das instruções do boleto
	 * @var string 
	 */
	protected $instrucoes2;

	/**
	 * Terceira linha das instruções do boleto
	 * @var string 
	 */
	protected $instrucoes3;

	/**
	 * Quarta linha das instruções do boleto
	 * @var string 
	 */
	protected $instrucoes4;

	/**
	 * Quantidade de itens relacionados ao pagamento do boleto
	 * @var int 
	 */
	protected $quantidade;

	/**
	 * Valor unitário dos itens relacionados ao boleto
	 * @var float 
	 */
	protected $valorUnitario;

	/**
	 * @var string 
	 */
	protected $aceite;

	/**
	 * Moeda aceita para pagamento do boleto
	 * @var string 
	 */
	protected $especie;

	/**
	 * Tipo de documento (padrão DM: duplicata mercantil)
	 * @var string 
	 */
	protected $especieDoc;

	/**
	 * String que compõe o código de barras
	 * 
	 * @var string 
	 */
	protected $codigoDeBarras;

	/**
	 * Linha digitável do boleto
	 * 
	 * @var string 
	 */
	protected $linhaDigitavel;

	/**
	 * Código da agência bancária com DV
	 * @var string 
	 */
	protected $agenciaCodigo;

	/**
	 * Código do banco com DV
	 * @var string 
	 */
	protected $codigoBancoComDV;
	
	/**
	 * CPF ou CNPJ do cedente
	 * @var string 
	 */
	protected $cpfCnpj;
	
	protected $valor;
	
	protected $cedente;
	
	/**
	 * Identificação do boleto (do site que está emitindo, por exemplo)
	 * @var string 
	 */
	protected $identificacao;
	
	protected $enderecoCedente;
	
	protected $cidadeUfCedente;
	
	protected $logoCedente;
	
	protected $logoBanco;
	
	protected $codigoBanco;
	
	protected $numMoeda;
	
	protected $agencia;
	
	protected $agenciaDV;
	
	protected $conta;
	
	protected $contaDV;
	
	protected $carteira;
	
	/**
	 * Construtura da classe. Utiliza a classe Hydrator para popular seus métodos
	 * @param array $options
	 */
	public function __constructor(array $options = null) {
		(new Hydrator\ClassMethods)->hydrate($options, $this);
	}

	public function getDiasPrazoPagamento() {
		return $this->diasPrazoPagamento;
	}

	public function setDiasPrazoPagamento($diasPrazoPagamento) {
		$this->diasPrazoPagamento = $diasPrazoPagamento;
		return $this;
	}

	public function getTaxaBoleto() {
		return $this->taxaBoleto;
	}

	public function setTaxaBoleto($taxaBoleto) {
		$this->taxaBoleto = $taxaBoleto;
		return $this;
	}

	public function getDataVencimento() {
		return $this->dataVencimento;
	}

	public function setDataVencimento($dataVencimento) {
		$this->dataVencimento = $dataVencimento;
		return $this;
	}

	public function getValorCobrado() {
		return $this->valorCobrado;
	}

	public function setValorCobrado($valorCobrado) {
		$this->valorCobrado = $valorCobrado;
		return $this;
	}

	public function getValorBoleto() {
		return $this->valorBoleto;
	}

	public function setValorBoleto($valorBoleto) {
		$this->valorBoleto = $valorBoleto;
		return $this;
	}

	public function getNossoNumero() {
		return $this->nossoNumero;
	}

	public function setNossoNumero($nossoNumero) {
		$this->nossoNumero = $nossoNumero;
		return $this;
	}
	
	public function getNossoNumeroDV() {
		return $this->nossoNumeroDV;
	}

	public function setNossoNumeroDV($nossoNumeroDV) {
		$this->nossoNumeroDV = $nossoNumeroDV;
		return $this;
	}
	
	public function getNossoNumeroFormatado() {
		return $this->nossoNumeroFormatado;
	}

	public function setNossoNumeroFormatado($nossoNumeroFormatado) {
		$this->nossoNumeroFormatado = $nossoNumeroFormatado;
		return $this;
	}

	public function getNumeroDocumento() {
		return $this->numeroDocumento;
	}

	public function setNumeroDocumento($numeroDocumento) {
		$this->numeroDocumento = $numeroDocumento;
		return $this;
	}

	public function getDataDocumento() {
		return $this->dataDocumento;
	}

	public function setDataDocumento($dataDocumento) {
		$this->dataDocumento = $dataDocumento;
		return $this;
	}

	public function getDataProcessamento() {
		return $this->dataProcessamento;
	}

	public function setDataProcessamento($dataProcessamento) {
		$this->dataProcessamento = $dataProcessamento;
		return $this;
	}

	public function getSacado() {
		return $this->sacado;
	}

	public function setSacado($sacado) {
		$this->sacado = $sacado;
		return $this;
	}

	public function getEndereco1() {
		return $this->endereco1;
	}

	public function setEndereco1($endereco1) {
		$this->endereco1 = $endereco1;
		return $this;
	}

	public function getEndereco2() {
		return $this->endereco2;
	}

	public function setEndereco2($endereco2) {
		$this->endereco2 = $endereco2;
		return $this;
	}

	public function getDemonstrativo1() {
		return $this->demonstrativo1;
	}

	public function setDemonstrativo1($demonstrativo1) {
		$this->demonstrativo1 = $demonstrativo1;
		return $this;
	}

	public function getDemonstrativo2() {
		return $this->demonstrativo2;
	}

	public function setDemonstrativo2($demonstrativo2) {
		$this->demonstrativo2 = $demonstrativo2;
		return $this;
	}

	public function getDemonstrativo3() {
		return $this->demonstrativo3;
	}

	public function setDemonstrativo3($demonstrativo3) {
		$this->demonstrativo3 = $demonstrativo3;
		return $this;
	}

	public function getInstrucoes1() {
		return $this->instrucoes1;
	}

	public function setInstrucoes1($instrucoes1) {
		$this->instrucoes1 = $instrucoes1;
		return $this;
	}

	public function getInstrucoes2() {
		return $this->instrucoes2;
	}

	public function setInstrucoes2($instrucoes2) {
		$this->instrucoes2 = $instrucoes2;
		return $this;
	}

	public function getInstrucoes3() {
		return $this->instrucoes3;
	}

	public function setInstrucoes3($instrucoes3) {
		$this->instrucoes3 = $instrucoes3;
		return $this;
	}

	public function getInstrucoes4() {
		return $this->instrucoes4;
	}

	public function setInstrucoes4($instrucoes4) {
		$this->instrucoes4 = $instrucoes4;
		return $this;
	}

	public function getQuantidade() {
		return $this->quantidade;
	}

	public function setQuantidade($quantidade) {
		$this->quantidade = $quantidade;
		return $this;
	}

	public function getValorUnitario() {
		return $this->valorUnitario;
	}

	public function setValorUnitario($valorUnitario) {
		$this->valorUnitario = $valorUnitario;
		return $this;
	}

	public function getAceite() {
		return $this->aceite;
	}

	public function setAceite($aceite) {
		$this->aceite = $aceite;
		return $this;
	}

	public function getEspecie() {
		return $this->especie;
	}

	public function setEspecie($especie) {
		$this->especie = $especie;
		return $this;
	}

	public function getEspecieDoc() {
		return $this->especieDoc;
	}

	public function setEspecieDoc($especieDoc) {
		$this->especieDoc = $especieDoc;
		return $this;
	}

	public function getCodigoDeBarras() {
		return $this->codigoDeBarras;
	}

	public function setCodigoDeBarras($codigoDeBarras) {
		$this->codigoDeBarras = $codigoDeBarras;
		return $this;
	}

	public function getLinhaDigitavel() {
		return $this->linhaDigitavel;
	}

	public function setLinhaDigitavel($linhaDigitavel) {
		$this->linhaDigitavel = $linhaDigitavel;
		return $this;
	}

	public function getAgenciaCodigo() {
		return $this->agenciaCodigo;
	}

	public function setAgenciaCodigo($agenciaCodigo) {
		$this->agenciaCodigo = $agenciaCodigo;
		return $this;
	}

	public function getCodigoBancoComDV() {
		return $this->codigoBancoComDV;
	}

	public function setCodigoBancoComDV($codigoBancoComDV) {
		$this->codigoBancoComDV = $codigoBancoComDV;
		return $this;
	}
	
	public function getCedente() {
		return $this->cedente;
	}

	public function setCedente($cedente) {
		$this->cedente = $cedente;
		return $this;
	}

	public function getCpfCnpj() {
		return $this->cpfCnpj;
	}

	public function setCpfCnpj($cpfCnpj) {
		$this->cpfCnpj = $cpfCnpj;
		return $this;
	}

	public function getIdentificacao() {
		return $this->identificacao;
	}

	public function setIdentificacao($identificacao) {
		$this->identificacao = $identificacao;
		return $this;
	}
	
	public function getEnderecoCedente() {
		return $this->enderecoCedente;
	}

	public function setEnderecoCedente($enderecoCedente) {
		$this->enderecoCedente = $enderecoCedente;
		return $this;
	}

	public function getCidadeUfCedente() {
		return $this->cidadeUfCedente;
	}

	public function setCidadeUfCedente($cidadeUfCedente) {
		$this->cidadeUfCedente = $cidadeUfCedente;
		return $this;
	}

	public function getLogoCedente() {
		return $this->logoCedente;
	}

	public function setLogoCedente($logoCedente) {
		$this->logoCedente = $logoCedente;
		return $this;
	}
	
	public function getLogoBanco() {
		return $this->logoBanco;
	}

	public function setLogoBanco($logoBanco) {
		$this->logoBanco = $logoBanco;
		return $this;
	}
	
	public function getCodigoBanco() {
		return $this->codigoBanco;
	}

	public function setCodigoBanco($codigoBanco) {
		$this->codigoBanco = $codigoBanco;
		return $this;
	}
	
	public function getNumMoeda() {
		return $this->numMoeda;
	}

	public function setNumMoeda($numMoeda) {
		$this->numMoeda = $numMoeda;
		return $this;
	}

	public function getAgencia() {
		return $this->agencia;
	}

	public function setAgencia($agencia) {
		$this->agencia = $agencia;
		return $this;
	}
	
	public function getAgenciaDV() {
		return $this->agenciaDV;
	}

	public function setAgenciaDV($agenciaDV) {
		$this->agenciaDV = $agenciaDV;
		return $this;
	}

	public function getConta() {
		return $this->conta;
	}

	public function setConta($conta) {
		$this->conta = $conta;
		return $this;
	}

	public function getContaDV() {
		return $this->contaDV;
	}

	public function setContaDV($contaDV) {
		$this->contaDV = $contaDV;
		return $this;
	}
	
	public function getCarteira() {
		return $this->carteira;
	}

	public function setCarteira($carteira) {
		$this->carteira = $carteira;
		return $this;
	}

	public function getValor() {
		return $this->valor;
	}

	public function setValor($valor) {
		$this->valor = $valor;
		return $this;
	}
	
	


}
