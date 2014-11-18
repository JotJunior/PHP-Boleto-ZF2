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

class BoletoSantander extends AbstractBoleto
{


    protected $codigocliente;

    protected $carteiraDescricao;

    protected $pontodevenda;

    /**
     * @return mixed
     */
    public function getCodigocliente()
    {
        return $this->codigocliente;
    }

    /**
     * @param mixed $codigocliente
     */
    public function setCodigocliente($codigocliente)
    {
        $this->codigocliente = $codigocliente;
    }

    /**
     * @return mixed
     */
    public function getCarteiraDescricao()
    {
        return $this->carteiraDescricao;
    }

    /**
     * @param mixed $carteiraDescricao
     */
    public function setCarteiraDescricao($carteiraDescricao)
    {
        $this->carteiraDescricao = $carteiraDescricao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPontodevenda()
    {
        return $this->pontodevenda;
    }

    /**
     * @param mixed $pontodevenda
     */
    public function setPontodevenda($pontodevenda)
    {
        $this->pontodevenda = $pontodevenda;
        return $this;
    }




}
