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

namespace PhpBoletoZf2\Model;

use Zend\Stdlib\Hydrator\ClassMethods;
use PhpBoletoZf2\Lib\LinhaDigitavel\ImageText;

abstract class AbstractBoleto implements BoletoInterface
{

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
     * Valor formatado (number_format)
     * @var string 
     */
    protected $valor;

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
     * Construtura da classe. Utiliza a classe Hydrator para popular seus métodos
     * @param array $options
     */
    public function __construct($data = null)
    {

        (new ClassMethods())->hydrate($data, $this);
    }

    public function getTaxaBoleto()
    {
        return $this->taxaBoleto;
    }

    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    public function getNossoNumeroDV()
    {
        return $this->nossoNumeroDV;
    }

    public function getNossoNumeroFormatado()
    {
        return $this->nossoNumeroFormatado;
    }

    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    public function getDataDocumento()
    {
        return $this->dataDocumento;
    }

    public function getDataProcessamento()
    {
        return $this->dataProcessamento;
    }

    public function getDemonstrativo1()
    {
        return $this->demonstrativo1;
    }

    public function getDemonstrativo2()
    {
        return $this->demonstrativo2;
    }

    public function getDemonstrativo3()
    {
        return $this->demonstrativo3;
    }

    public function getInstrucoes1()
    {
        return $this->instrucoes1;
    }

    public function getInstrucoes2()
    {
        return $this->instrucoes2;
    }

    public function getInstrucoes3()
    {
        return $this->instrucoes3;
    }

    public function getInstrucoes4()
    {
        return $this->instrucoes4;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }

    public function getCodigoDeBarras()
    {
        return $this->codigoDeBarras;
    }

    public function getLinhaDigitavel($format = 'string')
    {
        switch ($format) {
            case 'string' :
            default :
                return $this->linhaDigitavel;

            case 'base64' :
                $base64 = new ImageText([
                    'width' => 450,
                    'height' => 30,
                    'text' => $this->linhaDigitavel
                ]);

                return $base64;
        }

        return $this->linhaDigitavel;
    }

    public function setTaxaBoleto($taxaBoleto)
    {
        $this->taxaBoleto = $taxaBoleto;
        return $this;
    }

    public function setDataVencimento($dataVencimento)
    {
        $this->dataVencimento = \DateTime::createFromFormat('d/m/Y', $dataVencimento);
        return $this;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = $nossoNumero;
        return $this;
    }

    public function setNossoNumeroDV($nossoNumeroDV)
    {
        $this->nossoNumeroDV = $nossoNumeroDV;
        return $this;
    }

    public function setNossoNumeroFormatado($nossoNumeroFormatado)
    {
        $this->nossoNumeroFormatado = $nossoNumeroFormatado;
        return $this;
    }

    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;
        return $this;
    }

    public function setDataDocumento($dataDocumento)
    {
        $this->dataDocumento = \DateTime::createFromFormat('d/m/Y', $dataDocumento);
        return $this;
    }

    public function setDataProcessamento($dataProcessamento)
    {
        $this->dataProcessamento = \DateTime::createFromFormat('d/m/Y', $dataProcessamento);
        return $this;
    }

    public function setDemonstrativo1($demonstrativo1)
    {
        $this->demonstrativo1 = $demonstrativo1;
        return $this;
    }

    public function setDemonstrativo2($demonstrativo2)
    {
        $this->demonstrativo2 = $demonstrativo2;
        return $this;
    }

    public function setDemonstrativo3($demonstrativo3)
    {
        $this->demonstrativo3 = $demonstrativo3;
        return $this;
    }

    public function setInstrucoes1($instrucoes1)
    {
        $this->instrucoes1 = $instrucoes1;
        return $this;
    }

    public function setInstrucoes2($instrucoes2)
    {
        $this->instrucoes2 = $instrucoes2;
        return $this;
    }

    public function setInstrucoes3($instrucoes3)
    {
        $this->instrucoes3 = $instrucoes3;
        return $this;
    }

    public function setInstrucoes4($instrucoes4)
    {
        $this->instrucoes4 = $instrucoes4;
        return $this;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;
        return $this;
    }

    public function setCodigoDeBarras($codigoDeBarras)
    {
        $this->codigoDeBarras = $codigoDeBarras;
        return $this;
    }

    public function setLinhaDigitavel($linhaDigitavel)
    {
        $this->linhaDigitavel = $linhaDigitavel;
        return $this;
    }

}
