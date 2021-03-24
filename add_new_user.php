<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    if(!(($_POST['name']=="") || ($_POST['surname']=="") || ($_POST['login']=="") || ($_POST['email'] =="") || ($_POST['password']=="") || ($_POST['password2']==""))){
        $all_ok = true; //correct validation

        //name correctness check
        $name = $_POST['name'];
        if((strlen($name) < 3) || (strlen($name) > 20)){ //checking length of string name (3-20)
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
            $_SESSION['e_password'] = "Hasła muszą być identyczne!";
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
  

        //check email existing
        $newUserQuery = $database->prepare('SELECT user_id FROM users WHERE email = :email');
        $newUserQuery -> bindValue(':email', $email, PDO::PARAM_STR);
        $newUserQuery->execute(); 

        $how_many_emails = $newUserQuery->rowCount();
        if($how_many_emails > 0){
            $all_ok = false;
            $_SESSION['e_email'] = "Istnieje już konto, połączone z tym adresem e-mail!";
            }        

        //check login existing
        $newUserQuery2 = $database->prepare('SELECT user_id FROM users WHERE login = :login');
        $newUserQuery2 -> bindValue(':login', $login, PDO::PARAM_STR);
        $newUserQuery2->execute();       


        $how_many_logins = $newUserQuery2->rowCount();
        if($how_many_logins > 0){
            $all_ok = false;
            $_SESSION['e_login'] = "Istnieje już konto o takim loginie!";
            }


        if($all_ok == true){  
            //tests pass, client added
            $addNewUserQuery = $database->prepare("INSERT INTO users VALUES (NULL, :name, :surname, :login, :email, :password)");
            $addNewUserQuery->bindValue(':name', $name, PDO::PARAM_STR);
            $addNewUserQuery->bindValue(':surname', $surname, PDO::PARAM_STR);
            $addNewUserQuery->bindValue(':login', $login, PDO::PARAM_STR);
            $addNewUserQuery->bindValue(':email', $email, PDO::PARAM_STR);
            $addNewUserQuery->bindValue(':password', $password_hash, PDO::PARAM_STR);  
            $addNewUserQuery->execute(); 


            //add categories of incomes and expenses to asigned_to_user
            $assign_incomes_categories = $database->prepare("INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT users.user_id, incomes_category_default.name FROM users, incomes_category_default WHERE users.login= :login");
            $assign_incomes_categories->bindValue(':login', $login, PDO::PARAM_STR);
            $assign_incomes_categories->execute();
            

            $assign_expenses_categories = $database->prepare("INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT users.user_id, expenses_category_default.name FROM users, expenses_category_default WHERE users.login= :login");
            $assign_expenses_categories->bindValue(':login', $login, PDO::PARAM_STR);
            $assign_expenses_categories->execute();


            //add categories of payment method to asigned_to_user
            $assign_payment_method = $database->prepare("INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT users.user_id, payment_methods_default.name FROM users, payment_methods_default WHERE users.login= :login");
            $assign_payment_method->bindValue(':login', $login, PDO::PARAM_STR);
            $assign_payment_method->execute();

            
            $_SESSION['success_account_create'] = true;
            header('Location: welcome.php');            
        }                
    }
    else {
        $_SESSION['e_empty'] = "Uzupełnij wszystkie powysze pola!";
        header('Location: sign-in.php');
   }

   ?>