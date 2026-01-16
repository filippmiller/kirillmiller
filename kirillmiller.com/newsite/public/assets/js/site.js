jQuery(document).ready(function () {
    jQuery('.nicegallery-block').each(function (i) {
        console.log(jQuery(this).attr('id'))
        t('#' + jQuery(this).attr('id'), {
            emptySpace: 25,
            // border: 'solid #570202  5px',
            // galleryColumns: true,
            // galleryMosaic: true,
            getDataSizeAtr: true,
            gridOptions: [
                {screen: [400], items: 1},
                {screen: [500], items: 2},
                {screen: [767], items: 3},
                {screen: [1380], items: 3},
                {screen: [5000], items: 5},
            ],
        });
    });

    $('.slick-main').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true,
        autoplay: true,
        autoplaySpeed: 2500,
        arrows: false,
    });

    $('#mobile-menu-button').click(function () {
        $('#mobile-menu-show').toggle(500)
        return false
    })

});
