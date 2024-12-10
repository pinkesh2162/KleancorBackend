<?php

/**
 * WpMart Portfolio Theme Customizer.
 *
 * @package WpMart_Portfolio_Theme
 * @param WP_Customize_Manager $wp_customize The customizer object.
 */

function wpmart_portfolio_customize_register($wp_customize)
{

    // Add custom header background color setting and control.
    $colors = array(
        'primary' => array('default' => '#0A2647', 'label' => 'Primary Color'),
        'secondary' => array('default' => '#144272', 'label' => 'Secondary Color'),
        'button' => array('default' => '#205295', 'label' => 'Button Color'),
        'button_hover' => array('default' => '#1e5daf', 'label' => 'Button Hover Color'),
        'text' => array('default' => '#0F2C59', 'label' => 'Text Color'),
        'link' => array('default' => '#2C74B3', 'label' => 'Link Color'),
        'white' => array('default' => '#ffffff', 'label' => 'White Color'),
        'section_background' => array('default' => '#EFEFEF', 'label' => 'Section Background Color'),
        'box_shadow' => array('default' => '#efefef', 'label' => 'Box Shadow Color')
    );

    foreach ($colors as $id => $data) {
        $wp_customize->add_setting($id . '_color', array(
            'default' => $data['default'],
            'sanitize_callback' => 'sanitize_hex_color',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id . '_color', array(
            'label' => $data['label'],
            'section' => 'colors',
            'settings' => $id . '_color',
        )));
    }

    
    // ############ Home Banner Settings Start ############
    $wp_customize->add_section('wpmart_home_banner_settings', [
        'title' => __('Home Banner', 'wpmart-portfolio'),
        'priority' => 50,
        'description' => __('Customize the Home Banner', 'wpmart-portfolio'),
    ]);

    $wp_customize->add_setting('wpmart_home_banner_activate', [
        'default' => true,
        'sanitize_callback' => 'wpmart_sanitize_checkbox',
    ]);
    $wp_customize->add_control('wpmart_home_banner_activate', [
        'label' => __('Show Home Banner Section', 'wpmart-portfolio'),
        'section' => 'wpmart_home_banner_settings',
        'type' => 'checkbox',
    ]);
     
    // Home Banner Image
    $wp_customize->add_setting('wpmart_homepage_banner', [
        'default' => '',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'wpmart_homepage_banner', [
        'label' => __('Homepage Banner Image', 'wpmart-portfolio'),
        'section' => 'wpmart_home_banner_settings',
        'mime_type' => 'image',
    ]));

    // Banner Texts
    $wp_customize->add_setting('wpmart_banner_texts', [
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('wpmart_banner_texts', [
        'label' => __('Banner Texts (Separate by New Line)', 'wpmart-portfolio'),
        'section' => 'wpmart_home_banner_settings',
        'type' => 'textarea',
    ]);

    // Banner Description
    $wp_customize->add_setting('wpmart_banner_description', [
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);

    $wp_customize->add_control('wpmart_banner_description', [
        'label' => __('Banner Description', 'wpmart-portfolio'),
        'section' => 'wpmart_home_banner_settings',
        'type' => 'textarea',
    ]);

    // Banner Button Text
    $wp_customize->add_setting('wpmart_banner_btn_text', [
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('wpmart_banner_btn_text', [
        'label' => __('Banner Button Text', 'wpmart-portfolio'),
        'section' => 'wpmart_home_banner_settings',
        'type' => 'text',
    ]);

    // Banner Button URL
    $wp_customize->add_setting('wpmart_banner_btn_url', [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('wpmart_banner_btn_url', [
        'label' => __('Banner Button URL', 'wpmart-portfolio'),
        'section' => 'wpmart_home_banner_settings',
        'type' => 'url',
    ]);
    
    // ############ Home Banner Settings End ############

   
    // ############ Summary About Sections Start ############
    $wp_customize->add_section('wpmart_summary_about', [
        'title' => __('About Sections', 'wpmart-portfolio'),
        'priority' => 50,
        'description' => __('Customize the About Sections', 'wpmart-portfolio'),
    ]);
    $wp_customize->add_setting('wpmart_summary_about_activate', [
        'default' => true, // Default is to show the section
        'sanitize_callback' => 'wpmart_sanitize_checkbox',
    ]);

    $wp_customize->add_control('wpmart_summary_about_activate', [
        'label' => __('Activate Summary About Section', 'wpmart-portfolio'),
        'section' => 'wpmart_summary_about',
        'type' => 'checkbox',
    ]);   

    // Adding setting for 'About' section title
    $wp_customize->add_setting('wpmart_summary_about_title', [
        'default' => 'ABOUT WPMARTS',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    // Adding control for 'About' section title
    $wp_customize->add_control('wpmart_summary_about_title', [
        'label' => __('About Section Title', 'wpmart-portfolio'),
        'section' => 'wpmart_summary_about',
        'type' => 'text',
    ]);    
 
    
    // Setting for number of About sections
    $wp_customize->add_setting('wpmart_num_about_sections', [
        'default' => '3',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('wpmart_num_about_sections', [
        'label' => __('Number of About Sections', 'wpmart-portfolio'),
        'section' => 'wpmart_summary_about',
        'type' => 'number',
    ]);

    $num_about_sections = get_theme_mod('wpmart_num_about_sections', 3);

    // Default titles to help guide users
    $default_titles = ['SUMMARY ABOUT ME', 'MY CAREER', 'MY EDUCATION'];

    for ($i = 1; $i <= $num_about_sections; $i++) {

        // Dynamic Title
        $wp_customize->add_setting("wpmart_pt_about_sec_title_$i", [
            'default' => $default_titles[$i-1] ?? "Section $i",
            'sanitize_callback' => 'wp_kses_post',
        ]);

        $wp_customize->add_control("wpmart_pt_about_sec_title_$i", [
            'label' => __("Part $i Title", 'wpmart-portfolio'),
            'section' => 'wpmart_summary_about',
            'type' => 'text',
        ]);

        // Dynamic Description
        $wp_customize->add_setting("wpmart_pt_summary_about_me_des_$i", [
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        ]);

        $wp_customize->add_control("wpmart_pt_summary_about_me_des_$i", [
            'label' => __("Part $i Description", 'wpmart-portfolio'),
            'section' => 'wpmart_summary_about',
            'type' => 'textarea',
        ]);
    }
    // ############ Summary About Sections End ############


   // ############ Achievements section Start ############
    $wp_customize->add_section('wpmart_achievements', [
        'title' => __('Counter Sections', 'wpmart-portfolio'),
        'priority' => 60,
        'description' => __('Customize the Counter Sections', 'wpmart-portfolio'),
    ]);

    $wp_customize->add_setting('wpmart_achievements_activate', [
        'default' => true, // Default is to show the section
        'sanitize_callback' => 'wpmart_sanitize_checkbox',
    ]);
    
    $wp_customize->add_control('wpmart_achievements_activate', [
        'label' => __('Activate Achievements Section', 'wpmart-portfolio'),
        'section' => 'wpmart_achievements',
        'type' => 'checkbox',
    ]);

    $wp_customize->add_setting('wpmart_achievment_title', [
        'default' => 'MY ACHIEVEMENTS',
        'sanitize_callback' => 'wp_kses_post',
    ]);

    $wp_customize->add_control('wpmart_achievment_title', [
        'label' => __('Achievement Section Title', 'wpmart-portfolio'),
        'section' => 'wpmart_achievements',
        'type' => 'text',
    ]);

    // Setting for number of counters
    $wp_customize->add_setting('wpmart_num_achievements', [
        'default' => '3',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('wpmart_num_achievements', [
        'label' => __('Number of Counters', 'wpmart-portfolio'),
        'section' => 'wpmart_achievements',
        'type' => 'number',
    ]);

    $num_achievements = get_theme_mod('wpmart_num_achievements', 3);

    // Add settings and controls for each counter
    for ($i = 1; $i <= $num_achievements; $i++) {
        $wp_customize->add_setting("wpmart_counter_number_$i", [
            'default' => '5454',
            'sanitize_callback' => 'absint',
        ]);
        $wp_customize->add_control("wpmart_counter_number_$i", [
            'label' => __("Counter $i Number", 'wpmart-portfolio'),
            'section' => 'wpmart_achievements',
            'type' => 'number',
        ]);

        $wp_customize->add_setting("wpmart_counter_title_$i", [
            'default' => 'articles',
            'sanitize_callback' => 'wp_kses_post',
        ]);
        $wp_customize->add_control("wpmart_counter_title_$i", [
            'label' => __("Counter $i Title", 'wpmart-portfolio'),
            'section' => 'wpmart_achievements',
            'type' => 'text',
        ]);

        $wp_customize->add_setting("wpmart_counter_description_$i", [
            'default' => 'Habitasse platea dictumst. Ut tellus sem, suscipit ut enim id.',
            'sanitize_callback' => 'wp_kses_post',
        ]);
        $wp_customize->add_control("wpmart_counter_description_$i", [
            'label' => __("Counter $i Description", 'wpmart-portfolio'),
            'section' => 'wpmart_achievements',
            'type' => 'textarea',
        ]);
    }  
    // ############ Achievements section End ############


    // ############ Skills section Start ############
    $wp_customize->add_section('wpmart_skill_list', array(
        'title'      => __('Skill List', 'wpmart-portfolio'),
        'priority'   => 70,
        'capability' => 'edit_theme_options',
    ));

    // Skill List Activation Setting
    $wp_customize->add_setting('wpmart_skill_list_activate', [
        'default' => true, // Default is to show the section
        'sanitize_callback' => 'wpmart_sanitize_checkbox',
    ]);

    $wp_customize->add_control('wpmart_skill_list_activate', [
        'label' => __('Activate Skill List Section', 'wpmart-portfolio'),
        'section' => 'wpmart_skill_list',
        'type' => 'checkbox',
    ]);


    // Main Heading Setting
    $wp_customize->add_setting('wpmart_skill_section_heading', array(
        'default'           => 'MY LATEST WORK',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('wpmart_skill_section_heading', array(
        'label'    => __('Main Heading', 'wpmart-portfolio'),
        'section'  => 'wpmart_skill_list',
        'type'     => 'text',
    ));

    // Number of Categories
    $wp_customize->add_setting('wpmart_num_categories', array(
        'default'           => '2',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('wpmart_num_categories', array(
        'label'    => __('Number of Categories', 'wpmart-portfolio'),
        'section'  => 'wpmart_skill_list',
        'type'     => 'number',
    ));

    $num_categories = get_theme_mod('wpmart_num_categories', '2');

    for ($i = 1; $i <= $num_categories; $i++) {
        // Category Title
        $wp_customize->add_setting("wpmart_category_title_$i", array(
            'default'           => "Category $i",
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("wpmart_category_title_$i", array(
            'label'    => __("Category $i Title", 'wpmart-portfolio'),
            'section'  => 'wpmart_skill_list',
            'type'     => 'text',
        ));

        // Category Description
        $wp_customize->add_setting("wpmart_category_desc_$i", array(
            'default'           => 'Default description here.',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("wpmart_category_desc_$i", array(
            'label'    => __("Category $i Description", 'wpmart-portfolio'),
            'section'  => 'wpmart_skill_list',
            'type'     => 'textarea',
        ));

        // Number of Skills in Category
        $wp_customize->add_setting("wpmart_num_skills_$i", array(
            'default'           => '3',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control("wpmart_num_skills_$i", array(
            'label'    => __("Number of Skills in Category $i", 'wpmart-portfolio'),
            'section'  => 'wpmart_skill_list',
            'type'     => 'number',
        ));

        $num_skills = get_theme_mod("wpmart_num_skills_$i", '3');
        for ($j = 1; $j <= $num_skills; $j++) {
            // Skill Name
            $wp_customize->add_setting("wpmart_skill_name_{$i}_$j", array(
                'default'           => "Skill $j",
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control("wpmart_skill_name_{$i}_$j", array(
                'label'    => __("Skill Name for Category $i - Skill $j", 'wpmart-portfolio'),
                'section'  => 'wpmart_skill_list',
                'type'     => 'text',
            ));

            // Skill Value
            $wp_customize->add_setting("wpmart_skill_value_{$i}_$j", array(
                'default'           => '50',
                'sanitize_callback' => 'absint',
            ));
            $wp_customize->add_control("wpmart_skill_value_{$i}_$j", array(
                'label'    => __("Skill $j Progress (%) for Category $i", 'wpmart-portfolio'),
                'section'  => 'wpmart_skill_list',
                'type'     => 'number',
            ));
        }
    }
    // ############ Skills section End ############


    // ############ Projects section Start ############
    $wp_customize->add_section('wpmart_projects', [
        'title' => __('Projects', 'wpmart-portfolio'),
        'priority' => 80,
        'description' => __('Customize the Projects Section', 'wpmart-portfolio'),
    ]);

    // Projects Activation Setting
    $wp_customize->add_setting('wpmart_projects_activate', [
        'default' => true,
        'sanitize_callback' => 'wpmart_sanitize_checkbox',
    ]);

    $wp_customize->add_control('wpmart_projects_activate', [
        'label' => __('Activate Projects Section', 'wpmart-portfolio'),
        'section' => 'wpmart_projects',
        'type' => 'checkbox',
    ]);

    $wp_customize->add_setting('wpmart_project_section_title', [
        'default' => 'MY LATEST WORK',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    $wp_customize->add_control('wpmart_project_section_title', [
        'label' => __('Projects Section Title', 'wpmart-portfolio'),
        'section' => 'wpmart_projects',
        'type' => 'text',
    ]);

    // Number of Projects setting and control
    $wp_customize->add_setting('wpmart_num_projects', [
        'default' => '6', 
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('wpmart_num_projects', [
        'label' => __('Number of Projects', 'wpmart-portfolio'),
        'section' => 'wpmart_projects',
        'type' => 'number',
        'description' => __('Set how many projects you want to display.', 'wpmart-portfolio'),
    ]);

    $num_projects = get_theme_mod('wpmart_num_projects', 6); 
    
    $wp_customize->add_setting('wpmart_project_section_desc', [
        'default' => 'Maecenas quis justo at neque venenatis sagittis...',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    
    $wp_customize->add_control('wpmart_project_section_desc', [
        'label' => __('Projects Section Description', 'wpmart-portfolio'),
        'section' => 'wpmart_projects',
        'type' => 'textarea',
    ]);
    
    // ############ Projects section End ############


    // ############ Start Testimonials section ############
    $wp_customize->add_section('wpmart_testimonials', [
        'title' => __('Testimonials', 'wpmart-portfolio'),
        'priority' => 80,
        'description' => __('Customize the Testimonials Section', 'wpmart-portfolio'),
    ]);
    
    // Activate Testimonials Section
    $wp_customize->add_setting('wpmart_testimonials_activate', [
        'default' => true,
        'sanitize_callback' => 'wpmart_sanitize_checkbox',
    ]);
    $wp_customize->add_control('wpmart_testimonials_activate', [
        'label' => __('Activate Testimonials Section', 'wpmart-portfolio'),
        'section' => 'wpmart_testimonials',
        'type' => 'checkbox',
    ]);
    
    // Testimonials Section Title
    $wp_customize->add_setting('wpmart_testimonial_section_title', [
        'default' => 'Our Testimonials',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('wpmart_testimonial_section_title', [
        'label' => __('Testimonials Section Title', 'wpmart-portfolio'),
        'section' => 'wpmart_testimonials',
        'type' => 'text',
    ]);
    
    // Number of testimonials
    $wp_customize->add_setting('wpmart_num_testimonials', [
        'default' => '5',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('wpmart_num_testimonials', [
        'label' => __('Number of Testimonials', 'wpmart-portfolio'),
        'section' => 'wpmart_testimonials',
        'type' => 'number',
        'description' => __('Set how many testimonials you want to display.', 'wpmart-portfolio'),
    ]);
    
    $num_testimonials = get_theme_mod('wpmart_num_testimonials', 5);
    for ($i = 1; $i <= $num_testimonials; $i++) {
        // Job Title
        $wp_customize->add_setting("wpmart_testimonial_title_$i", [
            'default' => "Apps Development",
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        $wp_customize->add_control("wpmart_testimonial_title_$i", [
            'label' => __("Job Title $i", 'wpmart-portfolio'),
            'section' => 'wpmart_testimonials',
            'type' => 'text',
        ]);

        // Testimonial Text
        $wp_customize->add_setting("wpmart_testimonial_text_$i", [
            'default' => "Very attentive and keen to instructions. Will work with him again.",
            'sanitize_callback' => 'wp_kses_post',
        ]);

        $wp_customize->add_control("wpmart_testimonial_text_$i", [
            'label' => __("Feedback Text $i", 'wpmart-portfolio'),
            'section' => 'wpmart_testimonials',
            'type' => 'textarea',
        ]);

        // Client Name
        $wp_customize->add_setting("wpmart_testimonial_client_$i", [
            'default' => "John Doe",
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        $wp_customize->add_control("wpmart_testimonial_client_$i", [
            'label' => __("Client Name $i", 'wpmart-portfolio'),
            'section' => 'wpmart_testimonials',
            'type' => 'text',
        ]);

        // Client Image
        $wp_customize->add_setting("wpmart_testimonial_image_$i", [
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "wpmart_testimonial_image_$i", [
            'label' => __("Client Image $i", 'wpmart-portfolio'),
            'section' => 'wpmart_testimonials',
        ]));

        // Testimonial Star Rating
        $wp_customize->add_setting("wpmart_testimonial_star_rating_$i", [
            'default' => 5,
            'sanitize_callback' => 'absint',
        ]);

        $wp_customize->add_control("wpmart_testimonial_star_rating_$i", [
            'label' => __("Star Rating for Testimonial $i (out of 5)", 'wpmart-portfolio'),
            'section' => 'wpmart_testimonials',
            'type' => 'number',
            'input_attrs' => [
                'min' => 1,
                'max' => 5,
            ],
        ]);
    }
    // ############ End Testimonials section ############



    // ############ Footer section Start ############
    $wp_customize->add_section('wpmart_footer_settings', [
        'title' => __('Footer Settings', 'wpmart-portfolio'),
        'priority' => 200,
        'description' => __('Customize the Footer Settings', 'wpmart-portfolio'),
    ]);

    // Add setting for copyright text
    $wp_customize->add_setting('wpmart_footer_copyright_text', [
        'default' => '&copy; 2023 Betheme by Muffin group | All Rights Reserved | Powered by WordPress',
        'sanitize_callback' => 'wp_kses_post',
    ]);

    $wp_customize->add_control('wpmart_footer_copyright_text', [
        'label' => __('Footer Copyright Text', 'wpmart-portfolio'),
        'section' => 'wpmart_footer_settings',
        'type' => 'textarea',
    ]);

    // Social Activation Setting
    $wp_customize->add_setting('wpmart_social_activate', [
        'default' => true,
        'sanitize_callback' => 'wpmart_sanitize_checkbox',
    ]);

    $wp_customize->add_control('wpmart_social_activate', [
        'label' => __('Activate Social Section', 'wpmart-portfolio'),
        'section' => 'wpmart_footer_settings',
        'type' => 'checkbox',
    ]);

    $social_links = [
        'google' => __('Google Social Link', 'wpmart-portfolio'),
        'pinterest' => __('Pinterest Social Link', 'wpmart-portfolio'),
        'linkedin' => __('LinkedIn Social Link', 'wpmart-portfolio'),
        'twitter' => __('Twitter Social Link', 'wpmart-portfolio'),
    ];

    foreach ($social_links as $key => $label) {
        $wp_customize->add_setting("wpmart_social_$key", [
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);

        $wp_customize->add_control("wpmart_social_$key", [
            'label' => $label,
            'section' => 'wpmart_footer_settings',
            'type' => 'url',
        ]);
    } 
}
    // ############ Footer section End ############

add_action('customize_register', 'wpmart_portfolio_customize_register');

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function wpmart_portfolio_customize_preview_js()
{
    wp_enqueue_script('wpmart-portfolio-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), '1.0', true);
}
add_action('customize_preview_init', 'wpmart_portfolio_customize_preview_js');
