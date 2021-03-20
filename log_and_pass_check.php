<?php
    session_start();  
    
    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    if((!isset($_POST['login'])) || (!isset($_POST['password']))){ //user can't entry to this file without set login or password
        header('Location: index.php');
        exit();
    }      
   
    //$login = filter_input(INPUT_POST, 'login'); //take login from user and put it to variable $login
    //$password = filter_input(INPUT_POST, 'password');

    $login = $_POST['login'];
    $password = $_POST['password'];

    $userQuery = $database -> prepare('SELECT user_id, password FROM users WHERE login = :login');
    $userQuery -> bindValue(':login', $login, PDO::PARAM_STR);
    $userQuery -> execute();

    $user = $userQuery -> fetch();

    if($user && password_verify($password, $user['password'])){
        $_SESSION['logged_user_id'] = $user['user_id'];       
        unset($_SESSION['bad_attempt']);
        header('Location: main-menu.php');
    }else{
        $_SESSION['bad_attempt'] = true;
        header('Location: log-in.php');
        exit();      
    }

?>