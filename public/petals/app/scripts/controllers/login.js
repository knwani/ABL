'use strict'


angular.module('petalsApp').controller('LoginCtrl', function ($scope, $http, $rootScope, $localStorage, $location) {


    $scope.email = "";
    $scope.password = "";

    $rootScope.hide_it = true;

    $scope.login = function(type, $event){
      if($scope.email == ""){
        callNotification("Enter your email", 'warning');
      } else if ($scope.password == ""){
        callNotification("Enter your password", 'warning');
      } else {
        //go to server
        //$http.post('api/login', {username: $scope.email, password: $scope.password}).success(function (data) {
          //$rootScope.invoice_designs = data;
          //alert($rootScope.invoice_designs);
        //});
        $scope.promise = $http.post('api/authenticate_user', {username: $scope.email, password: $scope.password}).then(function(response){
          //callNotification('Your project has been successfully created. Hang on, taking you to your project now','notice');
          //NProgress.done();
          $localStorage.token = response.data.token;
          $location.path("/purposes");
        }, function(response){
          callNotification('Sorry, wrong login details','error');
          //NProgress.done();
        })
      }
      //console.log(type);
    }

    $(".container").css("display", "block");

    $scope.sendInvoice = function(){
      callNotification("Can't create the invoice just yet. Some needed fields are still empty", 'notice');
    }

});
