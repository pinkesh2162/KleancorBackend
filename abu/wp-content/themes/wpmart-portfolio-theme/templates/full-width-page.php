<?php

/**
 * Template Name: Full Width Page
 * 
 * The template for displaying pages without a sidebar.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package WpMart_Portfolio_Theme
 */

get_header();
?>

<main id="primary" class="site-main full-width-page">

    <?php
    while (have_posts()) :
        the_post();

        get_template_part('template-parts/content', 'page');

        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

    endwhile; // End of the loop.
    ?>

</main><!-- #primary -->

<?php
get_footer();
