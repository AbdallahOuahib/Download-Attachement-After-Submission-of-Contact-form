<?php 

function modal_button_shortcode( $atts, $content = null ) {
   
    // shortcode attributes
    extract( shortcode_atts( array(
        'url'    => '',
        'title'  => '',
        'target' => '',
        'text'   => '',
        'type' => 'button',
        'data-toggle' => 'modal',
        'data-target' => '#contactModal'
    ), $atts ) );
 
    $content = $text ? $text : $content;
 
    // Returns the button with a link
    if ( $url ) {
 
        $link_attr = array(
            'href'   => esc_url( $url ),
            'title'  => "Modal Button Contact",
            'target' => ( 'blank' == $target ) ? '_blank' : '',
            'class'  => 'btn modalbutton',
            'data-toggle' => 'modal',
            'data-target' => '#contactModal'
        );
 
        $link_attrs_str = '';
 
        foreach ( $link_attr as $key => $val ) {
 
            if ( $val ) {
 
                $link_attrs_str .= ' ' . $key . '="' . $val . '"';
 
            }
 
        }
 
 
        return '<a' . $link_attrs_str . '>' . do_shortcode( $content ) . '</a>';
 
    }
 
}
add_shortcode( 'modalbutton', 'modal_button_shortcode' );

function mediafield_button_shortcode( $atts, $content = null ) {
   
    

    // shortcode attributes
    extract( shortcode_atts( array(
        'url'    => '',
        'title'  => '',
        'target' => '',
        'text'   => '',
    ), $atts ) );
 
    $content = $text ? $text : $content;
 
    // Returns the button with a link
    if ( $url ) {
 
        $link_attr = array(
            'href'   => esc_url( $url ),
            'title'  => esc_attr( $title ),
            'target' => '_blank',
            'class'  => 'mediafieldbutton'
        );
 
        $link_attrs_str = '';
 
        foreach ( $link_attr as $key => $val ) {
 
            if ( $val ) {
 
                $link_attrs_str .= ' ' . $key . '="' . $val . '"';
 
            }
 
        } 

        
        return '<a' . $link_attrs_str . '><span>' . do_shortcode( $content ) . '</span></a>';
 
    }
 
}
add_shortcode( 'mediafieldbutton', 'mediafield_button_shortcode' );

function modal_shortcode( $atts, $content = null , $shortcode_mediafieldbutton) {
    return '
    <div class="modal fade" id="contactModal" tabindex="-1" 
         role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">'.get_the_title().'
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                '.do_shortcode('[contact-form-7 id="'.get_post_meta(get_the_ID(), '_contactfield_meta_key', true).'"]').'
                <div id="modal-download"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
      </div>
    </div>';
}
add_shortcode( 'modal', 'modal_shortcode' );

/* Add Shortcode Automatically */
function modal_button_to_a_post( $content ) {
    global $post;
    if( ! $post instanceof WP_Post ) return $content;

        switch( $post->post_type ) {

        case 'post':
            if(is_singular()) {
                return $content . '[modalbutton url="#"]'.get_post_meta(get_the_ID(), '_contactfield_text_button_meta_key', true).'[/modalbutton][modal][/modal]';
            }
        default:
            return $content;
        }

}
   
add_filter( 'the_content', 'modal_button_to_a_post' );