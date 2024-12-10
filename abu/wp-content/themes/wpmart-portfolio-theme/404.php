<?php

/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WpMart_Portfolio_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="wpmart-pt-not-found-container">
        <img class="wpmart-pt-not-found" src="<?php echo get_template_directory_uri() ?>/assets/img/404-not-found.png" alt="not-found-image"><br><br>
            <h1 class="wpmart-pt-error-text">Whoops, We can't seem to find the resource you're looking for.</h1>
            <p class="wpmart-pt-text">Please check that the Web site address is spelled correctly. <br><br><br>Or,</p>
        <div class="wpmart-pt-btn1">
            <a class="wpmart-pt-error" href="<?php echo get_home_url(); ?>">Go to Homepage</a>
        </div>
    </div>

</main><!-- #primary -->

<?php
get_footer();
