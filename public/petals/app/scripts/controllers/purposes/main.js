'use strict';

/**
 * @ngdoc function
 * @name petalsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the petalsApp
 */
angular.module('petalsApp').controller('PurposesCtrl', function ($scope, $http) {

  $scope.purposes = [];

  $scope.loadPurposes = function (){

    $scope.body = $("#writer").trumbowyg('html');
    $scope.title = $("#title").val();

    $scope.post_data = [];

    $scope.post_data.push({
      article_name: $scope.title, content: $scope.body, author: 1
    });

    $scope.promise = $http.get('api/get_purpose', {payload: $scope.post_data}).then(function(response){
      //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
      //NProgress.done();
      $scope.purposes = response.data;
      console.log(response);
      //$location.path("/projects/" + response);
    }, function(response){
      console.log(response);
      //callNotification('Something went wrong. Please try again. But we have noted the error','error');
      //NProgress.done();
    })

  }

  $scope.loadPurposes();

});
