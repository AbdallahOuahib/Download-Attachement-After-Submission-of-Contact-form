<?php


/* POST PART -- Custom Field filled with attachment PDF */

function contactfield_add_custom_box()
{
    $screens = ['post'];
    foreach ($screens as $screen) {
        add_meta_box(
            'contactfield_box_id',           // Unique ID
            'Contact',  // Box title
            'contactfield_custom_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}
add_action('add_meta_boxes', 'contactfield_add_custom_box');

function contactfield_custom_box_html($post)
{
    $args = array('post_type'=>'wpcf7_contact_form');
    $contacts = get_posts($args);
    $selected = get_post_meta(get_the_ID(), '_contactfield_meta_key', true);
?>
    <label for="contactfield_field">Choose Contact Form</label>
    <select class="form-control" name="contactfield_field" id="contactfield_field">
    <option> Choose Form</option>
<?php  
    if($contacts)   
    {
        foreach($contacts as $contact){
            echo '<option value="'.$contact->ID.'"'.selected( $selected, $contact->ID ).'">'.$contact->post_title.'</option>';
         }
    }           
    ?>       
</select>
<br/><br/>
<label for="title-button"> Text Button Contact : </label>
<?php
   echo '<input type="text" id="title-button" name="title-button" value="'.get_post_meta(get_the_ID(), '_contactfield_text_button_meta_key', true).'">';
         
}

function contactfield_save_postdata($post_id)
{
    if (array_key_exists('contactfield_field', $_POST)) {
        update_post_meta( $post_id,'_contactfield_meta_key',$_POST['contactfield_field']); 
        update_post_meta( $post_id,'_contactfield_text_button_meta_key',$_POST['title-button']);
    }
}
add_action('save_post', 'contactfield_save_postdata');
