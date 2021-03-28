<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    if(!($_POST['amount']=="")){
        $all_ok = true; //correct validation

        $logged_user_id = $_SESSION['logged_user_id'];           
        $comment = $_POST['comment'];//no validation, in comment user can writes everything

        //amount correctness check
        $amount = $_POST['amount'];
        if((is_numeric($amount) == false) || ($amount < 0.01) || ($amount > 2147483647)){
            $all_ok = false;
            $_SESSION['e_amount'] = "Podaj prawidłową wartość przychodu.";
            header('Location: add-income.php');
        }

        //date correctness check
        $date = $_POST['date'];
        $Date = strtotime($_POST['date']);    
        $timestamp = $Date; 
        $day=date('d',$timestamp);
        $month=date('m',$timestamp);
        $year=date('Y',$timestamp);
        if(!checkdate($month, $day, $year)){
            $all_ok = false;
            $_SESSION['e_date'] = "Wprowadź poprawną datę.";
        }

        //category correctness check
        $incomecat = $_POST['category'];
        if($incomecat==""){
            $all_ok = false;
            $_SESSION['e_incomecat'] = "Wybierz kategorię przychodu.";
        }   

        //tests pass, income added
        if($all_ok == true){

            //query -> get income category id 
            $select_income_category_id = $database->prepare("SELECT id FROM incomes_category_assigned_to_users WHERE name = :incomecat AND user_id = :user_id");
            $select_income_category_id->bindValue(':incomecat', $incomecat, PDO::PARAM_STR);
            $select_income_category_id->bindValue(':user_id', $logged_user_id, PDO::PARAM_INT);
            $select_income_category_id->execute();
            $category_id = $select_income_category_id->fetchColumn();

            
            //query -> add income to database
            $add_income_to_database = $database->prepare("INSERT INTO incomes (id, user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment) VALUES (NULL, :user_id, :category_id, :amount, :date, :comment)");
            $add_income_to_database->bindValue(':user_id', $logged_user_id, PDO::PARAM_INT);
            $add_income_to_database->bindValue(':category_id', $category_id, PDO::PARAM_INT);
            $add_income_to_database->bindValue(':amount', $amount, PDO::PARAM_STR);
            $add_income_to_database->bindValue(':date', $date, PDO::PARAM_STR);
            $add_income_to_database->bindValue(':comment', $comment, PDO::PARAM_STR);
            $add_income_to_database->execute();  


            $_SESSION['income_success'] = "Dodano przychód.";
            header('Location: main-menu.php');
        }       
    }