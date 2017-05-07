$(document).ready(function () {

    $(".menu-column").css("overflow-y", "hidden");
    $(".show-news").trigger("click");
});

$(".menu-column").hover(function () {

    $(".menu-column").css("overflow-y", "scroll");

}, function () {

    $(".menu-column").css("overflow-y", "hidden");

});
var timesClicked = 0;
$("#search").bind("click", function (event) {
    $("#search").css("-webkit-transition", "all 0.5s linear");
    $("#search").css("background-color", "#d3d3d3");
    $(".search-input").css("opacity", "1.0");
    timesClicked++;
    if (timesClicked == 2) {
        $("#search").css("-webkit-transition", "all 0.5s linear");
        $("#search").css("background-color", "transparent");
        $(".search-input").css("opacity", "0.0");
        timesClicked = 0;
    }

});


function smooth() {

    $('html, body').animate({
        scrollTop: 0
    }, 1000);
    $(".post-content > div:not('.news')").css("display", "none");
    $(".news").css("display", "block");

}

function toCourse() {

    $('.menu-column').animate({
        scrollTop: $(".course-container").offset().top
    }, 1000);
}

function toStats() {

    $('.menu-column').animate({
        scrollTop: $(".statistics-container").offset().top
    }, 1000);

}

var post_id = "latest";

$(".show-news").click(function () {

    
    post_id = "latest";
     $.ajax({
        type: "GET",
        data: {id: post_id},
        url: "../data_files/get_all_post.php",
        dataType: "xml",
        success: function (xml) {
        	
        	$(".post-content > div:not('.news')").css("display", "none");
   	   $(".news").css("display", "block");
   	   $(".news").empty();
   	   
         $(".news").append("<h2>Latest News</h2>");
         
         post_id = $(xml).find("last_id").text();
            
         if($(xml).find("post").length == 0) {
            		
          		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-frown-o'></i> No latest news</h4>").appendTo(".tile-course");
           		return;
         }
     
     		$(xml).find("post").each(function () {


				post_id = $(this).find("id").text();

				var title = $(this).find("title").text();
				var content = $(this).find("content").text();
				var youlink = $(this).find("youlink").text().split('=');
				youlink = youlink[youlink.length-1];
			
				var attach = $(this).find("attach").text();
				var tags = $(this).find("tags").text();
				var postby = $(this).find("postby").text();
				


				var div = jQuery("<div></div>", {"class": "post"});
				
				jQuery("<h3 style='color:#54ab82;'><i class='fa fa-star'></i> " + title + " -<span style='color:gray;font-size:20px;'> by " + postby + "</span></h3>").appendTo(div);
				

				
				$.ajax({
					type: "HEAD",
					url: attach,
				
					success: function () {
									piece = attach.split("/");
						jQuery("<a href='" + attach + "' download><i class='fa fa-download' style='color:skyblue'></i>  " + piece[piece.length - 1] + "</a><br>").appendTo(div);					
					
					},
					error: function () {
									piece = attach.split("/");
                  jQuery("<strong style='font-family: copseFont; font-size: 17px; font-weight: normal; color: #5b5b5b; text-decoration: line-through'><i style='color:#4a75b5; 'class='fa fa-download' ></i>  " + piece[piece.length - 1] + " [Link-not available]</strong><br>").appendTo(div);
						
					}
				
				
				}).always(function () {
				
					
										
				if(youlink.length > 0 ) {
				
				jQuery("<iframe width='100%' height='360' src='//www.youtube.com/embed/"
				 + youlink + "?feature=player_detailpage' frameborder='0' allowfullscreen></iframe>").appendTo(div);
				
				}
					
				jQuery("<p style='color:#333;font-size:20px;font-family:copsefont'><i class='fa fa-file-text-o'></i> " + content + "</p>").appendTo(div);
				jQuery("<h4 ><i class='fa fa-tags' style='color:#c6393c'></i> [" + tags +"]</h4><br>").appendTo(div);
                        jQuery("<div class='hr'></div>").appendTo(div);
				

				});

				div.appendTo(".news");
				
				
			
			
			});
        
        
        }
 	});

});


