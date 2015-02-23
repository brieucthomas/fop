<?php

if (isset($_ENV['DATABASE_URL']) && (false !== $url = parse_url($_ENV['DATABASE_URL']))) {
    $container->setParameter('database_host', $url['host']);
    $container->setParameter('database_port', $url['port']);
    $container->setParameter('database_name', trim($url['path'], '/'));
    $container->setParameter('database_user', $url['user']);
    $container->setParameter('database_password', $url['pass']);
}

if (isset($_ENV['MAILER_HOST'])) {
    $container->setParameter('mailer_host', $_ENV['MAILER_HOST']);
}

if (isset($_ENV['MAILER_PORT'])) {
    $container->setParameter('mailer_port', $_ENV['MAILER_PORT']);
}

if (isset($_ENV['MAILER_ENCRYPTION'])) {
    $container->setParameter('mailer_encryption', $_ENV['MAILER_ENCRYPTION']);
}

if (isset($_ENV['MAILER_AUTH_MODE'])) {
    $container->setParameter('mailer_auth_mode', $_ENV['MAILER_AUTH_MODE']);
}

if (isset($_ENV['MAILER_USER'])) {
    $container->setParameter('mailer_user', $_ENV['MAILER_USER']);
}

if (isset($_ENV['MAILER_PASSWORD'])) {
    $container->setParameter('mailer_password', $_ENV['MAILER_PASSWORD']);
}

if (isset($_ENV['SYMFONY_SECRET'])) {
    $container->setParameter('secret', $_ENV['SYMFONY_SECRET']);
}