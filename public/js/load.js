$(document).ready(function () {
    $("#imgLoad").hide();
});
var num = 5;
$(function () {
    $("#load div").click(function () {
        $("#imgLoad").show();
        $.ajax({
            url: "/comment/load",
            type: "POST",
            data: {"num": num},
            cache: false,
            success: function (response) {
                if (response == 0) {
                    alert("Больше нет комментариев");
                    $("#imgLoad").hide();
                } else {
                    $("#content").append(response);
                    num = num + 5;
                    $("#imgLoad").hide();
                }
            }
        });
    });
});