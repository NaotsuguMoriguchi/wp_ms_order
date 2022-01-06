<?php    
/**
 *shopfume-lite Theme Customizer
 *
 * @package Shopfume Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shopfume_lite_customize_register( $wp_customize ) {	
	
	function shopfume_lite_sanitize_dropdown_pages( $page_id, $setting ) {
	  // Ensure $input is an absolute integer.
	  $page_id = absint( $page_id );	
	  // If $page_id is an ID of a published page, return it; otherwise, return the default.
	  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}

	function shopfume_lite_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	} 
	
	function shopfume_lite_sanitize_phone_number( $phone ) {
		// sanitize phone
		return preg_replace( '/[^\d+]/', '', $phone );
	} 
	
	
	function shopfume_lite_sanitize_excerptrange( $number, $setting ) {	
		// Ensure input is an absolute integer.
		$number = absint( $number );	
		// Get the input attributes associated with the setting.
		$atts = $setting->manager->get_control( $setting->id )->input_attrs;	
		// Get minimum number in the range.
		$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );	
		// Get maximum number in the range.
		$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );	
		// Get step.
		$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );	
		// If the number is within the valid range, return it; otherwise, return the default
		return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
	}

	function shopfume_lite_sanitize_number_absint( $number, $setting ) {
		// Ensure $number is an absolute integer (whole number, zero or greater).
		$number = absint( $number );		
		// If the input is an absolute integer, return it; otherwise, return the default
		return ( $number ? $number : $setting->default );
	}
	
	// Ensure is an absolute integer
	function shopfume_lite_sanitize_choices( $input, $setting ) {
		global $wp_customize; 
		$control = $wp_customize->get_control( $setting->id ); 
		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}
	
		
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.logo h1 a',
		'render_callback' => 'shopfume_lite_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.logo p',
		'render_callback' => 'shopfume_lite_customize_partial_blogdescription',
	) );
		
	 	
	 //Panel for section & control
	$wp_customize->add_panel( 'shopfume_lite_panel_for_themesettings', array(
		'priority' => 4,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Shopfume Lite Settings', 'shopfume-lite' ),		
	) );

	$wp_customize->add_section('shopfume_lite_layoutoptions',array(
		'title' => __('Site Layout Options','shopfume-lite'),			
		'priority' => 1,
		'panel' => 	'shopfume_lite_panel_for_themesettings',          
	));		
	
	$wp_customize->add_setting('shopfume_lite_layouttype',array(
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'shopfume_lite_layouttype', array(
    	'section'   => 'shopfume_lite_layoutoptions',    	 
		'label' => __('Check to Show Box Layout','shopfume-lite'),
		'description' => __('check for box layout','shopfume-lite'),
    	'type'      => 'checkbox'
     )); //Box Layout Options 
	
	$wp_customize->add_setting('shopfume_lite_colorscheme',array(
		'default' => '#00b7f1',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'shopfume_lite_colorscheme',array(
			'label' => __('Site Color Options','shopfume-lite'),			
			'section' => 'colors',
			'settings' => 'shopfume_lite_colorscheme'
		))
	);
	
	$wp_customize->add_setting('shopfume_lite_hdrnavcolor',array(
		'default' => '#333333',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'shopfume_lite_hdrnavcolor',array(
			'label' => __('Navigation font Color','shopfume-lite'),			
			'section' => 'colors',
			'settings' => 'shopfume_lite_hdrnavcolor'
		))
	);
	
	
	$wp_customize->add_setting('shopfume_lite_hdrnavactive',array(
		'default' => '#eea702',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'shopfume_lite_hdrnavactive',array(
			'label' => __('Navigation Hover/Active Color','shopfume-lite'),			
			'section' => 'colors',
			'settings' => 'shopfume_lite_hdrnavactive'
		))
	);
	
	 //Header Contact details
	$wp_customize->add_section('shopfume_lite_hdrcontactdetails',array(
		'title' => __('Header Contact Details','shopfume-lite'),				
		'priority' => null,
		'panel' => 	'shopfume_lite_panel_for_themesettings',
	));	
	
	
	$wp_customize->add_setting('shopfume_lite_emailid',array(
		'sanitize_callback' => 'sanitize_email'
	));
	
	$wp_customize->add_control('shopfume_lite_emailid',array(
		'type' => 'email',
		'label' => __('enter email id here.','shopfume-lite'),
		'section' => 'shopfume_lite_hdrcontactdetails'
	));		
	
	
	$wp_customize->add_setting('shopfume_lite_phoneno',array(
		'default' => null,
		'sanitize_callback' => 'shopfume_lite_sanitize_phone_number'	
	));
	
	$wp_customize->add_control('shopfume_lite_phoneno',array(	
		'type' => 'text',
		'label' => __('Enter phone number here','shopfume-lite'),
		'section' => 'shopfume_lite_hdrcontactdetails',
		'setting' => 'shopfume_lite_phoneno'
	));	
		
	
	$wp_customize->add_setting('shopfume_lite_show_hdrcontactdetails',array(
		'default' => false,
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'shopfume_lite_show_hdrcontactdetails', array(
	   'settings' => 'shopfume_lite_show_hdrcontactdetails',
	   'section'   => 'shopfume_lite_hdrcontactdetails',
	   'label'     => __('Check To show This Section','shopfume-lite'),
	   'type'      => 'checkbox'
	 ));//Show Contact Details Sections
	 
	
	 //Social icons Section
	$wp_customize->add_section('shopfume_lite_hdrsocial_options',array(
		'title' => __('Header Social icons','shopfume-lite'),
		'description' => __( 'Add social icons link here to display icons in header ', 'shopfume-lite' ),			
		'priority' => null,
		'panel' => 	'shopfume_lite_panel_for_themesettings', 
	));
	
	$wp_customize->add_setting('shopfume_lite_hdrfb_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'	
	));
	
	$wp_customize->add_control('shopfume_lite_hdrfb_link',array(
		'label' => __('Add facebook link here','shopfume-lite'),
		'section' => 'shopfume_lite_hdrsocial_options',
		'setting' => 'shopfume_lite_hdrfb_link'
	));	
	
	$wp_customize->add_setting('shopfume_lite_hdrtw_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('shopfume_lite_hdrtw_link',array(
		'label' => __('Add twitter link here','shopfume-lite'),
		'section' => 'shopfume_lite_hdrsocial_options',
		'setting' => 'shopfume_lite_hdrtw_link'
	));

	
	$wp_customize->add_setting('shopfume_lite_hdrin_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('shopfume_lite_hdrin_link',array(
		'label' => __('Add linkedin link here','shopfume-lite'),
		'section' => 'shopfume_lite_hdrsocial_options',
		'setting' => 'shopfume_lite_hdrin_link'
	));
	
	$wp_customize->add_setting('shopfume_lite_hdrigram_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('shopfume_lite_hdrigram_link',array(
		'label' => __('Add instagram link here','shopfume-lite'),
		'section' => 'shopfume_lite_hdrsocial_options',
		'setting' => 'shopfume_lite_hdrigram_link'
	));
	
	
	$wp_customize->add_setting('shopfume_lite_show_hdrsocial_options',array(
		'default' => false,
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'shopfume_lite_show_hdrsocial_options', array(
	   'settings' => 'shopfume_lite_show_hdrsocial_options',
	   'section'   => 'shopfume_lite_hdrsocial_options',
	   'label'     => __('Check To show This Section','shopfume-lite'),
	   'type'      => 'checkbox'
	 ));//Show Social settings
	
	 	
	//Slider Section		
	$wp_customize->add_section( 'shopfume_lite_hdrslide_sections', array(
		'title' => __('Frontapage Slider Settings', 'shopfume-lite'),
		'priority' => null,
		'description' => __('Default image size for slider is 1400 x 670 pixel.','shopfume-lite'), 
		'panel' => 	'shopfume_lite_panel_for_themesettings',           			
    ));
	
	$wp_customize->add_setting('shopfume_lite_hdrslidepage1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'shopfume_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('shopfume_lite_hdrslidepage1',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 1:','shopfume-lite'),
		'section' => 'shopfume_lite_hdrslide_sections'
	));	
	
	$wp_customize->add_setting('shopfume_lite_hdrslidepage2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'shopfume_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('shopfume_lite_hdrslidepage2',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 2:','shopfume-lite'),
		'section' => 'shopfume_lite_hdrslide_sections'
	));	
	
	$wp_customize->add_setting('shopfume_lite_hdrslidepage3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'shopfume_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('shopfume_lite_hdrslidepage3',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slide 3:','shopfume-lite'),
		'section' => 'shopfume_lite_hdrslide_sections'
	));	//frontpage Slider Section	
	
	//Slider Excerpt Length
	$wp_customize->add_setting( 'shopfume_lite_excerpt_length_hdrslide', array(
		'default'              => 15,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'shopfume_lite_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'shopfume_lite_excerpt_length_hdrslide', array(
		'label'       => __( 'Slider Excerpt length','shopfume-lite' ),
		'section'     => 'shopfume_lite_hdrslide_sections',
		'type'        => 'range',
		'settings'    => 'shopfume_lite_excerpt_length_hdrslide','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );	
	
	$wp_customize->add_setting('shopfume_lite_hdrslidepage_btntext',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('shopfume_lite_hdrslidepage_btntext',array(	
		'type' => 'text',
		'label' => __('enter button name here','shopfume-lite'),
		'section' => 'shopfume_lite_hdrslide_sections',
		'setting' => 'shopfume_lite_hdrslidepage_btntext'
	)); // slider read more button text
	
	$wp_customize->add_setting('shopfume_lite_show_hdrslide_sections',array(
		'default' => false,
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'shopfume_lite_show_hdrslide_sections', array(
	    'settings' => 'shopfume_lite_show_hdrslide_sections',
	    'section'   => 'shopfume_lite_hdrslide_sections',
	    'label'     => __('Check To Show This Section','shopfume-lite'),
	   'type'      => 'checkbox'
	 ));//Show Header Slider Settings	
	 
	 
	 //Three pages Services Sections
	$wp_customize->add_section('shopfume_lite_services_threecolumn_sections', array(
		'title' => __('Three Page Boxes Sections','shopfume-lite'),
		'description' => __('Select pages from the dropdown for three column section','shopfume-lite'),
		'priority' => null,
		'panel' => 	'shopfume_lite_panel_for_themesettings',          
	));	
		
	$wp_customize->add_setting('shopfume_lite_services_threecolumn_page1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'shopfume_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'shopfume_lite_services_threecolumn_page1',array(
		'type' => 'dropdown-pages',			
		'section' => 'shopfume_lite_services_threecolumn_sections',
	));		
	
	$wp_customize->add_setting('shopfume_lite_services_threecolumn_page2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'shopfume_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'shopfume_lite_services_threecolumn_page2',array(
		'type' => 'dropdown-pages',			
		'section' => 'shopfume_lite_services_threecolumn_sections',
	));
	
	$wp_customize->add_setting('shopfume_lite_services_threecolumn_page3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'shopfume_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'shopfume_lite_services_threecolumn_page3',array(
		'type' => 'dropdown-pages',			
		'section' => 'shopfume_lite_services_threecolumn_sections',
	));		

	$wp_customize->add_setting( 'shopfume_lite_threecolumn_excerpt_length', array(
		'default'              => 0,
		'type'                 => 'theme_mod',		
		'sanitize_callback'    => 'shopfume_lite_sanitize_excerptrange',		
	) );
	$wp_customize->add_control( 'shopfume_lite_threecolumn_excerpt_length', array(
		'label'       => __( 'four page box excerpt length','shopfume-lite' ),
		'section'     => 'shopfume_lite_services_threecolumn_sections',
		'type'        => 'range',
		'settings'    => 'shopfume_lite_threecolumn_excerpt_length','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );	
	
	$wp_customize->add_setting('shopfume_lite_threecolumn_readmorebutton',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('shopfume_lite_threecolumn_readmorebutton',array(	
		'type' => 'text',
		'label' => __('Read more button name here','shopfume-lite'),
		'section' => 'shopfume_lite_services_threecolumn_sections',
		'setting' => 'shopfume_lite_threecolumn_readmorebutton'
	)); //four box read more button text
	
	
	$wp_customize->add_setting('shopfume_lite_show_services_threecolumn_sections',array(
		'default' => false,
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));		
	
	$wp_customize->add_control( 'shopfume_lite_show_services_threecolumn_sections', array(
	   'settings' => 'shopfume_lite_show_services_threecolumn_sections',
	   'section'   => 'shopfume_lite_services_threecolumn_sections',
	   'label'     => __('Check To Show This Section','shopfume-lite'),
	   'type'      => 'checkbox'
	 ));//Show four page boxes sections
	 
	 
	 //Blog Posts Settings
	$wp_customize->add_panel( 'shopfume_lite_blogsettings_panel', array(
		'priority' => 3,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Blog Posts Settings', 'shopfume-lite' ),		
	) );
	
	$wp_customize->add_section('shopfume_lite_blogmeta_options',array(
		'title' => __('Blog Meta Options','shopfume-lite'),			
		'priority' => null,
		'panel' => 	'shopfume_lite_blogsettings_panel', 	         
	));		
	
	$wp_customize->add_setting('shopfume_lite_hide_blogdate',array(
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'shopfume_lite_hide_blogdate', array(
    	'label' => __('Check to hide post date','shopfume-lite'),	
		'section'   => 'shopfume_lite_blogmeta_options', 
		'setting' => 'shopfume_lite_hide_blogdate',		
    	'type'      => 'checkbox'
     )); //Blog Date
	 
	 
	 $wp_customize->add_setting('shopfume_lite_hide_postcats',array(
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'shopfume_lite_hide_postcats', array(
		'label' => __('Check to hide post category','shopfume-lite'),	
    	'section'   => 'shopfume_lite_blogmeta_options',		
		'setting' => 'shopfume_lite_hide_postcats',		
    	'type'      => 'checkbox'
     )); //blogposts category	 
	 
	 
	 $wp_customize->add_section('shopfume_lite_postfeatured_image',array(
		'title' => __('Posts Featured image','shopfume-lite'),			
		'priority' => null,
		'panel' => 	'shopfume_lite_blogsettings_panel', 	         
	));		
	
	$wp_customize->add_setting('shopfume_lite_hide_postfeatured_image',array(
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'shopfume_lite_hide_postfeatured_image', array(
		'label' => __('Check to hide post featured image','shopfume-lite'),
    	'section'   => 'shopfume_lite_postfeatured_image',		
		'setting' => 'shopfume_lite_hide_postfeatured_image',	
    	'type'      => 'checkbox'
     )); //Posts featured image
	 
	 
	 $wp_customize->add_setting('shopfume_lite_blogimg_fullwidth',array(
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'shopfume_lite_blogimg_fullwidth', array(
		'label' => __('Check to featured image Full Width','shopfume-lite'),
    	'section'   => 'shopfume_lite_postfeatured_image',		
		'setting' => 'shopfume_lite_blogimg_fullwidth',	
    	'type'      => 'checkbox'
     )); //posts featured full
	 
	  
	 $wp_customize->add_section('shopfume_lite_postmorebtn',array(
		'title' => __('Posts Read More Button','shopfume-lite'),			
		'priority' => null,
		'panel' => 	'shopfume_lite_blogsettings_panel', 	         
	 ));	
	 
	 $wp_customize->add_setting('shopfume_lite_postmorebuttontext',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	)); //blog read more button text
	
	$wp_customize->add_control('shopfume_lite_postmorebuttontext',array(	
		'type' => 'text',
		'label' => __('Read more button text for blog posts','shopfume-lite'),
		'section' => 'shopfume_lite_postmorebtn',
		'setting' => 'shopfume_lite_postmorebuttontext'
	)); //Post read more button text	
	
	$wp_customize->add_section('shopfume_lite_postcontent_settings',array(
		'title' => __('Posts Excerpt Options','shopfume-lite'),			
		'priority' => null,
		'panel' => 	'shopfume_lite_blogsettings_panel', 	         
	 ));	 
	 
	$wp_customize->add_setting( 'shopfume_lite_postexcerptrange', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'shopfume_lite_sanitize_excerptrange',		
	) );
	
	$wp_customize->add_control( 'shopfume_lite_postexcerptrange', array(
		'label'       => __( 'Excerpt length','shopfume-lite' ),
		'section'     => 'shopfume_lite_postcontent_settings',
		'type'        => 'range',
		'settings'    => 'shopfume_lite_postexcerptrange','input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting('shopfume_lite_postsfullcontent_options',array(
        'default' => 'Excerpt',     
        'sanitize_callback' => 'shopfume_lite_sanitize_choices'
	));
	
	$wp_customize->add_control('shopfume_lite_postsfullcontent_options',array(
        'type' => 'select',
        'label' => __('Posts Content','shopfume-lite'),
        'section' => 'shopfume_lite_postcontent_settings',
        'choices' => array(
        	'Content' => __('Content','shopfume-lite'),
            'Excerpt' => __('Excerpt','shopfume-lite'),
            'No Content' => __('No Excerpt','shopfume-lite')
        ),
	) ); 
	
	
	$wp_customize->add_section('shopfume_lite_postsinglemeta',array(
		'title' => __('Posts Single Settings','shopfume-lite'),			
		'priority' => null,
		'panel' => 	'shopfume_lite_blogsettings_panel', 	         
	));	
	
	$wp_customize->add_setting('shopfume_lite_hide_postdate_fromsingle',array(
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'shopfume_lite_hide_postdate_fromsingle', array(
    	'label' => __('Check to hide post date from single','shopfume-lite'),	
		'section'   => 'shopfume_lite_postsinglemeta', 
		'setting' => 'shopfume_lite_hide_postdate_fromsingle',		
    	'type'      => 'checkbox'
     )); //Hide Posts date from single
	 
	 
	 $wp_customize->add_setting('shopfume_lite_hide_postcats_fromsingle',array(
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'shopfume_lite_hide_postcats_fromsingle', array(
		'label' => __('Check to hide post category from single','shopfume-lite'),	
    	'section'   => 'shopfume_lite_postsinglemeta',		
		'setting' => 'shopfume_lite_hide_postcats_fromsingle',		
    	'type'      => 'checkbox'
     )); //Hide blogposts category single
	 
	 
	 //Sidebar Settings
	$wp_customize->add_section('shopfume_lite_sidebarsettings', array(
		'title' => __('Sidebar Settings','shopfume-lite'),		
		'priority' => null,
		'panel' => 	'shopfume_lite_blogsettings_panel',          
	));		
	 
	$wp_customize->add_setting('shopfume_lite_hidesidebar_blogposts',array(
		'default' => false,
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'shopfume_lite_hidesidebar_blogposts', array(
	   'settings' => 'shopfume_lite_hidesidebar_blogposts',
	   'section'   => 'shopfume_lite_sidebarsettings',
	   'label'     => __('Check to hide sidebar from homepage','shopfume-lite'),
	   'type'      => 'checkbox'
	 ));//hide sidebar blog posts 
	
		 
	 $wp_customize->add_setting('shopfume_lite_hidesidebar_singleposts',array(
		'default' => false,
		'sanitize_callback' => 'shopfume_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'shopfume_lite_hidesidebar_singleposts', array(
	   'settings' => 'shopfume_lite_hidesidebar_singleposts',
	   'section'   => 'shopfume_lite_sidebarsettings',
	   'label'     => __('Check to hide sidebar from single post','shopfume-lite'),
	   'type'      => 'checkbox'
	 ));// Hide sidebar single post	 
		 
}
add_action( 'customize_register', 'shopfume_lite_customize_register' );

function shopfume_lite_custom_css(){ 
?>
	<style type="text/css"> 					
        a,
        #sidebar ul li a:hover,
		#sidebar ol li a:hover,							
        .BLogStyle-01 h3 a:hover,		
        .postmeta a:hover,
		.hdrsocial a:hover,
		h4.sub_title,			 			
        .button:hover,
		.ThreePageColumn h4 a:hover,		
		h2.services_title span,			
		.BlogMeta-Strip a:hover,
		.BlogMeta-Strip a:focus,
		blockquote::before	
            { color:<?php echo esc_html( get_theme_mod('shopfume_lite_colorscheme','#00b7f1')); ?>;}					 
            
        .pagination ul li .current, .pagination ul li a:hover, 
        #commentform input#submit:hover,		
        .nivo-controlNav a.active,
		.sd-search input, .sd-top-bar-nav .sd-search input,			
		a.blogreadmore,
		.footer-fix,			
		.copyrigh-wrapper:before,										
        #sidebar .search-form input.search-submit,				
        .wpcf7 input[type='submit'],				
        nav.pagination .page-numbers.current,		
		.morebutton,
		.menu-toggle:hover,
		.menu-toggle:focus,	
		.nivo-directionNav a:hover,	
		.nivo-caption .slidermorebtn:hover		
            { background-color:<?php echo esc_html( get_theme_mod('shopfume_lite_colorscheme','#00b7f1')); ?>;}
			
		
		.tagcloud a:hover,
		.ThreePageColumn:hover .PageColumnBG,
		blockquote
            { border-color:<?php echo esc_html( get_theme_mod('shopfume_lite_colorscheme','#00b7f1')); ?>;}			
			
		#SiteWrapper a:focus,
		input[type="date"]:focus,
		input[type="search"]:focus,
		input[type="number"]:focus,
		input[type="tel"]:focus,
		input[type="button"]:focus,
		input[type="month"]:focus,
		button:focus,
		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="range"]:focus,		
		input[type="password"]:focus,
		input[type="datetime"]:focus,
		input[type="week"]:focus,
		input[type="submit"]:focus,
		input[type="datetime-local"]:focus,		
		input[type="url"]:focus,
		input[type="time"]:focus,
		input[type="reset"]:focus,
		input[type="color"]:focus,
		textarea:focus
            { border:1px solid <?php echo esc_html( get_theme_mod('shopfume_lite_colorscheme','#00b7f1')); ?>;}	
			
		
		.site-navigation a,
		.site-navigation ul li.current_page_parent ul.sub-menu li a,
		.site-navigation ul li.current_page_parent ul.sub-menu li.current_page_item ul.sub-menu li a,
		.site-navigation ul li.current-menu-ancestor ul.sub-menu li.current-menu-item ul.sub-menu li a  			
            { color:<?php echo esc_html( get_theme_mod('shopfume_lite_hdrnavcolor','#333333')); ?>;}	
			
		
		.site-navigation ul.nav-menu .current_page_item > a,
		.site-navigation ul.nav-menu .current-menu-item > a,
		.site-navigation ul.nav-menu .current_page_ancestor > a,
		.site-navigation ul.nav-menu .current-menu-ancestor > a, 
		.site-navigation .nav-menu a:hover,
		.site-navigation .nav-menu a:focus,
		.site-navigation .nav-menu ul a:hover,
		.site-navigation .nav-menu ul a:focus,
		.site-navigation ul li a:hover, 
		.site-navigation ul li.current-menu-item a,			
		.site-navigation ul li.current_page_parent ul.sub-menu li.current-menu-item a,
		.site-navigation ul li.current_page_parent ul.sub-menu li a:hover,
		.site-navigation ul li.current-menu-item ul.sub-menu li a:hover,
		.site-navigation ul li.current-menu-ancestor ul.sub-menu li.current-menu-item ul.sub-menu li a:hover 		 			
            { color:<?php echo esc_html( get_theme_mod('shopfume_lite_hdrnavactive','#eea702')); ?>;}
			
		.hdrtopcart .cart-count
            { background-color:<?php echo esc_html( get_theme_mod('shopfume_lite_hdrnavactive','#eea702')); ?>;}		
			
		#SiteWrapper .site-navigation a:focus		 			
            { border:1px solid <?php echo esc_html( get_theme_mod('shopfume_lite_hdrnavactive','#eea702')); ?>;}	
	
    </style> 
<?php                                                                                                                                                                              
}
         
add_action('wp_head','shopfume_lite_custom_css');	 

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function shopfume_lite_customize_preview_js() {
	wp_enqueue_script( 'shopfume_lite_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '19062019', true );
}
add_action( 'customize_preview_init', 'shopfume_lite_customize_preview_js' );