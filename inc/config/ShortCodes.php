<?php

namespace Fooz\Config;

/**
 * Class ShortCodes
 * This class handles the creation of shortcodes for the theme.
 */
class ShortCodes
{
    /**
     * ShortCodes constructor.
     * Adds the shortcodes on class instantiation.
     */
    public function __construct()
    {
        // Register the 'recent-book-title' shortcode
        add_shortcode('recent-book-title', [$this, 'get_recent_book_title']);

        // Register the 'genre-books' shortcode
        add_shortcode('genre-books', [$this, 'get_genre_books']);
    }

    /**
     * Handles the 'recent-book-title' shortcode.
     * Returns the title of the most recent book.
     *
     * Example usage: [recent-book-title]
     *
     * @return string Title of the most recent book.
     */
    public function get_recent_book_title()
    {
        $args = [
            'post_type' => 'books',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
        ];

        $recent_book = new \WP_Query($args);

        if ($recent_book->have_posts()) {
            $recent_book->the_post();
            return get_the_title();
        } else {
            return __('No recent book found.', 'fooz');
        }

        wp_reset_postdata();
    }

    /**
     * Handles the 'genre-books' shortcode.
     * Returns a list of 5 books from a given genre, sorted alphabetically.
     *
     * Example usage: [genre-books genre="1"]
     *
     * @param array $atts Shortcode attributes.
     * @return string HTML output for the shortcode.
     */
    public function get_genre_books($atts)
    {
        $atts = shortcode_atts([
            'genre' => '',
        ], $atts, 'genre-books');

        $args = [
            'post_type' => 'books',
            'posts_per_page' => 5,
            'orderby' => 'title',
            'order' => 'ASC',
            'tax_query' => [
                [
                    'taxonomy' => 'genre',
                    'field' => 'term_id',
                    'terms' => $atts['genre'],
                ],
            ],
        ];

        $genre_books = new \WP_Query($args);

        if ($genre_books->have_posts()) {
            $output = '<ul>';
            while ($genre_books->have_posts()) {
                $genre_books->the_post();
                $output .= '<li>' . get_the_title() . '</li>';
            }
            $output .= '</ul>';
        } else {
            $output = __('No books found in this genre.', 'fooz');
        }

        wp_reset_postdata();

        return $output;
    }
}
