<?php

if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
    $url = parse_url($_ENV['CLEARDB_DATABASE_URL']);

    $container->setParameter('database_host', $url['host']);
    $container->setParameter('database_port', $url['port']);
    $container->setParameter('database_name', trim($url['name'], '/'));
    $container->setParameter('database_user', $url['user']);
    $container->setParameter('database_password', $url['pass']);
}

if (isset($_ENV['SYMFONY_SECRET'])) {
    $container->setParameter('secret', $_ENV['SYMFONY_SECRET']);
}