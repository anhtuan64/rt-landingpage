


/*  [ Function: On Change of Custom Post Type select box (custom post type slide widget) ]
- - - - - - - - - - - - - - - - - - - - */
function custom_post_type_slide_custom_type( obj ) {
	var $ = jQuery,
		parent = obj.parent().parent(),
		custom_type = obj.val();
	if ( custom_type != null || custom_type != 'undefined' && custom_type != '' ) {
		$.ajax({
			type: "GET",
			url: AvadaParams.ajaxurl,
			dataType: 'html',
			data: ({ action: 'rt_custom_post_type_slide_custom_type', custom_type: custom_type }),
			success: function( data ) {
				$('.rt-custom-post-type-slide-taxonomy', parent).html(data);
			}			
		});
	}
}

/*  [ Function: On Change of taxonomy select box (custom post type slide widget) ]
- - - - - - - - - - - - - - - - - - - - */
function custom_post_type_slide_taxonomy( obj ){
	var $ = jQuery,
		parent = obj.parent().parent(),
		taxonomy = obj.val();
	if ( taxonomy != null || taxonomy != 'undefined' && taxonomy != '' ) {
		$.ajax({
			type: "GET",
			url: AvadaParams.ajaxurl,
			dataType: 'html',
			data: ({ action: 'rt_custom_post_type_slide_taxonomy', taxonomy: taxonomy }),
			success: function( data ) {
				$('.rt-custom-post-type-slide-category', parent).html(data);
			}			
		});
	}
}

/*  [ Button upload image on admin ]
- - - - - - - - - - - - - - - - - - - - */
jQuery(document).ready(function($) {
    $(document).on("click", ".upload_image_button", function() {

        jQuery.data(document.body, 'prevElement', $(this).prev());

        window.send_to_editor = function(html) {
            var imgurl = jQuery(html).attr('src');
            var inputText = jQuery.data(document.body, 'prevElement');

            if(inputText != undefined && inputText != '')
            {
                inputText.val(imgurl);
            }

            tb_remove();
        };

        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        return false;
    });
});