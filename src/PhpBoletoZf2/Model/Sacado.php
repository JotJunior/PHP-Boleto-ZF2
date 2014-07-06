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

class Sacado implements SacadoInterface
{

    /**
     *
     * @var string 
     */
    protected $documento;

    /**
     *
     * @var string 
     */
    protected $nome;

    /**
     *
     * @var string 
     */
    protected $endereco1;

    /**
     *
     * @var string 
     */
    protected $endereco2;
    
    public function __construct($data = null)
    {
        (new ClassMethods())->hydrate($data, $this);
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEndereco1()
    {
        return $this->endereco1;
    }

    public function getEndereco2()
    {
        return $this->endereco2;
    }

    public function setDocumento($documento)
    {
        $this->documento = $documento;
        return $this;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function setEndereco1($endereco1)
    {
        $this->endereco1 = $endereco1;
        return $this;
    }

    public function setEndereco2($endereco2)
    {
        $this->endereco2 = $endereco2;
        return $this;
    }

}
