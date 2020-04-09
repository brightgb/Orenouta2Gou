document.addEventListener("DOMContentLoaded", function toggleNav() {
    var body = document.body;
    var hamburger = document.getElementById('js-hamburger');
    var blackBg = document.getElementById('js-black-bg');
    var elem = document.getElementById("acordion");

    hamburger.addEventListener('click', function() {
        body.classList.toggle('nav-open');
    });

    blackBg.addEventListener('click', function() {
        body.classList.remove('nav-open');
        elem.classList.remove('show');
        elem.classList.add('hide')
    });
});

function func1() {
    var elem1 = document.getElementById('acordion');
    var elem2 = document.getElementById('yohaku');
    var elem3 = document.getElementById('omake_kigou');

    if (elem1.classList == 'hide') {
        elem2.classList.add('yohaku');
        elem3.classList.remove('omake1');
        elem3.classList.add('omake2');
    }
    else if (elem1.classList == 'show') {
        elem2.classList.remove('yohaku');
        elem3.classList.remove('omake2');
        elem3.classList.add('omake1');
    }

    elem1.classList.toggle('show');
    elem1.classList.toggle('hide');
}