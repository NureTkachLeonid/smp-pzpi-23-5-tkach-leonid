<?php
// config/language.php
// session_start() УДАЛЕНА из этого файла, т.к. она уже вызывается в header.php

$available_langs = ['en', 'ua'];
$default_lang = 'ua';

if (isset($_GET['lang']) && in_array($_GET['lang'], $available_langs)) {
    $_SESSION['lang'] = $_GET['lang'];
    $current_url = strtok($_SERVER['REQUEST_URI'], '?');
    header('Location: ' . $current_url);
    exit;
}

if (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $available_langs)) {
    $current_lang = $_SESSION['lang'];
} else {
    $current_lang = $default_lang;
    $_SESSION['lang'] = $current_lang;
}

$lang_file = __DIR__ . '/../l10n/' . $current_lang . '.php';
if (file_exists($lang_file)) {
    $t = require $lang_file;
} else {
    $t = [];
}

function t(string $key): string
{
    global $t;
    return $t[$key] ?? $key;
}