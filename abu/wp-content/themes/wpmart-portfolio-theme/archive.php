<?php

/**
 * The template for displaying archive pages.
 *
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WpMart_Portfolio_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php if (have_posts()) : ?>

        <header class="page-header">
            <?php
            the_archive_title('<h1 class="page-title">', '</h1>');
            the_archive_description('<div class="archive-description">', '</div>');
            ?>
        </header><!-- .page-header -->

    <?php
        /* Start the Loop */
        while (have_posts()) :
            the_post();

            /**
             * Run the loop for the archive page to output the posts.
             * If you want to overload this in a child theme then include a file
             * called content-___.php (where ___ is the post type) and that will be used instead.
             */
            get_template_part('template-parts/content', get_post_type());

        endwhile;

        the_posts_navigation();

    else :

        get_template_part('template-parts/content', 'none');

    endif;
    ?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
