# Phone Recovery
The aim of this project is to provide a REST API in order to create and to consult phone recovery.
Prices are fixed according to the model of the device.
Data will be found in JSON files.
This project also provide a small application to list and create phone recovery.

### Architecture
This app is based on Symfony 3. The API will be located in a separate bundle (ApiBundle). The external bundle [NelmioApiDocBundle](https://github.com/nelmio/NelmioApiDocBundle) is used to generate an api doc.

### Deploy the application
Firstly, if not already done, refer to [this page](http://symfony.com/doc/current/setup/web_server_configuration.html) to configure your server (Apache and Nginx are supported).
Then, after cloning the project on your web directory, run this command to deploy the application in dev :
```shell
./deploy_dev.sh
```
You can also have a prod simulation by running :
```shell
./deploy_prod.sh
```
### Api doc
An api doc expose all services and provide sandboxes for testing. It is available under "http://<host_name>/services/doc".

### Testing
Run this command to execute unit and functional tests :
```shell
./vendor/phpunit/phpunit/phpunit --coverage-html web/coverage/
```
The coverage will be available under "http://<host_name>/coverage".