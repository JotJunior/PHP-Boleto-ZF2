<?php

/**
 * BoletoPhp ZF2 - Versão Beta 
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
 * Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel
 * William Schultz e Leandro Maniezo que por sua vez foi derivado do
 * PHPBoleto de João Prado Maia e Pablo Martins F. Costa
 * 
 * Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)
 * Acesse o site do Projeto BoletoPhp: www.boletophp.com.br 
 * 
 * Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br> 
 * 
 * Adaptação ao Zend Framework 2: João G. Zanon Jr. <jot@jot.com.br>
 * 
 */

namespace BoletophpZF2\Lib;

abstract class Boleto {

	const fBarcodeFino = 1;
	const fBarcodeLargo = 3;
	const fBarcodeAltura = 50;
	const fBarcodeImgB = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAABQAQMAAAAa6XZvAAAAA1BMVEX///+nxBvIAAAADElEQVR42mNgGFkAAADwAAE4aVpRAAAAAElFTkSuQmCC';
	const fBarcodeImgP = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAABQAQMAAAAa6XZvAAAAA1BMVEUAAACnej3aAAAADElEQVR42mNgGFkAAADwAAE4aVpRAAAAAElFTkSuQmCC';

	/**
	 * Gera o dígito verificador do código de barras
	 * @param int $numero
	 * @return int
	 */
	public static function digitoVerificadorBarra($numero) {
		$resto2 = self::modulo11($numero, 9, 1);
		if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
			$dv = 1;
		} else {
			$dv = 11 - $resto2;
		}
		return $dv;
	}

	/**
	 * Formata o número que gerará o código de barras
	 * 
	 * @param int $numero
	 * @param int $loop
	 * @param int $insert
	 * @param string $tipo
	 * @return string
	 */
	public static function formataNumero($numero, $loop, $insert, $tipo = "geral") {
		if ($tipo == "geral") {
			$numero = str_replace(",", "", $numero);
			while (strlen($numero) < $loop) {
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "valor") {
			/*
			  retira as virgulas
			  formata o numero
			  preenche com zeros
			 */
			$numero = str_replace(",", "", $numero);
			while (strlen($numero) < $loop) {
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "convenio") {
			while (strlen($numero) < $loop) {
				$numero = $numero . $insert;
			}
		}
		return $numero;
	}

	/**
	 * Gera a sequência de imagens que compõe o código de barras
	 * @param string $valor
	 * @return string
	 */
	public static function formataCodigoDeBarras($valor) {
		
		// binários do código de barras
		$barcodes[0] = "00110";
		$barcodes[1] = "10001";
		$barcodes[2] = "01001";
		$barcodes[3] = "11000";
		$barcodes[4] = "00101";
		$barcodes[5] = "10100";
		$barcodes[6] = "01100";
		$barcodes[7] = "00011";
		$barcodes[8] = "10010";
		$barcodes[9] = "01010";

		for ($f1 = 9; $f1 >= 0; $f1--) {
			for ($f2 = 9; $f2 >= 0; $f2--) {
				$f = ($f1 * 10) + $f2;
				$texto = "";
				for ($i = 1; $i < 6; $i++) {
					$texto .= substr($barcodes[$f1], ($i - 1), 1) . substr($barcodes[$f2], ($i - 1), 1);
				}
				$barcodes[$f] = $texto;
			}
		}

		$barcodeData = '<img src="' . self::fBarcodeImgP . '" width="' . self::fBarcodeFino . '" height="' . self::fBarcodeAltura . '" />';
		$barcodeData .= '<img src="' . self::fBarcodeImgB . '" width="' . self::fBarcodeFino . '" height="' . self::fBarcodeAltura . '" />';
		$barcodeData .= '<img src="' . self::fBarcodeImgP . '" width="' . self::fBarcodeFino . '" height="' . self::fBarcodeAltura . '" />';
		$barcodeData .= '<img src="' . self::fBarcodeImgB . '" width="' . self::fBarcodeFino . '" height="' . self::fBarcodeAltura . '" />';

		$texto = $valor;
		if ((strlen($texto) % 2) <> 0) {
			$texto = "0" . $texto;
		}

		while (strlen($texto) > 0) {
			$i = round(self::esquerda($texto, 2));
			$texto = self::direita($texto, strlen($texto) - 2);
			$f = $barcodes[$i];
			for ($i = 1; $i < 11; $i+=2) {
				if (substr($f, ($i - 1), 1) == "0") {
					$f1 = self::fBarcodeFino;
				} else {
					$f1 = self::fBarcodeLargo;
				}
				$barcodeData .= '<img src="' . self::fBarcodeImgP . '" width="' . $f1 . '" height="' . self::fBarcodeAltura . '" />';

				if (substr($f, $i, 1) == "0") {
					$f2 = self::fBarcodeFino;
				} else {
					$f2 = self::fBarcodeLargo;
				}
				$barcodeData .= '<img src="' . self::fBarcodeImgB . '" width="' . $f2 . '" height="' . self::fBarcodeAltura . '" />';
			}
		}

		$barcodeData .= '<img src="' . self::fBarcodeImgP . '" width="' . self::fBarcodeLargo . '" height="' . self::fBarcodeAltura . '" />';
		$barcodeData .= '<img src="' . self::fBarcodeImgB . '" width="' . self::fBarcodeFino . '" height="' . self::fBarcodeAltura . '" />';
		$barcodeData .= '<img src="' . self::fBarcodeImgP . '" width="' . self::fBarcodeFino . '" height="' . self::fBarcodeAltura . '" />';

		return $barcodeData;
	}

	/**
	 * 
	 * @param string $entra
	 * @param int $comp
	 * @return string
	 */
	public static function esquerda($entra, $comp) {
		return substr($entra, 0, $comp);
	}

	/**
	 * 
	 * 
	 * @param string $entra
	 * @param int $comp
	 * @return string
	 */
	public static function direita($entra, $comp) {
		return substr($entra, strlen($entra) - $comp, $comp);
	}

	/**
	 * Calcula o fator de vencimento para geração da data de vencimento do boleto
	 * @param string $data
	 * @return int
	 */
	public static function fatorVencimento($data) {
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
	public static function dataParaDias($ano, $mes, $dia) {
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
	public static function modulo10($num) {
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
	public static function modulo11($num, $base = 9, $r = 0) {
		$soma = 0;
		$fator = 2;

		/* Separacao dos numeros */
		for ($i = strlen($num); $i > 0; $i--) {
			// pega cada numero isoladamente
			$numeros[$i] = substr($num, $i - 1, 1);
			// Efetua multiplicacao do numero pelo falor
			$parcial[$i] = $numeros[$i] * $fator;
			// Soma dos digitos
			$soma += $parcial[$i];
			if ($fator == $base) {
				// restaura fator de multiplicacao para 2 
				$fator = 1;
			}
			$fator++;
		}

		/* Calculo do modulo 11 */
		if ($r == 0) {
			$soma *= 10;
			$digito = $soma % 11;
			if ($digito == 10) {
				$digito = 0;
			}
			return $digito;
		} elseif ($r == 1) {
			$resto = $soma % 11;
			return $resto;
		}
	}

	/**
	 * Gera o dígito verificador do código do banco
	 * @param int $numero
	 * @return int
	 */
	public static function geraCodigoBanco($numero) {
		$parte1 = substr($numero, 0, 3);
		$parte2 = self::modulo11($parte1);
		return $parte1 . "-" . $parte2;
	}

}
