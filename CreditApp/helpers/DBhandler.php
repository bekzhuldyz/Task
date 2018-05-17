<?php 

header('Access-Control-Allow-Origin: *');
header('content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    
    $function = $_POST['function'];
    $con = mysqli_connect('127.0.0.1', 'root', 'root', 'TASK_DB');

    if (mysqli_connect_errno())
    {        
        $answer = array('code' => 1,
                    'message' => 'Connect failed: '. mysqli_connect_error());
        echo json_encode($answer);
    } 
    
    if($function == "searchData")
    {
        $IIN = $_POST['IIN'];
        $userID = $_POST['userID'];

        // search user's Application by IIN
        $sql = "SELECT NumberOfApp, DateOfApp, AmountKZ, Term, Status FROM TASK_DB.Applications where ClientIIN = '$IIN' and userID = $userID"; 
        $result = mysqli_query($con, $sql);

        if(!$result)
        {
            $answer = array('code' => 1,
                        'message' => 'Not queried (INSERT INTO TASK_DB.Clients): '. mysqli_error($con));
            mysqli_close($con);
            echo json_encode($answer);
        }
        else 
        {
            //echo 'number: '. mysqli_num_rows($result);
            if (mysqli_num_rows($result) > 0){
                $search = "";
                while($row = $result->fetch_array())
                {
                    switch($row['Status']) {
                        case "CREATED":
                            $statusApp = "Создано";
                            break;
                        case "CANCELED":
                            $statusApp = "Отменено";
                            break;
                        case "REJECTED":
                            $statusApp = "Отклонено";
                            break;
                        case "CONFIRMED":
                            $statusApp = "Одобрено";
                            break;
                    }

                    $search = $search . "<tr><td>". $row['NumberOfApp'] ."</td>
                            <td>". date("d.m.Y", strtotime($row['DateOfApp'])) ."</td>
                            <td>". $row['AmountKZ'] ."</td>
                            <td>". $row['Term'] ."</td>
                            <td>". $statusApp ."</td></tr>";

                }
                $answer = array('code' => 0,
                        'message' => 'OK',
                        'search' => $search);
                mysqli_close($con);
                echo json_encode($answer);
            }
            else {  
                $answer = array('code' => 2,
                        'message' => 'Not Found');
                mysqli_close($con);
                echo json_encode($answer);
            }

        }
    }
    
    if ($function == "insertUpdateClientData") {
        
        $BirthDay = date("Y-m-d", strtotime($_POST['BirthDay']));
        $IssuedWhen = date("Y-m-d", strtotime($_POST['IssuedWhen']));
        $ValidUntill = date("Y-m-d", strtotime($_POST['ValidUntill']));
        $Salary = !empty($_POST['Salary']) ? $_POST['Salary'] : "NULL"; 
        $ComPaymentsRent = !empty($_POST['ComPaymentsRent']) ? $_POST['ComPaymentsRent'] : "NULL";

        $sql = "INSERT INTO TASK_DB.Clients
        (IIN,
        LastName,
        FirstName,
        MiddleName,
        Telephone,
        BirthDay,
        Gender,
        DocumentNumber,
        IssuedBy,
        IssuedWhen,
        ValidUntill,    
        Salary,
        ComPaymentsRent)
        VALUES
        ('". $_POST['IIN'] ."',
        '". $_POST['LastName'] ."',
        '". $_POST['FirstName'] ."',
        '". $_POST['MiddleName'] ."',
        '". $_POST['Telephone']."',
        '". $BirthDay ."',
        '". $_POST['Gender'] ."',
        '". $_POST['DocumentNumber'] ."',
        '". $_POST['IssuedBy'] ."',
        '". $IssuedWhen."',
        '". $ValidUntill ."',
        ". $Salary .",
        ". $ComPaymentsRent .") ON DUPLICATE KEY UPDATE " .
                "IIN = VALUES(IIN),
                LastName = VALUES(LastName),
                FirstName = VALUES(FirstName),
                MiddleName = VALUES(MiddleName),
                Telephone = VALUES(Telephone),
                BirthDay = VALUES(BirthDay),
                Gender = VALUES(Gender),
                DocumentNumber = VALUES(DocumentNumber),
                IssuedBy = VALUES(IssuedBy),
                IssuedWhen = VALUES(IssuedWhen),
                ValidUntill = VALUES(ValidUntill),
                Salary = VALUES(Salary),
                ComPaymentsRent= VALUES(ComPaymentsRent);";          


        if(!mysqli_query($con, $sql)) {        
            $answer = array('code' => 1,
                        'message' => 'Not queried (INSERT INTO TASK_DB.Clients): '. mysqli_error($con));
            mysqli_close($con);
            echo json_encode($answer);
        }
        else {
            // insert to application                                 
            $sql = "INSERT INTO TASK_DB.Applications
            (UserID,
            ClientIIN,
            NumberOfApp,
            DateOfApp,
            AmountKZ,
            AmountUSD,
            Term,
            Status,
            Rate,
            MonthlyPayments,
            TotalAmount,
            OverPayments)
            VALUES
            ('". $_POST['userID'] ."',
            '". $_POST['IIN'] ."',
            '". $_POST['guid'] ."',
            '". date("Y-m-d") ."',
            NULL,
            NULL,
            NULL,
            '". $_POST['status'] ."',
            NULL,
            NULL,
            NULL,
            NULL) ON DUPLICATE KEY UPDATE ".
                "UserID = VALUES(UserID),
                ClientIIN = VALUES(ClientIIN),
                NumberOfApp = VALUES(NumberOfApp),
                DateOfApp = VALUES(DateOfApp),
                AmountKZ = VALUES(AmountKZ),
                AmountUSD = VALUES(AmountUSD),
                Term = VALUES(Term),
                Status = VALUES(Status),
                Rate = VALUES(Rate),
                MonthlyPayments = VALUES(MonthlyPayments),
                TotalAmount = VALUES(TotalAmount),
                OverPayments = VALUES(OverPayments);";  
            
            if(!mysqli_query($con, $sql)) {        
                $answer = array('code' => 1,
                            'message' => 'Not queried (INSERT INTO TASK_DB.Applications): '. mysqli_error($con));
                mysqli_close($con);
                echo json_encode($answer);
            }
            else {
                $last_appID = $con->insert_id;
                $answer = array('code' => 0,
                            'message' => 'OK',
                            'id' => $last_appID);
                echo json_encode($answer);
            }
            
           
        }       
    }
    
    if ($function == "updateAppData") {
        
        $AmountKZ = !empty($_POST['AmountKZ']) ? $_POST['AmountKZ'] : "NULL"; 
        $AmountUSD = !empty($_POST['AmountUSD']) ? $_POST['AmountUSD'] : "NULL";
        $MonthlyPayments = !empty($_POST['MonthlyPayments']) ? $_POST['MonthlyPayments'] : "NULL"; 
        $TotalAmount = !empty($_POST['TotalAmount']) ? $_POST['TotalAmount'] : "NULL";
        $OverPayments = !empty($_POST['OverPayments']) ? $_POST['OverPayments'] : "NULL";
        
        $sql = "UPDATE TASK_DB.Applications SET ".
                "AmountKZ = ". $AmountKZ .",
                AmountUSD = ". $AmountUSD .",
                Term = '". $_POST['Term']."',
                Status = '". $_POST['status'] ."',
                Rate = '". $_POST['Rate'] ."',
                MonthlyPayments = ". $MonthlyPayments .",
                TotalAmount = ". $TotalAmount .",
                OverPayments = ". $OverPayments ." WHERE id=". $_POST['appID'] .";";
        
        if(!mysqli_query($con, $sql)) {        
            $answer = array('code' => 1,
                        'message' => 'Not queried (UPDATE TASK_DB.Applications): '. mysqli_error($con));
            mysqli_close($con);
            echo json_encode($answer);
        }
        else {
            $answer = array('code' => 0,
                            'message' => 'OK');
            echo json_encode($answer);
        }
    }
}
 



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

