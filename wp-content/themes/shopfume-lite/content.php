<?php
/**
 * @package Shopfume Lite
 */
?>
 <div class="BLogStyle-01">
 <div class="ContentStyle-ForSite">     
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>         
		  <?php if( get_theme_mod( 'shopfume_lite_hide_postfeatured_image' ) == '') { ?> 
			 <?php if (has_post_thumbnail() ){ ?>
                <div class="BlogImgDiv <?php if( esc_attr( get_theme_mod( 'shopfume_lite_blogimg_fullwidth' )) ) { ?>imgFull<?php } ?>">
                 <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                </div>
             <?php } ?> 
          <?php } ?> 
       
        <header class="entry-header">
           <?php if ( 'post' == get_post_type() ) : ?>
                <div class="BlogMeta-Strip">
                   <?php if( get_theme_mod( 'shopfume_lite_hide_blogdate' ) == '') { ?> 
                      <div class="post-date"> <i class="far fa-clock"></i>  <?php echo esc_html( get_the_date() ); ?></div><!-- post-date --> 
                    <?php } ?> 
                    
                    <?php if( get_theme_mod( 'shopfume_lite_hide_postcats' ) == '') { ?> 
                      <span class="blogpost_cat"> <i class="far fa-folder-open"></i> <?php the_category( __( ', ', 'shopfume-lite' ));?></span>
                   <?php } ?>                                                   
                </div><!-- .BlogMeta-Strip -->
            <?php endif; ?>
            <h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>                           
                                
        </header><!-- .entry-header -->          
        <?php if ( is_search() || !is_single() ) : // Only display Excerpts for Search ?>
        <div class="entry-summary">           
         <p>
            <?php $shopfume_lite_arg = get_theme_mod( 'shopfume_lite_postsfullcontent_options','Excerpt');
              if($shopfume_lite_arg == 'Content'){ ?>
                <?php the_content(); ?>
              <?php }
              if($shopfume_lite_arg == 'Excerpt'){ ?>
                <?php if(get_the_excerpt()) { ?>
                  <?php $excerpt = get_the_excerpt(); echo esc_html( shopfume_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('shopfume_lite_postexcerptrange','30')))); ?>
                <?php }?>
                
                 <?php
					$shopfume_lite_postmorebuttontext = get_theme_mod('shopfume_lite_postmorebuttontext');
					if( !empty($shopfume_lite_postmorebuttontext) ){ ?>
					<a class="morebutton" href="<?php the_permalink(); ?>"><?php echo esc_html($shopfume_lite_postmorebuttontext); ?></a>
                <?php } ?>                
              <?php }?>
           </p>
                    
        </div><!-- .entry-summary -->
        <?php else : ?>
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'shopfume-lite' ) ); ?>
            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'shopfume-lite' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div><!-- .entry-content -->
        <?php endif; ?>
        <div class="clear"></div>
    </div><!-- .ContentStyle-ForSite-->
    </article><!-- #post-## -->
</div>