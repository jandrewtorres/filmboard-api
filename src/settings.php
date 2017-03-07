<?php

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = "localhost";
$dbname = "film_board_db";
$username = "root";
$password = "Andr3w135246";
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$dbname = substr($url["path"], 1);


return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        "db" => [
            "host" => $server,
            "dbname" => $dbname,
            "user" => $username,
            "pass" => $password
        ],
    ],
];
