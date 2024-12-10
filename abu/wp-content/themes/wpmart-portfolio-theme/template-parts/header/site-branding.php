<?php

/**
 * Template part for displaying the site branding (logo or site title and description).
 *
 * @package WpMart_Portfolio_Theme
 */
?>

<div class="wpmart-pt-logo">
    <?php
    if (has_custom_logo()) :
        the_custom_logo();
    else :
        if (is_front_page() && is_home()) :
    ?>
            <h1 class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
            </h1>
        <?php else : ?>
            <p class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
            </p>
        <?php endif; ?>

        <?php
        $wpmart_portfolio_description = get_bloginfo('description', 'display');
        if ($wpmart_portfolio_description || is_customize_preview()) :
        ?>
            <p class="site-description">
                <?php echo esc_html($wpmart_portfolio_description); ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>
</div><!-- .site-branding -->