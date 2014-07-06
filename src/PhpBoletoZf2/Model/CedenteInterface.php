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

interface CedenteInterface
{

    public function getDocumento();

    public function getIdentificacao();

    public function getNomeCedente();

    public function getLogoCedente();

    public function getAgencia();

    public function getAgenciaDv();

    public function getContaCorrente();

    public function getContaCorrenteDv();

    public function getEndereco();

    public function getCidade();

    public function getUf();

    public function getContaCedente();

    public function getContaCedenteDv();

    public function getFormatacaoConvenio();

    public function getConvenio();

    public function getContrato();

    public function getCarteira();

    public function getVariacaoCarteira();

    public function getAgenciaCodigo();

    public function setDocumento($documento);

    public function setIdentificacao($identificacao);

    public function setNomeCedente($nomeCedente);

    public function setLogoCedente($logoCedente);

    public function setAgencia($agencia);

    public function setAgenciaDv($agenciaDv);

    public function setContaCorrente($contaCorrente);

    public function setContaCorrenteDv($contaCorrenteDv);

    public function setEndereco($endereco);

    public function setCidade($cidade);

    public function setUf($uf);

    public function setContaCedente($contaCedente);

    public function setContaCedenteDv($contaCedenteDv);

    public function setFormatacaoConvenio($formatacaoConvenio);

    public function setConvenio($convenio);

    public function setContrato($contrato);

    public function setCarteira($carteira);

    public function setVariacaoCarteira($variacaoCarteira);

    public function setAgenciaCodigo($agenciaCodigo);
}
