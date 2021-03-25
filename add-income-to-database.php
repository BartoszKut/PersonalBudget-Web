<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    if(!($_POST['amount']=="")){
        $all_ok = true; //correct validation

        $logged_user_id = $_SESSION['logged_user_id'];
        $amount = $_POST['amount']; 
        $date = $_POST['date'];
        $incomecat = $_POST['category'];
        $comment = $_POST['comment'];

        $add_income_to_database = $database->prepare("INSERT INTO incomes (id, user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment) VALUES (NULL, :user_id, (SELECT id FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND name = :incomecat), :amount, :date, :comment)");

        $add_income_to_database->bindParam(':user_id', $logged_user_id, PDO::PARAM_INT);
        echo $logged_user_id."<br/><br/>"; 
        $add_income_to_database->bindParam(':incomecat', $incomecat, PDO::PARAM_STR);
        echo $incomecat."<br/><br/>";
        $add_income_to_database->bindValue(':amount', $amount);
        echo "$amount<br/><br/>";
        $add_income_to_database->bindValue(':date', $date);
        echo $date."<br/><br/>";
        $add_income_to_database->bindParam(':comment', $comment, PDO::PARAM_STR);
        echo $comment."<br/><br/>";

        $add_income_to_database->execute();
        echo "<br/>powinien wykonac"; 

        header('Location: main-menu.php');
    }