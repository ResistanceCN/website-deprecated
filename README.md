# CantonRES

Developed upon Laravel 5.4 and Vue 2

## Requirements

* Nginx or Apache with `mod_rewrite`
* PHP 7.0+
* PostgreSQL 9.5+
* Redis 3.0+

## Setup in production

### File Permissions

Do either one of following:

1. Change the owner of whole project directory to the user with which PHP-FPM or Apache runs. For example: `chown -R www:www .`
2. `chmod -R 777 storage bootstrap/cache`

### URI Rewrite

#### Nginx

```
server {
    ...
    root /home/wwwroot/cantonres.com/public;
    
    location / {
        ...
        try_files $uri $uri/ /index.php?$query_string;
    }
}
```

#### Apache

You do not need to do anything since `.htaccess` has done its duty.

### Environment Configurations

1. Copy `.env.example` to `.env`
2. Run `php artisan key:generate`
3. Edit `.env`

Make sure `APP_DEBUG` is set to `false`.

### Install Database

Run `php artisan migrate`

You must run `php artisan migrate` each times you do a `git pull`.

### Front End Resources

1. Install NodeJS ([nvm](http://nvm.sh) is recommended) and [yarn](https://yarnpkg.com/)
2. Install Front End dependencies with `yarn` (Yes, just run it without any params)
3. Build JS and CSS with `yarn run production`

You must run `yarn run production` each times you do a `git pull`.

## Development

* Respect `PSR` in PHP
* Indent with 4 spaces in JS
* Use `yarn` rather than `npm` (for lockfile support)
