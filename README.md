# FOP

[![Build Status](https://img.shields.io/travis/brieucthomas/fop/develop.svg?style=flat-square)](https://travis-ci.org/brieucthomas/fop)

## Install

### Database

``` bash 
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:update --force
$ bin/console doctrine:fixtures:load --no-interaction --env=prod
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


## Translations

### Extraction

``` bash
$ bin/console translation:extract --config=app
```

### Edition

```
<base_url>/_trans
```
