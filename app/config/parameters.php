<?php

if (isset($_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'])) {
    $url = parse_url($_ENV['CLEARDB_DATABASE_URL']);

    $container->setParameter('database_host', $url['host']);
    $container->setParameter('database_port', $url['port']);
    $container->setParameter('database_name', trim($url['name'], '/'));
    $container->setParameter('database_user', $url['user']);
    $container->setParameter('database_password', $url['pass']);
}

