<?php
/**
 * Template part for displaying the header navigation.
 *
 * @package WpMart_Portfolio_Theme
 */
?>

<!-- Desktop Menu -->
<nav id="site-navigation" class="wpmart-pt-menu main-navigation">
    <?php
    wp_nav_menu([
        'theme_location' => 'menu-1',
        'menu_id'        => 'primary-menu',
        'menu_class'     => 'wpmart-pt-menu',
        'container'      => false
    ]);
    ?>
</nav>

<!-- Mobile Menu -->
<div class="wpmart-pt-mobile-navigation">
    <a class="wpmart-pt-mobile-menu-button" id="mobileMenuButton" aria-label="Mobile Menu Toggle">
        <i class="fa-solid fa-bars mobile-menu-icon"></i>
</a>
    
    <nav class="wpmart-pt-mobile-menu" id="mobileMenu">
        <?php
        wp_nav_menu([
            'theme_location' => 'menu-1',
            'menu_id'        => 'mobile-primary-menu',
            'menu_class'     => 'wpmart-pt-mobile-menu-list',
            'container'      => false
        ]);
        ?>
    </nav>
</div>
