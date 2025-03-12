<?php

namespace Fooz\Config;

/**
 * Seting up custom post types for the theme.
 */
class CustomPostTypes
{

    public function __construct()
    {

        /**
         * Hook into the 'init' action to add custom post types for "Books
         *
         * This function is registered as a callback for the 'init' action hook.
         * It will be executed during the WordPress initialization process.
         *
         * @see https://developer.wordpress.org/reference/hooks/init/
         */
        add_action('init', [$this, 'add_custom_posts_books']);

        /**
         * Registers AJAX actions for fetching books.
         *
         * This code adds two AJAX actions:
         * 1. 'wp_ajax_get_books' - For logged-in users.
         * 2. 'wp_ajax_nopriv_get_books' - For non-logged-in users.
         *
         * Both actions are linked to the 'get_books_callback' method of the current class.
         */
        add_action('wp_ajax_get_books', [$this, 'get_books_callback']);
        add_action('wp_ajax_nopriv_get_books', [$this, 'get_books_callback']);
    }

    /**
     * Registers a custom post type for "Books".
     */
    public function add_custom_posts_books()
    {
        $labels = array(
            'name'               => __('Books', 'fooz'),
            'singular_name'      => __('Book', 'fooz'),
            'menu_name'          => __('Books', 'fooz'),
            'name_admin_bar'     => __('Book', 'fooz'),
            'add_new'            => __('Add New', 'fooz'),
            'add_new_item'       => __('Add New Book', 'fooz'),
            'new_item'           => __('New Book', 'fooz'),
            'edit_item'          => __('Edit Book', 'fooz'),
            'view_item'          => __('View Book', 'fooz'),
            'all_items'          => __('All Books', 'fooz'),
            'search_items'       => __('Search Books', 'fooz'),
            'parent_item_colon'  => __('Parent Book:', 'fooz'),
            'not_found'          => __('No books found.', 'fooz'),
            'not_found_in_trash' => __('No books found in Trash.', 'fooz')
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'library'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'show_in_rest'       => true,
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt')
        );

        register_post_type('books', $args);

        $taxonomy_labels = array(
            'name'              => __('Genres', 'fooz'),
            'singular_name'     => __('Genre', 'fooz'),
            'search_items'      => __('Search Genres', 'fooz'),
            'all_items'         => __('All Genres', 'fooz'),
            'parent_item'       => __('Parent Genre', 'fooz'),
            'parent_item_colon' => __('Parent Genre:', 'fooz'),
            'edit_item'         => __('Edit Genre', 'fooz'),
            'update_item'       => __('Update Genre', 'fooz'),
            'add_new_item'      => __('Add New Genre', 'fooz'),
            'new_item_name'     => __('New Genre Name', 'fooz'),
            'menu_name'         => __('Genre', 'fooz'),
        );

        $taxonomy_args = array(
            'hierarchical'      => true,
            'labels'            => $taxonomy_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'book-genre'),
        );

        register_taxonomy('genre', array('books'), $taxonomy_args);
    }


    /**
     * Retrieves a list of books with specific details.
     *
     * This function queries the 'books' custom post type and retrieves up to 20 posts,
     * ordered by date in descending order. For each book, it gathers the title, date,
     * genre, and excerpt, and returns this information as a JSON response.
     *
     * @return void
     */
    public function get_books_callback()
    {
        $args = [
            'post_type' => 'books',
            'posts_per_page' => 20,
            'orderby' => 'date',
            'order' => 'DESC',
        ];

        $query = new \WP_Query($args);

        $books = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $terms = get_the_terms(get_the_ID(), 'genre');
                $genre = $terms ? $terms[0]->name : '';
                $books[] = [
                    'name' => get_the_title(),
                    'date' => get_the_date(),
                    'genre' => $genre,
                    'excerpt' => get_the_excerpt(),
                ];
            }
        }

        wp_reset_postdata();

        wp_send_json($books);
    }
}