$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
   	
   	if(post_id == -1) {
   		   	 $(".news > h4:last-child").remove();
   		jQuery("<h4 style='margin-top: 10px; font-weight: 600; text-align: center'>No more posts</h4>").appendTo(".news");
   	
   			return;
   	}
   	 $(".news > img:last-child").remove();
   	 $(".news > h4:last-child").remove();
   	
   	 var load_img = jQuery("<img></img>", {"src": "../images/loader1.gif", "style": 'margin:0 45%;'}).appendTo(".news");
      
       $.ajax({
        type: "GET",
        data: {id: post_id},
        url: "../data_files/get_all_post.php",
        dataType: "xml",
        success: function (xml) {
        
				if ($(xml).find("post").length == 0) {
				
					load_img.remove();
					post_id = -1;
					jQuery("<h4 style='margin-top: 10px; font-weight: 600; text-align: center'>No more posts</h4>").appendTo(".news");
					return;
				
				} else {
					load_img.remove();
				}
			
				$(xml).find("post").each(function () {

				post_id = $(this).find("id").text();
				var title = $(this).find("title").text();
				var content = $(this).find("content").text();
				var youlink = $(this).find("youlink").text();
				var attach = $(this).find("attach").text();
				var tags = $(this).find("tags").text();
				var postby = $(this).find("postby").text();
				


				var div = jQuery("<div></div>", {"class": "post"});
				
				jQuery("<h3 style='color:#54ab82;'>" + title + " by<span style='color:#333;font-size:15px;'> " + postby + "</span></h3>").appendTo(div);
				

				
				$.ajax({
					type: "HEAD",
					url: attach,
				
					success: function () {
									piece = attach.split("/");
						jQuery("<a href='" + attach + "' download><i class='fa fa-download'></i> " + piece[piece.length - 1] + "</a><br>").appendTo(div);					
					
					},
					error: function () {
									piece = attach.split("/");
                  jQuery("<strong style='font-family: copseFont; font-size: 17px; font-weight: normal; color: #5b5b5b; text-decoration: line-through'><i style='color: #333; 'class='fa fa-download'></i> " + piece[piece.length - 1] + " [Link-not available]</strong><br>").appendTo(div);
					
					}
				
				
				}).always(function () {
				
				jQuery("<h4><i class='fa fa-tags'></i> [" + tags +"]</h4><br>").appendTo(div);		
										
				if(youlink.length > 0 ) {
				
				jQuery("<iframe width='100%' height='360' src='//www.youtube.com/embed/"
				 + youlink + "?feature=player_detailpage' frameborder='0' allowfullscreen></iframe>").appendTo(div);
				
				}
				
				jQuery("<p>" + content + "</p>").appendTo(div);
				
                        jQuery("<div class='hr'></div>").appendTo(div);
				

				});

				div.appendTo(".news");
				
				
			
			
			});
			
			


        }
    });
      
      
      
      
   }
});

function enroll(button, id) {

    $.post("../data_files/enroll.php", {
        course_id: id
    }, function (data) {
        button.html('Unenroll');
        button.click(function () {
            button.off();
            unenroll(button, id);
        });


    });


}

function unenroll(button, id) {


    $.post("../data_files/unenroll.php", {
        course_id: id
    }, function (data) {
        button.html('Enroll');
        button.click(function () {
            button.off();
            enroll(button, id);
        });




    });


}

$(".related").click(function () {

    $.ajax({
        type: "POST",
        url: "../data_files/get_related.php",
        dataType: "xml",
        success: function (xml) {
            $(".post-content > div:not('.tile-course')").hide("slow");
            $(".tile-course").css("display", "block");
            $(".tile-course").empty();
            $(".tile-course").append("<h2><i class='fa fa-book'></i> Related courses</h2>");
            
             if($(xml).find("course").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No related courses</h4>").appendTo(".tile-course");
            		return;
            }

            jQuery("<div />", {

                class: "wrapper"
            }).appendTo(".tile-course");
            $(xml).find("course").each(function () {

                var title = $(this).find("name").text();
                var description = $(this).find("description").text();
                var id = $(this).find("id").text();
                var name = $(this).find("aname").text();
                var num = $(this).find("enrolled").text();
                var tileWrapper = jQuery("<div />", {

                    class: "tile-wrapper"

                }).insertBefore(".tile-course .wrapper");

                jQuery("<h4>" + title + "</h4>", {

                }).appendTo(jQuery("<div />", {

                    class: "tile course"

                }).appendTo(tileWrapper));

                var courseContain = jQuery("<div />", {

                    class: "tile course-contain"

                }).appendTo(tileWrapper);

                jQuery("<p>" + description + ' <i style="color:black"></br>by ' + name + "</i></p>", {

                }).appendTo(courseContain);
                if (num == 0) {

                    var enrollbutton = jQuery("<button class='button_enroll' href='#'> Enroll</button>", {



                    }).appendTo(courseContain);
                    enrollbutton.click(function () {
                        enrollbutton.off();
                        enroll($(this), id);

                    });
                } else {
                    var unenrollbutton = jQuery("<button class='button_enroll'  href='#'> Unenroll</button>", {



                    }).appendTo(courseContain);
                    unenrollbutton.click(function () {
                        unenrollbutton.off();
                        unenroll($(this), id);

                    });
                }
            });


        }



    });


});

