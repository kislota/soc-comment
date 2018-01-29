var num = 5;
jQuery(window).scroll(function() {
    var end = jQuery('#end').offset().top;
    if(jQuery(window).scrollTop()+jQuery(window).height()>=jQuery(document).height()){
        $(function () {
                $.ajax({
                    url: "/comment/load",
                    type: "POST",
                    data: {"num": num},
                    cache: false,
                    success: function (response) {
                        if (response != 0) {
                            $("#content").append(response);
                            num = num + 5;
                        }
                    }
                });
        });
    }
});