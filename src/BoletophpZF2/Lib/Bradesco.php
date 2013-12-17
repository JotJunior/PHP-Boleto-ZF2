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

class Bradesco extends Boleto {

	protected $banco = 'bradesco';

	/**
	 * @author Ramon Soares
	 * 
	 * Calcula o dígito verificaror do Nosso Nümero
	 * 
	 * @param string $numero
	 * @return int
	 */
	public static function digitoVerificadorNossoNumero($numero) {
		$resto2 = self::modulo11($numero, 7, 1);
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
	 * @author Ramon Soares
	 * 
	 * Gera a linha digitável do boleto BRADESCO
	 * 
	 * 01-03    -> Código do banco sem o digito
	 * 04-04    -> Código da Moeda (9-Real)
	 * 05-05    -> Dídigo verificador do código de barras
	 * 06-09    -> Fator de vencimento
	 * 10-19    -> Valor Nominal do TÌtulo
	 * 20-44    -> Campo Livre (Abaixo)
	 * 20-23    -> Código da Agencia (sem dídigo)
	 * 24-05    -> Número da Carteira
	 * 26-36    -> Nosso Número (sem dídigo)
	 * 37-43    -> Conta do Cedente (sem dídigo)
	 * 44-44    -> Zero (Fixo)
	 * 
	 * @param string $codigo
	 * @return string
	 */
	public static function montaLinhaDigitavel($codigo) {

		// 1. Campo - composto pelo código do banco, código da moeda, as cinco primeiras posições
		// do campo livre e DV (modulo10) deste campo
		$p1 = substr($codigo, 0, 4); // Numero do banco + Carteira
		$p2 = substr($codigo, 19, 5);   // 5 primeiras posiÁıes do campo livre
		$p3 = self::modulo10("$p1$p2");   // Digito do campo 1
		$p4 = $p1 . $p2 . $p3;  // União
		$campo1 = substr($p4, 0, 5) . '.' . substr($p4, 5);

		// 2. Campo - composto pelas posiÁoes 6 a 15 do campo livre
		// e livre e DV (modulo10) deste campo
		$p1 = substr($codigo, 24, 10);   //PosiÁıes de 6 a 15 do campo livre
		$p2 = self::modulo10($p1);  //Digito do campo 2	
		$p3 = $p1 . $p2;
		$campo2 = substr($p3, 0, 5) . '.' . substr($p3, 5);

		// 3. Campo composto pelas posicoes 16 a 25 do campo livre
		// e livre e DV (modulo10) deste campo
		$p1 = substr($codigo, 34, 10);   //PosiÁıes de 16 a 25 do campo livre
		$p2 = self::modulo10($p1);  //Digito do Campo 3
		$p3 = $p1 . $p2;
		$campo3 = substr($p3, 0, 5) . '.' . substr($p3, 5);

		// 4. Campo - digito verificador do codigo de barras
		$campo4 = substr($codigo, 4, 1);

		// 5. Campo composto pelo fator vencimento e valor nominal do documento, sem
		// indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
		// tratar de valor zerado, a representacao deve ser 000 (tres zeros).
		$p1 = substr($codigo, 5, 4);
		$p2 = substr($codigo, 9, 10);
		$campo5 = $p1 . $p2;

		return $campo1 . ' ' . $campo2 . ' ' . $campo3 . ' ' . $campo4 . ' ' . $campo5;
	}

}