$(".all-course h3").click(function () {
    var id = $(this).attr("data-title");
    var div = $(this).parent().find("div");
    div.empty();

    if (div.css("display") == "none")
        div.css("display", "block");
    else {
        div.css("display", "none");
        return;
    }
    $.ajax({
        type: "GET",
        url: "../data_files/all_course.php?dept_id=" + id,
        dataType: "xml",
        success: function (xml) {

				 if($(xml).find("course").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No related courses</h4>").appendTo(div);
            		return;
            }
							 var ul = jQuery("<ul></ul>");
            $(xml).find("course").each(function () {
                var id = $(this).find("id").text();
                var num = $(this).find("num").text();
               
                var li = jQuery("<li style='margin-bottom:5px'></li>");
                jQuery("<h5 style='display:inline'>" + $(this).find("name").text() + "</h5>").appendTo(li);
                if (num == 0) {
                    var enrollbutton = jQuery(" <button class='button_enroll' style='display:inline;margin-left:3px;' >Enroll</button></li>").appendTo(li);
                    enrollbutton.click(function () {
                        enrollbutton.off();
                        enroll($(this), id);

                    });
                } else {

                    var unenrollbutton = jQuery("<button class='button_enroll' style='display:inline;margin-left:3px;' > Unenroll</button></li>").appendTo(li);
                    unenrollbutton.click(function () {
                        unenrollbutton.off();
                        unenroll($(this), id);

                    });

                }
            	li.appendTo(ul);
            	ul.appendTo(div);
            });



        }
    });

});


$(".display-all-course").click(function () {
    $(".post-content > div:not('.all-course')").hide("slow");
    $(".all-course").css("display", "block");

});

$(".show-friends").click(function () {

    $(".post-content > div:not('.friend-list')").hide("slow");
    $(".friend-list").css("display", "block");
    $(".friend-list").empty();
    $(".friend-list").append("<h2><i class='fa fa-users'></i> Friends</h2>");
    jQuery("<div />", {

        class: "wrapper"

    }).appendTo(".friend-list");

    $.ajax({
        type: "POST",
        data: {},
        url: "../data_files/get_friend_list.php",
        dataType: "xml",
        success: function (xml) {
        	
        	 if($(xml).find("friend").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No friends</h4>").appendTo(".friend-list");
            		return;
            }

            $(xml).find("friend").each(function () {

                var fname = $(this).find("fname").text();
                var lname = $(this).find("lname").text();
                var department = $(this).find("dept_name").text();
                var email = $(this).find("email").text();
                var propic = $(this).find("propic").text();
                var vote = $(this).find("votecount").text();;

                var friendTile = jQuery("<div />", {

                    class: "friend-tile"

                });

                var frontFace = jQuery("<div />", {

                    class: "front-face"

                });

                var backFace = jQuery("<div />", {

                    class: "back-face"

                });

                frontFace.appendTo(friendTile);
                backFace.appendTo(friendTile);

                jQuery("<img />", {

                    src: propic

                }).appendTo(frontFace);

                jQuery("<h4><i class='fa fa-user'></i> " + fname + " " + lname + "</h4>").appendTo(frontFace);
                jQuery("<p style='margin-left:5px'><i class='fa fa-phone'></i>  Email: " + email + "</p><br> <p style='margin-left:5px'><i class='fa fa-thumbs-up'></i> Vote count: " + vote + "</p><br> <p style='margin-left:5px'><i class='fa fa-building-o'></i> Department: " + department + "</p>").appendTo(backFace);

                friendTile.insertBefore(".friend-list .wrapper");


            });

        }
    });

});

$(".devs").click(function () {

    if ($(".dev-contact-modal").hasClass("dev-contact-modal-show")) {
        $(".dev-contact-modal").removeClass("dev-contact-modal-show");
        $(".modal-overlay").css("display", "none");
    } else {
        $(".dev-contact-modal").addClass("dev-contact-modal-show");
        $(".modal-overlay").css("display", "block");

    }

});

$(".modal-overlay").click(function () {
    $(".dev-contact-modal").removeClass("dev-contact-modal-show");
    $(".manager-contact-modal").removeClass("manager-contact-modal-show");
    $(".modal-overlay").css("display", "none");

});


$(".managers").click(function () {
    $.ajax({
        type: "POST",
        data: {},
        url: "../data_files/get_manager_list.php",
        dataType: "xml",
        success: function (xml) {

            $(".manager-contact-modal > .mlist").empty();
            var ulist = jQuery("<ul></ul>").appendTo(".manager-contact-modal > .mlist");

            $(xml).find("manager").each(function () {

                var name = $(this).find("fname").text() + " " + $(this).find("lname").text();
                var num = $(this).find("contact_num").text();
                var email = $(this).find("email").text();

                var ilist = jQuery("<li>" + name + "</li>").appendTo(ulist);

                var iulist = jQuery("<ul></ul>").appendTo(ilist);

                jQuery("<li>Cell number: " + num + "</li>").appendTo(iulist);
                jQuery("<li>Email ID: " + email + "</li>").appendTo(iulist);


            });

            if ($(".manager-contact-modal").hasClass("manager-contact-modal-show")) {
                $(".manager-contact-modal").removeClass("manager-contact-modal-show");
                $(".modal-overlay").css("display", "none");
            } else {
                $(".manager-contact-modal").addClass("manager-contact-modal-show");
                $(".modal-overlay").css("display", "block");
            }
        }

    });
});

$(".upload-research").click(function () {
    $(".post-content > div:not('.upload_paper')").hide("slow");
    $(".upload_paper").css('display', 'block');

});

