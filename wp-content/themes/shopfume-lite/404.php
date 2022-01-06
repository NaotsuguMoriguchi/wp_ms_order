<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Shopfume Lite
 */

get_header(); ?>

<div class="container">
    <div id="TabNavigator">
        <div class="SiteContent-Left">
           <div class="BLogStyle-01">
            <div class="ContentStyle-ForSite"> 
             <header class="page-header">
                <h1 class="entry-title"><?php esc_html_e( '404 Not Found', 'shopfume-lite' ); ?></h1>                
            </header><!-- .page-header -->
            <div class="page-content">
                <p><?php esc_html_e( 'Looks like you have taken a wrong turn....Dont worry... it happens to the best of us.', 'shopfume-lite' ); ?></p>  
            </div><!-- .page-content -->
           </div><!--.ContentStyle-ForSite-->
          </div><!--.BLogStyle-01-->      
       </div><!-- SiteContent-Left-->   
        <?php get_sidebar();?>       
        <div class="clear"></div>
    </div>
</div>
<?php get_footer(); ?>