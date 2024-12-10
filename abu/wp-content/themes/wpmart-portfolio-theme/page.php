<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WpMart_Portfolio_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/content/content-page' );

            // If comments are open or there is at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
        endwhile; // End of the loop.
    ?>

</main><!-- #primary -->

<?php
get_footer();