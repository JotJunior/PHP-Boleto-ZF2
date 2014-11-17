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

class Cedente implements CedenteInterface
{

    /**
     *
     * @var string CPF ou CNPJ do cendente 
     */
    protected $documento;

    /**
     *
     * @var string Nome do aplicativo que está emitindo o boleto 
     */
    protected $identificacao;

    /**
     *
     * @var string Razão Social ou nome completo do cedente 
     */
    protected $nomeCedente;

    /**
     *
     * @var string URL da logo do cedente 
     */
    protected $logoCedente;

    /**
     *
     * @var int Agência bancária do cedente 
     */
    protected $agencia;

    /**
     *
     * @var int|string Dígito da conta bancária do cedente 
     */
    protected $agenciaDv;

    /**
     *
     * @var int Número da conta corrente do cedente 
     */
    protected $contaCorrente;

    /**
     *
     * @var int|string Dígito da conta corrente 
     */
    protected $contaCorrenteDv;

    /**
     *
     * @var string Endereço (Rua, número, complemento, bairro) 
     */
    protected $endereco;

    /**
     *
     * @var string 
     */
    protected $cidade;

    /**
     *
     * @var string 
     */
    protected $uf;

    /**
     *
     * @var int
     */
    protected $contaCedente;

    /**
     *
     * @var int|string 
     */
    protected $contaCedenteDv;

    /**
     *
     * @var int 
     */
    protected $formatacaoConvenio;

    /**
     *
     * @var int 
     */
    protected $convenio;

    /**
     *
     * @var int
     */
    protected $contrato;

    /**
     *
     * @var int|string 
     */
    protected $carteira;

    /**
     *
     * @var string 
     */
    protected $variacaoCarteira;

    /**
     * Dados bancários formatados para impressão
     * @var string 
     */
    protected $agenciaCodigo;

    protected $carteiraDescricao;

    protected $codigocliente;

    protected $pontodevenda;



    public function __construct($data = null)
    {
        (new ClassMethods())->hydrate($data, $this);
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function getIdentificacao()
    {
        return $this->identificacao;
    }

    public function getNomeCedente()
    {
        return $this->nomeCedente;
    }

    public function getLogoCedente()
    {
        return $this->logoCedente;
    }

    public function getAgencia()
    {
        return $this->agencia;
    }

    public function getAgenciaDv()
    {
        return $this->agenciaDv;
    }

    public function getContaCorrente()
    {
        return $this->contaCorrente;
    }

    public function getContaCorrenteDv()
    {
        return $this->contaCorrenteDv;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function getUf()
    {
        return $this->uf;
    }

    public function getContaCedente()
    {
        return $this->contaCedente;
    }

    public function getContaCedenteDv()
    {
        return $this->contaCedenteDv;
    }

    public function getFormatacaoConvenio()
    {
        return $this->formatacaoConvenio;
    }

    public function getConvenio()
    {
        return $this->convenio;
    }

    public function getContrato()
    {
        return $this->contrato;
    }

    public function getCarteira()
    {
        return $this->carteira;
    }

    public function getVariacaoCarteira()
    {
        return $this->variacaoCarteira;
    }

    public function getAgenciaCodigo()
    {
        return $this->agenciaCodigo;
    }

    public function setDocumento($documento)
    {
        $this->documento = $documento;
        return $this;
    }

    public function setIdentificacao($identificacao)
    {
        $this->identificacao = $identificacao;
        return $this;
    }

    public function setNomeCedente($nomeCedente)
    {
        $this->nomeCedente = $nomeCedente;
        return $this;
    }

    public function setLogoCedente($logoCedente)
    {
        $this->logoCedente = $logoCedente;
        return $this;
    }

    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
        return $this;
    }

    public function setAgenciaDv($agenciaDv)
    {
        $this->agenciaDv = $agenciaDv;
        return $this;
    }

    public function setContaCorrente($contaCorrente)
    {
        $this->contaCorrente = $contaCorrente;
        return $this;
    }

    public function setContaCorrenteDv($contaCorrenteDv)
    {
        $this->contaCorrenteDv = $contaCorrenteDv;
        return $this;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
    }

    public function setUf($uf)
    {
        $this->uf = $uf;
        return $this;
    }

    public function setContaCedente($contaCedente)
    {
        $this->contaCedente = $contaCedente;
        return $this;
    }

    public function setContaCedenteDv($contaCedenteDv)
    {
        $this->contaCedenteDv = $contaCedenteDv;
        return $this;
    }

    public function setFormatacaoConvenio($formatacaoConvenio)
    {
        $this->formatacaoConvenio = $formatacaoConvenio;
        return $this;
    }

    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;
        return $this;
    }

    public function setContrato($contrato)
    {
        $this->contrato = $contrato;
        return $this;
    }

    public function setCarteira($carteira)
    {
        $this->carteira = $carteira;
        return $this;
    }

    public function setVariacaoCarteira($variacaoCarteira)
    {
        $this->variacaoCarteira = $variacaoCarteira;
        return $this;
    }

    public function setAgenciaCodigo($agenciaCodigo)
    {
        $this->agenciaCodigo = $agenciaCodigo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCarteiraDescricao()
    {
        return $this->carteiraDescricao;
    }/**
     * @param mixed $carteiraDescricao
     */
    public function setCarteiraDescricao($carteiraDescricao)
    {
        $this->carteiraDescricao = $carteiraDescricao;
        return $this;
    }/**
     * @return mixed
     */
    public function getCodigocliente()
    {
        return $this->codigocliente;
    }/**
     * @param mixed $codigocliente
     */
    public function setCodigocliente($codigocliente)
    {
        $this->codigocliente = $codigocliente;
        return $this;
    }/**
     * @return mixed
     */
    public function getPontodevenda()
    {
        return $this->pontodevenda;
    }/**
     * @param mixed $pontodevenda
     */
    public function setPontodevenda($pontodevenda)
    {
        $this->pontodevenda = $pontodevenda;
        return $this;
    }






}
