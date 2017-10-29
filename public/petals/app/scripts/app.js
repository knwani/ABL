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
