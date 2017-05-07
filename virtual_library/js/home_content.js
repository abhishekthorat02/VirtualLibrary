

$(".course-request-show").click(function () {



    $.ajax({
        type: "POST",
        url: "../data_files/course_request.php",
        dataType: "xml",
        success: function (xml) {


            $(".post-content > div:not('.course_request_show_div')").css("display", "none");
            $(".course_request_show_div").css("display", "block");

            $(".course_request_show_div > ul").empty();
            
 if($(xml).find("courselist").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No course requests</h4>").appendTo(".course_request_show_div > ul");
            		return;
            }

            $(xml).find("courselist").each(function () {

                var name = $(this).find("title").text();
                var id = $(this).find("id").text();
                var desc = $(this).find("description").text();
                var dept = $(this).find("dept_name").text();
                var aname = $(this).find("aname").text();
                var year = $(this).find("year").text();



                var li = jQuery("<li></li>");
                var h4 = jQuery("<h4><i class='fa fa-book'></i> " + name + "</h4>");
                h4.appendTo(li);
                var contentDiv = jQuery("<div></div>", {
                    "class": "content"
                });
                contentDiv.appendTo(li);
                var p = jQuery("<p>" + desc + "</p>").appendTo(contentDiv);
                var h5 = jQuery("<h5><i class='fa fa-user'></i> Author: " + aname + "</h5><h5><i class='fa fa-building-o'></i> Department: " + dept + "</h5></h5><h5><i class='fa fa-magic'></i> Year: " + year + "</h5>");
                h5.appendTo(contentDiv);


                li.appendTo(".course_request_show_div > ul");


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
    $.post("../data_files/accept_course_request.php", {
        c_id: id
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
    $.post("../data_files/reject_course_request.php", {
        c_id: id
    }, function (data) {

        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });



    });


}



$(".course-accepted-show").click(function () {



    $.ajax({
        type: "POST",
        url: "../data_files/get_accepted_course.php",
        dataType: "xml",
        success: function (xml) {


            $(".post-content > div:not('.course_accepted_show_div')").css("display", "none");
            $(".course_accepted_show_div").css("display", "block");
            $(".course_accepted_show_div > ul").empty();
             if($(xml).find("courselist").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No accepted courses</h4>").appendTo(".course_accepted_show_div > ul");
            		return;
            }

            $(xml).find("courselist").each(function () {

                var name = $(this).find("title").text();
                var id = $(this).find("id").text();
                var desc = $(this).find("description").text();
                var dept = $(this).find("dept_name").text();
                var aname = $(this).find("aname").text();
                var year = $(this).find("year").text();
				

                var li = jQuery("<li></li>");
                var h4 = jQuery("<h4><i class='fa fa-book'></i> " + name + "</h4>");
                h4.appendTo(li);
                var contentDiv = jQuery("<div></div>", {
                    "class": "content"
                });
                contentDiv.appendTo(li);
                var p = jQuery("<p>" + desc + "</p>").appendTo(contentDiv);
                var h5 = jQuery("<h5><i class='fa fa-user'></i> Author: " + aname + "</h5><h5><i class='fa fa-building-o'></i> Department: " + dept + "</h5></h5><h5><i class='fa fa-magic'></i> Year: " + year + "</h5>");
                h5.appendTo(contentDiv);


                li.appendTo(".course_accepted_show_div > ul");

                var buttonshow = jQuery("<button class='block' style='margin-right:10px;'>Show uploads</button>").appendTo(li);

                buttonshow.click(function () {
                    show_uploads($(this), id, name);

                });

                jQuery("<div class='hr'></div>").appendTo(li);


            });
        }
    });


});

function show_uploads(button, id, name) {



    $.ajax({
        type: "POST",
        url: "../data_files/get_accepted_course_upload.php",
        data: {
            course_id: id
        },
        dataType: "xml",
        success: function (xml) {

            $(".post-content > div:not('.course_uploads_show_div')").css("display", "none");
            $(".course_uploads_show_div").css("display", "block");
            $(".course_uploads_show_div > ul").empty();
            $(".course_uploads_show_div > h2").text(name);
            
             if($(xml).find("upload").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No uploads</h4>").appendTo(".course_upload_show_div > ul");
            		return;
            }

            $(xml).find("upload").each(function () {

                var title = $(this).find("title").text();
                var url = $(this).find("filename").text();
                
                var description = $(this).find("description").text();
                var id = $(this).find('id').text();
                var li = jQuery("<li></li>");

                var h4 = jQuery("<h3><i class='fa  fa-tags '></i> " + title + "</h3>").appendTo(li);
                var data = jQuery("<h5><i class='fa fa-file-text-o  '></i> " + description + "</h5>").appendTo(li);
                
                
                $.ajax({
                    type: "HEAD",
                    url: url,
                    success: function (a) {
								piece = url.split("/");
                        var links = jQuery("<a href='" + url + "' download><i class='fa fa-download '></i> " + piece[piece.length - 1] + "</a><br>").appendTo(li);


                    },
                    error: function (a) {
								piece = url.split("/");
                        var links = jQuery("<strong style='font-weight: normal; margin-left:20px; color: #5b5b5b; text-decoration: line-through'><i style='color: #333; 'class='fa fa-download'></i> " + piece[piece.length - 1] + " [Link-not available]</strong><br>").appendTo(li);


                    }


                }).always(function () {


var buttonaccept = jQuery("<button class='block' style='margin-right:10px;'>Accept</button>").appendTo(li);

                buttonaccept.click(function () {
                    accept_uploads($(this), id);

                });

                var buttonreject = jQuery("<button class='block' style='margin-right:10px;'>Reject</button>").appendTo(li);

                buttonreject.click(function () {
                    reject_uploads($(this), id, url);

                });

                var load = jQuery("<img class='loading' src='../images/loader1.gif' style='margin-left:70px;display:none'></img>").appendTo(li);


                jQuery("<div class='hr'></div>").appendTo(li);




					});

             //   var links = jQuery("<a href='" + url + "' download><i class='fa fa-download '></i> " + piece[5] + "</a><br><br>").appendTo(li);

                

					li.appendTo(".course_uploads_show_div > ul");



            });
        }
    });


}

function accept_uploads(button, id) {
    button.parent().find(".loading").css("display", "block");
    button.hide();
    button.next().hide();
    $.post("../data_files/accept_course_upload.php", {
        upload_id: id
    }, function (data) {


        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });




    });


}

function reject_uploads(button, id, file_name) {
    button.parent().find(".loading").css("display", "block");
    button.hide();
    button.parent().find(".block").hide();
    $.post("../data_files/reject_course_upload.php", {
        upload_id: id,
        file_name: file_name
    }, function (data) {

        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });



    });


}

$(".reseach-paper-request").click(function () {


    $.ajax({
        type: "POST",
        url: "../data_files/research_paper_request.php",
        dataType: "xml",
        success: function (xml) {
            $(".post-content > div:not('.research_request_show_div')").css("display", "none");
            $(".research_request_show_div").css("display", "block");
            $(".research_request_show_div ul").empty();
            
             if($(xml).find("paper").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No paper uploads</h4>").appendTo(".research_request_show_div > ul");
            		return;
            }

            $(xml).find("paper").each(function () {
                var id = $(this).find("id").text();
                var title = $(this).find("title").text();
                var description = $(this).find("description").text();
                var username = $(this).find("username").text();
                var link = $(this).find("link").text();
                var li = jQuery("<li></li>");




                jQuery("<h3><i class='fa fa-star'></i> Title: " + title + "</h3><p><i class='fa fa-user'></i> " + username + "</p><p><i class='fa fa-file-text-o'></i> " + description + "</p>").appendTo(li);
              //  var links = jQuery("<a href='" + link + "' download><i class='fa fa-download '></i> " + piece[5] + "</a><br><br>").appendTo(li);


					$.ajax({
                    type: "HEAD",
                    url: link,
                    success: function (a) {
                var piece = link.split("/");
                        var links = jQuery("<a href='" + link + "' download><i class='fa fa-download '></i> " + piece[piece.length - 1] + "</a><br><br>").appendTo(li);


                    },
                    error: function (a) {
                var piece = link.split("/");
                        var links = jQuery("<strong style='font-weight: normal; margin-left:20px; color: #5b5b5b; text-decoration: line-through'><i style='color: #333; 'class='fa fa-download'></i> " + piece[piece.length - 1] + " [Link-not available]</strong><br><br>").appendTo(li);


                    }


                }).always(function () {
                
                  var buttonaccept = jQuery("<button class='block' style='margin-right:10px;'>Accept</button>").appendTo(li);

                buttonaccept.click(function () {
                    accept_paper($(this), id);
                });
                var buttonreject = jQuery("<button class='block'>Reject</button>").appendTo(li);
                buttonreject.click(function () {
                    reject_paper($(this), id);
                });

                jQuery("<div class='hr'></div>").appendTo(li);
                
                
                
                });

                li.appendTo(".research_request_show_div ul");

              

            });
        }
    });

});


function accept_paper(button, id) {
    button.parent().find(".loading").css("display", "block");
    button.hide();
    button.next().hide();
    $.post("../data_files/accept_paper_request.php", {
        c_id: id
    }, function (data) {


        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });




    });


}

