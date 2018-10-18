var picturecount = 0; //this is used for the gallery

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

function select(div){
  $(".nav li").removeClass("active");
  $(div).addClass("active");
}

function countPictures(){
    var input = document.getElementById('image');

    if (input.files.length == 0){
        $(".add_picture_details").text("Add pictures to Project");
    } else if (input.files.length == 1){
        picturecount = input.files.length;
        $(".add_picture_details").text("Selected 1 picture");
    } else {
        picturecount = input.files.length;
        $(".add_picture_details").text("Selected " + input.files.length + " pictures");
    }
}


function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('.cover-picture').attr('style', 'background-image:url(' + e.target.result + ')');
    }

    reader.readAsDataURL(input.files[0]);
  }
}

function deleteFile(element){
  var image_url, folder_name;
  image_url = $(element).attr('data-name');
  folder_name = $(element).attr('data-folder');
  angular.element($(".posts-holder")).scope().deleteFile(image_url, folder_name);
}

function callUpload(){
  $("#image").trigger("click");
}

function callUploadTwo(){
  $("#image_two").trigger("click");
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
