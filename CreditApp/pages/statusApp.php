<html>
    <head>
        <title>Статус</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="jumbotron" style="text-align: center">
            <h1 class="display-3">Ваша заявка 
                <?php
                if($_GET["status"] == "CONFIRMED") {
                    echo "одобрена!"; 
                }                   
                else {
                    echo "отказана!";
                } 
                    ?></h1>
            <hr>
            <p class="lead">
              <a class="btn btn-primary btn-sm" href="../pages/search.php?userID=<?php echo $_GET["userID"]?>"   role="button">Вернуться на главную</a>
            </p>
          </div>
    </body>
</html>

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

