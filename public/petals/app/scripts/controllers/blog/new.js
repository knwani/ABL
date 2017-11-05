'use strict';

/**
 * @ngdoc function
 * @name petalsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the petalsApp
 */
angular.module('petalsApp').controller('NewBlogCtrl', function ($scope, $http, $rootScope, $location) {

  $rootScope.url_id = '6';

  $scope.addBlog = function (){

    $scope.body = $("#writer").trumbowyg('html');
    $scope.title = $("#title").val();

    $scope.post_data = [];

    $scope.post_data.push({
      article_name: $scope.title, content: $scope.body, author: 1
    });

    $scope.promise = $http.post('api/add_blog', {payload: $scope.post_data}).then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      //console.log(response);
      $location.path("/blog/");
      //$location.path("/projects/" + response);
    }, function(response){
      //console.log(response);
      callNotification('Something went wrong. Please try again. But we have noted the error','error');
      //NProgress.done();
    })

  }

  $rootScope.hide_it = false;
  $(".container").css("display", "block");

});
