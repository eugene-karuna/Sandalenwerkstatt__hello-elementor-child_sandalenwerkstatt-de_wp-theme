<?php
/**
 * Workarrounds
*/

/**
 * Show items in Cart+Shortcode
 */
function lhd_show_cart_items( $atts ) {
    global $woocommerce;
    echo $woocommerce->cart->cart_contents_count;

}
add_shortcode( 'lhd_show_cart_items_elementor', 'lhd_show_cart_items');



// Change WooCommerce "Related products" text
add_filter(  'gettext',  'wps_translate_words_array'  );
add_filter(  'ngettext',  'wps_translate_words_array'  );
function wps_translate_words_array( $translated ) {
     $words = array(
                // 'word to translate' = > 'translation'
               'Related Products' => 'Further Products',
     );
     $translated = str_ireplace(  array_keys($words),  $words,  $translated );
     return $translated;
}

/**
 * Change add to Cart Button text
 */
add_filter( 'woocommerce_product_single_add_to_cart_text', 'cw_btntext_cart' );
add_filter( 'woocommerce_product_add_to_cart_text', 'cw_btntext_cart' );
function cw_btntext_cart() {
    return __( 'Purchase', 'woocommerce' );
}

/**
 * Remove added to cart message
 */
add_filter( 'wc_add_to_cart_message_html', '__return_false' );



/**
 * Add WooCommerce additional Checkbox checkout field
 */

add_action( 'woocommerce_review_order_before_submit', 'bt_add_checkout_checkbox', 10 );

function bt_add_checkout_checkbox() {

    woocommerce_form_field( 'checkout_checkbox', array( // CSS ID
       'type'          => 'checkbox',
       'class'         => array('form-row mycheckbox'), // CSS Class
       'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
       'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
       'required'      => true, // Mandatory or Optional
       'label'         => 'Ich habe die <a href="#" style="color:red">wichtigen Information oben</a> gesehen und gelesen', // Label and Link //<a href="/checkout-checkbox" target="_blank" rel="noopener"></a>
    ));
}

add_action( 'woocommerce_checkout_process', 'bt_add_checkout_checkbox_warning' );
/**
 * Alert if checkbox not checked
 */
function bt_add_checkout_checkbox_warning() {
    if ( ! (int) isset( $_POST['checkout_checkbox'] ) ) {
        wc_add_notice( __( 'Bitte schauen Sie die zusätzliche Informationen an, um mit Ihrer Bestellung fortfahren zu können.' ), 'error' );
    }
}



//++++++++
remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'custom_empty_cart_message', 10 );

function custom_empty_cart_message() {
    $html  = '<div class="col-12 offset-md-1 col-md-10"><p class="cart-empty">';
    $html .= wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Ihr Warenkorb ist leer!', 'woocommerce' ) ) );
    echo $html . '</p></div>';
}



//++++++++
//add_action( 'woocommerce_before_add_to_cart_quantity', 'wp_echo_qty_front_add_cart' );

function wp_echo_qty_front_add_cart() {
 echo '<div class="lhd_qty">Plätze: </div>';
}