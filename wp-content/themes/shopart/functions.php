<?php
/*This file is part of Shopart, fastest-shop child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

if ( ! function_exists( 'shopart_enqueue_child_styles' ) ) {
	function shopart_enqueue_child_styles() {
		
	    // loading parent style
	    wp_register_style(
	      'fastest-shop-parente-style',
	      get_template_directory_uri() . '/style.css'
	    );

	    wp_enqueue_style( 'fastest-shop-parente-style' );
	    // loading child style
	    wp_register_style(
	      'shopart-child-style',
	      get_stylesheet_directory_uri() . '/style.css'
	    );
	    wp_enqueue_style( 'shopart-child-style');
		
		
		
		
	 }
}
add_action( 'wp_enqueue_scripts', 'shopart_enqueue_child_styles',9999  );

/*Write here your own functions */


if( !function_exists('shopart_disable_from_parent') ):

	add_action('init','shopart_disable_from_parent',50);
	function shopart_disable_from_parent(){
		
		global $fastest_shop_Header_Layout;
		remove_action('fastest_shop_site_header', array( $fastest_shop_Header_Layout, 'site_header_layout' ), 30 );
		
		
	}
	
endif;

if( !function_exists('shopart_header_layout') ):

	add_action('fastest_shop_site_header','shopart_header_layout', 30 );
	function shopart_header_layout(){
	?>
    <header id="masthead" class="site-header header-4">
			<div class="container">
                <div class=" branding-wrap" style="text-align:center">
                    <?php do_action('fastest_shop_header_layout_1_branding');?>
                </div>
			</div>
            <div id="nav-bar-style">
           		 <div class="container">
                 	<div class="row align-items-center">
                        <div class="col-lg-9">
                            <?php do_action('fastest_shop_header_layout_1_navigation');?>
                        </div>
                        <div class="col-lg-3">
                        	<?php //echo wp_kses( $this->get_site_header_icon(), $this->alowed_tags() ); ?>
                            <?php do_action('fastest_shop_header_icon');?>
                            
                        </div>
                    </div>
            	</div>
            </div>
		</header>
    <?php	
	}
endif;


function shopart_filter_default_theme( $args ){
	$args['blog_layout']     				= 'sidebar-content';
	$args['single_post_layout']     		= 'no-sidebar';
	return $args;
}
add_filter( 'fastest_shop_filter_default_theme_options', 'shopart_filter_default_theme' );



function shopart_footer_copywrite_filter() {
   
	$string  .= '<span class="dev_info">'.sprintf( esc_html__( ' %1$s design and development by - aThemeArt', 'shopart' ), '<a href="'. esc_url( 'https://athemeart.com/downloads/fastest-elementor-woocommerce-theme/' ) .'" target="_blank" rel="nofollow">'.esc_html_x( 'Fastest Shop Theme', 'credit - theme', 'shopart' ).'</a>' ).'</span>';
	
    return $string;
}
add_filter( 'fastest_shop_dev_info', 'shopart_footer_copywrite_filter');
https://athemeart.com/downloads/fastest-elementor-woocommerce-theme/