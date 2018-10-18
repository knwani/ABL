//var show_modal = false;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$(document).ready(function(){
  $( ".mobile_menu i" ).click(function() {
       $( ".morty" ).slideToggle();
       //$(".morty" ).attr('display', 'flex');
   });
  //if the events are enough, create this fucking slider
  $(".shower").click(function(){
    if($(".categories_list").css("display") == "none"){
      $(".categories_list").css("display", "block");
      //alert("balls");
      //alert($(".categories_list").css("display"));
      event.stopPropagation();
    } else if ($(".categories_list").css("display") == "block") {
      $(".categories_list").css("display", "none");
      event.stopPropagation();
    }
  });

  $("body").click(function(){
    if ($(".categories_list").css("display") == "block"){
      //$(".categories_list").css("display", "none");
    }
  });


});

function showModal(){
  $(".parentModal").css("display", "block");
}

function closeModal(){
  $(".parentModal").css("display", "none");
}

function showQuestionAskbox(){
  showModal();
  $(".asking-questions").css("display", "block");
  $(".viewing-questions").css("display", "none");

  $(".close").bind("click", function (){
    closeModal();
  });
}

function showQuestion(link){
  showModal();
  NProgress.start();
  $(".asking-questions").css("display", "none");
  $(".viewing-questions").css("display", "block");
  var the_link = $(link).attr('data-path');
  var id = $(link).attr('data-id');

  var clone = $(link).clone();
  var the_former_link = $(".viewing-questions").attr('data-path') + "/ask-kenny#question";

  $(".viewing-questions").html(clone);

  $(".close").bind("click", function (){
    closeModal();
    history.pushState(null, null, the_former_link);
    //history.back();
  });

  history.pushState(null, null, the_link);

  /*if ($(".viewing-questions .question_status").text() == "Unanswered"){
    $(".answer_content .brex").text("Kenny hasn't answered this question yet. Do check back");
  }*/

  NProgress.done();
  //alert($(link).attr('data-path'));



  /*$.ajax({
    type: 'POST',
    url: "/view-question",
    data: {question_id: id}
  }).done(function(response) {


    history.pushState(null, null, the_link);

    /*$("#view-asker img").attr("src", response.question.avatar);
    $("#view-details .name").text(response.question.Who);
    $("#view-sparrow .question_title").text(response.question.Question);

    if (response.question.Answer == ""){
      $("#answer").text("Kenny hasn't answered this question yet. Do check back");
    }*/
    //alert(response.question.Question);

  //});

}

var validateEmail = function(elementValue) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return emailPattern.test(elementValue);
}

$('#e-mail').keyup(function() {

    var value = $(this).val();
    var valid = validateEmail(value);

    if (!valid) {
        $(this).css('color', 'red');
    } else {
        $(this).css('color', '#000');
    }

});

function signUpNewsletter(){
  var name = $("#name").val();
  var number = $("#number").val();
  var email = $("#e-mail").val();
  var valid = validateEmail(email);

  if (name == ""){
    alert("You haven't added your name");
  } else if (number == ""){
    alert("You haven't added your number");
  } else if (email == ""){
    alert("You haven't added your email");
  } else if (!valid) {
    alert("Please enter a valid email");
  } else {
    NProgress.start();
    $.ajax({
      type: 'POST',
      url: "/save-newsletter-signup",
      data: {the_name: name, the_number: number, the_email: email}
    }).done(function(response) {
      alert("You have successfully signed up");
      NProgress.done();
    });
  }
}

function askQuestion(value){
  var question = $('textarea#rum').val();
  if (question != ""){
    NProgress.start();
    $.ajax({
      type: 'POST',
      url: "/save-question",
      data: {the_question: question}
    }).done(function(response) {

      //alert(response.last_insert_id);
      if(value == "Facebook"){
        var id = response.last_insert_id;
        if (response.success == true){
          window.location.href = '/redirect/facebook';
          NProgress.done();
        }
      } else if (value == "Twitter"){
        var id = response.last_insert_id;
        if (response.success == true){
          window.location.href = '/redirect/twitter';
          NProgress.done();
        }
      } else if (value == "Google"){
        var id = response.last_insert_id;
        if (response.success == true){
          window.location.href = '/redirect/google';
          NProgress.done();
        }
      } else if (value == "Anon"){
        var id = response.last_insert_id;
        if (response.success == true){
          window.location.href = '/redirect/anon';
          NProgress.done();
        }
      }
      //$( this ).addClass( "done" );
    });
    /*if(value == "Facebook"){
      $.ajax({
        type: 'POST',
        url: "/save-question",
        data: {the_question: question}
      }).done(function(response) {
        //alert(response.last_insert_id);
        var id = response.last_insert_id;
        if (response.success == true){
          window.location.href = '/redirect-facebook';
        }
        //$( this ).addClass( "done" );
      });
    } else if (value == "Twitter"){

    } else if (value == "Google"){

    }*/
  } else {
    alert("You haven't typed a question");
  }
}
