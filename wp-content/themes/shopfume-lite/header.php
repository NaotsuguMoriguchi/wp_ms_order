<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package Shopfume Lite
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
?>
<a class="skip-link screen-reader-text" href="#TabNavigator">
<?php esc_html_e( 'Skip to content', 'shopfume-lite' ); ?>
</a>
<?php
$shopfume_lite_show_hdrsocial_options  		 	= esc_attr( get_theme_mod('shopfume_lite_show_hdrsocial_options', false) ); 
$shopfume_lite_show_hdrcontactdetails 	   	= esc_attr( get_theme_mod('shopfume_lite_show_hdrcontactdetails', false) ); 
$shopfume_lite_show_hdrslide_sections 	  		= esc_attr( get_theme_mod('shopfume_lite_show_hdrslide_sections', false) );
$shopfume_lite_show_services_threecolumn_sections      	= esc_attr( get_theme_mod('shopfume_lite_show_services_threecolumn_sections', false) );

?>
<div id="SiteWrapper" <?php if( get_theme_mod( 'shopfume_lite_layouttype' ) ) { echo 'class="boxlayout"'; } ?>>
<?php
if ( is_front_page() && !is_home() ) {
	if( !empty($shopfume_lite_show_hdrslide_sections)) {
	 	$innerpage_cls = '';
	}
	else {
		$innerpage_cls = 'innerpage_header';
	}
}
else {
$innerpage_cls = 'innerpage_header';
}
?>

<div id="masthead" class="site-header <?php echo esc_attr($innerpage_cls); ?> ">  
       <div class="container">       
        <div class="HdrRight"> 
          <?php if( $shopfume_lite_show_hdrcontactdetails != ''){ ?>            
				<?php 
					$email = get_theme_mod('shopfume_lite_emailid');
					if( !empty($email) ){ ?>                
					<div class="hdrinfo-BX">
                        <i class="far fa-envelope"></i>
                        <a href="<?php echo esc_url('mailto:'.sanitize_email($email)); ?>"><?php echo sanitize_email($email); ?></a>
					</div>            
                <?php } ?>
                            
				<?php $shopfume_lite_phoneno = get_theme_mod('shopfume_lite_phoneno');
					if( !empty($shopfume_lite_phoneno) ){ ?>              
					<div class="hdrinfo-BX">
						<i class="fas fa-phone fa-rotate-90"></i><?php echo esc_html($shopfume_lite_phoneno); ?>
					</div>       
                <?php } ?>  
                  
               <?php if( $shopfume_lite_show_hdrsocial_options != ''){ ?>   
                  <div class="hdrinfo-BX">               
                    <div class="hdrsocial">                                                
					   <?php $shopfume_lite_hdrfb_link = get_theme_mod('shopfume_lite_hdrfb_link');
                        if( !empty($shopfume_lite_hdrfb_link) ){ ?>
                        <a class="fab fa-facebook-f" target="_blank" href="<?php echo esc_url($shopfume_lite_hdrfb_link); ?>"></a>
                       <?php } ?>
                    
                       <?php $shopfume_lite_hdrtw_link = get_theme_mod('shopfume_lite_hdrtw_link');
                        if( !empty($shopfume_lite_hdrtw_link) ){ ?>
                        <a class="fab fa-twitter" target="_blank" href="<?php echo esc_url($shopfume_lite_hdrtw_link); ?>"></a>
                       <?php } ?>
                
                      <?php $shopfume_lite_hdrin_link = get_theme_mod('shopfume_lite_hdrin_link');
                        if( !empty($shopfume_lite_hdrin_link) ){ ?>
                        <a class="fab fa-linkedin" target="_blank" href="<?php echo esc_url($shopfume_lite_hdrin_link); ?>"></a>
                      <?php } ?> 
                      
                      <?php $shopfume_lite_hdrigram_link = get_theme_mod('shopfume_lite_hdrigram_link');
                        if( !empty($shopfume_lite_hdrigram_link) ){ ?>
                        <a class="fab fa-instagram" target="_blank" href="<?php echo esc_url($shopfume_lite_hdrigram_link); ?>"></a>
                      <?php } ?> 
                 </div><!--end .hdrsocial--> 
                </div> 
               <?php } ?>
               
               <?php if ( class_exists( 'WooCommerce' ) ) { ?>
    			<div class="hdrinfo-BX last-child">
                  <div class="hdrtopcart">
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View Shopping Cart', 'shopfume-lite' ); ?>">
                        <i class="fa fa-shopping-cart"></i> <span class="cart-count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
                    </a>  
    			  </div> 
                </div>               
    		  <?php } ?>
              <div class="clear"></div>
          <?php } ?>
          </div><!-- .HdrRight --> 
          
          <div class="logo">
           <?php shopfume_lite_the_custom_logo(); ?>
            <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
                <p><?php echo esc_html($description); ?></p>
            <?php endif; ?>
         </div><!-- logo --> 
             
         <div class="clear"></div>   
      </div><!-- .container -->           
     <div id="navigationpanel"> 
          <div class="container">             
		     <nav id="main-navigation" class="site-navigation" role="navigation" aria-label="<?php echo esc_attr_e('Primary Menu', 'shopfume-lite' ); ?>">
                <button type="button" class="menu-toggle">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php
               	wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                ) );
                ?>
            </nav><!-- #main-navigation -->  
       </div><!-- .container -->                   
	</div><!-- #navigationpanel -->    
 <div class="clear"></div> 
