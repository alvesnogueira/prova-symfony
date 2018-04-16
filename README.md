# prova-symfony
Criar um projeto com o symfony

1. Clone a url da maquina no repositório ``` https://github.com/alvesnogueira/vagrant-with-php7 ```
1. Dentro da pasta ``` awesome ``` Clone este projeto.
1. Execute o comando ```vagrant ssh```
1. Acesse a pasta do projeto dentro da máquina virtual ```/var/www/awesome/website-skeleton```
1. Execute as migrations

```html
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:diff

```
