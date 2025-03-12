<?php

namespace Fooz\Config;

/**
 * Seting up various things for the theme.
 */
class Config
{

    public function __construct()
    {
        /**
         * Hook into the 'init' action to register custom block patterns.
         */
        add_action('init', [$this, 'register_custom_patterns']);
    }

    /**
     * Registers custom block patterns for the theme.
     */
    function register_custom_patterns()
    {
        register_block_pattern(
            'twentytwentyfive-child/template-query-loop-books',
            array(
                'title'       => __('Template Query Loop Books', 'fooz'),
                'description' => __('A custom query loop for displaying books.', 'fooz'),
                'content'     => file_get_contents(get_stylesheet_directory() . '/patterns/template-query-loop-books.php'),
            )
        );
    }
}
