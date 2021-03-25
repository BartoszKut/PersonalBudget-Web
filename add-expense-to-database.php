<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    if(!($_POST['amount']=="")){
        $all_ok = true; //correct validation

        $logged_user_id = $_SESSION['logged_user_id'];
        $amount = $_POST['amount']; 
        $date = $_POST['date'];
        $paymentmethod = $_POST['paymentmethod'];
        $expensecat = $_POST['expensecat'];
        $comment = $_POST['comment'];
       

        $add_expense_to_database = $database->prepare("INSERT INTO expenses (user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment) VALUES (:user_id, (SELECT id FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND name = :expensecat), (SELECT id FROM payment_methods_assigned_to_users WHERE user_id = :user_id AND name = :paymentmethod), :amount, :date, :comment)");


        $add_expense_to_database->bindParam(':user_id', $logged_user_id, PDO::PARAM_INT);
        echo $logged_user_id."<br/><br/>"; 
        $add_expense_to_database->bindParam(':expensecat', $expensecat, PDO::PARAM_STR);
        echo $expensecat."<br/><br/>";
        $add_expense_to_database->bindParam(':paymentmethod', $paymentmethod, PDO::PARAM_STR);
        echo "$paymentmethod<br/><br/>";
        $add_expense_to_database->bindValue(':amount', $amount);
        echo "$amount<br/><br/>";
        $add_expense_to_database->bindValue(':date', $date);
        echo $date."<br/><br/>";
        $add_expense_to_database->bindParam(':comment', $comment, PDO::PARAM_STR);
        echo $comment."<br/><br/>";

        $add_expense_to_database->execute();
        echo "<br/>powinien wykonac"; 

        header('Location: main-menu.php');
    }
