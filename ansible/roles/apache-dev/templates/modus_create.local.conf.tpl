<VirtualHost *:80>
    ServerAdmin vladimirbasic@modus_create.local
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