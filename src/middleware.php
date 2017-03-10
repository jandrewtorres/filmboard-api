<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$corsOptions = array(
    "origin" => "*",
    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);
$app->add(new /CorsSlim/CorsSlim($corsOptions));