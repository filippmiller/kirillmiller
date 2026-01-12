jQuery(document).ready(function ($) {

    var buttons = jQuery('.ttrbutton').prev('input');

    for (var i = 0; i < buttons.length; i++) {
        var slideimg = jQuery("#ttr_slide_show_image" + i).val();
        var horizontal = jQuery("#ttr_horizontal_align" + i).parent().parent();
        var vertical = jQuery("#ttr_vertical_align" + i).parent().parent();
        var stretch = jQuery("#ttr_stretch" + i).parent().parent();

        if (slideimg == "") {
            horizontal.css("display", "none");
            vertical.css("display", "none");
            stretch.css("display", "none");
        }

    }


    var uploadID = ''; /*setup the var*/

    jQuery('.ttrbutton').click(function () {
        uploadID = $(this).prev('input'); /*grab the specific input*/
        formfield = $('.upload').attr('name');
        tb_show('Upload', 'media-upload.php?referer=functions.php&amp;type=image&amp;TB_iframe=true&amp;post_id=0', false);
        return false;
    });



    window.send_to_editor = function (html) {
        imgurl = $('img', html).attr('src');
        uploadID.val(imgurl); /*assign the value to the input*/

        tb_remove();
        $('#button').trigger('click');

        var horizontal = uploadID.parent().parent().next('tr');
        var vertical = uploadID.parent().parent().next('tr').next('tr');
        var stretch = uploadID.parent().parent().next('tr').next('tr').next('tr');

        if (uploadID.val() != "") {
            horizontal.css("display", "");
            vertical.css("display", "");
            stretch.css("display", "");
        }

    };

    for (var j = 0; j < buttons.length; j++) {
        jQuery("#ttr_slide_show_image" + j).change(function () {
            //alert("text changed");											

            var horiz = jQuery(this).parent().parent().next('tr');
            var vertiz = jQuery(this).parent().parent().next('tr').next('tr');
            var stretchz = jQuery(this).parent().parent().next('tr').next('tr').next('tr');

            if (jQuery(this).val() != "") {
                horiz.css("display", "");
                vertiz.css("display", "");
                stretchz.css("display", "");
            }
            else {
                horiz.css("display", "none");
                vertiz.css("display", "none");
                stretchz.css("display", "none");
            }

        });
    }

});