$(".student-course a").click(function () {

    var c_id = $(this).attr('data-title');
    var course = $(this).text();
    $.ajax({
        type: "POST",
        data: {
            course_id: c_id
        },
        url: "../data_files/get_quiz_list.php",
        dataType: "xml",
        success: function (xml) {

            $(".post-content > div:not('.quiz-list')").css("display","none");
            $(".quiz-list").css("display", "block");
            $(".quiz-list .quiz-div ul").empty();
            
            
            
            $(".quiz-list > h2").text(course);
            
            if($(xml).find("quiz").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No quizes</h4>").appendTo(".quiz-list .quiz-div ul");
            		//return;
            }
            
            var num = 1;
            $(xml).find("quiz").each(function () {
                var id = $(this).find("id").text();


                var li = jQuery("<li class='quiz-list-li'></li>").appendTo(".quiz-list .quiz-div ul");
                var i = jQuery("<i class='fa fa-archive'></i>");
                i.appendTo(li);
                var a = jQuery("<a data-title='" + id + "' class='quiz-list-link'> Quiz-" + num+++"</a>");
                a.click(function () {

                    get_quiz(id, $(this).text());

                })
                a.appendTo(li);
            });
            get_upload(c_id);

        }

    });



});


function get_upload(c_id) {

    $.ajax({
        type: "POST",
        data: {
            course_id: c_id
        },
        url: "../data_files/get_course_upload_by_author.php",
        dataType: "xml",
        success: function (xml) {

            $(".quiz-list .upload-div ul").empty();
 if($(xml).find("upload").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No uploads</h4>").appendTo(".quiz-list .upload-div ul");
            		return;
            }
            $(xml).find("upload").each(function () {
					 var download = $(this).find("download").text();
                var title = $(this).find("title").text();
                var description = $(this).find("description").text();
                var filename = $(this).find("filename").text();
					 var id = $(this).find("id").text();
                var li = jQuery("<li></li>");
                var num = $(this).find("num").text();
                var spam = $(this).find("spam").text();
                var rate_num = $(this).find("rate").text();
                var rating_count = $(this).find("rate_count").text();
                var tit =jQuery("<h4><i class='fa fa-book'></i> " + title + "</h4>").appendTo(li);
                jQuery("<h5><i class='fa fa-tag' style='color:#c6393c'></i> Rated by "+ rating_count +" students</h5><h5><i class='fa fa-file-text-o'></i> " + description + "</h5>").appendTo(li);
					 jQuery("<a style='float:right;margin-top:-5px;' class='qr'></a>").appendTo(tit);
					 $('.qr').empty();
					 $('.qr').qrcode({
        				text  : filename,
        				background : "#ffffff",
        				foreground : "#000000",
        				width : 30,
        				height: 30
    				});
                $.ajax({
                    type: "HEAD",
                    url: filename,
                    success: function (a) {
                var piece = filename.split("/");
                        var mp4 = piece[5].split(".");
                        if (download == '1') {
                        jQuery("<a target='_blank' style='color:#4a75b5; font-size: 20px;' href='" + filename + "'><i class='fa fa-download'></i> " + piece[5] + "</a>").appendTo(li);
								}                        
                        if (mp4[mp4.length - 1] == 'mp4' ) {
                            jQuery("<video controls='controls' style='width:95%; height:400px' src='" + filename + "'>" + piece[5] + "</video>").appendTo(li);
                        }
                        if (mp4[mp4.length - 1] == 'mp3') {
                            jQuery("<audio style='width:95%' controls='controls' src='" + filename + "'>" + piece[5] + "</audio>").appendTo(li);
                        }
                    jQuery("<div class='hr'></div>").appendTo(li);
                    		
                    },

                    error: function () {
								                 var piece = filename.split("/");
                        var links = jQuery("<strong style='font-family: copseFont; font-size: 17px; font-weight: normal; margin-left:20px; color: #5b5b5b; text-decoration: line-through'><i style='color: #333; 'class='fa fa-download'></i> " + piece[5] + " [Link-not available]</strong><br><br>").appendTo(li);
								                  
                        jQuery("<div class='hr'></div>").appendTo(li);

                    }
                });
                	
                	var rate = jQuery("<a class='rate' style='float:right'  title='Rate'><i class='fa fa-star-o'></i></a>").appendTo(tit);
                	var unrate = jQuery("<a class='unrate' style='float:right'  title='Un-rate'><i class='fa fa-star'></i></a>").appendTo(tit);
                	if (rate_num == 0) {
                		rate.css("display","inline");
					 			unrate.css("display","none");
                		 rate.click(function () {
                		 	
								 	   rate.off();
										rate_slide($(this),id);								 	
								 	});
                	}
                	else{
                			unrate.css("display","inline");
					 			rate.css("display","none");
						  unrate.click(function () {
						  
							 	   rate.off();
									unrate_slide($(this),id);								 	
								 	});
						}								 		 	
                	var bookmark1 = jQuery("<a class='not' style='float:right'  title='Bookmark me'><i class='fa fa-bookmark-o'></i></a>").appendTo(tit);
                	var bookmark2 = jQuery("<a title='Unbookmark me'  style='float:right'  class='yes'><i class='fa fa-bookmark'></i></a>").appendTo(tit); 
                	if (spam != 1) {
                	var spam = jQuery("<a class='spam'  style='float:right' title='report as spam'><i class='fa fa-ban'></i></a>").appendTo(tit);
                	   spam.click(function () {
								 	   spam.off();
										report_spam($(this),id);								 	
								 	});
					  }			 	
						if (num == 0) {
					 			bookmark1.css("display","inline");
					 			bookmark2.css("display","none");
								 bookmark1.click(function () {
								 	   bookmark1.off();
										bookmark($(this),id);								 	
								 	});
						}else{		 	  
								bookmark2.css("display","inline");
					 			bookmark1.css("display","none"); 
 									bookmark2.click(function () {
								 	   bookmark2.off();
										unbookmark($(this),id);								 	
								 	});
						}	
						
												
										
                li.appendTo(".quiz-list .upload-div ul");

            });
        }
    });
}

