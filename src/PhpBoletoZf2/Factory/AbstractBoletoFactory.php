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

use Zend\ServiceManager\FactoryInterface;
use PhpBoletoZf2\Model\Cedente;
use PhpBoletoZf2\Model\Banco;

abstract class AbstractBoletoFactory implements FactoryInterface
{
    
    /**
     * @var array dados do arquivo de configurção
     */
    protected $config;

    /**
     * @var string 
     */
    protected $codigoBanco;

    /**
     * @var \PhpBoletoZf2\Model\Cedente 
     */
    protected $cedente;

    /**
     * @var \PhpBoletoZf2\Model\BancoInterface
     */
    protected $banco;

    /**
     * @var \PhpBoletoZf2\Model\BoletoInterface
     */
    protected $boleto;

    /**
     *
     * @var \PhpBoletoZf2\Model\SacadoInterface
     */
    protected $sacado;

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {

        /**
         * Buscando o arquivo de configuração
         */
        $this->config = $serviceLocator->get('config');

        /**
         * Pré-instancia o banco
         */
        $this->banco = new Banco($this->codigoBanco);
        if (!$this->banco) {
            throw new Exception("Código de banco inválido");
        }

        /**
         * Pré instancia o cedente com dados vindos do arquivo de configuração
         */
        if (isset($this->config['php-zf2-boleto']) && isset($this->config['php-zf2-boleto'][$this->banco->getCodigoBanco()]) && isset($this->config['php-zf2-boleto'][$this->banco->getCodigoBanco()]['dados_cedente'])) {
            $this->cedente = new Cedente($this->config['php-zf2-boleto'][$this->banco->getCodigoBanco()]['dados_cedente']);
        }


        return $this;
    }

    public function getCodigoBanco()
    {
        return $this->codigoBanco;
    }

    public function getCedente()
    {
        return $this->cedente;
    }

    public function getBanco()
    {
        return $this->banco;
    }

    public function getBoleto()
    {
        return $this->boleto;
    }

    public function setCodigoBanco($codigoBanco)
    {
        $this->codigoBanco = $codigoBanco;
        return $this;
    }

    public function setCedente(\PhpBoletoZf2\Model\Cedente $cedente)
    {
        $this->cedente = $cedente;
        return $this;
    }

    public function setBanco(\PhpBoletoZf2\Model\Banco $banco)
    {
        $this->banco = $banco;
        return $this;
    }

    public function setBoleto(\PhpBoletoZf2\Model\AbstractBoleto $boleto)
    {
        $this->boleto = $boleto;
        return $this;
    }

    public function getSacado()
    {
        return $this->sacado;
    }

    public function setSacado(\PhpBoletoZf2\Model\SacadoInterface $sacado)
    {
        $this->sacado = $sacado;
        return $this;
    }

    /**
     * Método que prepara o boleto de acordo com os dados informados.
     */
    abstract public function prepare();
}
