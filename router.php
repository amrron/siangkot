<?php
// file router.php

// Dapatkan URI yang diminta
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Tentukan jalur ke skrip yang sesuai
$requested = __DIR__ . $uri;

// Jika file yang diminta ada, layani secara langsung
if ($uri !== '/' && file_exists($requested)) {
    return false;
}

// Jika tidak, arahkan ke index.php
include_once __DIR__ . '/index.php';
