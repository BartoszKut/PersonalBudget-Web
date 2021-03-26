<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server
    if(!($_POST['amount']=="")){
        $all_ok = true; //correct validation

        $logged_user_id = $_SESSION['logged_user_id'];        
        $comment = $_POST['comment'];//no validation, in comment user can writes everything

        //amount correctness check
        $amount = $_POST['amount'];
        if((is_numeric($amount) == false) || ($amount < 0.01)){
            $all_ok = false;
            $_SESSION['e_amount'] = "Podaj prawidłową wartość przychodu.";
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
        $expensecat = $_POST['expensecat'];
        if($expensecat==""){
            $all_ok = false;
            $_SESSION['e_expensecat'] = "Wybierz kategorię wydatku.";
        }   

        //payment method correctness check
        $paymentmethod = $_POST['paymentmethod'];
        if($paymentmethod==""){
            $all_ok = false;
            $_SESSION['e_paymentmethod'] = "Wybierz sposób płatności.";
        }   

        //tests pass, income added
        if($all_ok == true){
            //query -> get expense category id
            $select_expense_category_id = $database->prepare("SELECT id FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND name = :expensecat");
            $select_expense_category_id->bindValue(':user_id', $logged_user_id, PDO::PARAM_INT);
            $select_expense_category_id->bindValue(':expensecat', $expensecat, PDO::PARAM_INT);
            $select_expense_category_id->execute();
            $category_id = $select_expense_category_id->fetchColumn();


            //query -> get payment method id
            $select_payment_method_id = $database->prepare("SELECT id FROM payment_methods_assigned_to_users WHERE user_id = :user_id AND name = :paymentmethod");
            $select_payment_method_id->bindValue(':user_id', $logged_user_id, PDO::PARAM_INT);
            $select_payment_method_id->bindValue(':paymentmethod', $paymentmethod, PDO::PARAM_STR);
            $payment_id = $select_payment_method_id->fetchColumn();
            echo "Platnosc id dziala <br>";


            //query -> add expense to database
            $add_expense_to_database = $database->prepare("INSERT INTO expenses (id, user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment) VALUES (NULL, :user_id, :category_id, :payment_id, :amount, :date, :comment)");
            echo "query dziala<br>";
            $add_expense_to_database->bindParam(':user_id', $logged_user_id, PDO::PARAM_INT);
            $add_expense_to_database->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $add_expense_to_database->bindParam(':payment_id', $payment_id, PDO::PARAM_INT);
            $add_expense_to_database->bindValue(':amount', $amount, PDO::PARAM_STR);
            $add_expense_to_database->bindValue(':date', $date, PDO::PARAM_STR);
            $add_expense_to_database->bindParam(':comment', $comment, PDO::PARAM_STR);
            $add_expense_to_database->execute();

            
            $_SESSION['expense_success'] = "Dodano wydatek.";
            header('Location: main-menu.php');
        }
    }