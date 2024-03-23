<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '123/*-asd', 'bienesraices');

    if(!$db) {
        echo "Error, no se conecto a la bdd";
        exit;
    }

    return $db;

}