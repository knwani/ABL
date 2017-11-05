'use strict';

/**
 * @ngdoc function
 * @name petalsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the petalsApp
 */
angular.module('petalsApp').controller('CoversCtrl', function ($scope, $http, myDateService, $rootScope, FileUploader) {

  $scope.articles = [];

  //http://localhost:8080
  $scope.main_cover = "http://abeautifullifebykenny.com/images/beautiful_bg.png";
  $scope.second_cover = "http://abeautifullifebykenny.com/images/second_beautiful_bg.png";

  $rootScope.url_id = '7';

  $scope.loadArticles = function (){

    $scope.promise = $http.get('api/get_questions').then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      $scope.articles = response.data.questions;
      console.log(response);
      //$location.path("/projects/" + response);
    }, function(response){
      console.log(response);
      //callNotification('Something went wrong. Please try again. But we have noted the error','error');
      //NProgress.done();
    })

  }

  //$scope.loadArticles();

  var uploader = $scope.uploader = new FileUploader({
            url: 'api/edit_first_cover',
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
            $scope.main_cover = response.link;
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


        var second_uploader = $scope.second_uploader = new FileUploader({
                  url: 'api/edit_second_cover',
                  autoUpload: true
              });

              // FILTERS
              // a sync filter
              second_uploader.filters.push({
                  name: 'syncFilter',
                  fn: function(item /*{File|FileLikeObject}*/, options) {
                      console.log('syncFilter');
                      return this.queue.length < 10;
                  }
              });

              // an async filter
              second_uploader.filters.push({
                  name: 'asyncFilter',
                  fn: function(item /*{File|FileLikeObject}*/, options, deferred) {
                      console.log('asyncFilter');
                      setTimeout(deferred.resolve, 1e3);
                  }
              });

              // CALLBACKS

              second_uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
                  console.info('onWhenAddingFileFailed', item, filter, options);
              };
              second_uploader.onAfterAddingFile = function(fileItem) {
                  NProgress.start();
                  console.info('onAfterAddingFile', fileItem);
              };
              second_uploader.onAfterAddingAll = function(addedFileItems) {
                  console.info('onAfterAddingAll', addedFileItems);
              };
              second_uploader.onBeforeUploadItem = function(item) {
                  console.info('onBeforeUploadItem', item);
              };
              second_uploader.onProgressItem = function(fileItem, progress) {
                  console.info('onProgressItem', fileItem, progress);
              };
              second_uploader.onProgressAll = function(progress) {
                  console.info('onProgressAll', progress);
              };
              second_uploader.onSuccessItem = function(fileItem, response, status, headers) {
                  console.info('onSuccessItem', fileItem, response, status, headers);
                  //console.log(response.link);
                  NProgress.done();
                  $scope.second_cover = response.link;
              };
              second_uploader.onErrorItem = function(fileItem, response, status, headers) {
                  console.info('onErrorItem', fileItem, response, status, headers);
              };
              second_uploader.onCancelItem = function(fileItem, response, status, headers) {
                  console.info('onCancelItem', fileItem, response, status, headers);
              };
              second_uploader.onCompleteItem = function(fileItem, response, status, headers) {
                  console.info('onCompleteItem', fileItem, response, status, headers);
              };
              second_uploader.onCompleteAll = function() {
                  console.info('onCompleteAll');
              };

              console.info('second_uploader', second_uploader);

              $rootScope.hide_it = false;
              $(".container").css("display", "block");

});


angular.module('petalsApp').controller('EditAskKennyCtrl', function ($scope, $http, myDateService, $routeParams, FileUploader, $rootScope) {

  $scope.article = [];

  $scope.authors = [];

  $rootScope.url_id = '4';

  $scope.article_cover = "";

  $scope.loadArticle = function (){

    $scope.post_data = [];

    $scope.post_data.push({
      article_id: $routeParams.purposeid
    });

    $scope.promise = $http.post('api/get_single_question', {payload: $scope.post_data}).then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      $scope.article = response.data.article;
      $scope.authors = response.data.authors;
      $scope.article_cover = "http://abeautifullifebykenny.com/fem/" + $scope.article[0].cover;

      $("#writer").trumbowyg('html', $scope.article[0].body);
      $('#author option:eq(' + $scope.article[0].author + ')').prop('selected', true);
      //alert($("#author option:selected").val());
      console.log(response);
      //$location.path("/projects/" + response);
    }, function(response){
      console.log(response);
      //callNotification('Something went wrong. Please try again. But we have noted the error','error');
      //NProgress.done();
    })

  }

  $scope.loadArticle();

  $scope.selectedAuthor = function (id){
    if (id == $scope.article[0].author){
      return "selected";
    }
  }

  $scope.selectedCategory = function (text){
    if (text == $scope.article[0].category){
      return "selected";
    }
  }

  angular.element(function () {
    //console.log('page loading completed');
    //$('#author option:eq(' + $scope.purpose[0].author + ')').prop('selected', true);
  });

  $scope.getDateOnly = myDateService.getDateOnly;

  $scope.editArticle = function (){

    NProgress.start();

    //var someText = "Hello, World!";
    //$("#writer").append("<span class='bez'>Balls</span>");
    //$('#writer span.bez').last().remove();
    $scope.kenny = $("textarea#kenny").val();
    $scope.ade = $("textarea#ade").val();
    $scope.sade = $("textarea#sade").val();

    $scope.post_data = [];

    $scope.post_data.push({
      kenny: $scope.kenny, ade: $scope.ade, sade: $scope.sade, article_id: $routeParams.purposeid
    });

    $scope.promise = $http.post('api/edit_question', {payload: $scope.post_data}).then(function(response){
      NProgress.done();
      callNotification('Responses have been edited. :)','notice');
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
            url: 'api/edit_unique_picture?id=' + $routeParams.purposeid,
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
            $scope.article_cover = response.link;
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

        $rootScope.hide_it = false;
        $(".container").css("display", "block");

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
