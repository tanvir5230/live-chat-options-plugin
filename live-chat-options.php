<?php

/**
 * Plugin Name
 *
 * @package           PluginPackage
 * @author            adminherobd
 * @copyright         2023 adminherobd team
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Live Chat Options
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            adminherobd
 * Author URI:        https://example.com
 * Text Domain:       lco
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://example.com/my-plugin/
 */

// Add options page to menu
function live_chat_plugin_menu()
{
    add_options_page(
        'Live Chat Options',
        'Live Chat',
        'manage_options',
        'live_chat_options',
        'live_chat_plugin_options_page'
    );
}
add_action('admin_menu', 'live_chat_plugin_menu');

// Register the plugin settings
function live_chat_options_settings_init()
{
    register_setting(
        'live_chat_options_settings',
        'live_chat_options_settings'
    );
    add_settings_section(
        'live_chat_options_settings_section',
        '',
        '',
        'live_chat_options_settings'
    );
    add_settings_field(
        'live_chat_options_settings_facebook_page',
        'Facebook Page',
        'live_chat_options_facebook_page_html',
        'live_chat_options_settings',
        'live_chat_options_settings_section'
    );
    add_settings_field(
        'live_chat_options_settings_whatsapp_number',
        'WhatsApp Number',
        'live_chat_options_whatsapp_number_html',
        'live_chat_options_settings',
        'live_chat_options_settings_section'
    );

    // Register the options
    register_setting('live_chat_options_settings', 'live_chat_options_settings');
}
add_action('admin_init', 'live_chat_options_settings_init');

// Define the plugin options page
function live_chat_plugin_options_page()
{
?>
<div>
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php
            settings_fields('live_chat_options_settings');
            do_settings_sections('live_chat_options_settings');
            submit_button();
            ?>
    </form>
</div>
<?php
}

// Define the HTML for the Facebook Page option
function live_chat_options_facebook_page_html()
{
    $options = get_option('live_chat_options_settings');
    $value = isset($options['facebook_page']) ? $options['facebook_page'] : '';
?>
<input type="text" name="live_chat_options_settings[facebook_page]" value="<?php echo esc_attr($value); ?>">
<?php
}

// Define the HTML for the WhatsApp Number option
function live_chat_options_whatsapp_number_html()
{
    $options = get_option('live_chat_options_settings');
    $value = isset($options['whatsapp_number']) ? $options['whatsapp_number'] : '';
?>
<input type="text" name="live_chat_options_settings[whatsapp_number]" value="<?php echo esc_attr($value); ?>">
<?php
}

// add live chat button to bottom corner of site
add_action('wp_footer', 'live_chat_button');
function live_chat_button()
{
    // set up the HTML for the live chat button
    $output = '<div id="live-chat-button">';
    $output .= '<button" id="live-chat-open-button">';
    $output .= '<span>Live Chat</span>
</button>';
    $output .= '</div>';

    // output the live chat button HTML
    echo $output;
}

// Add live chat panel to website
function live_chat_panel()
{
    $options = get_option('live_chat_options_settings');
    $facebook_page = isset($options['facebook_page']) ? $options['facebook_page'] : '';
    $whatsapp_number = isset($options['whatsapp_number']) ? $options['whatsapp_number'] : '';

    // set up the HTML for the live chat panel
    $output = '<div id="live-chat-panel">';
    $output .= '<div id="live-chat-header">';
    $output .= '<a href="javascript:void(0);" id="live-chat-close-button">close</a>';
    $output .= '</div>';
    $output .= '<div id="live-chat-body">';
    if (!empty($facebook_page)) {
        $output .= '<a href="https://m.me/' . $facebook_page . '" target="_blank"> 
        <img src="' . plugin_dir_url(__FILE__) . 'images/Messenger.png" width="40px" height="40px" alt="Messenger">
        </a>';
    }
    if (!empty($whatsapp_number)) {
        $output .= '<a href="https://wa.me/' . $whatsapp_number . '" target="_blank">
        <img src="' . plugin_dir_url(__FILE__) . 'images/WhatsApp.png" width="40px" height="40px" alt="Whatsapp">
        </a>';
    }
    $output .= '</div>';
    $output .= '</div>';
    echo $output;
}
add_action('wp_footer', 'live_chat_panel');

// Enqueue the live chat styles
function live_chat_styles()
{
    wp_enqueue_style(
        'live-chat-styles',
        plugin_dir_url(__FILE__) . 'live-chat-styles.css'
    );
}
add_action('wp_enqueue_scripts', 'live_chat_styles');


// enqueue jQuery and custom script for live chat button
add_action('wp_enqueue_scripts', 'live_chat_enqueue_scripts');
function live_chat_enqueue_scripts()
{
    wp_enqueue_script('live-chat-script', plugins_url('/live-chat-script.js', __FILE__), array('jquery'), '1.0.0', true);
}