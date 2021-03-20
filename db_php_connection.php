<?php
    $connection = require_once 'connect.php';

    try {
        $database = new PDO("mysql:host={$connection['host']}; dbname={$connection['database_name']}; charset=utf8", $connection['database_user'], $connection['database_password'], [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } 
    catch (PDOException $error) {
        exit('Database error');
    }
?>