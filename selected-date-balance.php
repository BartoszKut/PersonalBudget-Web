<?php

    session_start();

    require_once "db_php_connection.php"; //this file opens connection with MySQL server

    if((isset($_POST['first_date'])) && (isset($_POST['second_date']))){

        $logged_user_id = $_SESSION['logged_user_id'];  
        $first_date = $_POST['first_date'];
        $second_date = $_POST['second_date'];


        // I N C O M E S

        $sql_balance_incomes = "SELECT category_incomes.name as Category, SUM(incomes.amount) as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id = :id_user AND incomes.date_of_income >= :first_date AND incomes.date_of_income <= :second_date GROUP BY Category ORDER BY Amount DESC";

        $query_select_incomes_sum = $database->prepare($sql_balance_incomes);
        $query_select_incomes_sum->bindValue(':id_user', $logged_user_id, PDO::PARAM_INT);
        $query_select_incomes_sum->bindValue(':first_date', $first_date, PDO::PARAM_STR);
        $query_select_incomes_sum->bindValue(':second_date', $second_date, PDO::PARAM_STR);
        $query_select_incomes_sum->execute();

        $result_sum_of_incomes = $query_select_incomes_sum->fetchAll();
                  
            /*foreach($result_sum_of_incomes as $month_incomes) {
                $sql_incomes_details = "SELECT incomes.date_of_income as Date, incomes.income_comment as Comment, incomes.amount as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND incomes.date_of_income >= :first_date AND incomes.date_of_income <= :second_date AND category_incomes.name = :category_name ORDER BY Date";
                $query_select_incomes_details = $database->prepare($sql_incomes_details);
                $query_select_incomes_details->bindValue(':id_user', $logged_user_id, PDO::PARAM_INT);
                $query_select_incomes_details->bindValue(':first_date', $first_date, PDO::PARAM_STR);
                $query_select_incomes_details->bindValue(':second_date', $second_date, PDO::PARAM_STR);  
                $query_select_incomes_details->bindValue(':category_name', $month_incomes[0], PDO::PARAM_INT);   
                $query_select_incomes_details->execute();

                $result_details_of_incomes = $query_select_incomes_details->fetchAll();

                echo '<div class="card-header">'.$month_incomes[0].': '.$month_incomes[1].'zł'.'</div>';
                foreach($result_details_of_incomes as $incomes_details) {
                    echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$incomes_details[0].' - '.$incomes_details[1].': '.$incomes_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>';   
                }             
            }*/

        $all_incomes_sum = "SELECT SUM(amount) FROM incomes WHERE user_id = :logged_user_id AND incomes.date_of_income >= :first_date AND incomes.date_of_income <= :second_date";
        $sum_of_incomes = $database->prepare($all_incomes_sum);
        $sum_of_incomes->bindValue(':logged_user_id', $logged_user_id, PDO::PARAM_INT);
        $sum_of_incomes->bindValue(':first_date', $first_date, PDO::PARAM_STR);
        $sum_of_incomes->bindValue(':second_date', $second_date, PDO::PARAM_STR);  
        $sum_of_incomes->execute();
        $incomes_sum = $sum_of_incomes->fetchColumn();

        
        // E X P E N S E S
        
        $sql_balance_expenses = "SELECT category_expenses.name as category, SUM(expenses.amount) as amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id = :id_user AND expenses.date_of_expense >= :first_date AND expenses.date_of_expense <= :second_date GROUP BY category ORDER BY amount DESC";

        $query_select_expenses_sum = $database->prepare($sql_balance_expenses);
        $query_select_expenses_sum->bindValue(':id_user', $logged_user_id, PDO::PARAM_INT);
        $query_select_expenses_sum->bindValue(':first_date', $first_date, PDO::PARAM_STR);
        $query_select_expenses_sum->bindValue(':second_date', $second_date, PDO::PARAM_STR);
        $query_select_expenses_sum->execute();

        $result_sum_of_expenses = $query_select_expenses_sum->fetchAll();
                    
            /*foreach($result_sum_of_expenses as $month_expenses) {
                $sql_expenses_details = "SELECT expenses.date_of_expense as date, expenses.expense_comment as comment, expenses.amount as amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND expenses.date_of_expense >= :first_date AND expenses.date_of_expense <= :second_date AND category_expenses.name = :category_name ORDER BY date";
                $query_select_expenses_details = $database->prepare($sql_expenses_details);
                $query_select_expenses_details->bindValue(':id_user', $logged_user_id, PDO::PARAM_INT);
                $query_select_expenses_details->bindValue(':first_date', $first_date, PDO::PARAM_STR);
                $query_select_expenses_details->bindValue(':second_date', $second_date, PDO::PARAM_STR);   
                $query_select_expenses_details->bindValue(':category_name', $month_expenses[0], PDO::PARAM_INT);   
                $query_select_expenses_details->execute();

                $result_details_of_expenses = $query_select_expenses_details->fetchAll();

                echo '<div class="card-header">'.$month_expenses[0].': '.$month_expenses[1].'zł'.'</div>';
                foreach($result_details_of_expenses as $expenses_details) {
                    echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$expenses_details[0].' - '.$expenses_details[1].': '.$expenses_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>';   
                }             
            } */

        $all_expenses_sum = "SELECT SUM(amount) FROM expenses WHERE user_id = :logged_user_id AND expenses.date_of_expense >= :first_date AND expenses.date_of_expense <= :second_date";
        $sum_of_expenses = $database->prepare($all_expenses_sum);
        $sum_of_expenses->bindValue(':logged_user_id', $logged_user_id, PDO::PARAM_INT);
        $sum_of_expenses->bindValue(':first_date', $first_date, PDO::PARAM_STR);
        $sum_of_expenses->bindValue(':second_date', $second_date, PDO::PARAM_STR); 
        $sum_of_expenses->execute();
        $expenses_sum = $sum_of_expenses->fetchColumn();
    }


    // S A V E or N O

    $balance = $incomes_sum - $expenses_sum;
    if($balance > 0) $information = "Zaoszczędziłeś ".$balance." zł";
    else if($balance < 0){
        $balance = abs($incomes_sum - $expenses_sum);
        $information = "Twoje wydatki były o ".$balance." zł większe niż przychody";
    } 
    else if($balance == 0) $information = "Twoje wydatki były równe Twoim przychodom";
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>

	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Balans</title>
	
	<meta name="description" content="Twoje finanse pod pełną kontrolą! PersonalBudget pozwoli w prosty sposób kontrolować Twoje finanse - zoptymalizuje wydatki, zwiększy oszczędności." />
	<meta name="keywords" content="Wydatki, oszczędności, portfel, zarządzanie pieniędzmi, eportfel" />
	
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


	<link href="https://fonts.googleapis.com/css2?family=Karma:wght@400;600&display=swap" rel="stylesheet">	
	<link href="balance-style.css" rel="stylesheet" type="text/css"/>
	<link href="fontello/css/github.css" rel="stylesheet" type="text/css"/>

    <script src="add-expense.js"></script>

    <style type="text/css">
        <?php 
            include "balance-style.css";  
        ?>
    </style>
	
