<?php

if (preg_match('/\.css|\.js|\.jpg|\.png|\.map$/', $_SERVER['REQUEST_URI'], $match)) {
    $mimeTypes = [
        '.css' => 'text/css',
        '.js'  => 'application/javascript',
        '.jpg' => 'image/jpg',
        '.png' => 'image/png',
        '.map' => 'application/json'
    ];
    $path = __DIR__ . $_SERVER['REQUEST_URI'];

    if (is_file($path)) {
        header("Content-Type: {$mimeTypes[$match[0]]}");
        require $path;
        exit;
    }
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/../App/bootstrap.php';

$kernel->run();
