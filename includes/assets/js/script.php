<?php 
function script()
{

?>
<script>
jQuery(document).ready(function($) {

    document.addEventListener( 'wpcf7mailsent', function( event ) {

        $url = '<?php echo site_url(); ?>/wp-admin/admin-ajax.php';

                    event.preventDefault();
                    $.ajax({
                        cache: false,
                        timeout: 80000,
                        url: $url,
                        type: 'GET',
                        data: {action: 'download_call', code: <?php echo get_the_ID(); ?>},
                    }).done(function (server_data) {
                        $("#modal-download").html('<a  href="' + server_data + '" class="btn btn-primary" download>Dowload File </a>')
                    }).fail(function () {
                        console.log("Error : not data")

                    });
                    }, false);

});
</script>
<?php
}
add_action('wp_footer', 'script'); // here execute the action


/*-------------AJAX-------------*/


add_action('wp_ajax_download_call', 'download_call');
add_action('wp_ajax_nopriv_download_call', 'download_call');

function download_call()
{
    $code = $_GET['code'];

    $post = get_post($code);

    if ($post):
        $meta = wp_get_attachment_url(get_post_meta($post->ID, 'attach_file', TRUE));
        if ($meta):
            echo $meta;
        else:
            echo "Not found file";
        endif;
    endif;


    wp_die();
}
