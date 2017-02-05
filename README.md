# Phone Recovery
The aim of this project is to provide a REST API in order to create and to consult phone recovery.
Prices are fixed according to the model of the device.
Data will be found in JSON files.
This project also provide a small application to list and create phone recovery.

### Architecture
This app is based on Symfony 3. The API will be located in a separate bundle (ApiBundle). The external bundle [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle) is used to generate an api doc.

### Prerequisite packages
Need to install the following packages : `php-curl` for external API calls, `php-mbstring` and `php-xdebug` for phpunit.

### Deploy the application
Firstly, if not already done, refer to [this page](http://symfony.com/doc/current/setup/web_server_configuration.html) to configure your server (Apache and Nginx are supported).
This is an example of my Nginx config:
```
server {
        listen 80;
        listen [::]:80;
        root /home/seb/projects/phone-recovery/web;
        server_name phone-recovery.localhost;
        location / {
                try_files $uri $uri/ =404;
        }
        location ~ ^/(app|app_dev|config).php(/|$) {
                fastcgi_pass unix:/run/php/php7.0-fpm.sock;
                fastcgi_split_path_info ^(.+.php)(/.*)$;
                include fastcgi_params;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_param HTTPS off;
        }
}
```
Then, clone the project on your web directory and give permissions on cache, log and sessions directories:
```shell
setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/logs var/sessions
setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/logs var/sessions
```
Finally, run this command to deploy the application in dev :
```shell
./deploy_dev.sh
```
The first time, composer will install all required packages. At the end, press just "enter" each time to keep all default parameters.

You can also have a prod simulation by running :
```shell
./deploy_prod.sh
```
### URLs
- The main application : http://phone-recovery.localhost/app_dev.php in dev, http://phone-recovery.localhost/app.php in prod
- An api doc expose all services and provide sandboxes: http://phone-recovery.localhost/app_dev.php/services/doc in dev, http://phone-recovery.localhost/app.php/services/doc in prod.

### Testing
Run this command to execute unit and functional tests, with generated code coverage:
```shell
./vendor/phpunit/phpunit/phpunit --coverage-html ~/phone-recovery-coverage
```