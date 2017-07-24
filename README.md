# CantonRES

Developed upon Laravel 5.4 and Vue 2

## Requirements

* Nginx or Apache with `mod_rewrite`
* PHP 7.0+
* PostgreSQL 9.5+
* Redis 3.0+
* Node.js 6.0+

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

1. Install Node.js 6.0+ ([nvm](http://nvm.sh) is recommended) and [yarn](https://yarnpkg.com/)
2. Install Front End dependencies with `yarn install` (or just `yarn`)
3. Build JS and CSS with `yarn run production`

You must run `yarn run production` each times you do a `git pull`.

## Development

### Code Standard

#### General

* Use `UTF-8` for file encoding
* Use `LF` for line wrapping
* Reserve an empty line at the end of file

#### PHP

* Respect [PSR](http://www.php-fig.org/psr/)

#### ECMAScript (JavaScript)

* Indent with 4 spaces
* Do not indent empty lines
* Double quotes for strings
* Keep semicolons for each statements
    * except for `export default { ... }` in Vue Components
* Use `let` to declare local variables rather than `var`
* Avoid declaring unused variables
* Keep space after keywords
* No space after function names
* Use ES2015 import/export syntax rather than `require()` function

```ecmascript 6
import pangu from "pangu";

export default function hello(text) {
    let str = text || "Hello世界!";

    if (typeof str === "string") {
        str = pangu.spacing(str);
    }

    console.log(str);

    return str;
}
```

#### CSS

* Use `scss` rather than `sass`

### Environment

* Use `yarn` rather than `npm` (for lockfile support)
