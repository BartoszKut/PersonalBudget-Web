<?php

    session_start();

    if(isset($_POST['email'])){
        $all_ok = true; //correct validation

        //name correctness check
        $name = $_POST['name'];
        if((strlen($name)<3) || (strlen($name)>20)){ //checking length of string name (3-20)
            $all_ok = false;
            $_SESSION['e_name'] = "Imię musi posiadać od 3 do 20 znaków!";
        }
        if(ctype_alpha($name)==false){
            $all_ok = false;
            $_SESSION['e_name'] = "Imię może składać się tylko z liter! (bez polskich znaków)";
        }


        //surname correctness check
        $surname = $_POST['surname'];
        if((strlen($surname)<3) || (strlen($surname)>20)){ //checking length of string name (3-20)
            $all_ok = false;
            $_SESSION['e_surname'] = "Nazwisko musi posiadać od 3 do 20 znaków!";
        }
        if(ctype_alpha($surname)==false){
            $all_ok = false;
            $_SESSION['e_surname'] = "Nazwisko może składać się tylko z liter! (bez polskich znaków)";
        }


        //login correctness check
        $login = $_POST['login'];
        if((strlen($login)<3) || (strlen($login)>20)){ //checking length of string name (3-20)
            $all_ok = false;
            $_SESSION['e_login'] = "Login musi posiadać od 3 do 20 znaków!";
        }
        if(ctype_alnum($login)==false){
            $all_ok = false;
            $_SESSION['e_login'] = "Login może składać się tylko z liter i cyfr! (bez polskich znaków)";
        }


        //email correctnes check
        $email = $_POST['email'];
        $safe_email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if((filter_var($safe_email, FILTER_VALIDATE_EMAIL)==false) || ($safe_email != $email)){
            $all_ok = false;
            $_SESSION['e_email'] = "Podaj poprawny adres email!";
        }


        //password correctnes check
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        
        if((strlen($password)<6) || (strlen($password)>20)){ 
            $all_ok = false;
            $_SESSION['e_password'] = "Hasło musi posiadać od 6 do 20 znaków!";
        }
        if($password != $password2){ 
            $all_ok = false;
            $_SESSION['e_password'] = "Hasło muszą być identyczne!";
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);


        //captcha
        $secret = "6Le0bHUaAAAAAJXYOiWwQgGuh76ylsCDpNajTj58";
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $answer = json_decode($check);
        if($answer->success == false){
        $all_ok = false;
        $_SESSION['e_captcha'] = "Potwierdź, że nie jestes botem!";
        }


        //connection with MySQL
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT); //kind of errors report, no warnings, just exceptions

        try{
            $connection = new mysqli($host, $database_user, $database_password, $database_name);
            if($connection->connect_errno != 0){
                throw new Exception(mysqli_connect_errno());
            }
            else{
                //check email existing
                $result = $connection->query("SELECT user_id FROM users WHERE email='$email'");
                if(!$result) throw new Exception($connection->error);

                $how_many_emails = $result->num_rows;
                if($how_many_emails > 0){
                    $all_ok = false;
                    $_SESSION['e_email'] = "Istnieje już konto, połączone z tym adresem e-mail!";
                    }
                

                //check login existing
                $result2 = $connection->query("SELECT user_id FROM users WHERE login='$login'");
                if(!$result2) throw new Exception($connection->error);

                $how_many_logins = $result2->num_rows;
                if($how_many_logins > 0){
                    $all_ok = false;
                    $_SESSION['e_login'] = "Istnieje już konto o takim loginie!";
                    }

                //tests pass, client added
                if($all_ok == true){  
                    if($connection->query("INSERT INTO users VALUES(NULL, '$name', '$surname', '$login', '$email', '$password_hash')")){
                        $_SESSION['success_account_create'] = true;
                        header('Location: welcome.php');
                    }
                    else{
                        throw new Exception($connection->error);
                    }
                }                

                $connection->close();
            }
        } 
        catch(Exception $er){
            echo '<span style="color: red;">Błąd serwera</span>';
            echo '<br/>Informacja developerska: '.$er;
        }
    }



?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>PersonalBudget-zarejestruj się</title>
	
	<meta name="description" content="Twoje finanse pod pełną kontrolą! PersonalBudget pozwoli w prosty sposób kontrolować Twoje finanse - zoptymalizuje wydatki, zwiększy oszczędności." />
	<meta name="keywords" content="Wydatki, oszczędności, portfel, zarządzanie pieniędzmi, eportfel" />
	
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


	<link href="https://fonts.googleapis.com/css2?family=Karma:wght@400;600&display=swap" rel="stylesheet">	
	<link href="sign-in-style.css" rel="stylesheet" type="text/css"/>
	<link href="fontello/css/github.css" rel="stylesheet" type="text/css"/>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style type="text/css">
        <?php 
            include "sign-in-style.css";  
        ?>
    </style>

