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

namespace PhpBoletoZf2\Lib;

abstract class Util
{

    /**
     * @author Ramon Soares
     * 
     * Calcula o dígito verificaror do Nosso Nümero
     * 
     * @param string $numero
     * @return int
     */
    public static function digitoVerificadorNossoNumero($numero, $base =9)
    {
        $resto2 = self::modulo11($numero, $base, 1);
        $digito = 11 - $resto2;
        if ($digito == 10) {
            $dv = "P";
        } elseif ($digito == 11) {
            $dv = 0;
        } else {
            $dv = $digito;
        }
        return $dv;
    }

    /**
     * Calcula o dígito verificador do Nosso Número para boletos Bancoob
     * com base em uma sequencia e uma constante
     *
     * @param string $sequencia:
     *          String de 21 dígitos contendo:
     *          - agencia cedente sem dígito verificador (4 dígitos)
     *          - número do cliente(convenio) (10 dígitos)
     *          - nosso número (7 dígitos)
     * @param string $constante: constante pra validar
     * 
     * @return int $dv valor digito verificador 
     */
    public static function digitoVerificadorNossoNumeroBancoob($sequencia, $constanteStr) 
    {
        $cont      = 0;
        $calculoDv = '';

        for ($num = 0; $num<=strlen($sequencia); $num++) {
            for ($posConst=0;$posConst<strlen($constanteStr);$posConst++) {
                if ($cont==$posConst) {
                    $constante = $constanteStr[$posConst];

                    if ($cont==strlen($constanteStr)-1) {
                        $cont=0;
                    } else {                
                        $cont++;
                    }    
                    
                    break;
                }
            }

            $calculoDv = $calculoDv + (substr($sequencia,$num,1) * $constante);
        }

        $resto = $calculoDv % 11;
        $dv   = 11 - $resto;

        if ($dv == 0) $dv = 0;
        if ($dv == 1) $dv = 0;
        if ($dv > 9) $dv = 0;

        return $dv;
    }

    /**
     * Gera o dígito verificador do código de barras
     * @param int $numero
     * @return int
     */
    public static function digitoVerificadorBarra($numero)
    {
        $resto = self::modulo11($numero, 9, 1);

        if ($resto == 0 || $resto == 1 || $resto > 9 || $resto == 'X') {
            $dv = 1;
        } else {
            $dv = 11 - $resto;
        }

        return $dv;
    }

    /**
     * Calcula o fator de vencimento para geração da data de vencimento do boleto
     * @param string $data
     * @return int
     */
    public static function fatorVencimento($data)
    {
        if ($data != "") {
            $data = explode("/", $data);
            $ano = $data[2];
            $mes = $data[1];
            $dia = $data[0];
            return(abs((self::dataParaDias("1997", "10", "07")) - (self::dataParaDias($ano, $mes, $dia))));
        } else {
            return "0000";
        }
    }

    /**
     * Converte uma data em número de dias, para composição do fator de vencimento 
     * 
     * @param int $ano
     * @param int $mes
     * @param int $dia
     * @return int
     */
    public static function dataParaDias($ano, $mes, $dia)
    {
        $seculo = substr($ano, 0, 2);
        $ano = substr($ano, 2, 2);
        if ($mes > 2) {
            $mes -= 3;
        } else {
            $mes += 9;
            if ($ano) {
                $ano--;
            } else {
                $ano = 99;
                $seculo--;
            }
        }
        return ( floor(( 146097 * $seculo) / 4) +
                floor(( 1461 * $ano) / 4) +
                floor(( 153 * $mes + 2) / 5) +
                $dia + 1721119);
    }

