# FOP

[![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy?template=https://github.com/brieucthomas/fop)
[![Build Status](https://img.shields.io/travis/brieucthomas/fop/master.svg?style=flat-square)](https://travis-ci.org/brieucthomas/fop)

## Install

### Database

``` bash 
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:update --force
$ bin/console doctrine:fixtures:load --no-interaction
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
