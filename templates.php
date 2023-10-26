<?php

function head() {
    error_reporting(E_ALL|E_STRICT);
    echo <<<XML
    <meta charset="utf-8">
    <title>Enigma</title>
    <!-- Responsive Web Site for smartphone -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <!-- Icônes -->
    <link rel="icon" type="image/png" href="favicon.png" sizes="512x512">
    <link rel="apple-touch-icon" type="image/png" href="favicon.png" sizes="512x512">
    <!-- Feuilles de style -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
    <link href='style.css' rel='stylesheet'>
    XML;
}

?>