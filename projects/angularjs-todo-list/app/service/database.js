app.service('database', function () {

    var scope = this;

    var defaultDB = {
        done: [],
        wait: []
    };

    // initialize database
    init();

    function init(){
        if (window.sessionStorage.getItem('database') == null) {
            window.sessionStorage.setItem('database', JSON.stringify(defaultDB));
        }
    }

    // update database
    this.updateDB = function (db) {
        if(typeof db != 'object') return false;
        db = JSON.stringify(db);
        return window.sessionStorage.setItem('database', db);
    }

    // get database
    this.getDB = function () {
        var db = window.sessionStorage.getItem('database');
        return JSON.parse(db);
    }

    // get done list
    this.getDone = function () {
        var db = scope.getDB();
        return db.done;
    }

    // get single tesk by index
    this.getDoneId = function (index) {
        var db = scope.getDB();
        return db.done[index];
    }

    // delete single tesk bu index
    this.deleteDoneId = function (index) {
        var db = scope.getDB();
        db.done.splice(index, 1);
        return scope.updateDB(db);
    }

    // get wait list
    this.getWait = function () {
        var db = scope.getDB();
        return db.wait;
    }

    // get single tesk by index
    this.getWaitId = function (index) {
        var db = scope.getDB();
        return db.wait[index];
    }

    // delete single tesk by index
    this.deleteWaitId = function (index) {
        var db = scope.getDB();
        db.wait.splice(index, 1);
        return scope.updateDB(db);
    }

    // add tesk to wait list
    this.addWaitList = function (tesk) {
        if (typeof tesk != 'object') return false;
        var db = scope.getDB();
        db.wait.push(tesk);
        return scope.updateDB(db);
    }

    // add tesk done list
    this.addDoneList = function(tesk){
        if(typeof tesk != 'object') return false;
        var db = scope.getDB();
        db.done.push(tesk);
        return scope.updateDB(db);
    }

    // move tesk form WaitList to Done List
    this.teskDone = function (index) {
        var db = scope.getDB();
        var tesk = db.wait.splice(index, 1)[0];
        scope.updateDB(db);
        return scope.addDoneList(tesk);
    }

});
