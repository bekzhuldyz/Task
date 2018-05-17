<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Главная</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <style>
            body {
                background-color: #eee;
            }

            *[role="form"] {
                max-width: 530px;
                padding: 15px;
                margin: 0 auto;
                background-color: #fff;
                border-radius: 0.3em;
            }
        </style>
    </head>
    <body>
        <div class="container">       
        <div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <div class="panel-title">Вход для пользователя</div>
                </div>     

                <div style="padding-top:30px" class="panel-body" >
                    <?php
                    $con = mysqli_connect('127.0.0.1', 'root', 'root', 'TASK_DB');

                    if(mysqli_connect_errno())
                        {
                            printf("<div class='alert alert-danger col-sm-12'>Connect failed: %s</div>". 
                                    mysqli_connect_error());
                            exit();
                        } 

                    if(isset($_POST['submit']))
                    {
                        $login = $_POST['login'];
                        $pass = $_POST['pass'];

                        $sql = "SELECT ID FROM TASK_DB.Users where LOGIN = '$login' and PASSWORD = md5('$pass')";
                        
                        $result = mysqli_query($con, $sql);

                        if(!$result)
                        {
                            printf("<div class='alert alert-danger col-sm-12'>Not queried</div>");
                            mysqli_close($con);
                            exit();
                        }
                        else 
                        {
                            if(mysqli_num_rows($result) > 0) 
                            {
                                $row = mysqli_fetch_assoc($result);
                                $userID = $row['ID'];
                                
                                mysqli_close($con);
                                header('Location: pages/search.php?userID='. $userID);
                            }
                            else
                            {
                                printf("<div class='alert alert-danger col-sm-12'>Not Found</div>");
                                mysqli_close($con);
                            }  
                        }
                    }
                    
                    ?>
                    
                    <form class="form-horizontal" role="form" data-toggle="validator" action="" method="post">
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login" type="text" class="form-control" name="login" 
                                   value="" placeholder="Логин" required>                                        
                        </div>

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="pass" type="password" class="form-control" name="pass" 
                                   placeholder="Пароль" required>
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                              <button type="submit" class="btn btn-primary" name="submit">Войти</button>
                            </div>
                        </div>  
                    </form>     
                </div>                     
            </div>  
        </div>
      </div>
    </body>
</html>





        





