<?php
/*
Plugin Name: ITI Mapify Location Shortcode
Description: Adds shortcode functionality to Mapify location text fields
Version: 1.1.1
Author: nkohlmeier@iti4dmv.com
*/

class LocationShortcode {

    public function __construct() {
        add_shortcode('itimpfy_location_main', array($this,'itimpfy_location_main_shortcode'));
        add_shortcode('itimpfy_location_short_description', array($this,'itimpfy_location_short_description_shortcode'));  
        add_shortcode('itimpfy_location_tooltip', array($this,'itimpfy_location_tooltip_shortcode'));

        // Add menu item to admin menu
        add_action('admin_menu', array($this, 'add_plugin_page'));
    }

    // Add plugin page
    public function add_plugin_page(){
        add_menu_page(
            'ITIMapify Location Shortcode',
            'ITIMapify Shortcode',
            'manage_options',
            'itimpfy-location-shortcode',
            array($this, 'display_plugin_page'),
            'dashicons-admin-generic',
            99
        );
    }

    // Parse the Markdown
    public function parse_markdown($markdown){
        require_once(plugin_dir_path(__FILE__) . 'parsedown/Parsedown.php');
        $parsedown = new Parsedown();
        return $parsedown->text($markdown);
    }

    // Display plugin page
    public function display_plugin_page(){
        $readme_file = plugin_dir_path(__FILE__) . 'readme.md';
        if (file_exists($readme_file)){
            $readme_content = file_get_contents($readme_file);
            echo '<div class="wrap">';
            echo '<h1>ITI-Mapify Location Shortcode</h1>';
            echo $this->parse_markdown($readme_content);
            echo '<p>This is where the markdown will go</p>';
            echo '</div>';
        } else {
            echo '<div class="wrap">';
            echo '<h1>Readme not found</h1>';
            echo '</div>';
        }
    }

    public function itimpfy_location_main_shortcode($atts) {
        $atts = shortcode_atts(array(
            'name' => '',
            'address' => '',
            'cash' => '',
            'hours' => '',
            'check' => ''
        ), $atts, 'itimpfy_location_main');
    
        // Sanitize attributes
        $name = sanitize_text_field($atts['name']);
        $address = esc_html($atts['address']);
        $cash = $atts['cash'] ? true : false;
        $check = $atts['check'] ? true : false;
        $hours = esc_html($atts['hours']);
    
        // Create HTML output using heredoc syntax
        $payment_options = '';
        if ($cash) {
            $payment_options .= '<li>Cash</li>';
        }
        if ($check) {
            $payment_options .= '<li>Check</li>';
        }
    
        $hours_list = '';
        $hours_rows = explode(';', $hours);
        foreach ($hours_rows as $hour) {
            $hours_list .= "<li>$hour</li>";
        }
    
        $output = <<<HTML
    <div class="main-container">
        <div class="column-container">
            <p class="address bold-text">$address</p>
            <p>Located inside the $name, the self-service kiosk is a fast, easy way to renew your registration and walk away with your tabs!</p>
            <p>Simply scan your renewal postcard or type in your license plate number, pay your taxes and fees via 
    HTML;
    
        if ($cash) {
            $output .= '<strong>cash</strong>, ';
        }
        if ($check) {
            $output .= '<strong>check</strong>, ';
        }
    
        $output .= <<<HTML
            <strong>credit card</strong> or <strong>debit card</strong>, and your registration and license plate decal prints immediately.</p>
            <p>Questions? <a href="/faq">Visit our FAQ Page</a></p>
            <p>Renew. Print. Go!</p>
        </div>
        <div class="kiosk-details-container">
            <h2 class="column-header bold-text">Payment Options</h2>
            <ul>
                $payment_options
                <li>Credit Card</li>
                <li>Debit Card</li>
            </ul>
            <h2 class="column-header bold-text">Hours of Operation</h2>
            <ul>
                $hours_list
            </ul>
        </div>
    </div>
    HTML;
    
        return $output;
    }
    

    public function itimpfy_location_short_description_shortcode($atts) {
        $atts = shortcode_atts( array(
            'address' => '',
            'hours' => '',
			'check' => '',
        ), $atts, 'itimpfy_location_short_description');

        // Sanitize attributes
        $address = esc_html($atts['address']);
        $hours = esc_html($atts['hours']);

        // Output sanitized content
        $output = '<div class="tooltip-address bold-text">' . $address . '</div>';
        
        // Display hours table
        $hours_rows = explode(';', $hours);
        $output .= '<ul>';

        foreach ($hours_rows as $hours) {
            $output .= "<li>$hours</li>";  
        }

        $output .= '</ul>';
        
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
