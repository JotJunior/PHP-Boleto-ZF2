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

namespace Boleto\Lib;

class BB extends Boleto {

	protected $banco = 'banco_do_brasil';

	/**
	 * @author Ramon Soares
	 * 
	 * Calcula o dígito verificaror do Nosso Nümero
	 * 
	 * @param string $numero
	 * @return int
	 */
	public function digitoVerificadorNossoNumero($numero) {
		$resto2 = $this->modulo11($numero, 7, 1);
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
	 * 
	 * Posição			Conteúdo
	 * 1 a 3			Número do banco
	 * 4				Código da moeda - 9 para Real
	 * 5				Dígito verificador do código de barras
	 * 6 a 19			Valor (12 inteiros e 2 decimais)
	 * 20 a 44			Campo livre definido pr cada banco
	 * 
	 * @param string $linha
	 * @return string
	 */
	public function montaLinhaDigitavel($linha) {
		// 1. Campo - composto pelo código do banco, código da moeda, as cinco primeiras posições
		// do campo livre e DV (modulo10) deste campo
		$p1 = substr($linha, 0, 4);
		$p2 = substr($linha, 19, 5);
		$p3 = $this->modulo10("$p1$p2");
		$p4 = "$p1$p2$p3";
		$p5 = substr($p4, 0, 5);
		$p6 = substr($p4, 5);
		$campo1 = "$p5.$p6";

		// 2. Campo - composto pelas posições 6 a 15 do campo livre
		// e livre e DV (modulo10) deste campo
		$p1 = substr($linha, 24, 10);
		$p2 = $this->modulo10($p1);
		$p3 = "$p1$p2";
		$p4 = substr($p3, 0, 5);
		$p5 = substr($p3, 5);
		$campo2 = "$p4.$p5";

		// 3. Campo composto pelas posicoes 16 a 25 do campo livre
		// e livre e DV (modulo10) deste campo
		$p1 = substr($linha, 34, 10);
		$p2 = $this->modulo10($p1);
		$p3 = "$p1$p2";
		$p4 = substr($p3, 0, 5);
		$p5 = substr($p3, 5);
		$campo3 = "$p4.$p5";

		// 4. Campo - digito verificador do codigo de barras
		$campo4 = substr($linha, 4, 1);

		// 5. Campo composto pelo valor nominal pelo valor nominal do documento, sem
		// indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
		// tratar de valor zerado, a representacao deve ser 000 (tres zeros).
		$campo5 = substr($linha, 5, 14);

		return $campo1 . ' ' . $campo2 . ' ' . $campo3 . ' ' . $campo4 . ' ' . $campo5;
	}

	/**
	 * Alterado por Daniel Schultz
	 * 
	 * Vamos explicar:
	 * 
	 * O módulo 11 só gera os dígitos verificadores do nossonumero, 
	 * agencia, conta e dígito verificador com código de barras (aquele que fica sozinho e triste na linha digitável)
	 * só que foi um rolo, porque ele nao podia resultar em 0, e o pessoal do phpboleto se esqueceu disso...
	 * 
	 * No BB, os dígitos verificadores podem ser X ou 0 (zero) para agencia, conta e nosso numero,
	 * mas nunca pode ser X ou 0 (zero) para a linha digitável, justamente por ser totalmente numérica.
	 * 
	 * Quando passamos os dados para a função, fica assim:
	 * 		Agencia = sempre 4 digitos
	 * 		Conta = até 8 dígitos
	 * 		Nosso número = de 1 a 17 digitos
	 * 
	 * A unica variável que passa 17 digitos é a da linha digitada, justamente por ter 43 caracteres
	 * 
	 * Entao vamos definir ai embaixo seguinte:
	 * 		se (strlen($num) == 43) { não deixar dar digito X ou 0 }*
	 * 
	 * 
	 * @param mixed $num
	 * @param int $base
	 * @param int $r
	 * @return int
	 */
	public function modulo11($num, $base = 9, $r = 0) {
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

			//corrigido
			if ($digito == 10) {
				$digito = "X";
			}

			if (strlen($num) == "43") {
				//então estamos checando a linha digitável
				if ($digito == "0" or $digito == "X" or $digito > 9) {
					$digito = 1;
				}
			}
			return $digito;
		} elseif ($r == 1) {
			$resto = $soma % 11;
			return $resto;
		}
	}

}