function bookmark(anchor,id) {
	  $.post("../data_files/bookmark.php", {
        upload_id: id
    }, function (data) {
    	 anchor.off();
       anchor.parent().find(".not").css('display','none');
		 anchor.parent().find(".yes").css('display','inline');	
		 anchor.parent().find(".yes").click(function () {
		 		
            unbookmark(anchor,id);
        });
    });

}	
function unbookmark(anchor,id) {
	  $.post("../data_files/unbookmark.php", {
        upload_id: id
    }, function (data) {
    	anchor.off();
       anchor.parent().find(".yes").css('display','none');
		 anchor.parent().find(".not").css('display','inline');	
		 anchor.parent().find(".not").click(function () {
            bookmark(anchor, id);
        });
    });

}
function rate_slide(anchor,id) {
	  $.post("../data_files/rate_slide.php", {
        upload_id: id
    }, function (data) {
    	 anchor.off();
       anchor.parent().find(".rate").css('display','none');
		 anchor.parent().find(".unrate").css('display','inline');	
		 anchor.parent().find(".unrate").click(function () {
		 		
            unrate_slide(anchor,id);
        });
    });

}	
function unrate_slide(anchor,id) {
	  $.post("../data_files/unrate_slide.php", {
        upload_id: id
    }, function (data) {
    	 anchor.off();
       anchor.parent().find(".unrate").css('display','none');
		 anchor.parent().find(".rate").css('display','inline');	
		 anchor.parent().find(".rate").click(function () {
		 		
            rate_slide(anchor,id);
        });
    });

}	
function report_spam(anchor,id) {
		  $.post("../data_files/reportspam.php", {
        upload_id: id
    }, function (data) {
    	anchor.off();
       anchor.parent().find(".spam").hide("slow");	
		 
    });
}	
function get_quiz(id, quiznumber) {


    $.ajax({
        type: "POST",
        data: {
            quiz_id: id
        },
        url: "../data_files/get_quiz_question.php",
        dataType: "xml",
        success: function (xml) {

            $(".post-content > div:not('.actual-quiz')").css("display","none");
            $(".actual-quiz").css("display", "block");
            $(".actual-quiz > .quiz-form").empty();
            if($(xml).find("problem").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No questions</h4>").appendTo(".actual-quiz > .quiz-form");
            		return;
            }
            jQuery('<input type="submit" class="submit" value="Submit">').appendTo(".actual-quiz > .quiz-form");
            jQuery("<input name='quiz-id' type='hidden' class='w-input qid' value='" + id + "'></input>").appendTo(".actual-quiz > .quiz-form");
            var qcinput = jQuery("<input name='qcount' type='hidden' class='w-input qid' value='0'></input>").appendTo(".actual-quiz > .quiz-form");
            $(".actual-quiz > h2").text(quiznumber);
            var qcount = 0;

            $(xml).find("problem").each(function () {

                var question = $(this).find("question").text();
                var option1 = $(this).find("option1").text();
                var option2 = $(this).find("option2").text();
                var option3 = $(this).find("option3").text();
                var option4 = $(this).find("option4").text();
                var qnumber = $(this).find("qnumber").text();

                var div = jQuery("<div class='question-answer'></div>");
                var h3 = jQuery("<h3>Question " + qnumber + "</h3>");
                var question = jQuery("<pre style='color:#333;font-size:15px;font-family:copsefont;margin-left:30px;'>" + question + " <i class='fa fa-question'></i></pre>");
                var input1 = jQuery("<p style='color:#5488ab;font-size:15px;font-family:copsefont;margin-left:40px;'><input value = '1' type='radio' name='option" + qnumber + "' checked> " + option1 + "</input></p>");
                var input2 = jQuery("<p style='color:#5488ab;font-size:15px;font-family:copsefont;margin-left:40px;'><input value = '2' type='radio' name='option" + qnumber + "'> " + option2 + "</input></p>");
                var input3 = jQuery("<p style='color:#5488ab;font-size:15px;font-family:copsefont;margin-left:40px;'><input value = '3' type='radio' name='option" + qnumber + "'> " + option3 + "</input></p>");
                var input4 = jQuery("<p style='color:#5488ab;font-size:15px;font-family:copsefont;margin-left:40px;'><input value = '4' type='radio' name='option" + qnumber + "'> " + option4 + "</input></p>");
                var hidden = jQuery("<input type='hidden' name='q_number' value='" + qnumber + "'></input>");

                h3.appendTo(div);
                question.appendTo(div);
                input1.appendTo(div);
                input2.appendTo(div);
                input3.appendTo(div);
                input4.appendTo(div);
                hidden.appendTo(div);


                div.insertBefore(".actual-quiz > .quiz-form > .submit");
                qcount++;
                qcinput.attr("value", qcount);

            });

        }
    });

}

