'use strict';

/**
 * @ngdoc overview
 * @name petalsApp
 * @description
 * # petalsApp
 *
 * Main module of the application.
 */
angular
  .module('petalsApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'angular-jwt',
    'ngStorage',
    'ngTouch',
    'angularFileUpload'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/purposes/new', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'New Article',
        templateUrl: 'views/purposes/new.html',
        controller: 'NewPurposeCtrl'
      })
      .when('/purposes/edit/:purposeid', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Edit Article',
        templateUrl: 'views/purposes/edit.html',
        controller: 'EditPurposeCtrl'
      })
      .when('/purposes', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Purposes',
        templateUrl: 'views/purposes/main.html',
        controller: 'PurposesCtrl'
      })
      .when('/feminique-woman', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Femique Woman',
        templateUrl: 'views/feminique/main.html',
        controller: 'FeminiqueCtrl'
      })
      .when('/feminique-woman/edit/:purposeid', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Edit Article',
        templateUrl: 'views/feminique/edit.html',
        controller: 'EditFeminiqueCtrl'
      })
      .when('/feminique-woman/new', {
        templateUrl: 'views/feminique/new.html',
        controller: 'NewFeminiqueCtrl'
      })
      .when('/unique-man', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Unique Man',
        templateUrl: 'views/unique/main.html',
        controller: 'UniqueCtrl'
      })
      .when('/unique-man/edit/:purposeid', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Edit Article',
        templateUrl: 'views/unique/edit.html',
        controller: 'EditUniqueCtrl'
      })
      .when('/unique-man/new', {
        templateUrl: 'views/unique/new.html',
        controller: 'NewUniqueCtrl'
      })
      .when('/unique-man/new-video', {
        templateUrl: 'views/unique/new_video.html',
        controller: 'NewUniqueVideoCtrl'
      })
      .when('/ask-kenny', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Ask Kenny',
        templateUrl: 'views/ask-kenny/main.html',
        controller: 'AskKennyCtrl'
      })
      .when('/contributors', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Contributors',
        templateUrl: 'views/contributors/main.html',
        controller: 'ContributorsCtrl'
      })
      .when('/gallery', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Gallery',
        templateUrl: 'views/gallery/main.html',
        controller: 'GalleryCtrl'
      })
      .when('/ask-kenny/edit/:purposeid', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Edit Question',
        templateUrl: 'views/ask-kenny/edit.html',
        controller: 'EditAskKennyCtrl'
      })
      .when('/events', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Events',
        templateUrl: 'views/events/main.html',
        controller: 'EventsCtrl'
      })
      .when('/events/edit/:purposeid', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Events',
        templateUrl: 'views/events/edit.html',
        controller: 'EditEventsCtrl'
      })
      .when('/events/new', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'New Event',
        templateUrl: 'views/events/new.html',
        controller: 'NewEventCtrl'
      })
      .when('/blog', {
        templateUrl: 'views/blog/main.html',
        controller: 'BlogCtrl'
      })
      .when('/blog/new', {
        templateUrl: 'views/blog/new.html',
        controller: 'NewBlogCtrl'
      })
      .when('/blog/edit/:purposeid', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        title: 'Edit Blog',
        templateUrl: 'views/blog/edit.html',
        controller: 'EditBlogCtrl'
      })
      .when('/covers', {
        templateUrl: 'views/covers/main.html',
        controller: 'CoversCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .when('/login', {
        templateUrl: 'views/login.html',
        controller: 'LoginCtrl'
      })
      .otherwise({
        redirectTo: '/purposes'
      });
  }).run(function ($rootScope, $location, $localStorage, $http, jwtHelper) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            //Data.get('session').then(function (results) {
                if ($localStorage.token != null) {
                  var bool = jwtHelper.isTokenExpired($localStorage.token);
                  if(bool == true){ //token has expired
                    $location.path("/login");
                  } else {
                    var tokenPayload = jwtHelper.decodeToken($localStorage.token);
                    $rootScope.uid = tokenPayload.data.userId;
                    $rootScope.email = tokenPayload.data.email;
                    $rootScope.authenticated = true;
                  }
                  //we have token, send to server for authentication
                } else {
                  $location.path("/login");
                    /*var nextUrl = next.$route.originalPath;
                    if (nextUrl == '/signup' || nextUrl == '/login') {

                    } else {
                        $location.path("/login");
                    }*/
                }
            //});
        });
    });
