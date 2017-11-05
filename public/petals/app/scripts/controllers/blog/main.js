'use strict';

/**
 * @ngdoc function
 * @name petalsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the petalsApp
 */
angular.module('petalsApp').controller('BlogCtrl', function ($scope, $http, myDateService, $rootScope) {

  $scope.articles = [];

  $rootScope.url_id = '6';

  $scope.loadArticles = function (){

    $scope.promise = $http.get('api/get_blog').then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      $scope.articles = response.data.blogs;
      console.log(response);
      //$location.path("/projects/" + response);
    }, function(response){
      console.log(response);
      //callNotification('Something went wrong. Please try again. But we have noted the error','error');
      //NProgress.done();
    })

  }

  $scope.loadArticles();

  $scope.getDateOnly = myDateService.getDateOnly;

  $scope.deleteArticle = function (id, $event){
    //$event.stopPropagation();
    $event.preventDefault();
    $.confirm({
        title: 'Confirm!',
        content: 'Are you sure you want to delete this article?',
        buttons: {
              somethingElse: {
                text: 'Yes',
                btnClass: 'btn-blue',
                keys: ['enter', 'shift'],
                action: function(){
                  NProgress.start();
                  $scope.post_data = [];

                  $scope.post_data.push({
                    article_id: id
                  });

                  $scope.promise = $http.post('api/delete_blog', {payload: $scope.post_data}).then(function(response){
                    callNotification('Article has been deleted','notice');
                    NProgress.done();
                    $scope.articles = response.data.blogs;
                    //console.log(response);
                  }, function(response){
                    //console.log(response);
                    callNotification('Something went wrong. Please try again. But we have noted the error','error');
                    NProgress.done();
                  })
                  //window.location.href = "/email-lists/delete/" + id;
                }
            },
            cancel: function () {
                //$.alert('Canceled!');
            }
        }
    });
  }

  $rootScope.hide_it = false;
  $(".container").css("display", "block");

});


angular.module('petalsApp').controller('EditBlogCtrl', function ($scope, $http, myDateService, $routeParams, FileUploader, $rootScope) {

  $scope.article = [];

  $scope.authors = [];

  $rootScope.url_id = '6';

  $scope.article_cover = "";

  $scope.loadArticle = function (){

    $scope.post_data = [];

    $scope.post_data.push({
      article_id: $routeParams.purposeid
    });

    $scope.promise = $http.post('api/get_single_blog', {payload: $scope.post_data}).then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      $scope.article = response.data.article;
      $scope.authors = response.data.authors;
      //$scope.article_cover = "http://localhost:8080/fem/" + $scope.article[0].cover;

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

    if ($("#title").val() != ""){
      NProgress.start();

      //var someText = "Hello, World!";
      //$("#writer").append("<span class='bez'>Balls</span>");
      //$('#writer span.bez').last().remove();
      $scope.title = $("#title").val();
      $scope.body = $("#writer").trumbowyg('html');
      //$scope.sade = $("textarea#sade").val();

      $scope.post_data = [];

      $scope.post_data.push({
        title: $scope.title, body: $scope.body, article_id: $routeParams.purposeid
      });

      $scope.promise = $http.post('api/edit_blog', {payload: $scope.post_data}).then(function(response){
        NProgress.done();
        callNotification('Article has been edited. :)','notice');
        //NProgress.done();
        console.log(response);
        //$location.path("/projects/" + response);
      }, function(response){
        console.log(response);
        callNotification('Something went wrong. Please try again. But we have noted the error :(','error');
        NProgress.done();
      })
    } else {
      callNotification('You need to include an article title :(','error');
    }


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
