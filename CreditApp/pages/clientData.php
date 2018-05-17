<html>
    <head>
        <title>Данные о клиенте</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../js/jquery.mask.js" type="text/javascript"></script>
        <script src="../js/clientData.js" type="text/javascript"></script>
        
        <style>           
            body {
                background-color: #eee;
            }

            #table {
                max-width: 700px;
                padding: 15px;
                margin: 0 auto;
                background-color: #fff;
                border-radius: 0.3em;
            }

            *[role="form"] h2 {
                margin-left: 5em;
                margin-bottom: 1em;
            }            
        </style>
    </head>
    <body>       

        <div class="container">
            <div id="table" class="mainbox col-sm-12 ">
                <form id="clientForm" class="form-horizontal col-sm-10" role="form" data-toggle="validator" >
                    <h2>Данные о клиенте</h2>
                    <input type="hidden" id="userID" name="userID" value="<?php echo $_GET['userID']?>">
                    <div class="form-group">
                        <label for="iin" class="col-sm-3 control-label">ИИН</label>
                        <div class="col-sm-9">
                            <input type="text" id="IIN" name="IIN" class="form-control" autofocus required> 
                        </div>                       
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="col-sm-3 control-label">Фамилия</label>
                        <div class="col-sm-9">  
                            <input type="text" id="LastName" name="LastName" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstName" class="col-sm-3 control-label">Имя</label>
                        <div class="col-sm-9">
                            <input type="text" id="FirstName" name="FirstName" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="middleName" class="col-sm-3 control-label">Отчество</label>
                        <div class="col-sm-9">
                            <input type="text" id="MiddleName" name="MiddleName" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telephone" class="col-sm-3 control-label">Мобильный телефон</label>
                        <div class="col-sm-9">
                            <input type="tel" id="Telephone" name="Telephone" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthDay" class="col-sm-3 control-label">Дата рождения</label>
                        <div class="col-sm-9">
                            <input type="text" id="BirthDay" name="BirthDay" class="form-control" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="control-label col-sm-3">Пол</label>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input type="radio" id="maleRadio" name="Gender" value="1" required>М
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <label class="radio-inline">
                                        <input type="radio" id="femaleRadio" name="Gender" value="2" required>Ж
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Номер документа</label>
                        <div class="col-sm-9">
                            <input type="text" id="DocumentNumber" name="DocumentNumber" class="form-control" required>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="control-label col-sm-3">Кем выдан</label>
                        <div class="col-sm-9">
                            <input type="text" id="IssuedBy" name="IssuedBy" class="form-control" required>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="birthDay" class="col-sm-3 control-label">Дата выдачи</label>
                        <div class="col-sm-9">
                            <input type="text" id="IssuedWhen" name="IssuedWhen" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthDay" class="col-sm-3 control-label">Действителен до</label>
                        <div class="col-sm-9">
                            <input type="text" id="ValidUntill" name="ValidUntill" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Заработная плата</label>
                        <div class="col-sm-9">
                            <input type="text" id="Salary" name="Salary" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Коммунальные платежи, аренда</label>
                        <div class="col-sm-9">
                            <input type="text" id="ComPaymentsRent" name="ComPaymentsRent" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-3">
                            <button type="button" class="btn btn-danger" id="cancel">Отмена</button>
                    </div>
                    <div class="col-sm-4 col-sm-offset-1">
                            <button type="submit" class="btn btn-primary" name="confirm" id="confirm">Подтвердить</button>
                    </div>
                    </div>
                </form>
            </div>
             <!-- /form -->
        </div> <!-- ./container -->
    </body>
</html>

