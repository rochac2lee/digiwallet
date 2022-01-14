<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Backend

Para esse projeto utilizamos o Laravel como framework backend e utilizamos o banco de dados Mysql.

## Instalação

1 - Acesse o mysql e crie o banco de dados com o comando abaixo:
```
CREATE DATABASE digiwallet;
```
2 - Crie uma cópia do arquivo .env.example para .env e altere os dados de conexões:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digiwallet
DB_USERNAME=seu_usuario_db
DB_PASSWORD=sua_senha_db

## Migrations e Seeds

Para migrar todas as tabelas e popular o banco com os dados default, execute o comando:
```
php artisan migrate --seed
```
## Executando o backend

Para executar o backend, execute o comando:
```
php artisan serve
```
