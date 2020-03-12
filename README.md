# Multiplica Talen API

This API allows to retrieve the name, color code, year and pantone value of a color.
You can also add them.

API develop in Symfony 4.5 (PHP).

#Installation :
1. Decompress archive (Multiplica_Talen.zip) <br>
2. In terminal : <br>
`composer install`<br>
*install composer (https://getcomposer.org/download)
3. Create database in MySQL :<br>
`CREATE DATABASE multiplica_talen;`
4. In .env file : <br>
4.1 Add your login, password, database name (line 32 - DATABASE_URL) <br>
5. In terminal : <br>
`php bin/console doctrine:migrations:generate` <br>
`php bin/console m:m` <br>
`php bin/console doctrine:migrations:migrate`
6. In terminal in repository project : <br>
`mysql -uroot -p < dump.sql`
7. Run local server
8. Good job !

#Manual

Colors collection : (GET)

 `/colores`
 
Pagination : (GET)
 
example : `/colores?page=2`

Xml request (default json response): (GET)
example :`/colores?type=xml`

Pagination & request : (GET)

example : `/colores?page=2&type=xml`

Show color : (GET)

`/colores/3`

Show color xml (default json response) : (GET)

`/colores/3?type=xml`

Create color : (POST)

example in postman :

`/colores/create/` 

-> body / raw


`{`



     "name": "test",
     "year": 2001,
     "color": "#00000",
     "pantone_value": "15-4343"`
     
 `}`
 
 GitHub project : https://github.com/JefDc/Multiplica_talen