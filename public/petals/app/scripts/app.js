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
    'ngTouch'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/new-purpose', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        templateUrl: 'views/purposes/new.html',
        controller: 'NewPurposeCtrl'
      })
      .when('/purposes', {
        //templateUrl: 'views/main.html',
        //controller: 'MainCtrl'
        templateUrl: 'views/purposes/main.html',
        controller: 'PurposesCtrl'
      })
      .when('/new-feminique', {
        templateUrl: 'views/feminique/new.html',
        controller: 'NewFeminiqueCtrl'
      })
      .when('/new-blog', {
        templateUrl: 'views/blog/new.html',
        controller: 'NewBlogCtrl'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      })
      .otherwise({
        redirectTo: '/purposes'
      });
  });
