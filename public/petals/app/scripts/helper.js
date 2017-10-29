

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




function callUpload(){
  $("#image").trigger("click");
}

function uploadPicture(){
  angular.element(document.getElementById('AdminParent')).scope().changeEventPoster();
}

function callNotification(message, type){
  //setTimeout( function() {
    // create the notification
    var notification = new NotificationFx({
      message : '<p>' + message + '</p>',
      // layout type: growl|attached|bar|other
      layout : 'growl',
      // effects for the specified layout:
    	// for growl layout: scale|slide|genie|jelly
    	// for attached layout: flip|bouncyflip
    	// for other layout: boxspinner|cornerexpand|loadingcircle|thumbslider
    	// ...
      effect : 'jelly',
      type : type, // notice, warning or error
      //ttl : 60000,
      onClose : function() {
        //bttn.disabled = false;
      }
    });
    // show the notification
    notification.show();

  //}, 100);
}