var Click = 0;
$(".forum-post-window-open").bind("click", function (event) {
    $(".forum-post-window-open").css("-webkit-transition", "all 0.5s linear");
    $(".forum-text-area").show("slow");
    Click++;
    if (Click == 2) {
        $(".forum-post-window-open").css("-webkit-transition", "all 0.5s linear");
        $(".forum-text-area").hide("slow");
        Click = 0;
    }

});



$(".discuss-forum").click(function () {


    $.ajax({
        type: "POST",
        url: "../data_files/forum_post_retrive.php",
        dataType: "xml",
        success: function (xml) {
            $(".post-content > div:not('.forum-wrapper')").hide("slow");
            $(".forum-wrapper").css("display", "block");
            $(".forum-wrapper ul").empty();
            
             if($(xml).find("forum_post").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No questions</h4>").appendTo(".forum-wrapper ul");
            		return;
            }

            $(xml).find("forum_post").each(function () {


                var id = $(this).find("id").text();
                var title = $(this).find("title").text();
                var description = $(this).find("description").text();
                var date = $(this).find("date").text();
                var whom = $(this).find("whom").text();
                var link = $(this).find("link").text();
                var short = $(this).find("short").text();

                var type = link.split(".");
                var time = date.split(" ");
                var li = jQuery("<li></li>");

                jQuery("<h3><i class='fa fa-star'></i> Title: " + title + "</h3><p><i class='fa fa-user'></i> " + whom + "</p><p><i class='fa fa-calendar'></i> " + time[0] + "</p><p><i class='fa fa-clock-o'></i> " + time[1] + "</p><p class='short'><i class='fa fa-file-text-o'></i> " +
                    short + "...</p><p class='long' style='display:none;'><i class='fa fa-file-text-o'></i> " + description + "</p>").appendTo(li);

                $.ajax({
                    type: "HEAD",
                    url: link,
                    success: function (a) {

                var piece = link.split("/");
                        if (type[type.length - 1] == 'pdf') {

                            var links = jQuery("<a href='" + link + "' target='_blank'><i class='fa fa-download '></i> " + piece[3] + "</a><br><br>").appendTo(li);
                        } else if (type[type.length - 1] == 'mp4') {
                        	  var links = jQuery("<a href='" + link + "' download><i class='fa fa-download '></i> " + piece[3] + "</a><br><br>").appendTo(li);
                            jQuery("<video controls='controls' style='width:95%; height:400px' src='" + link + "'>" + piece[3] + "</video>").appendTo(li);
                        } else if(type[type.length - 1] == 'mp3') {
                            var links = jQuery("<a href='" + link + "' download><i class='fa fa-download '></i> " + piece[3] + "</a><br><br>").appendTo(li);
								  jQuery("<audio style='width:95%' controls='controls' src='" + link + "'>" + piece[3] + "</audio>").appendTo(li);                        
                        
                        } else {
   						                     
	                  	   var links = jQuery("<a href='" + link + "' download><i class='fa fa-download '></i> " + piece[3] + "</a><br><br>").appendTo(li);      
                        }
                        
                        var show_complete = jQuery("<button class='block'>Read more ...</button>").appendTo(li);
                        show_complete.bind("click", function (event) {
                            read_more($(this));

                        });

                        var show_complete = jQuery("<button id='" + id + "' class='block'>Go to thread</button>").appendTo(li);

                        show_complete.click(function () {

                            forum_thread(id, title, description, date, whom, link, links);


                        });

                        jQuery("<div class='hr'></div>").appendTo(li);


                    },

                    error: function (a) {

                var piece = link.split("/");
                        var links = jQuery("<strong style='font-weight: normal; margin-left:20px; color: #5b5b5b; text-decoration: line-through'><i style='color: #333; 'class='fa fa-download'></i> " + piece[3] + " [Link-not available]</strong><br><br>").appendTo(li);

                        var show_complete = jQuery("<button class='block'>Read more ...</button>").appendTo(li);
                        show_complete.bind("click", function (event) {
                            read_more($(this));


                        });
                        var show_complete = jQuery("<button id='" + id + "' class='block'>Go to thread</button>").appendTo(li);

                        show_complete.click(function () {

                            forum_thread(id, title, description, date, whom, link, links);


                        });

                        jQuery("<div class='hr'></div>").appendTo(li);
                    }

                });



                li.appendTo(".forum-post ul");



            });
        }
    });


});

