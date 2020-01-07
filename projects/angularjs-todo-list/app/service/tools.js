app.service('tools', function () {

    var months = [
        'Janaury', 'Febuary', 'March', 'Apri', 'May',
        'June', 'July', 'August', 'September', 'October', 'November', 'December'
    ];

    // c
    var cleanHours = function (hours) {
        if (typeof hours != 'number') return false;
        if(hours > 12) hours -= 11;
        if(hours == 0) hours = 1;
        return hours;
    }

    var day = function (hours) {
        if(typeof hours != 'number') return false;
        if(hours > 11) return 'PM';
        return 'AM';
    }

    this.currentTime = function () {
        var date = new Date();
        var time = cleanHours(date.getHours()) + ':' + date.getMinutes() + day(date.getHours()) + ' ';
        time += date.getDate() + '-' + months[date.getMonth()] + '-' + date.getFullYear();
        return time;
    }

});