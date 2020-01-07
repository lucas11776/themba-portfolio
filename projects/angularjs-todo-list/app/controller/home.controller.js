app.controller('homeController', function ($scope, database) {

    // initialize controller
    init();

    function init() {
        $scope.list = database.getDB();
    }

});