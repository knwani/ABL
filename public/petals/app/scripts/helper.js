

function getTime(){
  var date = new Date();
  var current_hour = date.getHours();

  var timeOfDay = "morning";

  if(current_hour <= 11 && current_hour >= 0){
    timeOfDay = "morning";
  } else if(current_hour <= 17 && current_hour >= 12) {
    timeOfDay = "afternoon";
  } else if(current_hour <= 23 && current_hour >= 18) {
    timeOfDay = "evening";
  }

  $(".salute").html("Good " + timeOfDay + "<div class='tiny'>Looks like a busy week, lots of traffic!</div>");
}
