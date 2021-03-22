<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    if(!($_POST['amount']=="")){
        $all_ok = true; //correct validation

        $amount = $_POST['amount']; 
        $date = $_POST['date'];
        $category = $_POST['category'];
        $comment = $_POST['comment'];
        echo "$comment";
        

        


    }