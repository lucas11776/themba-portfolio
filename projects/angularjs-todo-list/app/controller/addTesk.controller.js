app.controller('addController', function ($scope, tools, database) {

    $scope.addTesk = function (tesk) {
        tesk['time'] = tools.currentTime();
        database.addWaitList(tesk);
        $scope.added = true;
        $scope.reset();
    };

    $scope.reset = function () {
        $scope.tesk = null;
    };

    $scope.resetAdded = function () {
        $scope.added = false;
    };

});