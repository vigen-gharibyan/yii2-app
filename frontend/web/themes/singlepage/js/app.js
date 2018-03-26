'use strict';

var app = angular.module('app', [
    'ngRoute',          //$routeProvider
    'mgcrea.ngStrap',   //bs-navbar, data-match-route directives
    'controllers'       //Our module frontend/web/js/controllers.js
]);

var basePath = 'themes/singlepage/views/partials/';

app.config(['$routeProvider', '$httpProvider',
    function($routeProvider, $httpProvider) {
        $routeProvider.
            when('/', {
                templateUrl: basePath +'site/index.html'
            }).
            when('/about', {
                templateUrl: basePath +'site/about.html'
            }).
            when('/contact', {
                templateUrl: basePath +'site/contact.html',
                controller: 'ContactController'
            }).
            when('/login', {
                templateUrl: basePath +'site/login.html',
                controller: 'LoginController'
            }).
            when('/signup', {
                templateUrl: basePath +'site/signup.html',
                controller: 'SignupController'
            }).
            when('/dashboard', {
                templateUrl: basePath +'site/dashboard.html',
                controller: 'DashboardController'
            }).
            otherwise({
                templateUrl: basePath +'site/404.html'
            });
        $httpProvider.interceptors.push('authInterceptor');
    }
]);

app.factory('authInterceptor', function ($q, $window, $location) {
    return {
        request: function (config) {
            if ($window.sessionStorage.access_token) {
                //HttpBearerAuth
                config.headers.Authorization = 'Bearer ' + $window.sessionStorage.access_token;
            }
            return config;
        },
        responseError: function (rejection) {
            if (rejection.status === 401) {
                $location.path('/login').replace();
            }
            return $q.reject(rejection);
        }
    };
});

app.factory('flash', function($rootScope) {
    var queue = {}, flash_data = null;

    $rootScope.$on('$routeChangeSuccess', function(value, event) {
        if (Object.getOwnPropertyNames(queue).length > 0) {
            flash_data = queue;
            queue = {};
        } else {
            flash_data = null;
        }
    });

    return {
        set: function(data) {
            queue = data;
        },
        get: function(data) {
            return flash_data;
        }
    };
});
