<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if (strpos($url, 'index') || strpos($url, '/')) {
    header('Location: store.php');
}
