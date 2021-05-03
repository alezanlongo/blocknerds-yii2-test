$(document).ready(() => {

    $('#checkbox').change(function () {
        setInterval(() => {
            moveRight();
        }, 3000);
    });

    var slideCount = $('#slider ul li').length;
    var slideWidth = $('#slider ul li').width();
    var slideHeight = $('#slider ul li').height();
    var sliderUlWidth = slideCount * slideWidth;

    $('#slider').css({ width: slideWidth, height: slideHeight });

    $('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });

    $('#slider ul li:last-child').prependTo('#slider ul');

    const moveLeft = () => {
        $('#slider ul').animate({
            left: + slideWidth
        }, 200, () => {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    const moveRight = () => {
        $('#slider ul').animate({
            left: - slideWidth
        }, 200, () => {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    $('a.control_prev').click(() => {
        moveLeft();
    });

    $('a.control_next').click(() => {
        moveRight();
    });

});
