# Installation

`composer install`

Create .env file in the root directory, near .env.dist

In .env file modify DATABASE_URL so that symfony could connect to your database.
Pick a database name, you do not need to have it created.

Run

`php bin/console doctrine:database:create`

this will create database.

Create table:

`php bin/console doctrine:migrations:migrate`
(choose yes answer).

Configure web server, example for apache:

```
<VirtualHost *:80>   
    DocumentRoot "E:/projektai/php projektai/htdocs/mokomieji/symfony_4_demo/public"
    ServerName symfony-4-demo.com
	
   <Directory "E:/projektai/php projektai/htdocs/mokomieji/symfony_4_demo/public">
        AllowOverride None
        Order Allow,Deny
        Allow from All

        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ index.php [QSA,L]
        </IfModule>
    </Directory>
</VirtualHost>
```

More web server configuration examples here:
http://symfony.com/doc/current/setup/web_server_configuration.html
