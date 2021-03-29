# WallBox Test

To start application exist two ways: 

1. Install [Docker](https://www.docker.com) and run command in terminal:
````
docker build .
````

to build docker container, then run docker container using command below:
````
docker run -p 8000:80 <container_id>
````

2. Second way to run app use first command:
````
composer install
````

then 

````
php bin/console server:run   
````


----
Now you can start testing application, documentation is available on url: 

```
localhost:8000/api/doc
```
