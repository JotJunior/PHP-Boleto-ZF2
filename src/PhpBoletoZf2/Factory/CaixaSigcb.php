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

namespace PhpBoletoZf2\Factory;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Barcode\Barcode;
use PhpBoletoZf2\Factory\AbstractBoletoFactory;
use PhpBoletoZf2\Lib\Util;

class CaixaSigcb extends AbstractBoletoFactory
{

    protected $codigoBanco = '104';

    public function prepare()
    {

        /**
         * adicionando dados das instruções e demonstrativo no boleto
         */
        (new ClassMethods())->hydrate($this->config['php-zf2-boleto']['instrucoes'], $this->getBoleto());

        /**
         * Compondo o Nosso Número e seu dígito verificador
         */
        $nossoNumeroProcessado = \str_pad($this->getBoleto()->getNossoNumero(), 9, '0', STR_PAD_LEFT);
        $nossoNumeroDV = Util::digitoVerificadorNossoNumero($this->getBoleto()->getNossoNumero());

        /**
         * Calcula o fator do vencimento (número inteiro que representa a data de vencimento na linha digitavel)
         */
        $fatorVencimento = Util::fatorVencimento($this->getBoleto()->getDataVencimento()->format("d/m/Y"));

        /**
         * Processando o valor para aplicação na linha digitável e no código de barras
         */
        $valor = preg_replace("/[^0-9]/", "", $this->getBoleto()->getValor()); // removendo formatação do número
        $valorProcessado = \str_pad($valor, 10, '0', STR_PAD_LEFT);

        /**
         * Calcula o dígito verificador do código de barras
         */
        $this->getCedente()->setContaCedenteDv(Util::digitoVerificadorNossoNumero($this->getCedente()->getContaCedente()));

        $campoLivre = $this->getCedente()->getContaCedente()
                . $this->getCedente()->getContaCedenteDv()
                . '00020004'
                . $nossoNumeroProcessado
        ;
        $campoLivreDv = Util::modulo11($campoLivre);

        $DV = Util::digitoVerificadorBarra(
                        $this->getBanco()->getCodigoBanco()
                        . $this->getBanco()->getMoeda()
                        . $fatorVencimento
                        . $valorProcessado
                        . $campoLivre
                        . $campoLivreDv
        );

        /**
         * Compondo a linha base para formação da Linha Digitável e do Código de Barras
         */
        $strLinha = $this->getBanco()->getCodigoBanco()
                . $this->getBanco()->getMoeda()
                . $DV
                . $fatorVencimento
                . $valorProcessado
                . $campoLivre
                . $campoLivreDv
        ;

        /**
         * Formatando o Nosso Número para impressão
         */
        $nossoNumeroFormatado = '24000000' . $nossoNumeroProcessado;
        $nossoNumeroFormatado = $nossoNumeroFormatado . Util::digitoVerificadorNossoNumero($nossoNumeroFormatado);
        
        

        /**
         * Formatando os dados bancários do cedente para impressão
         */
        $this->getCedente()->setAgenciaCodigo($this->getCedente()->getAgencia()
                . ' / '
                . $this->getCedente()->getContaCedente()
                . '-'
                . $this->getCedente()->getContaCedenteDv()
        );

        /**
         * Iniciando opções para criação do Código de Barras
         */
        $barcodeOptions = array('text' => $strLinha);

        /**
         * Criando o código de barras em uma imagem e retornando seu base64
         */
        $codigoDeBarras = Barcode::factory('Code25interleaved', 'PhpBoletoZf2\Lib\Barcode\Renderer\Base64', $barcodeOptions, array());

        /**
         * Termina de hidratar o objetodo boleto
         */
        $this->getBoleto()
                ->setCodigoDeBarras($codigoDeBarras)
                ->setLinhaDigitavel(Util::montaLinhaDigitavel($strLinha))
                ->setNossoNumeroFormatado($nossoNumeroFormatado);

        return $this;
    }

}
