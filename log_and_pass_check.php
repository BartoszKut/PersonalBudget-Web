<?php
    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['password']))){ //user cant entry to this file without set login or password
        header('Location: index.php');
        exit();
    }

    require_once "connect.php"; //this file opens connection with MySQL server
    mysqli_report(MYSQLI_REPORT_STRICT);

    try{
        $connection = new mysqli($host, $database_user, $database_password, $database_name);    
        if($connection->connect_errno != 0){
            throw new Exception(mysqli_connect_errno());
        }
        else {
            $login = $_POST['login']; //take login from MySQL and put it to variable $login
            $password = $_POST['password'];

            $login = htmlentities($login, ENT_QUOITES, "UTF-8");    //this fuction protect us from MySQL querie iniection (attack for our database)
            
            if($result = @$connection->query(sprintf("SELECT * FROM users WHERE user = '%s'", //result of querie  
            mysqli_real_escape_string($connection, $login)))){   //this fuction protect us from MySQL querie iniection (attack for our database)
            
                $how_many_users = $result->num_rows;      
                if($how_many_users > 0){   
                    $row = $result->fetch_assoc();   // association array(take value from MySQL for every column) 

                    if(password_verify($password, $row['password'])){    
                                
                        $_SESSION['loged-in'] = true;                
                        
                        $_SESSION['user_id'] = $row['user_id'];
                        //$_SESSION['name'] = $row['name']; //take value from MySQL from column 'name' and save it in variable $name
                    
                        unset($_SESSION['error']);   
                            
                        $result = free_result();     
                        header('Location: main-menu.php'); 
                    }  
                }   
                else{ 
                    $_SESSION['error'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
                    header('Location: log-in.php');
                }
                 
            }                           
            else{ 
                throw new Exception($connection->error);
            }
            $connection->close();             
        }
    }
    catch(Exception $er){
        echo '<span style="color: red;">Błąd serwera</span>';
    }
?>