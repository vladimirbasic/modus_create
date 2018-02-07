# API Test project

## Prerequisites when using Vagrant

List of tools and versions for development environment setup in which the app was tested:

* [VirtualBox 5.1.30](https://www.virtualbox.org/)
* [Ansible 2.2.1.0](https://www.ansible.com/)
* [Vagrant 2.0.1](https://www.vagrantup.com/)


Links are available in [Built With](#built-with) section below.

### Installing with Vagrant

Steps required to get a development environment running:

From [app_root]/vagrant directory run machine setup and provisioning

```bash
vagrant up
```

Login into development machine

```bash
vagrant ssh
```

(Optional) Edit your local hosts file (in *nix systems location is usually /etc/hosts) and add following line (you may use `localhost:8080` as well) 

```bash
192.168.111.125 api.modus_create.local
```

Provisioning process will automatically invoke installment of required PHP libraries with `composer install` command

## Prerequisites when NOT using Vagrant

List of tools and versions for manual setup of development environment:

* [PHP 7.1](http://php.net/) with modules: 
  * php7.1-curl
  * php7.1-json
* [Composer 1.6.3](https://getcomposer.org/)
* Web Server (Apache, Nginx or other...)

### Installing without Vagrant

Setup DocumentRoot of your web server to point to `web` directory in root of your application.

Example of Vhost setup using Apache 2.4

```apacheconfig
<VirtualHost *:80>
    ServerAdmin admin@modus_create.local
    DirectoryIndex index.html index.htm index.php
    DocumentRoot "/var/www/modus_create/web"
    ServerName api.modus_create.local

    <Directory "/var/www/modus_create/web">
        AllowOverride None
        Options None
        Order allow,deny
        Allow from all
        Options +FollowSymLinks +SymLinksIfOwnerMatch

        SetEnv MODUS_CREATE_PROJECT_ENVIRONMENT development

        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </Directory>
</VirtualHost>
```

Create file `/var/log/modus_create/error.log` and make it writable.

Run `composer install` in root directory of the application.

## Try application

Depending on the approach you took while installing the application, you should be able to get some response with following URLs:
 * GET http://localhost:8080/vehicles/2015/Audi/A3
 * POST http://localhost:8080/vehicles with following JSON:
   ```javascript
   {
       "modelYear": 2015,
       "manufacturer": "Audi",
       "model": "A3"
   }
   ```  

## Running the tests

In order to run Unit and Integration tests invoke following steps.

Go to application directory (path on Vagrant machine)

```bash
cd /var/www/modus_create
```

Run Unit tests

```bash
composer test-u
```

Run Integration tests

```bash
composer test-i
```

## Coding quality

For code quality PHP CodeSniffer and PHP MessDetector were used.

Runnables are located in code-inspections directory in project root (path on Vagrant machine).

To run PHP CodeSniffer execute:

```bash
./phpcs.sh
```

To run PHP MessDetector execute:

```bash
./phpmd.sh
```

## Built With

* [Ubuntu Trusty](https://www.ubuntu.com/) - 
Popular linux distribution
* [PHP 7.1](http://php.net/) - 
Popular web programming language 
* [Composer 1.6.3](https://getcomposer.org/) - 
Dependency Manager for PHP
* [Silex 2.0](https://silex.symfony.com/) - 
PHP micro-framework based on the Symfony Components
* [PHPUnit 6.4.4](https://phpunit.de/) - 
Unit testing framework for the PHP
* [PHP CodeSniffer 3.1.1](https://github.com/squizlabs/PHP_CodeSniffer) - 
Tool for detecting violations of a defined set of coding standards
* [PHP MessDetector 2.6.0](https://phpmd.org/) - 
Tool for detecting possible bugs, suboptimal code, overcomplicated expressions and unused parameters, methods, properties
* [JSON Schema](http://json-schema.org/) - 
Specification used for describing data format in human/machine readable documentation. Kind of a type hint for JSON user input 
* [Apache 2.4](https://www.apache.org/) - 
HTTP Web server
* [VirtualBox 5.1.30](https://www.virtualbox.org/) - 
Visualization tool for running various OS environments 
* [Vagrant 2.0.1](https://www.vagrantup.com/) - 
Tool for managing virtual machines
* [Ansible 2.2.1.0](https://www.ansible.com/) - 
Tool for making apps and infrastructure automated
* [Aglio/Apiary 2.3.0](https://github.com/danielgtaylor/aglio) - 
An API Blueprint renderer

## Authors

* **Vladimir Basic**
