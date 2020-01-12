<?php
/**
 * Sample Code
 * 
 * Filter Posts by ACF Sub Fields
 *
 * @package Pentamint_WP_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*
    in this example I have a repeater field named "case-attr"
    one of the rows of this repeater is named "const-area"
    and I want to be able to search, sort and filter by this field
*/

// create a function that will convert this repeater during the acf/save_post action
if (!function_exists('convert_constarea_to_standard_wp_meta')) {

    function convert_constarea_to_standard_wp_meta($post_id) {

        // pick a new meta_key to hold the values of the color field
        // I generally name this field by suffixing _wp to the field name
        // as this makes it easy for me to remember this field name
        // also note, that this is not an ACF field and will not
        // appear when editing posts, it is just a db field that we
        // will use for searching
        $meta_key = 'constarea_wp';

        // the next step is to delete any values already stored
        // so that we can update it with new values
        // and we don't need to worry about removing a value
        // when it's deleted from the ACF repeater
        delete_post_meta($post_id, $meta_key);

        // create an array to hold values that are already added
        // this way we won't add the same meta value more than once
        // because having the same value to search and filter by
        // would be pointless
        $saved_values = array();

        // now we'll look at the repeater and save any values
        if (have_rows('mediator-attr', $post_id)) {
            while (have_rows('mediator-attr', $post_id)) {
                the_row();

                // get the value of this row
                $constarea = get_sub_field('const-area');

                // see if this value has already been saved
                // note that I am using isset rather than in_array
                // the reason for this is that isset is faster than in_array
                if (isset($saved_values[$constarea])) {
                    // no need to save this one we already have it
                    continue;
                }

                // not already save, so add it using add_post_meta()
                // note that we are using false for the 4th parameter
                // this means that this meta key is not unique
                // and can have more then one value
                add_post_meta($post_id, $meta_key, $constarea, false);

                // add it to the values we've already saved
                $saved_values[$constarea] = $constarea;
            } // end while have rows
        } // end if have rows
    } // end function

    // priority of 20 to run after ACF is done saving the new values
    add_filter('acf/save_post', 'convert_constarea_to_standard_wp_meta', 20);

}