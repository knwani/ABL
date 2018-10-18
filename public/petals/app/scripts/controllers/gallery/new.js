'use strict';

/**
 * @ngdoc function
 * @name petalsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the petalsApp
 */
angular.module('petalsApp').controller('NewGalleryCtrl', function ($scope, $http, $rootScope, FileUploader, $location) {

  $scope.authors = [];

  $rootScope.url_id = '9';

  var this_file;

  $scope.loadAuthors = function (){
    $scope.promise = $http.get('api/get_authors').then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      //$scope.purpose = response.data.purpose;
      $scope.authors = response.data.authors;
      //$scope.purpose_cover = "http://localhost:8080/tenets/" + $scope.purpose[0].cover;

      //$("#writer").trumbowyg('html', $scope.purpose[0].content);
      //$('#author option:eq(' + $scope.purpose[0].author + ')').prop('selected', true);
      //alert($("#author option:selected").val());
      //console.log(response);
      //$location.path("/projects/" + response);
    }, function(response){
      //console.log(response);
      //callNotification('Something went wrong. Please try again. But we have noted the error','error');
      //NProgress.done();
    })
  }

  $scope.loadAuthors();

  $scope.addArticle = function (){

    $scope.post_data = [];

    if(picturecount == 0){
      callNotification('You need to select at least one picture', 'warning');
    } else if ($("#title").val() == '') {
      callNotification('You need to enter a Folder name', 'warning');
    } else if ($("#datepicker").val() == '') {
      callNotification('You need to select a Folder date', 'warning');
    } else {
      //uploader.uploadAll();
      uploader.uploadAll();
    }

  }

  $scope.showUploader = function (){
    //alert(contributor);
    $("#image").trigger("click");
  }

  var uploader = $scope.uploader = new FileUploader({
        url: 'api/add_gallery_folder',
        queueLimit: 20
    });

    // FILTERS
    // a sync filter
    uploader.filters.push({
        name: 'syncFilter',
        fn: function(item /*{File|FileLikeObject}*/, options) {
            console.log('syncFilter');
            return this.queue.length < 10;
        }
    });

    // an async filter
    uploader.filters.push({
        name: 'asyncFilter',
        fn: function(item /*{File|FileLikeObject}*/, options, deferred) {
            console.log('asyncFilter');
            setTimeout(deferred.resolve, 1e3);
        }
    });

    // CALLBACKS

    uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
        console.info('onWhenAddingFileFailed', item, filter, options);
    };
    uploader.onAfterAddingFile = function(fileItem) {
      //NProgress.start();
      $scope.title = $("#title").val();
      $scope.datetime = $("#datepicker").val();
      fileItem.url = "api/add_gallery_folder?article_name=" + $scope.title + "&date_time=" + $scope.datetime;
      console.info('onAfterAddingFile', fileItem);
    };
    uploader.onAfterAddingAll = function(addedFileItems) {
        console.info('onAfterAddingAll', addedFileItems);
    };
    uploader.onBeforeUploadItem = function(item) {
        NProgress.start();
        console.info('onBeforeUploadItem', item);
    };
    uploader.onProgressItem = function(fileItem, progress) {
        console.info('onProgressItem', fileItem, progress);
    };
    uploader.onProgressAll = function(progress) {
        console.info('onProgressAll', progress);
    };
    uploader.onSuccessItem = function(fileItem, response, status, headers) {
        console.info('onSuccessItem', fileItem, response, status, headers);
        //console.log(response.link);

    };
    uploader.onErrorItem = function(fileItem, response, status, headers) {
        console.info('onErrorItem', fileItem, response, status, headers);
    };
    uploader.onCancelItem = function(fileItem, response, status, headers) {
        console.info('onCancelItem', fileItem, response, status, headers);
    };
    uploader.onCompleteItem = function(fileItem, response, status, headers) {
        console.info('onCompleteItem', fileItem, response, status, headers);
    };
    uploader.onCompleteAll = function() {
        console.info('onCompleteAll');
        NProgress.done();
        //$scope.cover_name = response.name;

        $scope.post_data = [];

        $scope.datetime = $("#datepicker").val();
        $scope.title = $("#title").val();
        $scope.desc = $("textarea#description").val();

        $scope.post_data.push({
          article_name: $scope.title, date_time: $scope.datetime, desc: $scope.desc
        });

        $scope.promise = $http.post('api/add_gallery', {payload: $scope.post_data}).then(function(response){
          //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
          //NProgress.done();
          //console.log(response);
          $location.path("/gallery/");
        }, function(response){
          console.log(response);
          callNotification('Something went wrong. Please try again. But we have noted the error','error');
          //NProgress.done();
        })
        //$scope.post_data = [];
    };

    console.info('uploader', uploader);

    $rootScope.hide_it = false;
    $(".container").css("display", "block");

});
