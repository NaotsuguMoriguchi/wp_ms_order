<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fashion Estore
 */
?>

<div class="col-lg-6 col-md-6 col-sm-6">
	<article id="post-<?php the_ID(); ?>" class="article-box">
		<header class="entry-header">
			<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
	        <hr>
			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php fashion_estore_posted_on(); ?>
			</div>
			<?php endif; ?>
		</header>

		<?php fashion_estore_post_thumbnail(); ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>
		<footer class="entry-footer">
			<?php fashion_estore_entry_footer(); ?>
		</footer>
	</article>
</div>