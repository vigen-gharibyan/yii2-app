'use strict';

var controllers = angular.module('controllers', []);

controllers.controller('MainController', ['$scope', '$location', '$window', 'flash',
    function ($scope, $location, $window, flash) {
        $scope.flash = flash;
        $scope.loggedIn = function() {
            return Boolean($window.sessionStorage.access_token);
        };

        $scope.logout = function () {
            delete $window.sessionStorage.access_token;
            $location.path('/login').replace();
        };
    }
]);

controllers.controller('ContactController', ['$scope', '$http', '$window',
    function($scope, $http, $window) {
        $scope.captchaUrl = 'site/captcha';
        $scope.contact = function () {
            $scope.submitted = true;
            $scope.error = {};
            $http.post('api/default/contact', $scope.contactModel).success(
                function (data) {
                    $scope.contactModel = {};
                    $scope.flash = data.flash;
                    $window.scrollTo(0,0);
                    $scope.submitted = false;
                    $scope.captchaUrl = 'site/captcha' + '?' + new Date().getTime();
            }).error(
                function (data) {
                    angular.forEach(data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
            );
        };

        $scope.refreshCaptcha = function() {
            $http.get('site/captcha?refresh=1').success(function(data) {
                $scope.captchaUrl = data.url;
            });
        };
    }
]);

controllers.controller('DashboardController', ['$scope', '$http',
    function ($scope, $http) {
        $http.get('api/default/dashboard').success(function (data) {
           $scope.dashboard = data;
        })
    }
]);

controllers.controller('LoginController', ['$scope', '$http', '$window', '$location', 'flash',
    function($scope, $http, $window, $location, flash) {
        $scope.login = function () {
            $scope.submitted = true;
            $scope.error = {};
            $http.post('api/default/login', $scope.userModel).success(
                function (data) {
                    $window.sessionStorage.access_token = data.access_token;
                    $location.path('/dashboard').replace();
            }).error(
                function (data) {
                    angular.forEach(data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
            );
        };
    }
]);

controllers.controller('SignupController', ['$scope', '$http', '$window', '$location', 'flash',
    function($scope, $http, $window, $location, flash) {
        $scope.login = function () {
            $scope.submitted = true;
            $scope.error = {};
            $http.post('api/default/signup', $scope.userModel).success(
                function (data) {
                    if(data.success == true) {
                        flash.set(data.flash);
                        $location.path('/login').replace();
                        $window.scrollTo(0,0);
                    }
            }).error(
                function (data) {
                    angular.forEach(data, function (error) {
                        $scope.error[error.field] = error.message;
                    });
                }
            );
        };
    }
]);
