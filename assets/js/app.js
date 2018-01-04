//Font Awesome requirement
var fa = require('fontawesome');

// loads the jquery package from node_modules
var $ = require('jquery');

$(document).ready(function() {
    $('#edit-preferences').click(function() {
        $('#edit-preferences-modal').addClass('is-active');
    });

    $('.modal-close').click(function(element) {
        var parentModal = $('.modal-close').closest('div').parent('div').removeClass('is-active');
    });

    $('.notification-close').click(function(element) {
        console.log($('.notification-close').closest('div').parent('div'));
        var parentModal = $('.notification-close').closest('div').parent('div').hide();
    });
});