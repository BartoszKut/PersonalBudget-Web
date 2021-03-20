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
	<link href="add-income-style.css" rel="stylesheet" type="text/css"/>
	<link href="fontello/css/github.css" rel="stylesheet" type="text/css"/>

    <script src="add-expense.js"></script>
	
</head>

<body onload="setDate()">
    <main>
        <div class="container-fluid">

            <div class="mainbg">
            
                <div class="row head"> 
                    <div class="col">           

                        <div class="d-inline-block">
                            <a href="main-menu.html" class="btn mmbtn" role="button">Menu główne</a>
                        </div>

                        <a href="index.html" class="button" style="float: right; margin-top: 20px; margin-right: 20px">Wyloguj się
                        </a>
                    </div>   
                </div> 

                <div class="col title">
                    <h1>Nowy przychód </h1>
                </div>

                <form method="post">

                    <div class="form-group row">
                        <label for="value" class="col-5 col-form-label"><h5>Kwota</h5></label>
                        <div class="col-7" >
                            <input type="number" step="0.01" min="0" required></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="date" class="col-5 col-form-label"><h5>Data</h5></label>
                        <div class="col-7" >
                            <input type="date" id="theDate" required></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="paymentmethod" class="col-5 col-form-label"><h5>Kategoria</h5></label>
                        <div class="col-7" >
                            <select id="paymentmethod">
                                <option>Wypłata</option>
                                <option>Najem</option>
                                <option>Praca dodatkowa</option>
                                <option>Inne</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="comment" class="col-5 col-form-label"><h5>Komentarz (opcjonalnie)</h5></label>
                        <div class="col-7" >
                            <textarea name="comment" id="comment" rows="1"></textarea>
                        </div>
                    </div>

                    <div class="form-group row addExpense">
                        <div class="col d-flex justify-content-center">
                            <button type="submit" class="btn sbmbtn">Dodaj</button>
                        </div>
                    </div>
            
                </form>	

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