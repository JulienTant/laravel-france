"use strict";


module.exports = function (moment) {
    var momentifys = document.getElementsByClassName('momentify');
    if (momentifys.length) {
        var momentifyAllTheThings = function () {
            for (var momentifyMe in momentifys) {
                if (momentifys.hasOwnProperty(momentifyMe)) {
                    momentifys[momentifyMe].innerHTML = moment(momentifys[momentifyMe].dataset.date).fromNow();
                }
            }
        };
        momentifyAllTheThings();
        setInterval(momentifyAllTheThings, 10000);
    }
};