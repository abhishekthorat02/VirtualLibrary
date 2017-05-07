var qc = 1;

$(".new_question").click(function () {

    var question = $(".quiz .question:first-child").clone();
    question.find(".q_text").attr("name", "question" + qc);
    question.find(".option1").attr("name", "option1" + qc);
    question.find(".option2").attr("name", "option2" + qc);
    question.find(".option3").attr("name", "option3" + qc);
    question.find(".option4").attr("name", "option4" + qc);
    question.find(".qnumber").attr("name", "qnumber" + qc).attr("value", qc);
    question.find(".qanswer").attr("name", "qanswer" + qc);



    question.insertBefore(".quiz > .submit");
    qc++;
    $(".qcount").attr("value", qc);

});

$(".display_course").click(function () {


    $.ajax({
        type: "POST",
        url: "../data_files/get_my_course.php",
        dataType: "xml",
        success: function (xml) {
            $(".post-content > div:not('.my_course')").css("display", "none");
            $(".my_course").css("display", "block");


            $(".my_course").find("ul").empty();
             if($(xml).find("course").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-frown-o'></i> No courses</h4>").appendTo(".my_course > ul");
            		return;
            }
            $(xml).find("course").each(function () {

                var c_name = $(this).find("name").text();
                var id = $(this).find("id").text();
                var count = $(this).find("count").text();
                var approved = $(this).find("approved").text();

                var li = jQuery("<li></li>");
                jQuery("<h4><i class='fa fa-book'></i> " + c_name + "</h4>").appendTo(li);

                var div = jQuery("<div class='course_content'></div>");

                jQuery("<h5>Course ID: " + id + "</h5><h5>Enrolled: " + count + "</h5>").appendTo(div);

                if (approved == 1)
                    jQuery("<h5>Approved: <i style='color:#92d02f' class='fa fa-check-circle'></i></h5>").appendTo(div);
                else
                    jQuery("<h5>Approved: <i style='color:#e61920' class='fa fa-times-circle'></i></h5>").appendTo(div);

                div.appendTo(li);

                var buttonAddSlide = jQuery("<button class='block'>Upload slides</button>").appendTo(li);
                buttonAddSlide.click(function () {
                    course_upload_slide(id, c_name)

                });
                var buttonAddQuiz = jQuery("<button class='block'>Add Quiz</button>").appendTo(li);

                buttonAddQuiz.click(function () {
                    quiz_open(id, c_name);

                });

                var buttonDelete = jQuery("<button class='block'>Delete course</button>").appendTo(li);

                buttonDelete.click(function () {

                    delete_course(buttonDelete, id);

                });

                var buttonShowUpload = jQuery("<button class='block'>Show uploads</button>").appendTo(li);

                buttonShowUpload.click(function () {

                    showUpload(id, c_name);

                });


                li.appendTo(".my_course ul");

                jQuery("<div class='hr'></div>").appendTo(li);

            });
        }
    });


});


$('.search-input').keyup(function () {
    if ($(".my_course").css("display") == 'block') {
        if ($(this).val().length == 0)
            $(".my_course > ul > li").show();
        else {
            $(".my_course > ul > li").hide();
            $(".my_course > ul > li > h4:contains(" + $(this).val() + ")").parent().show();
        }
    }
});
$('.course').click(function () {
    $(".post-content > div:not('.create_course')").css("display", "none");
    $(".create_course").css("display", "block");
});
$('.trending').click(function () {
    $(".post-content > div:not('.posts_trending')").css("display", "none");
    $(".posts_trending").css("display", "block");
});


function course_upload_slide(course_id, course_name) {
    $(".post-content > div:not('.course_upload_slides')").css("display", "none");
    $(".course_upload_slides").css("display", "block");
    $(".course_upload_slides .form-id").attr("value", course_id);
    $(".course_upload_slides h2").text(course_name);

}


function quiz_open(course_id) {

    $(".post-content > div:not('.create_quiz')").css("display", "none");
    $(".create_quiz").css("display", "block");
    $(".create_quiz .qcount").attr("value", "1");
    $(".create_quiz .c_id").attr("value", course_id);
    qc = 1;

}

