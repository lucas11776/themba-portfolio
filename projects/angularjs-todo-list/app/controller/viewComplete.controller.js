app.controller('viewCompleteController', function ($scope, $routeParams, database) {

    $scope.moved = false;

    // initialize controller
    init();

    function init() {
        $scope.list = $routeParams.list;
        switch ($routeParams.list) {
            case 'uncomplete':
                $scope.item = database.getWaitId($routeParams.id);
                break;
            case 'complete':
                $scope.item = database.getDoneId($routeParams.id);
                break;
            default:
                $scope.item = false;
        }

        if (typeof $scope.item != 'object') $scope.item = false;
    }

    $scope.delete = function () {
        switch ($routeParams.list) {
            case 'uncomplete':
                database.deleteWaitId($routeParams.id);
                $scope.moved = true;
                break;
            case 'complete':
                database.deleteDoneId($routeParams.id);
                $scope.moved = true;
            default:
                break;
        }
    }

    $scope.complete = function () {
        database.teskDone($routeParams.id);
        $scope.moved = true;
    }

});