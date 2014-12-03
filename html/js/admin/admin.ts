/// <reference path="../definitions/jquery.d.ts" />

class Admin {

    constructor() {
        var $pickers:JQuery= $('.datetimepicker');
        $pickers.datetimepicker();
    }
}

new Admin();

interface JQuery{
    datetimepicker():any;
}

