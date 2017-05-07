$(document).ready(function () {

    $(".name,.already,.repass,.signup-header").css("display", "none");
    $(".login").attr("action", "data_files/auth.php");

});

$(".signup").click(function () {

    $(".warning_show").removeClass("warning_show").addClass("warning_hidden");
    $(".repass, .pass").removeClass("wrong-pass");
    $(".repass, .pass").removeClass("correct-pass");
    $(".login").fadeOut("slow", function () {
        $(".profile_pic,.fpass,.remember_me,.signup,#admin").css("display", "none");
        $(".signin").attr("value", "Sign up");
        $(".login").attr("action", "data_files/form.php");
        $(".already").css("display", "inline");
        $(".name,.login,.repass,.pass,.user,.signup-header").show(0);
        $(".login").css("margin-top", "96px");
        $(".name,.repass").attr("required", "required");
        $(this).fadeOut(0);
        $(this).fadeIn("slow");

    });


});

$(".already").click(function () {

    $(".repass, .pass").removeClass("wrong-pass").val("");
    $(".repass, .pass").removeClass("correct-pass");
    $(".login").fadeOut("slow", function () {
        $(".profile_pic").css("display", "inline");
        $(".name,.repass").removeAttr("required");
        $(".signin").attr("value", "Sign in");
        $(".login").attr("action", "data_files/auth.php");
        $(".fpass,.remember_me,.signup,.user,.pass,#admin").show(0);
        $(".already").css("display", "none");
        $(".name,.repass,.signup-header").css("display", "none");
        $(".login").css("margin-top", "100px");
        $(".login").css("background", "none");
        $(this).fadeOut(0);
        $(this).fadeIn("slow");
    });
});

$(".repass").bind('input', function () {

    if ($(".pass").val() == $(this).val() && $(this).val().length > 0) {
        $(this).removeClass("wrong-pass");
        $(this).addClass("correct-pass");
        $(".pass").addClass("correct-pass");
    } else {
        $(this).removeClass("correct-pass");
        $(".pass").removeClass("correct-pass");
    }
});

$(".repass").focusout(function () {

    if ($(".pass").val() != $(this).val()) {
        $(this).removeClass("correct-pass");
        $(this).addClass("wrong-pass");
    }

});

$(".login").submit(function (e) {

    if ($(".pass").val() != $(".repass").val() && $(".repass").attr("required") == "required") {
        $(this).removeClass("correct-pass");
        $(".repass").addClass("wrong-pass");
        e.preventDefault();
    }

});
$(".pass").bind('input', function () {

    if ($(".repass").val() == $(this).val() && $(this).val().length > 0) {
        $(this).removeClass("wrong-pass");
        $(this).addClass("correct-pass");
        $(".repass").addClass("correct-pass");
    } else {
        $(this).removeClass("correct-pass");
        $(".repass").removeClass("correct-pass");
    }
});

$('.fpass').click(function () {
    if ($(".fpass-modal").hasClass("fpass-modal-show")) {
        $(".fpass-modal").removeClass("fpass-modal-show");
        $(".modal-overlay").css("display", "none");
    } else {
        $(".fpass-modal").addClass("fpass-modal-show");
        $(".modal-overlay").css("display", "block");

    }

});

$(".modal-overlay").click(function () {
    $(".fpass-modal").removeClass("fpass-modal-show");
    $(".modal-overlay").css("display", "none");

});

$(".fpass-form").submit(function (e) {

    e.preventDefault();
    var form = $(this);
    $(".fpass-submit").css("display", "none");
    $(".show_load").css("display", "inline");
    $.post("data_files/forgot.php", form.serializeArray(), function (data) {
        $(".fpass-modal").removeClass("fpass-modal-show");
        $(".modal-overlay").css("display", "none");
        $(".show_load").css("display", "none");
        $(".fpass-submit").css("display", "show");
    });
});