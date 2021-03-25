<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    $logged_user_id = $_SESSION['logged_user_id'];

    $incomesQuery = $database -> prepare("SELECT * FROM incomes WHERE user_id = :logged_user_id");

    $incomesQuery->bindValue(':logged_user_id', $logged_user_id, PDO::PARAM_INT);

    $incomes = $incomesQuery -> fetch();
    
    
    
    
    if(isset($_POST['beginning_date'])){
        $beginning_date = $_POST['beginning_date'];
        $end_date = $_POST['end_date'];
    }

    