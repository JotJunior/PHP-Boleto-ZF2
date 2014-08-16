BoletoPHP - ZF2 Module
=======================

Introdução
------------
A intenção deste projeto é criar uma versão alternativa do BoletoPHP (http://boletophp.com.br) adaptado
para o Zend Framework 2, convertido totalmente para MVC com suas funções convertidas para classes e unificadas 
em uma única library.

As views foram convertidas para UTF-8 e o código de barras agora é gerado pelo Zend\Barcode.  

Instalação
----------
  1. `cd diretorio/do/meu/projeto`
  2. Crie um arquivo `composer.json` com o seguinte conteúdo:

     ```json
     {
         "minimum-stability": "dev",
         "require": {
             "jotjunior/boletophp-zf2": "dev-master"
         }
     }
     ```
  3. Instale o PHP Composer via `curl -s http://getcomposer.org/installer | php` (No windows, acesse
     http://getcomposer.org/installer e o execute com o PHP)
  4. execute `php composer.phar install`
  5. abra `diretorio/do/meu/projeto/config/application.config.php` e adicione a seguinte chave no índice `modules`: 

     ```php
     'PhpBoletoZf2',
     ```
  6. Copie o arquivo `diretorio/do/meu/projeto/vendor/jotjunior/boletophp-zf2/dist/php-boleto-zf2.global.php` para o diretório `diretorio/do/meu/projeto/config/autoload` e configure seus dados.

Rotas
-----
As rotas de acesso ao módulo são:

`exemplo.com/boleto[/:controller[/:format]]` para acesso ao boleto;

`exemplo.com/boleto[:/controller]/demo` para acesso ao formulário de exemplo;

OBS: são dois formatos válidos para o boleto: `html` ou `pdf`, sendo o HTML opcionsl


Chamando o boleto dentro do seu controller
--
Para escrever os dados do cedente, sacado ou boleto dentro do seu próprio controlador, basta fazer o seguinte:

```php
// recebendo os dados do boleto, seja por REQUEST ou Banco de Dados
$data = array( /** dados para emissão do boleto **/ ); 

// Instanciando as classes relacionadas ao boleto
$boleto = new BoletoItau($data);
$sacado = new Sacado($data);
$cedente = new Cedente($data);

// chamando o serviço para criação do boleto
$itau = $this->getServiceLocator()
        ->get('Boleto\Itau')
        ->setSacado($sacado)
        ->setCedente($cedente)
        ->setBoleto($boleto);
$dados = $itau->prepare();

// montando a view
$view = new ViewModel(array("dados" => $dados));
$view->setTerminal(true); // elimina o layout
$view->setTemplate("/php-boleto-zf2/itau/index");

return $view;
```
Demo
----
[Página de demonstração do projeto](http://phpboleto-zf2.jot.com.br/)

Créditos
--------
Este projeto é inspirado no [BoletoPHP](http://www.boletophp.com.br) 