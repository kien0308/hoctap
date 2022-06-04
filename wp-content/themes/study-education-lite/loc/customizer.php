<?php 
function study_education_lite_customize_register($wp_customize){

    // Register custom section types.
    $wp_customize->register_section_type( 'study_education_lite_Customize_Section_Pro' );

    // Register sections.
    $wp_customize->add_section( new study_education_lite_Customize_Section_Pro(
        $wp_customize,
        'theme_go_pro',
        array(
            'priority' => 1,
            'title'    => esc_html__( 'Study Education Pro', 'study-education-lite' ),
            'pro_text' => esc_html__( 'Upgrade To Pro', 'study-education-lite' ),
            'pro_url'  => 'https://www.featherthemes.com/themes/wordpress-template-study-education-pro/',
        )
    ) );
    $wp_customize->add_section('study_education_lite_header', array(
        'title'    => esc_html__('Header Phone and Email', 'study-education-lite'),
        'description' => '',
        'priority' => 30,
    ));
     $wp_customize->add_section('study_education_lite_social', array(
        'title'    => esc_html__('Social Section', 'study-education-lite'),
        'description' => '',
        'priority' => 35,
    ));


    //  =============================
    //  = Text Input phone number                =
    //  =============================
    $wp_customize->add_setting('study_education_lite_phone', array(
        'default'        => '',
        'sanitize_callback' => 'study_education_lite_sanitize_phone_number'
    ));
 
    $wp_customize->add_control('study_education_lite_phone', array(
        'label'      => esc_html__('Phone Number', 'study-education-lite'),
        'section'    => 'study_education_lite_header',
        'setting'   => 'study_education_lite_phone',
        'type'    => 'text'
    ));
    
      
    //  =============================
    //  = Text Input Email                =
    //  =============================
    $wp_customize->add_setting('study_education_lite_address', array(
        'default'        => '',
        'sanitize_callback' => 'sanitize_email'       
    ));
 
    $wp_customize->add_control('study_education_lite_address', array(
        'label'      => esc_html__('Email Address', 'study-education-lite'),
        'section'    => 'study_education_lite_header',
        'setting'   => 'study_education_lite_address',
        'type'    => 'email'
    ));
    
    //  =============================
    //  = Text Input facebook                =
    //  =============================
    $wp_customize->add_setting('study_education_lite_fb', array(
        'default'        => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control('study_education_lite_fb', array(
        'label'      => esc_html__('Facebook', 'study-education-lite'),
        'section'    => 'study_education_lite_social',
        'setting'   => 'study_education_lite_fb',
    ));
    //  =============================
    //  = Text Input Twitter                =
    //  =============================
    $wp_customize->add_setting('study_education_lite_twitter', array(
        'default'        => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control('study_education_lite_twitter', array(
        'label'      => esc_html__('Twitter', 'study-education-lite'),
        'section'    => 'study_education_lite_social',
        'setting'   => 'study_education_lite_twitter',
    ));
    //  =============================
    //  = Text Input youtube                =
    //  =============================
    $wp_customize->add_setting('study_education_lite_youtube', array(
        'default'        => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control('study_education_lite_youtube', array(
        'label'      => esc_html__('YouTube', 'study-education-lite'),
        'section'    => 'study_education_lite_social',
        'setting'   => 'study_education_lite_youtube',
    ));
    //  =============================
    //  = Text Input linkedin                =
    //  =============================
    $wp_customize->add_setting('study_education_lite_in', array(
        'default'        => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control('study_education_lite_in', array(
        'label'      => esc_html__('Linkedin', 'study-education-lite'),
        'section'    => 'study_education_lite_social',
        'setting'   => 'study_education_lite_in',
    ));

    //  =============================
    //  = slider section              =
    //  =============================
    $wp_customize->add_section('study_education_lite_banner', array(
        'title'    => esc_html__('Home Banner Text', 'study-education-lite'),
        'description' => esc_html__('add home banner text here.','study-education-lite'),
        'priority' => 36,
    ));
   
// Banner heading Text
    $wp_customize->add_setting('banner_heading',array(
            'default'   => null,
            'sanitize_callback' => 'sanitize_text_field'    
    ));
    
    $wp_customize->add_control('banner_heading',array( 
            'type'  => 'text',
            'label' => esc_html__('Add Banner heading here','study-education-lite'),
            'section'   => 'study_education_lite_banner',
            'setting'   => 'banner_heading'
    )); // Banner heading Text

    // Banner heading Text
    $wp_customize->add_setting('banner_sub_heading',array(
            'default'   => null,
            'sanitize_callback' => 'sanitize_text_field'    
    ));
    
    $wp_customize->add_control('banner_sub_heading',array( 
            'type'  => 'text',
            'label' => esc_html__('Add Banner sub heading here','study-education-lite'),
            'section'   => 'study_education_lite_banner',
            'setting'   => 'banner_sub_heading'
    )); // Banner heading Text

    //  =============================
    //  = box section              =
    //  =============================
    $wp_customize->add_section('study_education_lite_box', array(
        'title'    => esc_html__('Resource Section', 'study-education-lite'),
        'description' => esc_html__('Upload image, it will auto crop with 400*250.','study-education-lite'),
        'priority' => 36,
    ));
   
    $wp_customize->add_setting('study_education_lite_box1',array(
            'default'   => '0',         
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'study_education_lite_sanitize_page'
    ));
    
    $wp_customize->add_control('study_education_lite_box1',array(
            'type'  => 'dropdown-pages',
            'label' => esc_html__('Select page for Resource first:','study-education-lite'),
            'section'   => 'study_education_lite_box'
    )); 

    $wp_customize->add_setting('study_education_lite_box2',array(
            'default'   => '0',         
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'study_education_lite_sanitize_page'
    ));
    
    $wp_customize->add_control('study_education_lite_box2',array(
            'type'  => 'dropdown-pages',
            'label' => esc_html__('Select page for Resource second:','study-education-lite'),
            'section'   => 'study_education_lite_box'
    )); 

    $wp_customize->add_setting('study_education_lite_box3',array(
            'default'   => '0',         
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'study_education_lite_sanitize_page'
    ));
    
    $wp_customize->add_control('study_education_lite_box3',array(
            'type'  => 'dropdown-pages',
            'label' => esc_html__('Select page for Resource third:','study-education-lite'),
            'section'   => 'study_education_lite_box'
    )); 

    $wp_customize->add_setting('study_education_lite_box4',array(
        'default'   => '0',         
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'study_education_lite_sanitize_page'
));

$wp_customize->add_control('study_education_lite_box4',array(
        'type'  => 'dropdown-pages',
        'label' => esc_html__('Select page for Resource fourth:','study-education-lite'),
        'section'   => 'study_education_lite_box'
)); 

//  =============================
    //  = box section              =
    //  =============================

  //  =============================
    //  = Footer              =
    //  =============================

    $wp_customize->add_section('study_education_lite_footer', array(
        'title'    => esc_html__('Footer', 'study-education-lite'),
        'description' => '',
        'priority' => 37,
    ));

	// Footer design and developed
	 $wp_customize->add_setting('study_education_lite_design', array(
        'default'        => '',
		'sanitize_callback' => 'sanitize_textarea_field'
    ));
 
    $wp_customize->add_control('study_education_lite_design', array(
        'label'      => esc_html__('Design and developed', 'study-education-lite'),
        'section'    => 'study_education_lite_footer',
        'setting'   => 'study_education_lite_design',
		'type'	   =>'textarea'
    ));
	// Footer copyright
	 $wp_customize->add_setting('study_education_lite_copyright', array(
        'default'        => '',
		'sanitize_callback' => 'sanitize_textarea_field'       
    ));
 
    $wp_customize->add_control('study_education_lite_copyright', array(
        'label'      => esc_html__('Copyright', 'study-education-lite'),
        'section'    => 'study_education_lite_footer',
        'setting'   => 'study_education_lite_copyright',
		'type'	   =>'textarea'
    ));	
}
add_action('customize_register', 'study_education_lite_customize_register');

function study_education_lite_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}