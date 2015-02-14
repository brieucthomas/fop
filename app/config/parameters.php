<?php

if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
    $url = parse_url($_ENV['CLEARDB_DATABASE_URL']);

    $container->setParameter('database_host', $url['host']);
    $container->setParameter('database_port', $url['port']);
    $container->setParameter('database_name', trim($url['path'], '/'));
    $container->setParameter('database_user', $url['user']);
    $container->setParameter('database_password', $url['pass']);
}

if (isset($_ENV['POSTMARK_SMTP_SERVER'])) {
    $container->setParameter('mailer_host', $_ENV['POSTMARK_SMTP_SERVER']);
}

if (isset($_ENV['POSTMARK_API_TOKEN'])) {
    $container->setParameter('mailer_host', $_ENV['POSTMARK_API_TOKEN']);
}

if (isset($_ENV['POSTMARK_INBOUND_ADDRESS'])) {
    $container->setParameter('mailer_host', $_ENV['POSTMARK_INBOUND_ADDRESS']);
}

if (isset($_ENV['SYMFONY_SECRET'])) {
    $container->setParameter('secret', $_ENV['SYMFONY_SECRET']);
}

if (isset($_ENV['SYMFONY_SECRET'])) {
    $container->setParameter('secret', $_ENV['SYMFONY_SECRET']);
}

