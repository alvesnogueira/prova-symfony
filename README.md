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
1.Configure o arquivo .env
``` de DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name ```
``` para DATABASE_URL=mysql://dbuser:123@127.0.0.1:3306/dbprova ```
