<?php

namespace Fooz\Config;

/**
 * Enquing all styles and all scripts
 */
class EnqueStylesScripts
{

    /**
     * Adds actions to enqueue scripts and styles
     */
    public function __construct()
    {
        // Hook to enqueue scripts
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        // Hook to enqueue styles
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
    }

    /**
     * Enqueues all scripts
     */
    public function enqueue_scripts()
    {
        // Enqueue the main JavaScript file with jQuery as a dependency
        wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/dist/scripts.js', ['jquery'], VER, true);

        // Localize script to pass the AJAX URL to the script
        wp_localize_script('main-js', 'ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }

    /**
     * Enqueues all styles
     */
    public function enqueue_styles()
    {
        // Enqueue the parent theme's stylesheet
        wp_enqueue_style('twentytwentyfive-parent-style', get_template_directory_uri() . '/style.css');

        // Register the main stylesheet for the child theme
        wp_register_style(
            'main-css',
            get_stylesheet_directory_uri() . '/dist/style.css',
            ['twentytwentyfive-parent-style'],
            VER
        );
        // Enqueue the main stylesheet for the child theme
        wp_enqueue_style('main-css');
    }
}
