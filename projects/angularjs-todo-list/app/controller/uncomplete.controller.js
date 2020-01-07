app.controller('uncompleteController', function ($scope, database) {

    // initialize controller
    init();

    function init() {
        $scope.list = database.getWait();
    }

    $scope.delete = function (index) {
        database.deleteWaitId(index);
        init();
    }

});