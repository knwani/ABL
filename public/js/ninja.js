$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$(document).ready(function(){
  //if the events are enough, create this fucking slider



  $(".shower").click(function(){
    if($(".categories_list").css("display") == "none"){
      $(".categories_list").css("display", "block");
    } else {
      $(".categories_list").css("display", "none");
    }
    event.stopPropagation();
  });

  $("body").click(function(){
    $(".categories_list").css("display", "none");
  });
});

function showModal(){
  $(".parentModal").css("display", "block");
}

function closeModal(){
  $(".parentModal").css("display", "none");
}



function askQuestion(value){
  var question = $('textarea#rum').val();

  if (question != ""){
    if(value == "Facebook"){
      $.ajax({
        type: 'POST',
        url: "/save-question",
        data: {the_question: question}
      }).done(function() {
        //$( this ).addClass( "done" );
      });
    } else if (value == "Twitter"){

    } else if (value == "Google"){

    }
  } else {
    alert("You haven't typed a question");
  }
}
