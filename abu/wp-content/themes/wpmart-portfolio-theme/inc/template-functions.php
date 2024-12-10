<?php

/**
 * Custom template functions for this theme.
 *
 * @package WpMart_Portfolio_Theme
 */

if (!function_exists('wpmart_portfolio_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function wpmart_portfolio_posted_on()
    {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date())
        );

        echo '<span class="posted-on">' . $time_string . '</span>';
    }
endif;

if (!function_exists('wpmart_portfolio_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function wpmart_portfolio_posted_by()
    {
        echo '<span class="byline">' . esc_html(get_the_author()) . '</span>';
    }
endif;

if (!function_exists('wpmart_portfolio_read_more_link')) :
    /**
     * Custom "Read More" link for excerpts.
     *
     * @return string Custom read more link.
     */
    function wpmart_portfolio_read_more_link()
    {
        return ' <a href="' . esc_url(get_permalink()) . '">Read More &raquo;</a>';
    }
    add_filter('excerpt_more', 'wpmart_portfolio_read_more_link');
endif;


if (!function_exists('wpmart_portfolio_post_thumbnail')) :
    /**
     * Display the post thumbnail.
     */
    function wpmart_portfolio_post_thumbnail()
    {
        // Check if the post has a thumbnail
        if (has_post_thumbnail()) :
            echo '<div class="post-thumbnail">';
            the_post_thumbnail('full');  // You can specify the image size. 'full' will display the full image.
            echo '</div>';
        endif;
    }
endif;


if (!function_exists('wpmart_portfolio_entry_footer')) :
    function wpmart_portfolio_entry_footer()
    {
        if ('post' === get_post_type()) {
            $categories_list = get_the_category_list(esc_html__(', ', 'wpmart-portfolio'));
            if ($categories_list) {
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'wpmart-portfolio') . '</span>', $categories_list);
            }

            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'wpmart-portfolio'));
            if ($tags_list) {
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'wpmart-portfolio') . '</span>', $tags_list);
            }
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    __('Edit <span class="screen-reader-text">%s</span>', 'wpmart-portfolio'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;
