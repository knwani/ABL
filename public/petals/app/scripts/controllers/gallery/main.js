'use strict';

/**
 * @ngdoc function
 * @name petalsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the petalsApp
 */
angular.module('petalsApp').controller('GalleryCtrl', function ($scope, $http, myDateService, $rootScope) {

  $scope.articles = [];

  $rootScope.url_id = '9';

  $scope.loadArticles = function (){

    $scope.promise = $http.get('api/get_gallery').then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      $scope.articles = response.data.articles;
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
        content: 'Are you sure you want to delete this folder?',
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

                  $scope.promise = $http.post('api/delete_gallery', {payload: $scope.post_data}).then(function(response){
                    callNotification('Folder has been deleted','notice');
                    NProgress.done();
                    $scope.articles = response.data.articles;
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


angular.module('petalsApp').controller('EditGalleryCtrl', function ($scope, $http, myDateService, $routeParams, FileUploader, $rootScope, $sce) {

  $scope.article = [];

  $scope.folder = "";

  $scope.authors = [];

  $scope.pictures = '';

  $rootScope.url_id = '9';

  $scope.article_cover = "";

  $scope.loadArticle = function (){

    $scope.post_data = [];

    $scope.post_data.push({
      article_id: $routeParams.galleryid
    });

    $scope.promise = $http.post('api/get_single_gallery', {payload: $scope.post_data}).then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      $scope.article = response.data.article;
      $scope.authors = response.data.authors;
      $scope.pictures = response.data.files;
      $scope.folder = response.data.folder;
      //$scope.article_cover = "http://abeautifullifebykenny.com/fem/gallery/" + $scope.article[0].cover;

      //$("#writer").trumbowyg('html', $scope.article[0].body);
      //$('#author option:eq(' + $scope.article[0].author + ')').prop('selected', true);
      //alert($("#author option:selected").val());
      console.log(response);
      //$location.path("/projects/" + response);
    }, function(response){
      console.log(response);
      //callNotification('Something went wrong. Please try again. But we have noted the error','error');
      //NProgress.done();
    })

  }

  $scope.trustAsHtml = function(html) {
      return $sce.trustAsHtml(html);
    }

    $scope.deleteFile = function(image_url, folder_name) {
        //alert(image_url);
        NProgress.start();

        $scope.post_data = [];

        $scope.post_data.push({
          image: image_url, folder: folder_name
        });

        $scope.promise = $http.post('api/delete_file', {payload: $scope.post_data}).then(function(response){
          NProgress.done();
          callNotification('Image has been deleted. :)','notice');
          //NProgress.done();
          console.log(response);
          $scope.loadArticle();
          //$location.path("/projects/" + response);
        }, function(response){
          console.log(response);
          callNotification('Something went wrong. Please try again. But we have noted the error :(','error');
          NProgress.done();
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

  $scope.showUploader = function (){
    //alert(contributor);
    $("#image").trigger("click");
  }


  $scope.editArticle = function (){

    NProgress.start();

    if(picturecount == 0){
      //var someText = "Hello, World!";
      //$("#writer").append("<span class='bez'>Balls</span>");
      //$('#writer span.bez').last().remove();
      //$scope.body = $("#writer").trumbowyg('html');

      //alert($scope.body);
      //alert($("#writer").trumbowyg('html'));
      $scope.title = $("#title").val();
      $scope.datetime = $("#datepicker").val();
      $scope.desc = $("textarea#description").val();

      $scope.post_data = [];

      $scope.post_data.push({
        article_name: $scope.title, datetime: $scope.datetime, description: $scope.desc, folder: $scope.folder, article_id: $routeParams.galleryid
      });

      $scope.promise = $http.post('api/edit_gallery', {payload: $scope.post_data}).then(function(response){
        NProgress.done();
        callNotification('This folder has been edited. :)','notice');
        //NProgress.done();
        console.log(response);

        //$location.path("/projects/" + response);
      }, function(response){
        console.log(response);
        callNotification('Something went wrong. Please try again. But we have noted the error :(','error');
        NProgress.done();
      })

    //callNotification('You need to select at least one picture', 'warning');
  }

  }

  var uploader = $scope.uploader = new FileUploader({
        url: 'api/edit_gallery_folder',
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
      //NProgress.start();
      //$scope.title = $("#title").val();
      //$scope.datetime = $("#datepicker").val();
      fileItem.url = "api/edit_gallery_folder?folder=" + $scope.folder;
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
        $scope.loadArticle();
        //$scope.cover_name = response.name;
        //$scope.post_data = [];
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