function read_more(button) {
    $('html, body').animate({
        scrollTop: button.parent().offset().top
    }, 1000);
    button.off();
    button.html('shrink');
    button.parent().find(".short").hide("slow");


    button.parent().find(".long").show("slow");
    button.bind("click", function (event) {
        shrink(button);
    });
}

function shrink(button) {
    button.off();
    button.html('Read more');
    button.parent().find(".short").show("slow");


    button.parent().find(".long").hide("slow");
    button.bind("click", function (event) {
        read_more(button);
    });
}

$("p").bind("selectstart", function (e) {

    e.preventDefault();
    return false;
});

/**************Changes******************/

function forum_thread(id, title, description, date, whom, link, links) {

    $(".forum-thread > form > .post_id").attr("value", id);

    $.ajax({
        type: "POST",
        url: "../data_files/get_forum_comment.php",
        data: {
            post_id: id
        },
        dataType: "xml",
        success: function (xml) {


            $(".forum-thread > h2").text(title);
            $(".forum-thread > .creator").html("<i class='fa fa-user'></i> " + whom);
            $(".forum-thread > .response").html("<i class='fa fa-comments'></i> Responses(" + $(xml).find("comment_info").length + ")");
            $(".forum-thread > .date").html("<i class='fa fa-clock-o'></i> " + date);
            $(".forum-thread > .desc").text(description);
            $(".forum-thread > strong, .forum-thread > a, .forum-thread > br").remove();
        
            $(links).insertAfter('.forum-thread > .desc');

          //  $(".forum-thread > a").html("<i class='fa fa-download'></i> " + link.split("/")[3]).attr("href", link);


            $(".post-content > div:not('.forum-thread')").hide("slow");
            $(".forum-thread").css("display", "block");
            $(".forum-thread > .comment").empty();

            if ($(xml).find("comment_info").length == 0) {
                jQuery("<h4 style='text-align:center'><i class='fa fa-comment'></i> No comments</h4>").
                appendTo(".forum-thread > .comment");
                return;
            }

            $(xml).find("comment_info").each(function () {

                var id = $(this).find("id").text();
                var by = $(this).find("name").text();
                var comment = $(this).find("comment").text();
                var s_id = $(this).find("s_id").text();
                var num = $(this).find("num").text();
                var by_whom = jQuery("<h4><i class='fa fa-comment'></i> " + by + "</h4>").appendTo(".forum-thread > .comment");
                jQuery("<p>" + comment + "</p>").appendTo(".forum-thread > .comment");
                var like = jQuery("<a class='like' style='float:right;color:gray;cursor:pointer'  title='like'><i class='fa fa-thumbs-up'></i></a>").appendTo(by_whom);
                var unlike = jQuery("<a class='unlike' style='float:right;color:#4769b8;cursor:pointer'  title='unlike'><i class='fa fa-thumbs-up'></i></a>").appendTo(by_whom);
             	 if (num == 0) {
					 			like.css("display","inline");
					 			unlike.css("display","none");
								 like.click(function () {
								 	   like.off();
										likecomment($(this),id);								 	
								 	});
						}else{		 	  
								unlike.css("display","inline");
					 			like.css("display","none"); 
 									unlike.click(function () {
								 	   unlike.off();
										unlikecomment($(this),id);								 	
								 	});
						}					

            });
        }
    });

}
function likecomment(anchor,id) {
	  $.post("../data_files/like.php", {
        comment_id: id
    }, function (data) {
    	 anchor.off();
       anchor.parent().find(".like").css('display','none');
		 anchor.parent().find(".unlike").css('display','inline');	
		 anchor.parent().find(".unlike").click(function () {
		 		
            unlikecomment(anchor,id);
        });
    });

}
function unlikecomment(anchor,id) {
	  $.post("../data_files/unlike.php", {
        comment_id: id
    }, function (data) {
    	 anchor.off();
       anchor.parent().find(".unlike").css('display','none');
		 anchor.parent().find(".like").css('display','inline');	
		 anchor.parent().find(".like").click(function () {
		 		
            likecomment(anchor,id);
        });
    });

}

$(".forum-thread form").submit(function (e) {

    e.preventDefault();


    var comment = $(this).find("textarea").val();

    var id = $(this).find("input").val();

    var button = $(this).find("button").hide("fast");
    var img = $(this).find("img").css("display", "block");

    $.ajax({
        type: "POST",
        url: "../data_files/post_comment.php",
        data: {
            post_id: id,
            comment: comment
        },
        dataType: "text",
        success: function (text) {

            img.hide("fast");
            button.show("fast");

            $("#" + id).trigger("click");

        },
        error: function (text) {
            img.hide("fast");
            button.show("fast");

            $("#" + id).trigger("click");

        }
    });
});


