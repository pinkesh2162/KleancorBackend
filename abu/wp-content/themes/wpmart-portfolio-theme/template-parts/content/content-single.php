<?php

/**
 * Template part for displaying single post content.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WpMart_Portfolio_Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="wpmart-pt-details-banner">
            <?php wpmart_portfolio_post_thumbnail(); ?>
        </div>
        <div class="wpmart-pt-details-publish-info">
            <div class="wpmart-pt-details-publish-data">
                Published by <i class="fa-solid fa-user"></i>
                 <?php wpmart_portfolio_posted_by(); ?> 
                 , Posted on 
                 <i class="fa-regular fa-clock"></i> 
                 <?php wpmart_portfolio_posted_on(); ?>
            </div>

            <div class="wpmart-pt-details-category">
                Category:            
                <?php 
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        echo esc_html($categories[0]->name);   
                    }                
                ?>
            </div>
        </div>

        <div class="wpmart-pt-details-tast-title">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        </div>

        <div class="wpmart-pt-details-custom-three-col">
            <div class="wpmart-pt-details-col-1">
                <?php the_content(); ?>
            </div>
            <div class="wpmart-pt-details-col-2">
                <div class="wpmart-pt-details-client-2">
                    <div class="wpmart-pt-details-client-wrapper-2">
                        <div class="wpmart-pt-details-client-title">
                            Detials:
                        </div>
                            <?php 
                            $website_url = get_post_meta(get_the_ID(), '_website_url_meta_key', true);
                            $link_url = $website_url ? esc_url($website_url) : '';
                            $link_text = $website_url ? '' : 'View Demo';
                            ?>

                            <div class="wpmart-pt-details-client-sub-title wpmart-pt-view-demo" id="demo-<?php echo get_the_ID() ?>"> 
                                <i class="fa-solid fa-share"></i> 
                                <?php echo $link_text; ?>
                            </div>
                    </div>
                    <div class="wpmart-pt-details-client-wrapper-2">
                        <div class="wpmart-pt-details-client-title">
                            Posted On:
                        </div>
                        <div class="wpmart-pt-details-client-sub-title">
                            <?php wpmart_portfolio_posted_on(); ?>
                        </div>
                    </div>
                    <!-- <div class="wpmart-pt-details-client-wrapper-2">
                        <div class="wpmart-pt-details-client-title">
                            Client
                        </div>
                        <div class="wpmart-pt-details-client-sub-title">
                        <?php //wpmart_portfolio_posted_by(); ?>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    <footer class="entry-footer">
        <!-- <?php wpmart_portfolio_entry_footer(); ?> -->
    </footer>

</article><!-- #post-<?php the_ID(); ?> -->