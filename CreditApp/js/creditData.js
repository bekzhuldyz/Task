$(document).ready(function() {
    var userID = $("#userID").val();
    var salary = $("#salary").val();
    var expense = $("#expense").val();
    var url = "", data = "", status = "";

    $('#AmountKZ, #Term, #Rate').change(function(e){
        if (e.target.id == "AmountKZ") {
            var AmountKZ = $("#AmountKZ").val();
            var reg = new RegExp(/^[+]?\d+(\.\d+)?$/);
            if (!reg.test(AmountKZ)) {
                alert("Допускается позитивные числа с плавающей точкой 999.99");
                e.target.value = "";
                return;
        }
        else {
                $.ajax({
                    //url : 'https://bekzhuldyz.000webhostapp.com/handler.php', // connect to NB RK
                    url : '../helpers/ServiceHandler.php', // connect to NB RK
                    type : 'POST',
                    data: 'function=getExchangeRates',
                    dataType : 'json',
                    success: function(result) {
                            var currentUSD = parseFloat(result['USD']);
                            var AmountKZnum = parseFloat($("#AmountKZ").val()) / currentUSD;
                            $("#AmountUSD").val(AmountKZnum.toFixed(2));
                    },
                    error: function(jqXHR, exception) {
                            alert("Status: " + jqXHR.status + "\nException: " + exception);
                            return;
                    }
                });					
            }
        }

        if ($("#AmountKZ").val() != "" && $("#Term").val() != "" && $("#Rate").val() != "") {
                var AmountKZnum = parseFloat($("#AmountKZ").val());
                var TermNum = parseFloat($("#Term").val());
                var RateNum = parseFloat($("#Rate").val()) / 100;
                var Precent = RateNum / 12; // delete to 12 months
                var MonthlyPayments = AmountKZnum * (Precent +  (Precent / (Math.pow((Precent + 1), TermNum) - 1)));
                var TotalAmount = MonthlyPayments * TermNum;
                var OverPayments = TotalAmount - AmountKZnum;

                $("#MonthlyPayments").val(MonthlyPayments.toFixed(2));
                $("#TotalAmount").val(TotalAmount.toFixed(2));
                $("#OverPayments").val(OverPayments.toFixed(2));
        }
    });

    $("#cancel").click(function(e){
        e.preventDefault();

        url = '../helpers/DBhandler.php';
        data = 'function=updateAppData&status=CANCELED&'+ $("#creditForm").serialize();
        ajaxCall(url, data, cancelSuccess);
    });

    $("#creditForm").submit(function(e) {
        e.preventDefault();
        var status = "";

        // check App
        url = '../helpers/ServiceHandler.php';
        data = 'function=checkApp&salary=' + salary + '&term=' + $("#Term").val() + "&rate=" + $("#Rate").val() +
                    "&expense=" + expense + "&monthlyPayments=" + $("#MonthlyPayments").val() + "&amount=" + $("#AmountKZ").val();
        ajaxCall(url, data, checkAppSuccess);
    });

    function ajaxCall(url, data, successFunction){
        $.ajax({
            url : url, 
            type : 'POST',
            data: data,
            dataType : 'json',
            success: function(result) {
                successFunction(result);
            },
            error: function(jqXHR, exception) {
                    alert("Status: " + jqXHR.status + "\nException: " + exception);
                    return;
            }
        });
    }

    function submitSuccess (result) {
        if(result['code'] != 0) {
            alert("Ошибка: " + result['message']);
            return;
        }
        else {
            window.location.href = "../pages/statusApp.php?userID=" + userID + "&status=" + status;
        }
    }

    function checkAppSuccess(result) {
        status = result['Message'];
        
        // Add to DB
        url = '../helpers/DBhandler.php';
        data = 'function=updateAppData&status=' + status + '&'+ $("#creditForm").serialize();
        ajaxCall(url, data, submitSuccess);
    }

    function cancelSuccess(result) {
        if(result['code'] != 0) {
            alert("Ошибка: " + result['message']);
            return;
        }
        else {
            window.location.href = "../pages/search.php?userID=" + userID;
        }
    }   
});