$(".show-research").click(function () {


    $.ajax({
        type: "POST",
        url: "../data_files/retrieve_paper.php",
        dataType: "xml",
        success: function (xml) {
            $(".post-content > div:not('.retrieve_paper')").hide("slow");
            $(".retrieve_paper").css("display", "block");
            $(".retrieve_paper ul").empty();
             if($(xml).find("paper").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-smile-o'></i> No research papers</h4>").appendTo(".retrieve_paper ul");
            		return;
            }

            $(xml).find("paper").each(function () {

                var title = $(this).find("title").text();
                var description = $(this).find("description").text();
                var username = $(this).find("username").text();
                var tags = $(this).find("tags").text();
                var link = $(this).find("link").text();
                var li = jQuery("<li></li>");


                jQuery("<h3><i class='fa fa-star'></i> Title: " + title + "</h3><p><i class='fa fa-user'></i> " + username + "</p><p><i class='fa fa-file-text-o'></i> " + description + "</p><p><i class='fa fa-tags'></i> " + tags + "</p>").appendTo(li);

                $.ajax({
                    type: "HEAD",
                    url: link,
                    success: function (a) {
                var piece = link.split("/");
                        var links = jQuery("<a href='" + link + "' download><i class='fa fa-download '></i> " + piece[piece.length - 1] + "</a><br><br>").appendTo(li);
                        jQuery("<div class='hr'></div>").appendTo(li);

                    },
                    error: function (a) {
                var piece = link.split("/");
                        var links = jQuery("<strong style='font-weight: normal; margin-left:20px; color: #5b5b5b; text-decoration: line-through'><i style='color: #333; 'class='fa fa-download'></i> " + piece[piece.length - 1] + " [Link-not available]</strong><br><br>").appendTo(li);
                        jQuery("<div class='hr'></div>").appendTo(li);

                    }


                });




                li.appendTo(".retrieve_paper ul");



            });
        }
    });


});


$(".search-book").click(function () {

$(".post-content > div:not('.quickbooklook')").css("display", "none");
            $(".quickbooklook").css("display", "block");


});

$(".bookmarked-show").click(function () {

 $.ajax({
        type: "POST",
        url: "../data_files/bookmarked_show.php",
        dataType: "xml",
        success: function (xml) {
            $(".post-content > div:not('.bookmark_show')").hide("slow");
            $(".bookmark_show").show();
            $(".bookmark_show ul").empty();
            
              if($(xml).find("bookmark").length == 0) {
            		
            		$("<h4 style='margin-left:-10px; color:#54ab82; text-align:center'><i class='fa fa-frown-o'></i> No bookmarks</h4>").appendTo(".bookmark_show ul");
            		return;
            }

            $(xml).find("bookmark").each(function () {
					 
                var title = $(this).find("name").text();
                var description = $(this).find("description").text();
                var link = $(this).find("file").text();
                var id = $(this).find("id").text();
                var li = jQuery("<li></li>");
               
                var tit = jQuery("<h3><i class='fa fa-star'></i> Title: " + title + "</h3>").appendTo(li);
                jQuery("<p><i class='fa fa-file-text-o'></i> " + description + "</p>").appendTo(li);
                $.ajax({
                    type: "HEAD",
                    url: link,
                    success: function (a) {
 var piece = link.split("/");
                var dot = link.split(".");
                        var links = jQuery("<a href='" + link + "' download><i class='fa fa-download '></i> " + piece[piece.length - 1] + "</a><br><br>").appendTo(li);
                     
                        if (dot[dot.length - 1] == 'mp4') {
								  jQuery("<video controls='controls' style='width:95%; height:400px' src='" + link + "'>" + piece[piece.length - 1] + "</video>").appendTo(li);                      
                        }	else if(dot[dot.length - 1] == 'mp3') {
                            jQuery("<audio style='width:95%' controls='controls' src='" + link + "'>" + piece[piece.length - 1] + "</audio>").appendTo(li);                        
                        
                        }
								   jQuery("<div class='hr'></div>").appendTo(li);
                    },
                    error: function (a) {
var piece = link.split("/");
                var dot = link.split(".");
                        var links = jQuery("<strong style='font-weight: normal; margin-left:20px; color:red; text-decoration: line-through'><i style='color: #333; 'class='fa fa-download'></i> " + piece[piece.length - 1] + " [Link-not available]</strong><br><br>").appendTo(li);
                        jQuery("<div class='hr'></div>").appendTo(li);

                    }
							

                });
                	var bookmark2 = jQuery("<a title='Unbookmark me' style='cursor: pointer;float:right' class='yes'><i class='fa fa-bookmark'></i></a>").appendTo(tit);   			 	  
								bookmark2.css("display","inline");
 									bookmark2.click(function () {
										deletebookmark($(this),id);								 	
						});									
	


                li.appendTo(".bookmark_show ul");



            });
        }
    });


});

function deletebookmark(anchor,id) {
	  $.post("../data_files/unbookmark.php", {
        upload_id: id
    }, function (data) {
    	anchor.off(); 
		 anchor.parent().parent().hide("slow");	
		
    });

}
;


