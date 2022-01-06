<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Shopfume Lite
 */
 
?>

<div class="site-footer">         
    <div class="container"> 
       <div class="footer-fix">         
          <?php if ( is_active_sidebar( 'fw-column-1' ) ) : ?>
                <div class="fwcolumn-1">  
                    <?php dynamic_sidebar( 'fw-column-1' ); ?>
                </div>
           <?php endif; ?>
          
          <?php if ( is_active_sidebar( 'fw-column-2' ) ) : ?>
                <div class="fwcolumn-2">  
                    <?php dynamic_sidebar( 'fw-column-2' ); ?>
                </div>
           <?php endif; ?>
           
           <?php if ( is_active_sidebar( 'fw-column-3' ) ) : ?>
                <div class="fwcolumn-3">  
                    <?php dynamic_sidebar( 'fw-column-3' ); ?>
                </div>
           <?php endif; ?> 
           
           <?php if ( is_active_sidebar( 'fw-column-4' ) ) : ?>
                <div class="fwcolumn-4">  
                    <?php dynamic_sidebar( 'fw-column-4' ); ?>
                </div>
           <?php endif; ?>            
          	
           <div class="clear"></div>    
         </div><!--.footer-fix-->
       </div><!--end .container-->   

        <div class="copyrigh-wrapper"> 
             <div class="container">             
                <div class="fcopy-center">
				   <?php bloginfo('name'); ?> - <?php esc_html_e('Theme by Netnus','shopfume-lite'); ?>  
                </div>                             
             </div><!--end .container-->             
        </div><!--end .copyrigh-wrapper-->  
                             
     </div><!--end #site-footer-->
</div><!--#end SiteWrapper-->
<?php wp_footer(); ?>
</body>
</html>