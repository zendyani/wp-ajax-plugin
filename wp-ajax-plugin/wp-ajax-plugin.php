<?php
/**
 * Plugin Name: WP AJAX Plugin
 * Description: A simple AJAX example for WordPress.
 * Version: 1.0
 * Author: Your Name here
 * Text Domain: wp-ajax-plugin
 */

namespace MyAjaxPlugin;

use Exception;

// Prevent direct access
defined('ABSPATH') or die('No script kiddies please!');

class MyAjaxPlugin {
    private const NONCE_NAME = 'my-ajax-nonce';

    /**
     * Initialize the plugin.
     */
    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'adminScripts']);
        add_action('admin_menu', [$this, 'adminMenu']);
        if (wp_doing_ajax()) {
            add_action('wp_ajax_my_action', [$this, 'ajaxHandler']);
            add_action('wp_ajax_nopriv_my_action', [$this, 'ajaxHandler']);
        }
    }

    /**
     * Enqueue scripts for the admin area.
     *
     * @param string $hook The current hook being processed.
     */
    public function adminScripts($hook): void {
        if ($hook !== 'toplevel_page_my-ajax-plugin') {
            return;
        }

        wp_enqueue_script('my-ajax-request', plugin_dir_url(__FILE__) . 'js/ajax-script.js', ['jquery'], false, true);
        wp_localize_script('my-ajax-request', 'MyAjax', ['ajaxurl' => admin_url('admin-ajax.php')]);
    }

    /**
     * Register the admin menu item in the WordPress dashboard.
     */
    public function adminMenu(): void {
        add_menu_page(
            esc_html__('My AJAX Plugin Settings', 'my-ajax-plugin'), // Page title
            esc_html__('My AJAX Plugin', 'my-ajax-plugin'), // Menu title
            'manage_options', // Capability
            'my-ajax-plugin', // Menu slug
            [$this, 'settingsPage'], // Function to display the settings page
            'dashicons-admin-generic' // Icon URL
        );
    }

    /**
     * Display the settings/admin page for the plugin.
     */
    public function settingsPage(): void {
        ?>
        <div class="wrap">
            <h2><?php esc_html_e('My AJAX Plugin', 'my-ajax-plugin'); ?></h2>
            <form id="my-ajax-form">
                <label for="name"><?php esc_html_e('Enter your name:', 'my-ajax-plugin'); ?></label>
                <input type="text" name="name" id="name" required>
                <input type="hidden" name="nonce" id="my_nonce" value="<?php echo wp_create_nonce(self::NONCE_NAME); ?>">
                <button id="submit-name"><?php esc_html_e('Submit', 'my-ajax-plugin'); ?></button>
            </form>
            <div id="message"></div>
        </div>
        <?php
    }

    /**
     * Handle the AJAX request.
     */
    public function ajaxHandler(): void {
        try {
            check_ajax_referer(self::NONCE_NAME, 'nonce');

            $name = sanitize_text_field($_POST['name']);
            echo 'Hello, ' . esc_html($name) . '!';
        } catch (Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        }

        wp_die();
    }
}

new MyAjaxPlugin();
