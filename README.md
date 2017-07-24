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

Make sure:

```
APP_DEBUG=false
APP_ENV=production
```

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
* Use `LF` for line breaking
* Reserve an empty line at the end of file

#### PHP

* Respect [PSR](http://www.php-fig.org/psr/)

#### ECMAScript (JavaScript)

* Indent with 4 spaces
* Do not indent empty lines
* Opening braces go on the same line
* Double quotes for strings
    * Except to avoid escaping
* Keep semicolons for each statements
    * Except for `export { ... }` or `return { ... }`
* Use `let` to declare local variables rather than `var`
* Avoid declaring unused variables
* Each variable has its own declaration statement
* Keep space after keywords and commas
* Keep space before and after infix operators
* No space after function names
    * Except for member function declarations in class/object
* Use ES2015 import/export syntax rather than `require()` function

Example:

```js
import pangu from "pangu";

function hello(text) {
    let str = text || "Hello世界!";
    let length = str.length;

    if (typeof str === "string")
        str = pangu.spacing(str);
    else
        str = "Hello 世界!";

    return { str, length }
}

class Greeter {
    constructor (name) {
        this.name = name;

        if (name.length < 100) {
            let mixin = {
                html: "",
                deny () {
                    return false;
                }
            };

            let obj = {
                ...mixin,
                html: '<div class="hello"></div>',
                reverse: str => str.split("").reverse().join("")
            };
        } else {
            console.log("The name is too long.");
        }
    }

    greet () {
        let str = "Hello " + this.name + "!";
        window.alert(str);
        return str;
    }
}

export { hello as default, Greeter }
```

#### CSS

* Use `scss` rather than `sass`
* No prefixes. [autoprefixer](https://github.com/postcss/autoprefixer) will add them automatically.

### Environment

* Use `yarn` rather than `npm` (for lockfile support)

### Serve

```bash
# Temporary Web Server
php -S localhost:9000 -t public server.php

# Webpack Hot Module Replacement
yarn run hot
```
