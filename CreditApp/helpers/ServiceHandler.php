<?php
    header('Access-Control-Allow-Origin: *');
    header('content-type: application/json; charset=utf-8');
    header("Access-Control-Allow-Headers: X-Requested-With");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $function = $_POST['function'];
        
        if ($function == 'getExchangeRates') {
            $xml = simplexml_load_file('http://www.nationalbank.kz/rss/rates_all.xml');
            foreach($xml->channel->item as $child)
            {
                if ($child->title == "USD") {
                    $advert = array('USD' => (string) $child->description);
                    echo json_encode($advert);
                }
            }
        }
        
        if ($function == 'checkIIN') { 

            $iin = $_POST['IIN'];
            $birthDay = $_POST['birthDay'];
            $gender = $_POST['gender'];
            
            $url ="http://localhost:8080/Service/webresources/rest/". $iin ."/". $birthDay. "/". $gender;
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $result = curl_exec($curl);
            
            echo $result;
            curl_close($curl); 
        }
        
        if ($function == 'checkApp') { 

            $salary = $_POST['salary'];
            $term = $_POST['term'];
            $rate = $_POST['rate'];
            $expense = $_POST['expense'];
            $monthlyPayments = $_POST['monthlyPayments'];
            $amount = $_POST['amount'];
            
            $url ="http://localhost:8080/Service/webresources/rest/". $salary ."/". $term. "/". $rate ."/". $expense ."/". $monthlyPayments. "/". $amount;
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $result = curl_exec($curl);
            
            echo $result;
            curl_close($curl); 
        }
    }
?>