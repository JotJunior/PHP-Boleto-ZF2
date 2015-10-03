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

class BoletoBB extends AbstractBoleto
{

    /**
     * @var string 
     */
    protected $formatacaoConvenio;

    /**
     * @var string 
     */
    protected $formatacaoNossoNumero;

    /**
     * @var boolean
     */
    protected $mostraInstrucoes;
    
    public function getFormatacaoConvenio()
    {
        return $this->formatacaoConvenio;
    }

    public function getFormatacaoNossoNumero()
    {
        return $this->formatacaoNossoNumero;
    }

    public function setFormatacaoConvenio($formatacaoConvenio)
    {
        $this->formatacaoConvenio = $formatacaoConvenio;
        return $this;
    }

    public function setFormatacaoNossoNumero($formatacaoNossoNumero)
    {
        $this->formatacaoNossoNumero = $formatacaoNossoNumero;
        return $this;
    }
    
	public function getMostraInstrucoes() {
		return $this->mostraInstrucoes;
	}
	
	public function setMostraInstrucoes($mostraInstrucoes) {
		$this->mostraInstrucoes = $mostraInstrucoes;
		return $this;
	}
	

}
