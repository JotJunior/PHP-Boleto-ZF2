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

interface BoletoInterface
{

    /**
     * Aquela taxa ilegal que algumas empresas insistem em cobrar dos clientes
     * @param float $taxaBoleto
     */
    public function setTaxaBoleto($taxaBoleto);

    public function getTaxaBoleto();

    /**
     * Valor final, formatado
     * @param string $valor
     */
    public function setValor($valor);

    public function getValor();

    /**
     * Número de identificação do boleto
     * @param int $nossoNumero
     */
    public function setNossoNumero($nossoNumero);

    public function getNossoNumero();

    public function setNossoNumeroDV($nossoNumeroDV);

    public function getNossoNumeroDV();

    /**
     * String do nosso número formatado de acordo com o banco (com barras, hifem, etc)
     * @param string $nossoNumeroFormatado
     */
    public function setNossoNumeroFormatado($nossoNumeroFormatado);

    public function getNossoNumeroFormatado();

    /**
     * 
     * @param string $numeroDocumento
     */
    public function setNumeroDocumento($numeroDocumento);

    public function getNumeroDocumento();

    /**
     * Data da emissão do boleto
     * @param \DateTime $dataDocumento
     */
    public function setDataDocumento($dataDocumento);

    public function getDataDocumento();

    /**
     * Data em que o boleto foi processado
     * @param \DateTime $dataProcessamento
     */
    public function setDataProcessamento($dataProcessamento);

    public function getDataProcessamento();

    /**
     * 
     * @param \DateTime $dataVencimento
     */
    public function setDataVencimento($dataVencimento);

    public function getDataVencimento();

    /**
     * Descrição do boleto (o que o valor se refere)
     * @param string $demonstrativo1
     */
    public function setDemonstrativo1($demonstrativo1);

    public function getDemonstrativo1();

    public function setDemonstrativo2($demonstrativo2);

    public function getDemonstrativo2();

    public function setDemonstrativo3($demonstrativo3);

    public function getDemonstrativo3();

    /**
     * Instruções para o funcionário do banco, multa, juros, etc
     * @param string $instrucoes1
     */
    public function setInstrucoes1($instrucoes1);

    public function getInstrucoes1();

    public function setInstrucoes2($instrucoes2);

    public function getInstrucoes2();

    public function setInstrucoes3($instrucoes3);

    public function getInstrucoes3();

    public function setInstrucoes4($instrucoes4);

    public function getInstrucoes4();

    /**
     * Quantidade de itens referente ao valor (nunca vi mais do que 1)
     * @param float $quantidade
     */
    public function setQuantidade($quantidade);

    public function getQuantidade();

    /**
     * Valor unitário do serviço prestado (multiplica-se pela quantidade)
     * @param float $valorUnitario
     */
    public function setValorUnitario($valorUnitario);

    public function getValorUnitario();

    /**
     * String do código de barras
     * @param string $codigoDeBarras
     */
    public function setCodigoDeBarras($codigoDeBarras);

    public function getCodigoDeBarras();

    /**
     * Linha digitável para pagamento pela internet
     * @param string $linhaDigitavel
     */
    public function setLinhaDigitavel($linhaDigitavel);

    public function getLinhaDigitavel();

}
