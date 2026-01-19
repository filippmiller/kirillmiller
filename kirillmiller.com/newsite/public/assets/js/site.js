jQuery(document).ready(function () {
    // Wait for all gallery images to load before initializing
    function initGalleries() {
        jQuery('.nicegallery-block').each(function (i) {
            console.log(jQuery(this).attr('id'))
            t('#' + jQuery(this).attr('id'), {
                emptySpace: 25,
                // border: 'solid #570202  5px',
                // galleryColumns: true,
                // galleryMosaic: true,
                getDataSizeAtr: false,
                gridOptions: [
                    {screen: [400], items: 1},
                    {screen: [500], items: 2},
                    {screen: [767], items: 3},
                    {screen: [1380], items: 3},
                    {screen: [5000], items: 5},
                ],
            });
        });
    }

    // Wait for images to load before initializing gallery
    var $galleries = jQuery('.nicegallery-block');
    if ($galleries.length > 0) {
        var $images = $galleries.find('img');
        var totalImages = $images.length;
        var processedImages = 0;

        if (totalImages === 0) {
            initGalleries();
        } else {
            $images.each(function() {
                var img = this;
                var $img = jQuery(img);

                function checkComplete() {
                    processedImages++;
                    // Remove failed images (and their parent link) from DOM
                    if (img.naturalWidth === 0 || img.naturalHeight === 0) {
                        var $parent = $img.closest('a');
                        if ($parent.length) {
                            $parent.remove();
                        } else {
                            $img.remove();
                        }
                    }
                    if (processedImages === totalImages) initGalleries();
                }

                if (img.complete) {
                    checkComplete();
                } else {
                    $img.on('load', checkComplete);
                    $img.on('error', function() {
                        // Remove failed image and its parent link
                        var $parent = $img.closest('a');
                        if ($parent.length) {
                            $parent.remove();
                        } else {
                            $img.remove();
                        }
                        processedImages++;
                        if (processedImages === totalImages) initGalleries();
                    });
                }
            });
        }
    }

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