    /**
     * Cálculo de dígito verificador modulo_10
     * 
     * @param int $num
     * @return int
     */
    public static function modulo10($num)
    {
        $numtotal10 = 0;
        $fator = 2;

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo (falor 10)
            $temp = $numeros[$i] * $fator;
            $temp0 = 0;
            foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
                $temp0+=$v;
            }
            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }

        // v·rias linhas removidas, vide funÁ„o original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }

        return $digito;
    }

    /**
     *   @autor Pablo Costa <pablo@users.sourceforge.net>
     *
     *   Método:
     *    Calculo do Modulo 11 para geracao do digito verificador 
     *    de boletos bancarios conforme documentos obtidos 
     *    da Febraban - www.febraban.org.br 
     * 
     *   ObservaÁıes:
     *     - Script desenvolvido sem nenhum reaproveitamento de código pré existente.
     *     - Assume-se que a verificação do formato das variáveis de entrada é feita antes da execução deste método.
     * 
     * @param type $num string numérica para a qual se deseja calcular o digito verificador;
     * @param type $base valor maximo de multiplicacao [2-$base]
     * @param type $r quando especificado um devolve somente o resto
     * @return int
     * 
     */
    public static function modulo11($num, $base = 9, $r = 0, $calcx = 0)
    {
        $soma = 0;
        $fator = 2;
        for ($i = strlen($num); $i > 0; $i--) {
            $numeros[$i] = substr($num, $i - 1, 1);
            $parcial[$i] = $numeros[$i] * $fator;
            $soma += $parcial[$i];
            if ($fator == $base) {
                $fator = 1;
            }
            $fator++;
        }
        if ($r == 0) {
            $soma *= 10;
            $digito = $soma % 11;

            if ($digito == 10 && $calcx == 1) {
                $digito = "X";
            } elseif ($digito == 10) {
                $digito = 0;
            }

            return $digito;
        } elseif ($r == 1) {
            $resto = $soma % 11;
            return $resto;
        } elseif ($r == 2) {
        	$resto = $soma % 11;
        	$res = 11-$resto;
        	if (in_array($res,array(0,10,11)))
        		$res = 1;
        	return $res;
        }
    }

    /**
     * @author Ramon Soares
     *
     * Gera a linha digitável do boleto BRADESCO
     *
     * 01-03 -> Código do banco sem o digito
     * 04-04 -> Código da Moeda (9-Real)
     * 05-05 -> Dídigo verificador do código de barras
     * 06-09 -> Fator de vencimento
     * 10-19 -> Valor Nominal do TÌtulo
     * 20-44 -> Campo Livre (Abaixo)
     * 20-23 -> Código da Agencia (sem dídigo)
     * 24-05 -> Número da Carteira
     * 26-36 -> Nosso Número (sem dídigo)
     * 37-43 -> Conta do Cedente (sem dídigo)
     * 44-44 -> Zero (Fixo)
     *
     * @param string $codigo
     * @return string
     */
    public static function montaLinhaDigitavel($codigo)
    {

        /**
         * 1. Campo - composto pelo código do banco, código da moeda, as cinco primeiras posições
         * do campo livre e DV (modulo10) deste campo
         */
        $p1 = substr($codigo, 0, 4); // Numero do banco + Carteira
        $p2 = substr($codigo, 19, 5); // 5 primeiras posiÁıes do campo livre
        $p3 = self::modulo10("$p1$p2"); // Digito do campo 1
        $p4 = $p1 . $p2 . $p3; // União
        $campo1 = substr($p4, 0, 5) . '.' . substr($p4, 5);

        /**
         * 2. Campo - composto pelas posiÁoes 6 a 15 do campo livre
         * e livre e DV (modulo10) deste campo
         */
        $p1 = substr($codigo, 24, 10); //Posições de 6 a 15 do campo livre
        $p2 = self::modulo10($p1); //Digito do campo 2
        $p3 = $p1 . $p2;
        $campo2 = substr($p3, 0, 5) . '.' . substr($p3, 5);

        /**
         * 3. Campo composto pelas posicoes 16 a 25 do campo livre
         * e livre e DV (modulo10) deste campo
         */
        $p1 = substr($codigo, 34, 10); //Posições de 16 a 25 do campo livre
        $p2 = self::modulo10($p1); //Digito do Campo 3
        $p3 = $p1 . $p2;
        $campo3 = substr($p3, 0, 5) . '.' . substr($p3, 5);

        /**
         * 4. Campo - digito verificador do codigo de barras
         */
        $campo4 = substr($codigo, 4, 1);

        /**
         * 5. Campo composto pelo fator vencimento e valor nominal do documento, sem
         * indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
         * tratar de valor zerado, a representacao deve ser 000 (tres zeros).
         */
        $p1 = substr($codigo, 5, 4);
        $p2 = substr($codigo, 9, 10);
        $campo5 = $p1 . $p2;

        return $campo1 . ' ' . $campo2 . ' ' . $campo3 . ' ' . $campo4 . ' ' . $campo5;
    }

}
