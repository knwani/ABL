'use strict';

/**
 * @ngdoc function
 * @name petalsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the petalsApp
 */
angular.module('petalsApp').controller('PurposesCtrl', function ($scope, $http, myDateService) {

  $scope.purposes = [];

  $scope.loadPurpose = function (){



    $scope.promise = $http.get('api/get_purposes').then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      $scope.purposes = response.data.purposes;
      console.log(response);
      //$location.path("/projects/" + response);
    }, function(response){
      console.log(response);
      //callNotification('Something went wrong. Please try again. But we have noted the error','error');
      //NProgress.done();
    })

  }

  $scope.loadPurpose();

  $scope.getDateOnly = myDateService.getDateOnly;

});


angular.module('petalsApp').controller('EditPurposeCtrl', function ($scope, $http, myDateService, $routeParams, FileUploader) {

  $scope.purpose = [];

  $scope.authors = [];

  $scope.purpose_cover = "";

  $scope.loadPurpose = function (){

    $scope.post_data = [];

    $scope.post_data.push({
      article_id: $routeParams.purposeid
    });

    $scope.promise = $http.post('api/get_purpose', {payload: $scope.post_data}).then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      $scope.purpose = response.data.purpose;
      $scope.authors = response.data.authors;
      $scope.purpose_cover = "http://localhost:8080/tenets/" + $scope.purpose[0].cover;

      $("#writer").trumbowyg('html', $scope.purpose[0].content);
      $('#author option:eq(' + $scope.purpose[0].author + ')').prop('selected', true);
      //alert($("#author option:selected").val());
      console.log(response);
      //$location.path("/projects/" + response);
    }, function(response){
      console.log(response);
      //callNotification('Something went wrong. Please try again. But we have noted the error','error');
      //NProgress.done();
    })

  }

  $scope.loadPurpose();

  $scope.selectedAuthor = function (id){
    if (id == $scope.purpose[0].author){
      return "selected";
    }
  }

  $scope.selectedCategory = function (text){
    if (text == $scope.purpose[0].category){
      return "selected";
    }
  }

  angular.element(function () {
    //console.log('page loading completed');
    //$('#author option:eq(' + $scope.purpose[0].author + ')').prop('selected', true);
  });

  $scope.getDateOnly = myDateService.getDateOnly;

  $scope.editPurpose = function (){

    NProgress.start();

    //var someText = "Hello, World!";
    //$("#writer").append("<span class='bez'>Balls</span>");
    //$('#writer span.bez').last().remove();
    $scope.body = $("#writer").trumbowyg('html');

    //alert($scope.body);
    //alert($("#writer").trumbowyg('html'));
    $scope.title = $("#title").val();
    $scope.category = $("#category option:selected").text();
    $scope.author = $("#author option:selected").val();;

    $scope.post_data = [];

    $scope.post_data.push({
      article_name: $scope.title, content: $scope.body, author: $scope.author, tenet_id: $routeParams.purposeid, category: $scope.category
    });

    $scope.promise = $http.post('api/edit_purpose', {payload: $scope.post_data}).then(function(response){
      NProgress.done();
      callNotification('This article has been edited. :)','notice');
      //NProgress.done();
      console.log(response);
      //$location.path("/projects/" + response);
    }, function(response){
      console.log(response);
      callNotification('Something went wrong. Please try again. But we have noted the error :(','error');
      NProgress.done();
    })

  }

  var uploader = $scope.uploader = new FileUploader({
            url: 'api/edit_picture?id=' + $routeParams.purposeid,
            autoUpload: true
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
          NProgress.start();
            console.info('onAfterAddingFile', fileItem);
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function(item) {
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
            NProgress.done();
            $scope.purpose_cover = response.link;
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
        };

        console.info('uploader', uploader);

});


angular.module('petalsApp').factory('myDateService', function () {
      return {
          getDateOnly: function (UNIX_timestamp) {
              var a = new Date(UNIX_timestamp * 1000);
              var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
              var year = a.getFullYear();
              var month = months[a.getMonth()];
              var date = a.getDate();
              var hour = a.getHours();
              var min = a.getMinutes();
              var sec = a.getSeconds();

              var ampm = hour >= 12 ? 'pm' : 'am';

              min = min < 10 ? '0' + min : min;

              hour = hour % 12;

              var time = date + ' ' + month + ' ' + year;// + ' ' + hour + ':' + min + ampm; // + ':' + sec ;
              var time = date + ' ' + month + ' ' + year + ' - ' + hour + ':' + min + ampm; // + ':' + sec ;
              return time;
          }
      }
});