</head>

<body>
    <main>
        <div class="container-fluid">
            
            <div class="row">                   

                <div class="col mainbg">

                    <div class="d-inline-block">
                        <a href="index.php"><img id="logo" src="img/logo.png" width="90" height="90" alt=""/></a>
                    </div>

                    <div class="col title">
                        <h1>Aby załoyć konto,<br/>uzupełnij ponisze dane.</h1>
                    </div>

                    <form method="post"> <!-- no action argument means that the same file will process the code-->
                        
                        <div class="form-group d-flex justify-content-center">
                            <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="Imię">
                        </div>
                        <?php
                            if(isset($_SESSION['e_name'])){
                                echo '<div class="error d-flex justify-content-center">'.$_SESSION['e_name'].'</div>';
                                unset($_SESSION['e_name']);
                            }
                        ?>

                        <div class="form-group d-flex justify-content-center">
                            <input type="text" class="form-control" name="surname" aria-describedby="surname" placeholder="Nazwisko">
                        </div>
                        <?php
                            if(isset($_SESSION['e_surname'])){
                                echo '<div class="error d-flex justify-content-center">'.$_SESSION['e_surname'].'</div>';
                                unset($_SESSION['e_surname']);
                            }
                        ?>

                        <div class="form-group d-flex justify-content-center">
                            <input type="text" class="form-control" name="login" aria-describedby="login" placeholder="Login">
                        </div>
                        <?php
                            if(isset($_SESSION['e_login'])){
                                echo '<div class="error d-flex justify-content-center">'.$_SESSION['e_login'].'</div>';
                                unset($_SESSION['e_login']);
                            }
                        ?>

                        <div class="form-group d-flex justify-content-center">
                            <input type="email" class="form-control" name="email" aria-describedby="email" placeholder="Email">
                        </div>
                        <?php
                            if(isset($_SESSION['e_email'])){
                                echo '<div class="error d-flex justify-content-center">'.$_SESSION['e_email'].'</div>';
                                unset($_SESSION['e_email']);
                            }
                        ?>

                        <div class="form-group d-flex justify-content-center">
                            <input type="password" class="form-control" name="password" placeholder="Hasło">
                        </div>

                        <div class="form-group d-flex justify-content-center">
                            <input type="password" class="form-control" name="password2" placeholder="Powtórz hasło">
                        </div>
                        <?php
                            if(isset($_SESSION['e_password'])){
                                echo '<div class="error d-flex justify-content-center">'.$_SESSION['e_password'].'</div>';
                                unset($_SESSION['e_password']);
                            }
                        ?>

                        <div class="g-recaptcha form-group d-flex justify-content-center mt-4" data-sitekey="6Le0bHUaAAAAAOF8S6DRasrN7CcM24COB_rUQbGU"></div>
                        <?php
                            if(isset($_SESSION['e_captcha'])){
                                echo '<div class="error d-flex justify-content-center">'.$_SESSION['e_captcha'].'</div>';
                                unset($_SESSION['e_captcha']);
                            }
                        ?>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn login-btn text-center mt-4"> Zarejestruj się</button>
                        </div>

                    </form>

                    <h5 class="d-flex justify-content-center">Posiadasz konto? <a href="log-in.html" class="createAccount"> Zaloguj się</a></h5>

                </div>
            </div>
        </div>

    </main>

    <footer>        

            <div class="row foot-cont">                           

                <a href="https://www.linkedin.com/in/bartosz-kut-0aa1a3167/" class="col-12 col-sm-8 col-md-5 col-lg-4 linkedin mx-auto mt-4 li">            
                    <i class="icon-linkedin-squared icon"><h6>https://bit.ly/37G6duy</h6></i>                                     
                </a>
                
                <a href="https://github.com/BartoszKut" class="col-12 col-sm-8 col-md-5 col-lg-4 mx-auto mt-4 gh">              
                    <i class="icon-github-circled icon"><h6>github.com/BartoszKut</h6></i>
                </a>   

                <div class="col-12 col-sm-8 col-md-5 col-lg-4 mx-auto mt-4 ct">  
                    <i class="icon-mail-alt icon"><h6>@: bartosz.kut93@gmail.com<br/>m: +48 792 722 230</h6></i>                    
                </div>               
            </div>
        
	</footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
	<script src="../../bootstrap-5.0.0-beta2-dist/js/bootstrap.min.js"></script>

</body>
</html>