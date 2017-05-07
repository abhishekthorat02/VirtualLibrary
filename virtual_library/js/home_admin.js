$(document).ready(function () {

    $(".add_content_manager, .add_author").hide();


});

$(".open_content").click(function () {

    if ($(".add_content_manager").css("display") == "none") {
        $(".add_content_manager").show("slow");


        $("body").animate({
            scrollTop: $(".add_content_manager").offset().top
        }, 1000);
    } else {
        $(".add_content_manager").hide("slow");
    }

});

$(".open_author").click(function () {

    if ($(".add_author").css("display") == "none") {
        $(".add_author").show("slow");


        $("body").animate({
            scrollTop: $(".author").offset().top
        }, 1000);
    } else {
        $(".add_author").hide("slow");
    }


});
$(".ulist").click(function () {

    $.ajax({
        type: "POST",
        url: "../data_files/get_user_list.php",
        dataType: "xml",
        success: function (xml) {


            $(".post-content > div:not('.userlist')").css("display", "none");
            $(".userlist").css("display", "block");
            $(".userlist > ul").empty();
            if($(xml).find("user").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-frown-o'></i> No users</h4>").appendTo(".userlist > ul");
            		return;
            }
            $(xml).find("user").each(function () {

                var name = $(this).find("name").text();
                var id = $(this).find("id").text();
                var dept = $(this).find("dept_name").text();
                var year = $(this).find("year_name").text();
                var email = $(this).find("email").text();
                var blocked = $(this).find("blocked").text();


                var li = jQuery("<li></li>");
                var h4 = jQuery("<h4><i class='fa fa-user'></i> " + name + "</h4>");
                h4.appendTo(li);
                var contentDiv = jQuery("<div></div>", {
                    "class": "content"
                });
                contentDiv.appendTo(li);
                var h5 = jQuery("<h5>Department: " + dept + "</h5><h5>Email: " + email + "</h5><h5>Year: " + year + "</h5>");
                h5.appendTo(contentDiv);


                li.appendTo(".userlist > ul");

                if (blocked == 0) {
                    var blockbutton = jQuery("<button class='block'>Block user</button>").appendTo(li);

                    blockbutton.click(function () {
                        blockbutton.off();
                        block($(this), id);

                    });
                } else {
                    var unblockbutton = jQuery("<button class='block'>Unblock user</button>").appendTo(li);
                    unblockbutton.click(function () {
                        unblockbutton.off();
                        unblock($(this), id);

                    });
                }

                var rejectbutton = jQuery("<button class='block'>Delete user</button>").appendTo(li);

                rejectbutton.click(function () {
                    rejectbutton.off();
                    reject($(this), id);

                });
                var load = jQuery("<img class='loading' src='../images/loader1.gif' style='margin-left:70px;display:none'></img>").appendTo(li);
                jQuery("<div class='hr'></div>").appendTo(li);

            });

        }


    });
});

function block(button, id) {
    $.post("../data_files/block.php", {
        s_id: id
    }, function (data) {
        button.html('Unblock user');
        button.click(function () {
            button.off();
            unblock(button, id);
        });


    });


}

function unblock(button, id) {


    $.post("../data_files/unblock.php", {
        s_id: id
    }, function (data) {
        button.html('Block user');
        button.click(function () {
            button.off();
            block(button, id);
        });




    });


}

