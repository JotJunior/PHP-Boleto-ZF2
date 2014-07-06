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

interface BancoInterface
{

    /**
     * @param $codigo Código de 3 digitos do banco
     */
    public function setCodigoBanco($codigo);

    public function getCodigoBanco();

    /**
     * @param $nome Nome do banco
     */
    public function setNomeBanco($nome);

    public function getNomeBanco();

    /**
     * @param $logo URL ou Base64 da logo do banco
     */
    public function setLogoBanco($logo);

    public function getLogoBanco();

    /**
     * 
     * @param string $carteira
     */
    public function setCarteira($carteira);

    public function getCarteira();

    /**
     * 
     * @param string $aceite
     */
    public function setAceite($aceite);

    public function getAceite();

    /**
     * 
     * @param int $moeda
     */
    public function setMoeda($moeda);

    public function getMoeda();

    /**
     * 
     * @param string $especie
     */
    public function setEspecie($especie);

    public function getEspecie();
    
    /**
     * 
     * @param string $especieDoc
     */
    public function setEspecieDoc($especieDoc);

    public function getEspecieDoc();
}
