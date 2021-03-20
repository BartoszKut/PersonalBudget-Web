<?php
    session_start();

    if((isset($_SESSION['logged_user_id'])) && ($_SESSION['logged_user_id'] != 0)){ //if user is logged in, redirect to main-menu.php
        header('Location: main-menu.php');
        exit(); //leave file, dont execute rest of code from this file
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>PersonalBudget</title>
	
	<meta name="description" content="Twoje finanse pod pełną kontrolą! PersonalBudget pozwoli w prosty sposób kontrolować Twoje finanse - zoptymalizuje wydatki, zwiększy oszczędności." />
	<meta name="keywords" content="Wydatki, oszczędności, portfel, zarządzanie pieniędzmi, eportfel" />
	
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


	<link href="https://fonts.googleapis.com/css2?family=Karma:wght@400;600&display=swap" rel="stylesheet">	
	<link href="log-in-style.css" rel="stylesheet" type="text/css"/>
	<link href="fontello/css/github.css" rel="stylesheet" type="text/css"/>
	
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
                        <h1>Zaloguj się do swojego konta<br/>PersonalBudget</h1>
                    </div>

                    <form action="log_and_pass_check.php" method="post">
                        
                        <div class="form-group d-flex justify-content-center">
                            <input type="text" class="form-control" name="login" placeholder="login">
                        </div>

                        <div class="form-group d-flex justify-content-center">
                            <input type="password" class="form-control" name="password" placeholder="hasło">
                        </div>
                        
                        <?php ///////////////////////////////////////////////
                            if($_SESSION['bad_attempt'] == true)
                                echo '<p style="text-align: center; color: red;"> Niepoprawny login lub hasło. </>';         
                        ?>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn login-btn text-center"> Zaloguj się</button>
                        </div>

                    </form>

                    <h5 class="d-flex justify-content-center">Nie posiadasz konta? <a href="sign-in.php" class="createAccount"> Zarejestruj się</a></h5>

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