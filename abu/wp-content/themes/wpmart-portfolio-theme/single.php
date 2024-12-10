<?php

/**
 * The template for displaying all single posts.
 *
 * This is the template that displays all individual posts by default.
 * Please note that this is the WordPress construct of posts and that
 * other "pages" on your WordPress site might use different templates.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WpMart_Portfolio_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="wpmart-pt-details-area">
        <div class="wpmart-pt-custom-row-2">
            <?php
            while (have_posts()) :
                the_post();

                get_template_part('template-parts/content/content', 'single');

                // Post navigation.
                // the_post_navigation(
                //     array(
                //         'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'wpmart-portfolio') . '</span> <span class="nav-title">%title</span>',
                //         'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'wpmart-portfolio') . '</span> <span class="nav-title">%title</span>',
                //     )
                // );

                // if (comments_open() || get_comments_number()) :
                //     comments_template();
                // endif;

            endwhile; // End of the loop.
            ?>

        </div>
    </div>    

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
