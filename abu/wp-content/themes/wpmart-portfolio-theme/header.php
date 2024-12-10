<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div id="page" class="site wpmart-pt-wrapper">

        <!-- Skip Link for Accessibility -->
        <a class="skip-link screen-reader-text" href="#primary">
            <?php esc_html_e('Skip to content', 'wpmart-portfolio'); ?>
        </a>

        <header id="masthead" class="wpmart-pt-sticky-header">
            <!-- Site Branding and Navigation -->
            <?php
            get_template_part('template-parts/header/site-branding');
            get_template_part('template-parts/header/navigation');
            ?>
        </header>

        <div id="content" class="site-content">