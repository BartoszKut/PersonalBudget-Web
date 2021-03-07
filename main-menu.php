<?php
    session_start();

    if(!isset($_SESSION['loged-in'])){
        header('Location: log-in.php');
        exit();
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
	<link href="main-menu-style.css" rel="stylesheet" type="text/css"/>
	<link href="fontello/css/github.css" rel="stylesheet" type="text/css"/>

</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="mainbg">
                
                <div class="row head"> 
                    <div class="col">           

                        <div class="d-inline-block">
                            <a href="index.php"><img id="logo" src="img/logo.png" width="90" height="90" alt=""/></a>
                        </div>

                        <a href="log-out.php" class="button" style="float: right; margin-top: 20px; margin-right: 20px">Wyloguj się
                        </a>
                    </div>   
                </div> 
                
                <div class="row info">

                    <h3 class="col-6">Twoje przychody w tym miesiącu: </h3>
                    <div id="incomes" class="col-6">pewnie uzyc innerHTML w JS'ie</div>

                    <h3 class="col-6">Twoje wydatki w tym miesiącu: </h3>
                    <div id="incomes" class="col-6">pewnie uzyc innerHTML w JS'ie</div>
                    
                </div> 
                
                <div class="row">
                    
                    <div class="col-12 text-center">
                        <a class="btn optionbtn" href="add-income.html" role="button">Dodaj przychód</a>             
                    </div>

                    <div class="col-12 text-center">
                        <a class="btn optionbtn" href="add-expense.html" role="button">Dodaj wydatek</a>             
                    </div>

                    <div class="col-12 text-center">
                        <a class="btn optionbtn" href="balance.html" role="button">Bilnas</a>             
                    </div>

                    <div class="col-12 text-center">
                        <a class="btn optionbtn" href="settings.html" role="button">Ustawienia</a>             
                    </div>

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