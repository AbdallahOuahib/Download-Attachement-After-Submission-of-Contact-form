/**
 * Load media uploader on pages with our custom metabox
 */
jQuery(function($){
    /*
     * Select/Upload image(s) event
     */
    $('body').on('click', '.media_upload_file_button', function(e){
        e.preventDefault();

            var button = $(this),
                custom_uploader = wp.media({
            title: 'Insert File',
            library : {
                // uncomment the next line if you want to attach image to the current post
                 uploadedTo : wp.media.view.settings.post.id, 
                //type : 'image'
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: false // for multiple image selection set to true
        }).on('select', function() { // it also has "open" and "close" events 
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            console.log(attachment);
            if(attachment.type == 'image'){
                $(button).removeClass('button').html(
                    '<img class="true_pre_image" src="' + attachment.url + '" style="width:150px"/>'
                    ).next().val(attachment.id).next().show();
            }
            else {
                $(button).removeClass('button').html(
                    'Name : '+attachment.title
                    ).next().val(attachment.id).next().show();
            }
            
        })
        .open();
    });

    /*
     * Remove image event
     */
    $('body').on('click', '.media_remove_image_button', function(){
        $(this).hide().prev().val('').prev().addClass('button').html('Upload File');
        return false;
    });

});