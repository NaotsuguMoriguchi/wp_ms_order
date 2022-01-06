<?php
/**
 * @package Shopfume Lite
 */
?>
<div class="BLogStyle-01">
 <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
   <div class="ContentStyle-ForSite"> 
    <header class="entry-header">        
           <div class="BlogMeta-Strip">
			 <?php if( get_theme_mod( 'shopfume_lite_hide_postdate_fromsingle' ) == '') { ?> 
                  <div class="post-date"> <i class="far fa-clock"></i>  <?php echo esc_html( get_the_date() ); ?></div><!-- post-date --> 
                <?php } ?> 
                
                <?php if( get_theme_mod( 'shopfume_lite_hide_postcats_fromsingle' ) == '') { ?> 
                  <span class="blogpost_cat"> <i class="far fa-folder-open"></i> <?php the_category( __( ', ', 'shopfume-lite' ));?></span>
               <?php } ?>  
             </div><!-- .BlogMeta-Strip --> 
             <?php the_title( '<h3 class="single-title">', '</h3>' ); ?>      
    </header><!-- .entry-header -->
    <div class="entry-content">		
        <?php the_content(); ?>
        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'shopfume-lite' ),
            'after'  => '</div>',
        ) );
        ?>
        <div class="postmeta">          
            <div class="post-tags"><?php the_tags(); ?> </div>
            <div class="clear"></div>
        </div><!-- postmeta -->
    </div><!-- .entry-content -->   
    <footer class="entry-meta">
      <?php edit_post_link( __( 'Edit', 'shopfume-lite' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-meta -->
    </div><!-- .ContentStyle-ForSite--> 
 </article>
</div><!-- .BLogStyle-01-->