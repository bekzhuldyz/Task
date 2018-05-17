$(document).ready(function() {
    var userID = $("#userID").val();

    $("#search").click(function(e) {
        e.preventDefault();                   
        var iin = $("#IIN").val();

        if (iin != "") {
            var reg = new RegExp('^[0-9]{12}$');
            if (!reg.test(iin)) {
                    alert("Допускается числа длинною 12 цифр");
                    $("#IIN").val("");
                    return;
            }
        }
        else {
            alert("Введите ИИН!");
            return;
        }

        $.ajax({
            url : '../helpers/DBhandler.php', 
            type : 'POST',
            data: 'function=searchData&IIN=' + iin + '&userID=' + userID,
            dataType : 'json',
            success: function(result) {
                if(result['code'] == 0) {
                    var table = "<table  class='table table-striped'>" + 
                                "<thead>" +
                                "<tr>" +
                                "<th>Номер заявки</th>" +
                                "<th>Дата обращения</th>" +
                                "<th>Сумма</th>" +
                                "<th>Срок</th>" +
                                "<th>Статус</th>" +
                                "</tr>" +
                                "</thead>" +
                                "<tbody>" + 
                                result['search'] +
                                "</tbody>" +
                                "</table>"; 
                        $("#results").html(table);
                }
                else if(result['code'] == 2) {
                    window.location.href = '../pages/clientData.php?userID=' + userID;
                }
                else {
                    alert("Ошибка: " + result['message']);
                    return;
                }
            },
            error: function(jqXHR, exception) {
                    alert("Status: " + jqXHR.status + "\nException: " + exception);
                    return;
            }
        });

    });

});


