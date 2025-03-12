<?php

namespace Fooz\Config;

/**
 * Enquing all styles and all scripts
 */
class EnqueStylesScripts
{

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
    }

    /**
     * Enques all scripts
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/dist/scripts.js', ['jquery'], VER, true);
        wp_localize_script('main-js', 'ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }

    /**
     * Enques all styles
     */
    public function enqueue_styles()
    {
        wp_enqueue_style('twentytwentyfive-parent-style', get_template_directory_uri() . '/style.css');

        wp_register_style(
            'main-css',
            get_stylesheet_directory_uri() . '/dist/style.css',
            ['twentytwentyfive-parent-style'],
            VER
        );
        wp_enqueue_style('main-css');
    }
}
