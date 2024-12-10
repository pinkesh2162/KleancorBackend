<?php

/**
 * The template for displaying the front page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WpMart_Portfolio_Theme
 */

get_header(); ?>

<main id="main" class="site-main">

        <!-- Banner Section Start-->
        <?php
            if ( get_theme_mod('wpmart_home_banner_activate', true) ): 
        ?>
            <section class="homepage-banner" id="wpmart-pt-home-banner">
                <div class="wpmart-pt-banner">
                    <?php if (get_theme_mod('wpmart_homepage_banner')) : ?>
                        <img src="<?php echo wp_get_attachment_url(get_theme_mod('wpmart_homepage_banner')); ?>" alt="Banner Image" />
                    <?php endif; ?>

                    <div class="wpmart-pt-banner-content">
                        <div class="wpmart-pt-col">
                            <div class="wpmart-pt-col-content">

                                <?php
                                $texts = explode("\n", get_theme_mod('wpmart_banner_texts'));
                                foreach ($texts as $text) :
                                ?>
                                    <div><?php echo esc_html($text); ?></div>
                                <?php endforeach; ?>

                                <div class="wpmart-pt-col-content-desc">
                                    <?php echo esc_html(get_theme_mod('wpmart_banner_description')); ?>
                                </div>

                                <?php 
                                    $banner_btn_text = get_theme_mod('wpmart_banner_btn_text');
                                    $banner_btn_url = get_theme_mod('wpmart_banner_btn_url', '#');
                                ?>
                                <?php if ($banner_btn_text) : ?>
                                    <div class="wpmart-pt-about-btn">
                                        <a href="<?php echo esc_url($banner_btn_url); ?>" target="_blank">
                                            <?php echo esc_html($banner_btn_text); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="wpmart-pt-col mobile-hide-section"></div>
                    </div>
                </div>
            </section>
        <?php 
            endif; 
        ?>
        <!-- Banner Section End-->


        <div class="wpmart-pt-ext-margin">

            <!-- About Section Start-->
            <?php
                if (get_theme_mod('wpmart_summary_about_activate', true)): 
            ?>
                <div class="wpmart-pt-custom-row" id="wpmart-pt-summary-about-me">
                    <div class="wpmart-pt-about-title">
                        <?php echo esc_html(get_theme_mod('wpmart_summary_about_title', 'ABOUT WPMARTS')); ?>
                    </div>
                    <div class="wpmart-pt-about-wrapper"> 
                        <?php 
                        $num_about_sections = get_theme_mod('wpmart_num_about_sections', 3); 
                        for ($i = 1; $i <= $num_about_sections; $i++) : ?>
                            <div class="wpmart-pt-custom-col custom-color-gray custom-font-size-2">
                                <div class="<?php echo "wpmart-pt-about-subtitle wpmart-pt-about-sec-title-$i"; ?>">
                                    <?php echo esc_html(get_theme_mod("wpmart_pt_about_sec_title_$i", ($i === 1) ? 'SUMMARY ABOUT ME' : (($i === 2) ? 'MY CAREER' : 'MY EDUCATION'))); ?>
                                </div>
                                <div class="<?php echo "wpmart-pt-summary-about-me-des wpmart-pt-summary-about-me-des-$i"; ?>">
                                    <?php echo wp_kses_post(get_theme_mod("wpmart_pt_summary_about_me_des_$i", '')); ?>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php 
                endif; 
            ?>
            <!-- About Section End-->

            <!-- Project Section Start-->
            <?php if (get_theme_mod('wpmart_projects_activate', true)): ?>
                <div class="wpmart-pt-project-wrapper-main wpmart-pt-margin-top" id="wpmart-pt-project-client">
                    <div class="wpmart-pt-project-section">
                        <div class="wpmart-pt-project-wrapper">
                            <!-- Project Title and Description -->
                            <div class="wpmart-pt-project-title">
                                <?= esc_html(get_theme_mod('wpmart_project_section_title', 'MY LATEST WORK')); ?>
                            </div>
                            <div class="wpmart-pt-project-desc wpmart-pt-custom-desc-style custom-color-gray">
                                <?= wp_kses_post(get_theme_mod('wpmart_project_section_desc', 'Maecenas quis justo at neque venenatis sagittis...')); ?>
                            </div>

                            <!-- Category Filter -->
                            <div class="wpmart-pt-project-category-filter">
                                <div class="wpmart-pt-filter-list">
                                    <?php 
                                    $categories = get_categories(); 
                                    foreach ($categories as $category): ?>
                                        <a class="wpmart-pt-project-category-filter-item" href="#" data-filter=".<?= esc_attr($category->slug); ?>"><?= esc_html($category->name); ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>    
                    </div>

                    <!-- Projects Grid -->
                    <div class="wpmart-pt-porject-wrapper isotope-wrapper">
                        <?php 
                        $args = array(
                            'post_type' => 'post',
                            'posts_per_page' => get_theme_mod('wpmart_num_projects', 6)
                        );
                        $projects_query = new WP_Query($args);

                        if ($projects_query->have_posts()):
                            while ($projects_query->have_posts()): $projects_query->the_post();
                                $categories = get_the_category();
                                $slug_class = join(' ', wp_list_pluck($categories, 'slug'));
                                ?>
                                <div class="wpmart-pt-project-container <?= $slug_class; ?>">
                                    <div class="wpmart-pt-hover-img">
                          	<?php if (has_post_thumbnail()) : ?>
							  <a href="<?php echo get_permalink(); ?>" target="_blank"> <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
							  </a>
							<?php else : ?>
							  <a href="<?php echo get_permalink(); ?>" target="_blank"> <img src="<?php echo get_template_directory_uri() ?>/assets/img/banner-scaled.jpg" alt="Default Project Image">
							  </a>
							<?php endif; ?>

                                        <div class="wpmart-pt-project-img-link-content">
                                            <div class="wpmart-pt-icon">
                                                <a onclick="openModal('<?php has_post_thumbnail() ? the_post_thumbnail_url() : "./img/banner-scaled.jpg"; ?>')" class="wpmart-pt-magnify-image">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </a>
                                            </div>

                                            <?php 
                                            $website_url = get_post_meta(get_the_ID(), '_website_url_meta_key', true);
                                            $link_url = $website_url ? esc_url($website_url) : get_permalink();
                                            if ($website_url): ?>
                                                <div class="wpmart-pt-icon">
                                                    <a href="<?php echo get_permalink(); ?>" target="_blank" class="wpmart-pt-project-link">
                                                        <i class="fa-solid fa-link"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="wpmart-pt-img-content-wrapper">
                                        <div class="wpmart-pt-about-sec-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br>
                                            <span class="wpmart-pt-project-subtitle">
                                            <?php 
                                                if (!empty($categories)) {
                                                    echo esc_html($categories[0]->name);  
                                                }                
                                            ?>
                                            </span>
                                        </div>
                                    </div> 
                                </div>
                            <?php endwhile; wp_reset_postdata(); endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <!-- Project Section End-->
            


            <!-- Achievment Section Start-->
            <?php
                if (get_theme_mod('wpmart_achievements_activate', true)): 
            ?>
            <div class="wpmart-pt-achievment-section" id="wpmart-pt-achievment">
                <div class="wpmart-pt-achievment-title">
                    <?php echo esc_html(get_theme_mod('wpmart_achievment_title', 'MY ACHIEVEMENTS')); ?>
                </div>
                <div class="wpmart-pt-counter-wrapper">
                    <?php 
                    $num_achievements = get_theme_mod('wpmart_num_achievements', 3); 
                    for ($i = 1; $i <= $num_achievements; $i++) : ?>
                        <div class="<?php echo " wpmart-pt-counter wpmart-pt-counter-$i"; ?>">
                            <div class="<?php echo " wpmart-pt-conter-number wpmart-pt-conter-number-$i"; ?>">
                                <?php echo esc_html(get_theme_mod("wpmart_counter_number_$i", '5454')); ?>
                            </div>
                            <div class="<?php echo " wpmart-pt-conter-title wpmart-pt-conter-title-$i"; ?>">
                                <?php echo esc_html(get_theme_mod("wpmart_counter_title_$i", 'articles')); ?>
                            </div>
                            <div class="<?php echo " wpmart-pt-conter-description wpmart-pt-conter-description-$i"; ?>">
                                <?php echo wp_kses_post(get_theme_mod("wpmart_counter_description_$i", 'Habitasse platea dictumst. Ut tellus sem, suscipit ut enim id.')); ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <?php 
                endif; 
            ?>
            <!-- Achievment Section End-->

            <!-- Start Testimonial Section -->
                <?php if (get_theme_mod('wpmart_testimonials_activate', true)): ?>
                    <section class="wpmart-pt-testimonial-section" id="wpmart-pt-testimonials-section">                
                        <header class="wpmart-pt-testimonial-title">
                            <?= esc_html(get_theme_mod('wpmart_testimonial_section_title', 'OUR TESTIMONIALS')); ?>
                        </header>

                        <div class="wpmart-pt-testimonial-slider">
                            <?php
                            $num_testimonials = get_theme_mod('wpmart_num_testimonials', 5);
                            $testimonials = [];
                            for ($i = 1; $i <= $num_testimonials; $i++) {
                                $testimonials[] = [
                                    'image' => get_theme_mod("wpmart_testimonial_image_$i"),
                                    'name' => get_theme_mod("wpmart_testimonial_client_$i"),
                                    'rating' => get_theme_mod("wpmart_testimonial_star_rating_$i"),
                                    'title' => get_theme_mod("wpmart_testimonial_title_$i"),
                                    'text' => get_theme_mod("wpmart_testimonial_text_$i"),
                                ];
                            }

                            foreach ($testimonials as $testimonial): ?>
                                <div class="wpmart-pt-testimonial-wrapper">
                                    <div class="wpmart-pt-testimonial-left-selection">
                                        <div class="wpmart-pt-testimonial-img">
                                            <?php 
                                            $image_url = (!empty($testimonial['image'])) ? $testimonial['image'] : get_template_directory_uri() . '/assets/img/avatar.png';
                                            ?>
                                            <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($testimonial['name']); ?>">
                                        </div>

                                        <div class="wpmart-pt-testimonial-title"><?= esc_html($testimonial['name']); ?></div>
                                        <div class="wpmart-pt-testimonial-rating">
                                            <div style="margin-right: 8px;">
                                                <?php for ($j = 1; $j <= 5; $j++): ?>
                                                    <i class="<?= ($j <= $testimonial['rating']) ? 'fa-solid fa-star' : 'fa-regular fa-star'; ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <div style="font-weight: 600;"><?= esc_html($testimonial['rating']); ?> of 5</div>
                                        </div>
                                    </div>
                                    <div class="wpmart-pt-testimonial-right-selection">
                                        <div class="wpmart-pt-testimonial-quote"><i class="fa-solid fa-quote-left"></i></div>
                                        <div class="wpmart-pt-testimonial-right-selection-ext-padding">
                                            <div class="wpmart-pt-testimonial-title"><?= esc_html($testimonial['title']); ?></div>
                                            <div class="wpmart-pt-testimonial-description"><?= wp_kses_post($testimonial['text']); ?></div>
                                        </div>
                                        <div class="wpmart-pt-testimonial-quote" style="text-align: right;"><i class="fa-solid fa-quote-right"></i></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>                 
                        </div>
                    </section>
                <?php endif; ?>
                <!-- End Testimonial Section -->


            <!-- Skill List Start -->
            <?php
                if (get_theme_mod('wpmart_skill_list_activate', true)): 
            ?>
                <div class="wpmart-pt-margin-top" id="wpmart-pt-skill-list">
                    <div class="wpmart-pt-about-title">
                        <?php echo esc_html(get_theme_mod('wpmart_skill_section_heading', 'MY LATEST WORK')); ?>
                    </div>

                    <div class="wpmart-pt-custom-row-2">
                        <?php
                        $num_categories = get_theme_mod('wpmart_num_categories', '2');
                        for ($i = 1; $i <= $num_categories; $i++) :
                        ?>
                            <div class="wpmart-pt-custom-col-2">
                                <!-- Category Title -->
                                <div class="wpmart-pt-latest-work-title">
                                    <?php echo esc_html(get_theme_mod("wpmart_category_title_$i", "Category $i")); ?>
                                </div>

                                <!-- Category Description -->
                                <div class="wpmart-pt-latest-work-desc wpmart-pt-custom-desc-style">
                                    <?php echo esc_html(get_theme_mod("wpmart_category_desc_$i", 'Default description here.')); ?>
                                </div>

                                <?php
                                $num_skills = get_theme_mod("wpmart_num_skills_$i", '3');
                                for ($j = 1; $j <= $num_skills; $j++) :
                                ?>
                                    <!-- Skill Progress Bar -->
                                    <div class="wpmart-pt-progress-bar">
                                        <div class="wpmart-pt-progress-bar-title">
                                            <span>
                                                <?php echo esc_html(get_theme_mod("wpmart_skill_name_{$i}_$j", "Skill $j")); ?>
                                            </span>
                                            <div class="wpmart-pt-custom-tooltip">
                                                <?php echo esc_html(get_theme_mod("wpmart_skill_value_{$i}_$j", '50')); ?>%
                                               
                                            </div>
                                        </div>
                                        <div class="wpmart-pt-custom-progress-bar">
                                        <div class="wpmart-pt-progress-bar-value" style="width: <?php echo esc_attr(get_theme_mod("wpmart_skill_value_{$i}_$j", '50')); ?>%;"></div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php 
                endif; 
            ?>
            <!-- Skill List End -->
            
        </div>

</div><!-- #main -->

<?php get_footer(); ?>