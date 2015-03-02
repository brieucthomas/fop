# FOP

[![Build Status](https://img.shields.io/travis/brieucthomas/fop/master.svg?style=flat-square)](https://travis-ci.org/brieucthomas/fop)
[![Code Coverage](http://img.shields.io/scrutinizer/coverage/g/brieucthomas/fop/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/brieucthomas/fop/?branch=master)
[![Code Quality](http://img.shields.io/scrutinizer/g/brieucthomas/fop/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/brieucthomas/fop/?branch=master)

## Install

### Database

``` bash 
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:create --force
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