</head>

<body>
    <main>
        <div class="container-fluid">

            <div class="mainbg">
            
                <div class="row head"> 
                    <div class="col">           

                        <div class="d-inline-block">
                            <a href="main-menu.php" class="btn mmbtn" role="button">Menu główne</a>
                        </div>

                        <a href="index.html" class="button" style="float: right; margin-top: 20px; margin-right: 20px">Wyloguj się</a>
                    </div>   
                </div> 

                <div class="row">
                    <div class="col-12 col-md-4 col-xl-3 align-middle">
                        <div class="row"><a class="btn optionbtn" href="balance.php" role="button">Bilans aktualnego miesiąca</a></div>
                        <div class="row"><a class="btn optionbtn" href="last-month-balance.php" role="button">Bilans poprzedniego miesiąca</a></div>
                        <div class="row"><a class="btn optionbtn" href="select-date-balance.php" role="button">Bilans - wprowadź daty</a></div>
                    </div>
                    <div class="col-12 col-md-8 col-xl-9">
                        <div class="row">
                            <div class="balanceTitle">
                                <h1>Bilans:   <?php echo $first_date."  -  ".$second_date?></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                            <div class="columnTitle"><h3>Twoje przychody: <?php echo $incomes_sum." zł" ?></h3></div>
                                <?php
                                    foreach($result_sum_of_incomes as $month_incomes) {
                                        $sql_incomes_details = "SELECT incomes.date_of_income as Date, incomes.income_comment as Comment, incomes.amount as Amount FROM incomes INNER JOIN incomes_category_assigned_to_users as category_incomes WHERE incomes.income_category_assigned_to_user_id = category_incomes.id AND incomes.user_id= :id_user AND incomes.date_of_income >= :first_date AND incomes.date_of_income <= :second_date AND category_incomes.name = :category_name ORDER BY Date";
                                        $query_select_incomes_details = $database->prepare($sql_incomes_details);
                                        $query_select_incomes_details->bindValue(':id_user', $logged_user_id, PDO::PARAM_INT);
                                        $query_select_incomes_details->bindValue(':first_date', $first_date, PDO::PARAM_STR);
                                        $query_select_incomes_details->bindValue(':second_date', $second_date, PDO::PARAM_STR);  
                                        $query_select_incomes_details->bindValue(':category_name', $month_incomes[0], PDO::PARAM_INT);   
                                        $query_select_incomes_details->execute();
                        
                                        $result_details_of_incomes = $query_select_incomes_details->fetchAll();
                        
                                        echo '<div class="card-header">'.$month_incomes[0].': '.$month_incomes[1].'zł'.'</div>';
                                        foreach($result_details_of_incomes as $incomes_details) {
                                            echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$incomes_details[0].' - '.$incomes_details[1].': '.$incomes_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>';   
                                        }             
                                    } 
                                ?>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="columnTitle"><h3>Twoje wydatki: <?php echo $expenses_sum." zł" ?></h3></div>
                                <?php
                                    foreach($result_sum_of_expenses as $month_expenses) {
                                        $sql_expenses_details = "SELECT expenses.date_of_expense as date, expenses.expense_comment as comment, expenses.amount as amount FROM expenses INNER JOIN expenses_category_assigned_to_users as category_expenses WHERE expenses.expense_category_assigned_to_user_id = category_expenses.id AND expenses.user_id= :id_user AND expenses.date_of_expense >= :first_date AND expenses.date_of_expense <= :second_date AND category_expenses.name = :category_name ORDER BY date";
                                        $query_select_expenses_details = $database->prepare($sql_expenses_details);
                                        $query_select_expenses_details->bindValue(':id_user', $logged_user_id, PDO::PARAM_INT);
                                        $query_select_expenses_details->bindValue(':first_date', $first_date, PDO::PARAM_STR);
                                        $query_select_expenses_details->bindValue(':second_date', $second_date, PDO::PARAM_STR);   
                                        $query_select_expenses_details->bindValue(':category_name', $month_expenses[0], PDO::PARAM_INT);   
                                        $query_select_expenses_details->execute();
                        
                                        $result_details_of_expenses = $query_select_expenses_details->fetchAll();
                        
                                        echo '<div class="card-header">'.$month_expenses[0].': '.$month_expenses[1].'zł'.'</div>';
                                        foreach($result_details_of_expenses as $expenses_details) {
                                            echo '<ul class="list-group list-group-flush"><li class="list-group-item"><i class="fas fa-long-arrow-alt-right"></i>'.' '.$expenses_details[0].' - '.$expenses_details[1].': '.$expenses_details[2].'zł '.'<i class="fas fa-edit"></i><i class="fas fa-trash-alt ml-1"></i> </li></ul>';   
                                        }             
                                    } 
                                ?> 
                            </div>
                        </div>
                        <div class="row information">
                            <h3><?php echo $information ?></h3>
                        </div>
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