</div><!--.site-header --> 
 
<?php 
if ( is_front_page() && !is_home() ) {
if($shopfume_lite_show_hdrslide_sections != '') {
	for($i=1; $i<=3; $i++) {
	  if( get_theme_mod('shopfume_lite_hdrslidepage'.$i,false)) {
		$slider_Arr[] = absint( get_theme_mod('shopfume_lite_hdrslidepage'.$i,true));
	  }
	}
?> 
<div class="HeaderSlider">              
<?php if(!empty($slider_Arr)){ ?>
<div id="slider" class="nivoSlider">
<?php 
$i=1;
$slidequery = new WP_Query( array( 'post_type' => 'page', 'post__in' => $slider_Arr, 'orderby' => 'post__in' ) );
while( $slidequery->have_posts() ) : $slidequery->the_post();
$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); 
$thumbnail_id = get_post_thumbnail_id( $post->ID );
$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
?>
<?php if(!empty($image)){ ?>
<img src="<?php echo esc_url( $image ); ?>" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php }else{ ?>
<img src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/images/slides/slider-default.jpg" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php } ?>
<?php $i++; endwhile; ?>
</div>   

<?php 
$j=1;
$slidequery->rewind_posts();
while( $slidequery->have_posts() ) : $slidequery->the_post(); ?>                 
    <div id="slidecaption<?php echo esc_attr( $j ); ?>" class="nivo-html-caption">         
     <h2><?php the_title(); ?></h2>
     <p><?php $excerpt = get_the_excerpt(); echo esc_html( shopfume_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('shopfume_lite_excerpt_length_hdrslide','15')))); ?></p>
		<?php
        $shopfume_lite_hdrslidepage_btntext = get_theme_mod('shopfume_lite_hdrslidepage_btntext');
        if( !empty($shopfume_lite_hdrslidepage_btntext) ){ ?>
            <a class="slidermorebtn" href="<?php the_permalink(); ?>"><?php echo esc_html($shopfume_lite_hdrslidepage_btntext); ?></a>
        <?php } ?>                  
    </div>   
<?php $j++; 
endwhile;
wp_reset_postdata(); ?>   
<?php } ?>
 </div><!-- .HeaderSlider -->    
<?php } } ?> 

<?php if ( is_front_page() && ! is_home() ) { ?>  

	<?php if( $shopfume_lite_show_services_threecolumn_sections != ''){ ?> 
   <section id="PageSections-1">
     <div class="container">       
          <?php 
                for($n=1; $n<=3; $n++) {    
                if( get_theme_mod('shopfume_lite_services_threecolumn_page'.$n,false)) {      
                    $queryvar = new WP_Query('page_id='.absint(get_theme_mod('shopfume_lite_services_threecolumn_page'.$n,true)) );		
                    while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>     
                     <div class="ThreePageColumn <?php if($n % 3 == 0) { echo "last_column"; } ?>">   
                        <div class="PageColumnBG">                                                                
							 <?php if(has_post_thumbnail() ) { ?>
                                <div class="thumBX">
                                  <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>                                
                                </div>        
                             <?php } ?>
                             <div class="ShortinfoBX">              	
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4> 
                                <p><?php $excerpt = get_the_excerpt(); echo esc_html( shopfume_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('shopfume_lite_threecolumn_excerpt_length','0')))); ?></p> 
								<?php
                                    $shopfume_lite_threecolumn_readmorebutton = get_theme_mod('shopfume_lite_threecolumn_readmorebutton');
                                    if( !empty($shopfume_lite_threecolumn_readmorebutton) ){ ?>
                                    <a class="ReadMoreBtn" href="<?php the_permalink(); ?>"><?php echo esc_html($shopfume_lite_threecolumn_readmorebutton); ?></a>
                                <?php } ?>  
                             </div>                                                      
                         </div>
                      </div>
                    <?php endwhile;
                    wp_reset_postdata();                                  
                } } ?>                                 
               <div class="clear"></div>        
      </div><!-- .container -->
    </section><!-- #PageSections-1 -->
  <?php } ?>   
<?php } ?>