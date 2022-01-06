<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Shopfume Lite
 */

get_header(); ?>

<div class="container">
     <div id="TabNavigator">
        <div class="SiteContent-Left <?php if( esc_attr( get_theme_mod( 'shopfume_lite_hidesidebar_singleposts' )) ) { ?>fullwidth<?php } ?>">           
				<?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'content', 'single' ); ?>                  
                    <div class="clear"></div>
                    <?php
                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || '0' != get_comments_number() )
                    	comments_template();
                    ?>
                <?php endwhile; // end of the loop. ?>                  
          </div><!-- .SiteContent-Left-->        
          <?php if( esc_attr(get_theme_mod( 'shopfume_lite_hidesidebar_singleposts' )) == '') { ?> 
          	  <?php get_sidebar();?>
          <?php } ?>       
        <div class="clear"></div>
    </div><!-- #TabNavigator -->
</div><!-- container -->	
<?php get_footer(); ?>