<?php
    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['password']))){ //user cant entry to this file without set login or password
        header('Location: index.php');
        exit();
    }

    require_once "connect.php"; //this file opens connection with MySQL server


    $connection = @new mysqli($host, $database_user, $database_password, $database_name); //at (@) to CHANGE!!   object of connection


    if($connection->connect_errno != 0){
        echo "Error: ".$connection->connect_errno;
    }

    else {
        $login = $_POST['login']; //take login from MySQL and put it to variable $login
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOITES, "UTF-8");    //this fuction protect us from MySQL querie iniection (attack for our database)
        $password = htmlentities($password, ENT_QUOITES, "UTF-8");

        $sql = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";   //database querie
        
        if($result = @$connection->query(sprintf("SELECT * FROM users WHERE login = '%s' AND password = '$%s'", //result of querie  
        mysqli_real_escape_string($connection, $login),  //this fuction protect us from MySQL querie iniection (attack for our database)
        mysqli_real_escape_string($connection, $password)))){  
            $how_many_users = $result->num_rows;      
            if($how_many_users > 0){   
                $_SESSION['loged-in'] = true;
                
                $row = $result->fetch_assoc();   // association array(take value from MySQL for every column) 
                $_SESSION['user_id'] = $row['user_id'];
                //$_SESSION['name'] = $row['name']; //take value from MySQL from column 'name' and save it in variable $name
                unset($_SESSION['error']);   
                header('Location: main-menu.php'); //must be above cleaning result     
                $result = free_result();                  
            }  
            else{ 
                $_SESSION['error'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
                header('Location: log-in.php');
            }
        }

        $connection->close(); 
    }
?>