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

namespace PhpBoletoZf2\Form;

use Zend\InputFilter\InputFilter;

class BoletoFilter extends InputFilter
{

    public function __construct()
    {

        $this->add(array(
            'name' => 'nome',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 2,
                        'max' => 50,
                    ),
                )
            )
        ));

        $this->add(array(
            'name' => 'endereco1',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 2,
                        'max' => 50,
                    ),
                )
            )
        ));

        $this->add(array(
            'name' => 'endereco2',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 50,
                    ),
                )
            )
        ));

        $this->add(array(
            'name' => 'dataVencimento',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
                array(
                    'name' => 'Zend\Validator\Date',
                    'options' => array(
                        'locale' => 'pt_BR',
                        'format' => 'd/m/Y',
                    ),
                )
            )
        ));

        $this->add(array(
            'name' => 'dataDocumento',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
                array(
                    'name' => 'Zend\Validator\Date',
                    'options' => array(
                        'locale' => 'pt_BR',
                        'format' => 'd/m/Y',
                    ),
                )
            )
        ));

        $this->add(array(
            'name' => 'dataProcessamento',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
                array(
                    'name' => 'Zend\Validator\Date',
                    'options' => array(
                        'locale' => 'pt_BR',
                        'format' => 'd/m/Y',
                    ),
                )
            )
        ));

        $this->add(array(
            'name' => 'nossoNumero',
            'required' => true,
            'filters' => array(
                array('name' => 'Digits'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
            )
        ));

        $this->add(array(
            'name' => 'numeroDocumento',
            'required' => true,
            'filters' => array(
                array('name' => 'Digits'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
            )
        ));

        $this->add(array(
            'name' => 'valor',
            'required' => true,
            'filters' => array(
                array('name' => 'Digits'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
            )
        ));

        $this->add(array(
            'name' => 'quantidade',
            'required' => true,
            'filters' => array(
                array('name' => 'Digits'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
            )
        ));
    }

}
