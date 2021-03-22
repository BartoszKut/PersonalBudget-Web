<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    if(!($_POST['amount']=="")){
        $all_ok = true; //correct validation

        $amount = $_POST['amount']; 
        $date = $_POST['date'];
        $paymentmethod = $_POST['paymentmethod'];
        $expensecat = $_POST['expensecat'];
        $comment = $_POST['comment'];
       
        echo "$amount<br/><br/>";
        echo "$date<br/><br/>";
        echo "$paymentmethod<br/><br/>";
        echo "$expensecat<br/><br/>";
        echo "$comment<br/><br/>";
        

        


    }