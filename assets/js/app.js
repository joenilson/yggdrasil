//Font Awesome requirement
var fa = require('fontawesome');

// loads the jquery package from node_modules
var $ = require('jquery');

var Bulma = require('bulmajs');

var flatpickr = require('flatpickr');

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

    /*
    var burger = document.querySelector('.navbar-burger');
    var menu = document.querySelector('.navbar-menu');
    if (menu !== null) {
        burger.addEventListener('click', function() {
            burger.classList.toggle('is-active');
            menu.classList.toggle('is-active');
        });
    }
    */
});