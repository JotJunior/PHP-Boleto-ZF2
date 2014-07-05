<?php

namespace PhpBoletoZf2\Lib\Barcode\Renderer;

use Zend\Barcode\Renderer\Image;

/**
 * Class for rendering the barcode as image
 */
class Base64 extends Image
{

    /**
     * Draw and render the barcode with correct headers
     *
     * @return mixed
     */
    public function render()
    {
        $this->draw();

        ob_start();
        /**
         * fazendo o crop da imagem para que seja removido os números abaixo do
         * código de barras
         */
        $width = imagesx($this->resource);
        
        $cropped = imagecreatetruecolor($width, 52);
        imagecopyresampled($cropped, $this->resource, 0, 0, 0, 0, $width, 52, $width, 52);
        
        $functionName = 'image' . $this->imageType;
        $functionName($cropped);
        $contents = ob_get_contents();
        ob_end_clean();

        echo 'data:image/' . $this->imageType . ';base64,' . base64_encode($contents);
        
        imagedestroy($this->resource);
        imagedestroy($cropped);
        
    }

}
