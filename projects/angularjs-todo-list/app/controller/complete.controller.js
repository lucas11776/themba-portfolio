app.controller('completeController', function ($scope, database) {

    // initialize controller
    init();

    function init() {
        $scope.list = database.getDone();
    }

    $scope.delete = function (index) {
        database.deleteDoneId(index);
        init();
    }

});