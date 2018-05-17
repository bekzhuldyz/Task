
<html>
    <head>
        <title>Поиск</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../js/search.js" type="text/javascript"></script>
        
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
            
            #results {
                max-width: 800px;
                padding: 15px;
                margin: 0 auto;
                background-color: #fff;
                border-radius: 0.3em;
            }
        </style>
    </head>
    <body>       
        <div class="container">
            <div style="margin-top:50px;" class="mainbox col-md-12 "> <!--  col-md-offset-3 col-sm-8 col-sm-offset-2-->                
                <form class="form-horizontal" role="form"> 
                    <!--<div class='alert alert-danger col-md-12'>Connect failed: %s</div>-->
                    <h3>Поиск</h3>
                    <div class="input-group stylish-input-group">
                        <input id="userID" type="hidden" value="<?php echo $_GET['userID'] ?>"> 
                        <input id="IIN" type="text" class="form-control" name="IIN" placeholder="ИИН"> 
                        <span class="input-group-addon" style="background: white !important; ">
                            <button type="button" style="border:0;" name="search" id="search">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>  
                        </span>                        
                    </div>
                </form>                
            </div>
            <div id="results">         
            </div>
            <div class="col-sm-5 col-sm-offset-7" style="padding-top: 30px; padding-bottom: 50px">
                <input type="button" value="Новая заявка" class="btn btn-primary" 
                   onClick="document.location.href='../pages/clientData.php?userID=' + '<?php echo $_GET['userID']?>'" />
            </div>            
        </div>      
    </body>
</html>










