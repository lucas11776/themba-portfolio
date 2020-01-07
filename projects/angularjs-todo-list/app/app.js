var app = angular.module('toDoList', ['ngRoute']);

app.config(function ($locationProvider, $routeProvider) {

    $routeProvider
    .when('/', {
        templateUrl: './app/views/home.html',
        controller: 'homeController'
    })
    .when('/add', {
        templateUrl: './app/views/add.html',
        controller: 'addController'
    })
    .when('/complete', {
        templateUrl: './app/views/complete.html',
        controller: 'completeController'
    })
    .when('/uncomplete', {
        templateUrl: './app/views/uncomplete.html',
        controller: 'uncompleteController'
    })
    .when('/:list/:id', {
        templateUrl: './app/views/detail.html',
        controller: 'viewCompleteController'
    })
    .otherwise('/')

    // pretty url
    $locationProvider.html5Mode(true);
});