$(".user_req").click(function () {

    $.ajax({
        type: "POST",
        url: "../data_files/user_list_request.php",
        dataType: "xml",
        success: function (xml) {


            $(".post-content > div:not('.user_request')").css("display", "none");
            $(".user_request").css("display", "block");
            $(".user_request > ul").empty();
             if($(xml).find("user").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-frown-o'></i> No user requests</h4>").appendTo(".user_request > ul");
            		return;
            }
            $(xml).find("user").each(function () {

                var name = $(this).find("name").text();
                var id = $(this).find("id").text();
                var dept = $(this).find("dept").text();
                var year = $(this).find("year").text();



                var li = jQuery("<li></li>");
                var h4 = jQuery("<h4><i class='fa fa-user'></i> " + name + "</h4>");
                h4.appendTo(li);
                var contentDiv = jQuery("<div></div>", {
                    "class": "content"
                });
                contentDiv.appendTo(li);
                var h5 = jQuery("<h5>Department: " + dept + "</h5></h5><h5>Year: " + year + "</h5>");
                h5.appendTo(contentDiv);


                li.appendTo(".user_request > ul");


                var buttonaccept = jQuery("<button class='block' style='margin-right:10px;'>Accept</button>").appendTo(li);

                buttonaccept.click(function () {
                    accept($(this), id);
                });
                var buttonreject = jQuery("<button class='block'>Reject</button>").appendTo(li);
                buttonreject.click(function () {
                    reject($(this), id);
                });
                var load = jQuery("<img class='loading' src='../images/loader1.gif' style='margin-left:70px;display:none'></img>").appendTo(li);
                jQuery("<div class='hr'></div>").appendTo(li);

            });

        }


    });
});

function accept(button, id) {
    button.parent().find(".loading").css("display", "block");
    button.hide();
    button.next().hide();
    $.post("../data_files/accept_request.php", {
        s_id: id
    }, function (data) {


        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });




    });


}

function reject(button, id) {
    button.parent().find(".loading").css("display", "block");
    button.hide();
    button.parent().find(".block").hide();
    $.post("../data_files/reject_request.php", {
        s_id: id
    }, function (data) {

        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });



    });


}



$(".blocked").click(function () {

    $.ajax({
        type: "POST",
        url: "../data_files/get_blocked_list.php",
        dataType: "xml",
        success: function (xml) {


            $(".post-content > div:not('.blocked_user')").css("display", "none");
            $(".blocked_user").css("display", "block");
            $(".blocked_user > ul").empty();
             if($(xml).find("block").length == 0) {
            		
            		$("<h4 style='margin-left:-12px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No blocked users</h4>").appendTo(".blocked_user > ul");
            		return;
            }
            $(xml).find("block").each(function () {

                var name = $(this).find("name").text();
                var id = $(this).find("id").text();
                var dept = $(this).find("dept").text();
                var year = $(this).find("year").text();
                var email = $(this).find("email").text();


                var li = jQuery("<li></li>");
                var h4 = jQuery("<h4><i class='fa fa-user'></i> " + name + "</h4>");
                h4.appendTo(li);
                var contentDiv = jQuery("<div></div>", {
                    "class": "content"
                });
                contentDiv.appendTo(li);
                var h5 = jQuery("<h5>Department: " + dept + "</h5><h5>Email: " + email + "</h5><h5>Year: " + year + "</h5>");
                h5.appendTo(contentDiv);


                li.appendTo(".blocked_user > ul");


                var buttonunblock = jQuery("<button class='block' style='margin-right:10px;'>Unblock</button>").appendTo(li);

                buttonunblock.click(function () {
                    unblock_user($(this), id);
                });

                jQuery("<div class='hr'></div>").appendTo(li);

            });

        }


    });
});



function unblock_user(button, id) {


    $.post("../data_files/unblock.php", {
        s_id: id
    }, function (data) {

        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });


    });


}
$('.search-input').keyup(function () {
    if ($(".userlist").css("display") == 'block') {
        if ($(this).val().length == 0)
            $(".userlist > ul > li").show();
        else {
            $(".userlist > ul > li").hide();
            $(".userlist > ul > li > h4:contains(" + $(this).val() + ")").parent().show();
        }
    } else if ($(".user_request").css("display") == 'block') {
        if ($(this).val().length == 0)
            $(".user_request > ul > li").show();
        else {
            $(".user_request > ul > li").hide();
            $(".user_request > ul > li > h4:contains(" + $(this).val() + ")").parent().show();
        }
    } else if ($(".blocked_user").css("display") == 'block') {
        if ($(this).val().length == 0)
            $(".blocked_user > ul > li").show();
        else {
            $(".blocked_user > ul > li").hide();
            $(".blocked_user > ul > li > h4:contains(" + $(this).val() + ")").parent().show();
        }


    }

});