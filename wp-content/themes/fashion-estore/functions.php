<?php
/**
 * Fashion Estore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fashion Estore
 */

include get_theme_file_path( 'vendor/wptrt/autoload/src/Fashion_Estore_Loader.php' );

$fashion_estore_loader = new \WPTRT\Autoload\Fashion_Estore_Loader();

$fashion_estore_loader->fashion_estore_add( 'WPTRT\\Customize\\Section', get_theme_file_path( 'vendor/wptrt/customize-section-button/src' ) );

$fashion_estore_loader->fashion_estore_register();

if ( ! function_exists( 'fashion_estore_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fashion_estore_setup() {

		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'woocommerce' );
		
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

        add_image_size('fashion-estore-featured-header-image', 2000, 660, true);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary','fashion-estore' ),
	        'footer'=> esc_html__( 'Footer Menu','fashion-estore' ),
        ) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'fashion_estore_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 50,
			'width'       => 50,
			'flex-width'  => true,
		) );

		add_editor_style( array( '/editor-style.css' ) );

		add_theme_support( 'wp-block-styles' );

		add_theme_support( 'align-wide' );
	}
endif;
add_action( 'after_setup_theme', 'fashion_estore_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fashion_estore_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fashion_estore_content_width', 1170 );
}
add_action( 'after_setup_theme', 'fashion_estore_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fashion_estore_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fashion-estore' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'fashion-estore' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'fashion-estore' ),
		'id'            => 'fashion-estore-footer1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'fashion-estore' ),
		'id'            => 'fashion-estore-footer2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'fashion-estore' ),
		'id'            => 'fashion-estore-footer3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'fashion_estore_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fashion_estore_scripts() {

	wp_enqueue_style('fashion-estore-font', fashion_estore_font_url(), array());

	wp_enqueue_style( 'fashion-estore-block-editor-style', get_theme_file_uri('/assets/css/block-editor-style.css') );

	// load bootstrap css
    wp_enqueue_style( 'flatly-css', esc_url(get_template_directory_uri()) . '/assets/css/flatly.css');

	wp_enqueue_style( 'fashion-estore-style', get_stylesheet_uri() );

	wp_style_add_data('fashion-estore-style', 'rtl', 'replace');

	// fontawesome
	wp_enqueue_style( 'fontawesome-css', esc_url(get_template_directory_uri()).'/assets/css/fontawesome/css/all.css' );

	wp_enqueue_style( 'owl.carousel-css', esc_url(get_template_directory_uri()).'/assets/css/owl.carousel.css' );

    wp_enqueue_script('owl.carousel-js', esc_url(get_template_directory_uri()) . '/assets/js/owl.carousel.js', array('jquery'), '', true );

    wp_enqueue_script('fashion-estore-theme-js', esc_url(get_template_directory_uri()) . '/assets/js/theme-script.js', array('jquery'), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fashion_estore_scripts' );

/**
 * Enqueue theme color style.
 */
function fashion_estore_theme_color() {

    $theme_color_css = '';
    $fashion_estore_theme_color = get_theme_mod('fashion_estore_theme_color');

	$theme_color_css = '
		.sidebar h5,span.cart-value,.sticky .entry-title::before,#button,.sidebar input[type="submit"], .sidebar button[type="submit"],.comment-respond input#submit,.post-navigation .nav-previous a:hover, .post-navigation .nav-next a:hover, .posts-navigation .nav-previous a:hover, .posts-navigation .nav-next a:hover,.pro-button a, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce .woocommerce-ordering select,.main-navigation .sub-menu,.woocommerce-account .woocommerce-MyAccount-navigation ul li,.toggle-nav i,.wp-block-button__link,.menu_cat,.slider-inner-box{
			background: '.esc_attr($fashion_estore_theme_color).';
		}
		a,#colophon a:hover, #colophon a:focus,.sidebar ul li a:hover,p.price, .woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price,.woocommerce-message::before, .woocommerce-info::before,.call-info i{
			color: '.esc_attr($fashion_estore_theme_color).';
		}
		.woocommerce-message, .woocommerce-info,.wp-block-pullquote,.wp-block-quote, .wp-block-quote:not(.is-large):not(.is-style-large), .wp-block-pullquote,.btn-primary,.post-navigation .nav-previous a:hover, .post-navigation .nav-next a:hover, .posts-navigation .nav-previous a:hover, .posts-navigation .nav-next a:hover{
			border-color: '.esc_attr($fashion_estore_theme_color).';
		}
	';
    wp_add_inline_style( 'fashion-estore-style',$theme_color_css );

}
add_action( 'wp_enqueue_scripts', 'fashion_estore_theme_color' );

/**
 * Enqueue S Header.
 */
function fashion_estore_sticky_header() {

	$fashion_estore_sticky_header = get_theme_mod('fashion_estore_sticky_header');

	$fashion_estore_custom_style= "";

	if($fashion_estore_sticky_header != true){

		$fashion_estore_custom_style .='.stick_header{';

			$fashion_estore_custom_style .='position: static;';
			
		$fashion_estore_custom_style .='}';
	} 

	wp_add_inline_style( 'fashion-estore-style',$fashion_estore_custom_style );

}
add_action( 'wp_enqueue_scripts', 'fashion_estore_sticky_header' );

function fashion_estore_font_url(){
	$font_url = '';
	$Montserrat = _x('on','Montserrat:on or off','fashion-estore');
	
	if('off' !== $Montserrat ){
		$font_family = array();
		if('off' !== $Montserrat){
			$font_family[] = 'Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900';
		}
		$query_args = array(
			'family'	=> urlencode(implode('|',$font_family)),
		);
		$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
	}
	return $font_url;
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/*dropdown page sanitization*/
function fashion_estore_sanitize_dropdown_pages( $page_id, $setting ) {
	$page_id = absint( $page_id );
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function fashion_estore_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

function fashion_estore_string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}

function fashion_estore_sanitize_checkbox( $input ) {
	// Boolean check 
	return ( ( isset( $input ) && true == $input ) ? true : false );
}