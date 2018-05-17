$(document).ready(function() {
    var userID = $("#userID").val();
    var url = "", data = "";

    $('#Telephone').mask('(999)999-9999');
    $('#BirthDay').mask('99.99.9999');
    $('#IssuedWhen').mask('99.99.9999');
    $('#ValidUntill').mask('99.99.9999');

    var guid = createGUID();

    var mobileCodes = [ '700',
                        '701',
                        '702',
                        '705',
                        '707',
                        '708',
                        '771',
                        '775',
                        '776',
                        '777',
                        '778'];

    $("#IIN").change(function(e){
        if (e.target.value != "") {
            var reg = new RegExp('^[0-9]{12}$');
            if (!reg.test(e.target.value)) {
                    alert("Допускается числа длинною 12 цифр");
                    e.target.value = "";
                    return;
            }
        }
    });

    $("#LastName, #FirstName, #MiddleName").change(function(e){
            if(e.target.value != "") {
                    var reg = new RegExp('[а-яА-Я ]+');
                    if (!reg.test(e.target.value)) {
                            alert("Допускается только русские буквы");
                            e.target.value = "";
                            return;
                    }
            }
    });

    $("#Telephone").change(function(e){
            if (e.target.value != "") {
                    if ($("#Telephone").val().length != 13) {
                            alert("Введите корректный формат мобильного телефона (000)000-0000");
                            e.target.value = "";
                            return;
                    }
                    else {
                            var mobileVal = $("#Telephone").val().substring(1, 4);
                            var index = $.inArray(mobileVal, mobileCodes);
                            if (index < 0) {
                                    alert("Мобильный код оператора нет в РК");
                                    e.target.value = "";
                                    return;
                            }
                    }
            }
    });

    $("#BirthDay, #IssuedWhen, #ValidUntill").change(function(e){
        if (e.target.value != "") {
            var today = new Date();
            today.setHours(0,0,0,0);
            if(!parseDTE(e.target.value)) {
                alert("Введите корректный формат даты 00.00.0000");
                e.target.value = "";
                return;
            }
        }
    });

    $("#maleRadio").change(function(){
        $("#femaleRadio").prop("checked", false);
    });

    $("#femaleRadio").change(function(){
        $("#maleRadio").prop("checked", false);
    });

    $("#DocumentNumber").change(function(e){
            if (e.target.value != "") {
                    var reg = new RegExp('^[0-9]{9}$');
                    if (!reg.test(e.target.value)) {
                            alert("Допускается числа длинною 9 цифр");
                            e.target.value = "";
                            return;
                    }
            }
    });

    $("#Salary, #ComPaymentsRent").change(function(e){
            if(e.target.value != "") {
                    var reg = new RegExp(/^[+]?\d+(\.\d+)?$/);
                    if (!reg.test(e.target.value)) {
                            alert("Допускается числа с палавающей точкой 0.00");
                            e.target.value = "";
                            return;
                    }
            }
    });

    $("#cancel").click(function(e){
        e.preventDefault();

        if ($("#IIN").val() == "") {                       
            alert("Введите ИИН!");
            return;
        }

        var form = $("#clientForm").serialize();
        if(form.indexOf('Gender') < 0) { // Gender does'nt exist if it is not picked
            form = form + '&Gender=';
        }

        // Cancel app in db
        url = '../helpers/DBhandler.php';
        data = 'function=insertUpdateClientData&guid=' + guid + '&status=CANCELED&'+ form;
        ajaxCall(url, data, cancelSuccess);
    });

    $("#clientForm").submit(function(e) {
        e.preventDefault();

        // check IIN
        url = '../helpers/ServiceHandler.php';
        data = 'function=checkIIN&IIN=' + $("#IIN").val() + '&birthDay=' + $("#BirthDay").val() + '&gender=' + $("input[name=Gender]:checked").val();
        ajaxCall(url, data, checkIINSuccess);                             
    });

    function parseDTE(text){
        var comp = text.split('.');
        var d = parseInt(comp[0], 10);
        var m = parseInt(comp[1], 10);
        var y = parseInt(comp[2], 10);
        var date = new Date(y,m-1,d);
        if (date.getFullYear() == y && date.getMonth() + 1 == m && date.getDate() == d) {
          return true;
        } else {
          return false;
        }
    }

    function createGUID() {
        function s4() {
          return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
        }
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
      }

    function ajaxCall(url, data, succesFunction) {
        $.ajax({
            url : url, 
            type : 'POST',
            data: data,
            dataType : 'json',
            success: function(result) {
                succesFunction(result);
            },
            error: function(jqXHR, exception) {
                    alert("Status: " + jqXHR.status + "\nException: " + exception);
                    return;
            }
        }); 
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

    function checkIINSuccess(result) {
        if(result['Result'] != true) {
            alert("Ошибка: " + result['Message']);
            return;
        }
        else {
            // Add data to DB
            url = '../helpers/DBhandler.php';
            data = 'function=insertUpdateClientData&guid=' + guid + '&status=CREATED&'+ $("#clientForm").serialize();
            ajaxCall(url, data, submitSuccess);
        }
    }

    function submitSuccess(result) {
        if(result['code'] != 0) {
            alert("Ошибка: " + result['message']);
            return;
        }
        else {
            window.location.href = "../pages/creditData.php?appID=" +
                    result['id'] + "&userID=" + userID + "&salary=" + $("#Salary").val() +
                    "&expense=" + $("#ComPaymentsRent").val();
        }
    }
});

