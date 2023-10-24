# docker-compose

To get started, make sure you have [Docker installed](https://docs.docker.com/desktop/install/windows-install/) on your system, and then clone this repository.

1. Navigate in your terminal to the directory you cloned this
2. copy `.env.example` to `.env` and fill in the data
3. spin up the containers for the web server by running `docker-compose up -d --build`

### run Docker in project
```bash
./vendor/bin/sail up -d   <- run docker
```
```bash
./vendor/bin/sail down   <- remove docker
```



### Container ports

- **nginx** - `:80`
- **postgres** - `:5432` 
- - password = `password`, database = `laravel` 
> http://localhost:`port`

### laravel init
Navigate in your backend directory and run this command:
```bash
php artisan key:generate
php artisan storage:link
php artisan optimize:clear
```
