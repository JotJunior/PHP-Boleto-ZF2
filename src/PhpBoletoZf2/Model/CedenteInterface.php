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
 * Originado do Projeto Projeto BoletoPhp: http://www.boletophp.com.br 
 * 
 * Adaptação ao Zend Framework 2: João G. Zanon Jr. <jot@jot.com.br>
 * 
 */

namespace PhpBoletoZf2\Model;

interface CedenteInterface
{

    /**
     * 
     * @param string $cpfOuCnpj Número do documento (CPF ou CNPJ)
     */
    public function setDocumento($cpfOuCnpj);

    public function getDocumento();

    /**
     * 
     * @param string $nome Nome da pessoa que está emitindo o boleto
     */
    public function setNomeCedente($nome);

    public function getNomeCedente();

    /**
     * Identificação do boleto (do site que está emitindo, por exemplo)
     * @var string 
     */
    public function setIdentificacao($identificacao);

    public function getIdentificacao();

    /**
     * 
     * @param string $logo URL ou Base64 da logo do cliente
     */
    public function setLogoCedente($logo);

    public function getLogoCedente();

    /**
     * 
     * @param int $agencia 
     */
    public function setAgencia($agencia);

    public function getAgencia();

    /**
     * 
     * @param string|int $agenciaDv
     */
    public function setAgenciaDv($agenciaDv);

    public function getAgenciaDv();

    /**
     * 
     * @param int $contaCorrente
     */
    public function setContaCorrente($contaCorrente);

    public function getContaCorrente();

    /**
     * 
     * @param int|string $contaCorrenteDv
     */
    public function setContaCorrenteDv($contaCorrenteDv);

    public function getContaCorrenteDv();

    /**
     * 
     * @param string $cidade
     */
    public function setCidade($cidade);

    public function getCidade();

    /**
     * 
     * @param string $uf
     */
    public function setUf($uf);

    public function getUf();
}
