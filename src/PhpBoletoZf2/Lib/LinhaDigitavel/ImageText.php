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

namespace PhpBoletoZf2\Lib\LinhaDigitavel;

use Zend\Stdlib\Hydrator\ClassMethods;

class ImageText
{

    protected $width = 450;
    protected $height = 30;
    protected $format = 'image/png';
    protected $text;
    protected $font = 'arial.ttf';
    protected $image;
    protected $colors;

    public function __construct($options = null)
    {

        $this->font = dirname(__FILE__) . '/../../../../public/assets/fonts/arial.ttf';

        if (is_array($options)) {
            (new ClassMethods(true))->hydrate($options, $this);
        }
    }

    protected function createImage()
    {

        if (!$this->getText()) {
            throw new \InvalidArgumentException('Você deve informar um texto');
        }

        if (!$this->getWidth()) {
            throw new \InvalidArgumentException('Você deve informar a largura da imagem');
        }

        if (!$this->getHeight()) {
            throw new \InvalidArgumentException('Você deve informar a altura da imagem');
        }

        if (!$this->getFont()) {
            throw new \InvalidArgumentException('Você deve informar a fonte que será utilizada no texto');
        }

        /**
         * Criando o resource da imagem
         */
        $this->image = imagecreatetruecolor($this->getWidth(), $this->getHeight());

        /**
         * Adicionando algumas cores ao resource
         */
        $this->colors = [
            'white' => imagecolorallocate($this->image, 255, 255, 255),
            'black' => imagecolorallocate($this->image, 0, 0, 0)
        ];

        /**
         * Pintando o fundo da imagem de branco
         */
        imagefilledrectangle($this->image, 0, 0, $this->getWidth(), $this->getHeight(), $this->colors['white']);

        /**
         * Escrevendo o texto
         */
        imagettftext($this->image, 11, 0, 5, $this->getHeight()-5, $this->colors['black'], $this->getFont(), $this->getText());

        /**
         * Gerando a imagem
         */
        imagepng($this->image);

        return $this;
    }

    public function render()
    {

        ob_start();
        $this->createImage();

        $contents = ob_get_contents();
        ob_end_clean();

        echo 'data:' . $this->format . ';base64,' . base64_encode($contents);

        imagedestroy($this->image);
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getFont()
    {
        return $this->font;
    }

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function setFont($font)
    {
        $this->font = $font;
        return $this;
    }

}
