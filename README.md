
### Installation
#### 0. Clone this project

#### 1. Create `.env` file from `.env.example` in docker directory
The given configuration will be used by Docker to build the containers.

If you change `NGINX_PORT` to other than port 8000 or `PHP_PORT` to other than port 9000,
you need to adjust `listen` and `fastcgi_pass` in nginx configuration at
[`/nginx/default.conf`](https://github.com/wiliamhw/Laravel-9-Docker-Template/blob/main/nginx/default.conf).

For example, if you change `NGINX_PORT` to port 8005 or `PHP_PORT` to port 9005, the
[`/nginx/default.conf`](https://github.com/wiliamhw/Laravel-9-Docker-Template/blob/main/nginx/default.conf) will be filled
like this:
```
server {
	listen 8005;
	...
    
	location ~ \.php$ {
		try_files $uri =404;
		fastcgi_split_path_info ^(.+\.php)(\.+)$;
		fastcgi_pass php:9005;
		...
	}
	...
}
```

#### 2. Run command `make build` on your terminal
This command will build Docker Compose containers.

#### 3. Run command `make up` on your terminal
This command will run Docker Compose containers.

#### 4. Run command `make ex` on your terminal
This command will open PHP container terminal.

#### 5. Adjust `.env` file in `` directory
The given DB credentials, DB port, and Redis port in `/.env` must be equal to the given values in `/.env`.  
You also need to change `DB_HOST` value in `/.env` based on this format: `{CONTAINER_PREFIX}_postgres`.  
You can see the value of `CONTAINER_PREFIX` in `/.env` at the project root directory.

#### 6. Go to [http://localhost:8000/](http://localhost:8000/) or any port you assign to `NGINX_PORT` in the root directory `.env` file
This action will open Laravel application in a web browser.  
If you want to open [Laravel Telescope](https://laravel.com/docs/9.x/telescope) page, you can access
[http://localhost:8000/telescope](http://localhost:8000/telescope) or any port you assign to `NGINX_PORT` in the root directory `.env` file.

### Makefile
>Makefile command can be run on the project docker directory, where `Makefile` resides in.
* `make build` : build Docker Compose containers
* `make up` : run Docker Compose containers
* `make stop` : stop Docker Compose containers
* `make down` : remove Docker Compose containers
* `make purge` : remove Postgres SQL volume in host.
* `make ex` : open PHP container terminal
* `make analyse` : run static analysis and store the result in `/storage/logs/analyse.log`
