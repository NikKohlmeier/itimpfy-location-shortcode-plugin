<?php
/*
Plugin Name: ITI Mapify Location Shortcode
Description: Adds shortcode functionality to Mapify location text fields
Version: 1.0.0
Author: nkohlmeier@iti4dmv.com
*/

class LocationShortcode {

    public function __construct() {
        add_shortcode('itimpfy_location_main', array($this,'itimpfy_location_main_shortcode'));
        add_shortcode('itimpfy_location_short_description', array($this,'itimpfy_location_short_description_shortcode'));  
        add_shortcode('itimpfy_location_tooltip', array($this,'itimpfy_location_tooltip_shortcode'));
    }

    public function itimpfy_location_main_shortcode($atts) {
    $atts = shortcode_atts( array(
        'name' => '',
        'address' => '',
        'cash' => '',
        'hours' => '',
    ), $atts, 'itimpfy_location_main');

    // Sanitize attributes
    $name = sanitize_text_field($atts['name']);
    $address = esc_html($atts['address']);
    $cash = $atts['cash'] ? true : false;
    $hours = esc_html($atts['hours']);

    // Output sanitized content
    $output = '<div class="main-container">';
    $output .= '<div class="column-container">';
    $output .= '<p class="address bold-text">' . $address . '</p>';
    $output .= '<p>Located inside the ' . $name . ', the self-service kiosk is a fast, easy way to renew your registration and walk away with your tabs!</p>';
    $output .= '<p>Simply scan your renewal postcard or type in your license plate number, pay your taxes and fees via ';
    
    if($cash) {
        $output .= '<strong>cash</strong>, ';
    }

    $output .= '<strong>credit card</strong> or <strong>debit card</strong>, and your registration and license plate decal prints immediately.</p>'
        . '<p>Questions? <a href="/faq">Visit our FAQ Page</a></p>'
        . '<p>Renew. Print. Go!</p>';
    $output .= '</div>';
    $output .= '<div class="kiosk-details-container">';
    $output .= '<h2 class="column-header bold-text">Payment Options</h2>';
    $output .= '<ul>';

    if($cash) {
        $output .= '<li>Cash</li>';
    }

    $output .= '<li>Credit Card</li><li>Debit Card</li></ul>';
    $output .= '<h2 class="column-header bold-text">Hours of Operation</h2>';

    // Display hours table
    $hours_rows = explode(';', $hours);
    $output .= '<table>';

    foreach ($hours_rows as $hours) {
        $output .= "<tr><td>$hours</td></tr>";  
    }

    $output .= '</table>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
    }

    public function itimpfy_location_tooltip_shortcode($atts) {
        $atts = shortcode_atts( array(
            'address' => '',
            'cash' => '',
        ), $atts, 'itimpfy_location_tooltip');

        // Sanitize attributes
        $address = esc_html($atts['address']);
        $cash = $atts['cash'] ? true : false;



        // Output sanitized content
        $output = '<div class="tooltip-address"><p>' . do_shortcode($address) . '</p></div></br>';
        $output .= '<div><p><strong>PAYMENT OPTIONS</strong></p>';
        $output .= '<p>';
        if($cash) {
            $output .= 'Cash, ';
        }
        $output .= 'Credit & Debit Cards</p></div>';
        return $output;
    }

    public function itimpfy_location_short_description_shortcode($atts) {
        $atts = shortcode_atts( array(
            'address' => '',
            'hours' => '',
        ), $atts, 'itimpfy_location_short_description');

        // Sanitize attributes
        $address = esc_html($atts['address']);
        $hours = esc_html($atts['hours']);

        // Output sanitized content
        $output = '<div class="tooltip-address bold-text">' . $address . '</div>';
        
        // Display hours table
        $hours_rows = explode(';', $hours);
        $output .= '<table>';

        foreach ($hours_rows as $hours) {
            $output .= "<tr><td>$hours</td></tr>";  
        }

        $output .= '</table>';
        
        return $output;
        }
}

function register_shortcodes(){
  new LocationShortcode();
}

add_action('plugins_loaded', 'register_shortcodes');

add_filter('mpfy_map_location_tooltip_text', 'override_mapify_shortcode_processing', 10, 1);

function override_mapify_shortcode_processing($text) {
    // Process shortcodes in the tooltip text
    $text = do_shortcode($text);
    return $text;
}

?>