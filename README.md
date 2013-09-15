BoletoPHP - ZF2 Module
=======================

Introdução
------------
A intenção deste projeto é criar uma versão alternativa do BoletoPHP (http://boletophp.com.br) adaptado
para o Zend Framework 2, convertido totalmente para MVC e aplicado nas regras da PSR-0 do PHP.

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
     'Boleto',
     ```
  6. Copie o arquivo `diretorio/do/meu/projeto/vendor/jotjunior/boletophp-zf2/boleto.global.php.default` para o diretório `diretorio/do/meu/projeto/config/autoload` e remova a extensão .default

Demo
----
[Página de demonstração do projeto](http://phpboleto-zf2.jot.com.br/)

Créditos
--------
Este projeto é totalmente inspirado no BoletoPHP e trata-se somente de uma adtaptação para o Zend Framework 2. Todos os créditos e direitos dos boletos exibidos neste módulo pertencem ao BoletoPHP.
Para mais informações, acesse o site do [BoletoPHP](http://www.boletophp.com.br)