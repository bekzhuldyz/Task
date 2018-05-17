<!DOCTYPE html>
<html>
<head>
  <title>Данные о кредите</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  <script src="../js/creditData.js" type="text/javascript"></script>
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
	*[role="form"] h2 {
		margin-left: 5em;
		margin-bottom: 1em;
	}
</style>
</head>
<body>
    <?php
    // get terms options
    $con = mysqli_connect('127.0.0.1', 'root', 'root', 'TASK_DB');
    $error = '';
    $options = '<option></option>';

    if(mysqli_connect_errno())
    {
        $error = "<div class='alert alert-danger col-md-12'>Connect failed: %s</div>". mysqli_connect_error();
        mysqli_close($con);
        exit();
    }
    
    $query = "SELECT * FROM TASK_DB.Terms";
    $result = mysqli_query($con, $query);

    if(!$result)
    {
        $error = "<div class='alert alert-danger col-md-12'>Not queried: ". mysqli_error($con) ."</div>";
        mysqli_close($con);
        exit();
    }
    else {
        while($row = mysqli_fetch_assoc($result)) {
            $name = $row['Name'];
            $options = $options. '<option>' . $name . '</option>';
        }
         mysqli_close($con);
    }   
      
    ?> 
	<div class="container">
		<form id="creditForm" class="form-horizontal" role="form" data-toggle="validator">
                    <?php echo $error;?>
                    <h2>Данные о кредите</h2>
                    <input type="hidden" name="appID" id="appID"  value="<?php echo $_GET['appID'];?>">
                    <input type="hidden" name="userID" id="userID"  value="<?php echo $_GET['userID'];?>">
                    <input type="hidden" name="salary" id="salary"  value="<?php echo $_GET['salary'];?>">
                    <input type="hidden" name="expense" id="expense"  value="<?php echo $_GET['expense'];?>">
                    <div class="form-group">
                            <label for="amountKZ" class="col-sm-3 control-label">Сумма в тг.</label>
                            <div class="col-sm-9">
                                    <input type="text" id="AmountKZ" name="AmountKZ" class="form-control"
                                    required autofocus>
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="term" class="col-sm-3 control-label">Срок в мес.</label>
                            <div class="col-sm-9">
                                    <select id="Term" name="Term" class="form-control" required>
                                        <?php echo $options;?>
                                    </select>
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="rate" class="col-sm-3 control-label">Ставка в %</label>
                            <div class="col-sm-9">
                                    <select id="Rate" name="Rate" class="form-control" required>
                                            <option selected></option>
                                            <option>9</option>
                                            <option>10</option>
                                            <option>11</option>
                                    </select>
                            </div>
                    </div>
                    <hr>
                    <div class="form-group">
                            <label for="monthlyPayments" class="col-sm-3 control-label">Еж. платеж</label>
                            <div class="col-sm-9">
                                    <input type="text" id="MonthlyPayments" name="MonthlyPayments" class="form-control" readonly>
                            </div>
                    </div>
                    <div class="form-group">
                            <label for="amountUSD" class="col-sm-3 control-label">Сумма в $</label>
                            <div class="col-sm-9">
                                    <input type="text" id="AmountUSD" name="AmountUSD" class="form-control" readonly>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="control-label col-sm-3">Общая сумма выплат</label>
                            <div class="col-sm-9">
                                    <input type="text" id="TotalAmount" name="TotalAmount" class="form-control" readonly>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="control-label col-sm-3">Переплата</label>
                            <div class="col-sm-9">
                                    <input type="text" id="OverPayments" name="OverPayments" class="form-control" readonly>
                            </div>
                    </div>
                    <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-3">
                                <button type="button" class="btn btn-danger" name="cancel" id="cancel">Отмена</button>
                            </div>
                            <div class="col-sm-4 col-sm-offset-1">
                                <button type="submit" class="btn btn-primary" name="confirm" id="confirm">Подтвердить</button>
                            </div>
                    </div>
            </form>
	</div> 
</body>
</html>
