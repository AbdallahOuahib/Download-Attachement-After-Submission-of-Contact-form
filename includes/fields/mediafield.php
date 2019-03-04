<?php 

function media_image_uploader_field( $name, $value = '') {
    $image = ' button">Attach File';
    $image_size = 'thumbnail'; // it would be better to use thumbnail size here (150x150 or so)
    $display = 'none'; // display state ot the "Remove image" button

    if( $file_url = wp_get_attachment_url( $value, $image_size ) ) {

        if(in_array(pathinfo($file_url)['extension'],array("png","jpg","jpeg"))) {
            $image = '"><img src="' . $file_url . '" style="width:50px"/>';
        }
        else {
            $image = '"><img src="'.plugins_url('../assets/img/file.png', __FILE__).'" style="width:50px"/>';
        }

        $display = 'inline-block';

    }

    return '<div>
        <a href="#" class="media_upload_file_button'.$image.'</a>
        <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
        <a href="#" class="media_remove_image_button" style="display:'.$display.';">Remove</a>
    </div>';


}

/*
 * Add a meta box
 */
add_action( 'admin_menu', 'media_meta_box_add' );

function media_meta_box_add() {
    add_meta_box('mediadiv', // meta box ID
        'More settings', // meta box title
        'media_print_box', // callback function that prints the meta box HTML 
        'post', // post type where to add it
        'normal', // priority
        'high' ); // position
}

/*
 * Meta Box HTML
 */
function media_print_box( $post ) {
    $meta_key = 'attach_file';
    echo media_image_uploader_field( $meta_key, get_post_meta($post->ID, $meta_key, true) );
}

/*
 * Save Meta Box data
 */
add_action('save_post', 'media_save');

function media_save( $post_id ) {
    //if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
      //  return $post_id;

    $meta_key = 'attach_file';
    if (array_key_exists($meta_key, $_POST)) {
        update_post_meta( $post_id, $meta_key, $_POST[$meta_key] );
    }
    

    // if you would like to attach the uploaded image to this post, uncomment the line:
    // wp_update_post( array( 'ID' => $_POST[$meta_key], 'post_parent' => $post_id ) );

    //return $post_id;
}