function delete_course(button, c_id) {

    $.post("../data_files/delete_course.php", {
        course_id: c_id
    }, function (data) {

        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });



    });

}

function showUpload(course_id, course_name) {

    $.ajax({
        type: "POST",
        url: "../data_files/show_course_upload.php",
        dataType: "xml",
        data: {
            id: course_id
        },
        success: function (xml) {
            $(".post-content > div:not('.showUpload')").css("display", "none");
            $(".showUpload").css("display", "block");
            $(".showUpload ul").empty();
         
            $(".showUpload li").css("display", "block");
            $(xml).find("upload").each(function () {
					 var download = $(this).find("download").text();
                var title = $(this).find("title").text();
                var url = $(this).find("filename").text();
                var description = $(this).find("description").text();
                var id = $(this).find('id').text();
                var approved = $(this).find('approved').text();



                var li = jQuery("<li></li>");

                var h4 = jQuery("<h3><i class='fa  fa-tags '></i> " + title + "</h3>").appendTo(li);
                var data = jQuery("<h5><i class='fa fa-file-text-o  '></i> " + description + "</h5>").appendTo(li);
                if (approved == 1)
                    jQuery("<h5>Approved: <i style='color:#92d02f' class='fa fa-check-circle'></i></h5>").appendTo(li);
                else
                    jQuery("<h5>Approved: <i style='color:#e61920' class='fa fa-times-circle'></i></h5>").appendTo(li);
                    
                    
                 $.ajax({
                    type: "HEAD",
                    url: url,
                    success: function (a) {
                var piece = url.split("/");
                        var links = jQuery("<a href='" + url + "' download><i class='fa fa-download '></i> " + piece[piece.length - 1] + "</a><br>").appendTo(li);


                    },
                    error: function (a) {
                var piece = url.split("/");
                        var links = jQuery("<strong style='font-weight: normal; margin-left:20px; color: #5b5b5b; text-decoration: line-through'><i style='color: #333; 'class='fa fa-download'></i> " + piece[piece.length - 1] + " [Link-not available]</strong><br>").appendTo(li);


                    }


                }).always(function(){



var deleteslide = jQuery("<button class='block'>Delete slide</button>").appendTo(li);

                deleteslide.click(function () {
                    deleteslide.off();
                    delete_slide($(this), id);

                });
                var allow_download = jQuery("<button class='block download' style='display:none'>Restrict download</button>").appendTo(li);
                var res_download = jQuery("<button class='block not-download' style='display:none'>Allow download</button>").appendTo(li);
        				if (download == 1) {
        					allow_download.parent().find(".download").show();
                 allow_download.click(function () {
                    allow_download.off();
                    allowdownload($(this), id);

                });
                }
            		if (download == 0)  {
            			allow_download.parent().find(".not-download").show();
                 res_download.click(function () {
                    res_download.off();
                    restrictdownload($(this), id);

                });
            		}
            	                jQuery("<div class='hr'></div>").appendTo(li);


					});
               // var links = jQuery("<a href='" + url + "' download><i class='fa fa-download '></i> " + piece[5] + "</a><br><br>").appendTo(li);
                

					 li.appendTo(".showUpload ul")


            });
        }
    });

}
function allowdownload(button, id) {
		
    $.post("../data_files/restrict_download.php", {
        upload_id: id
    }, function (data) {
			button.html("allow download");
			button.click(function () {
            button.off();
            restrictdownload(button, id);
        	});


    });

}
function restrictdownload(button, id) {
		
    $.post("../data_files/allow_download.php", {
        upload_id: id
    }, function (data) {
			button.html("restrict download");
			 button.click(function () {
            button.off();
            allowdownload(button, id);
        });

    });

}

function delete_slide(button, id) {

    $.post("../data_files/delete_slide.php", {
        upload_id: id
    }, function (data) {

        $(button.parent()).fadeOut("slow", function () {
            button.parent().remove();
        });



    });

}