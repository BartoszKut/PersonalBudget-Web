<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    if(!($_POST['amount']=="")){
        $all_ok = true; //correct validation

        $amount = $_POST['amount']; 
        $date = $_POST['date'];
        $category = $_POST['category'];
        $comment = $_POST['comment'];

        $sql_select_income_query = $database -> prepare("SELECT id FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND name = :income_category");
  
        

        


    }