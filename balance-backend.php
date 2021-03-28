<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    $begining_date = $_POST['begining_date'];
    $end_date = $_POST['end_date'];

    $get_incomes_by_date = $database->prepare("SELECT * FROM incomes WHERE date_of_income > :beginingDate AND date_of_income < :endDate");
    $get_incomes_by_date->bindValue(':beginingDate', $begining_date, PDO::PARAM_STR);
    $get_incomes_by_date->bindValue(':endDate', $end_date, PDO::PARAM_STR);
    $get_incomes_by_date->execute();