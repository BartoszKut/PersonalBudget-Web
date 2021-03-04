<?php
    session_start();

    require_once "connect.php"; //this file opens connection with MySQL server


    $connection = @new mysqli($host, $database_user, $database_password, $database_name); //at (@) to CHANGE!!   object of connection


    if($connection->connect_errno != 0){
        echo "Error: ".$connection->connect_errno;
    }

    else {
        $login = $_POST['login']; //take login from MySQL and put it to variable $login
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";   //database querie
        
        if($result = @$connection->query($sql)){  //result of querie
            $how_many_users = $result->num_rows;      
            if($how_many_users > 0){
                //$row = $result->fetch_assoc();    
                unset($_SESSION['error']);            
                $result = free_result();
                header('Location: main-menu.php');
            }  
            else{ 
                $_SESSION['error'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
                header('Location: log-in.php');
            }
        }

        $connection->close(); 
    }
?>