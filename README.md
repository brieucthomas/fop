# FOP

[![Build Status](https://img.shields.io/travis/brieucthomas/fop/develop.svg?style=flat-square)](https://travis-ci.org/brieucthomas/fop)

## Install

### Database

``` bash 
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:create --force
```

### Create an administrator

You can create an administrator account like that (ROLE_ADMIN) :

``` bash 
$ bin/console fos:user:create
$ bin/console fos:user:promote
```

### Assets

``` bash
$ npm update
```

``` bash
$ ./node_modules/.bin/bower update
```

``` bash
$ ./node_modules/.bin/gulp
```

``` bash
bin/console assets:install --symlink
```

## Translations

### Extraction

``` bash
$ bin/console translation:extract --config=app
```

### Edition

```
<base_url>/_trans
```


## Heroku

``` bash
$ heroku run bin/console doctrine:database:create
$ heroku run bin/console doctrine:schema:create --force
```

## Production

``` bash
$ bin/console assetic:dump 
```