function reject_paper(button, id) {
    button.parent().find(".loading").css("display", "block");
    button.hide();
    button.parent().find(".block").hide();
    $.post("../data_files/reject_paper_request.php", {
        c_id: id
    }, function (data) {

        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });



    });


}
$(".spam-show").click(function () {

    $.ajax({
        type: "POST",
        url: "../data_files/spam_show.php",
        dataType: "xml",
        success: function (xml) {


            $(".post-content > div:not('.spam_request_show_div')").css("display", "none");
            $(".spam_request_show_div").css("display", "block");

            $(".spam_request_show_div > ul").empty();
            
             if($(xml).find("spam").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No spams</h4>").appendTo(".spam_request_show_div > ul");
            		return;
            }

            $(xml).find("spam").each(function () {

                var name = $(this).find("title").text();
                var course_id = $(this).find("course_id").text();
                var upload_id = $(this).find("upload_id").text();
                var desc = $(this).find("description").text();
                var username = $(this).find("username").text();
       			 var course_name = $(this).find("course_name").text();
       			 var link = $(this).find("link").text();

					 var author_name =  $(this).find("author_name").text();

                var li = jQuery("<li></li>");
                var h4 = jQuery("<h3><i class='fa fa-book'></i> " + course_name + "</h3>");
                h4.appendTo(li);
                var contentDiv = jQuery("<div></div>", {
                    "class": "content"
                });
                contentDiv.appendTo(li);
                var p = jQuery("<h4><i class='fa fa-list'></i> " + name + "</h4>").appendTo(contentDiv);
                var h5 = jQuery("<h5><i class='fa fa-user'></i> Author: " + author_name + "</h5><h5><i class='fa fa-building-o'></i> description: " + desc + "</h5></h5><h5><i class='fa fa-magic'></i> Spamed by: " + username + "</h5>");
                h5.appendTo(contentDiv);
                      $.ajax({
                    type: "HEAD",
                    url: link,
                    success: function (a) {
					 var piece = link.split("/");
                        var links = jQuery("<a href='" + link + "' download><i class='fa fa-download '></i> " + piece[piece.length - 1] + "</a><br><br>").appendTo(contentDiv);
                     	
								   
                    },
                    error: function (a) {
					 var piece = link.split("/");
                        var links = jQuery("<strong style='font-weight: normal; margin-left:30px;font-size:15px; color:red; text-decoration: line-through'><i style='color: #333; 'class='fa fa-download'></i> " + piece[piece.length - 1] + " [Link-not available]</strong><br><br>").appendTo(contentDiv);
                        

                    }
							

                }).always(function(){


 var buttonaccept = jQuery("<button class='block' style='margin-right:10px;'>Accept</button>").appendTo(li);

                buttonaccept.click(function () {
                    accept_spam($(this), upload_id);
                });
					  var buttonreject = jQuery("<button class='block'>Reject</button>").appendTo(li);
                buttonreject.click(function () {
                    reject_spam($(this), upload_id);
                });
                 var load = jQuery("<img class='loading' src='../images/loader1.gif' style='margin-left:70px;display:none'></img>").appendTo(li);
					 jQuery("<div class='hr'></div>").appendTo(li);




					});
               
                li.appendTo(".spam_request_show_div > ul");


             
              

            });

        }


    });

});

function accept_spam(button, upload_id) {
    button.parent().find(".loading").css("display", "block");
    button.hide();
    button.next().hide();
    $.post("../data_files/accept_spam_request.php", {
        u_id: upload_id
    }, function (data) {

        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });




    });


}

function reject_spam(button, upload_id) {
    $.post("../data_files/reject_spam_request.php", {
        u_id: upload_id
    }, function (data) {

        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });



    });


}