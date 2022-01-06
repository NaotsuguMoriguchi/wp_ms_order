<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shopfume Lite
 */
?>

		<header>
                <h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'shopfume-lite' ); ?></h1>
         </header>

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		 <p><?php printf( esc_html__( 'Ready to publish your first post? Get started here.', 'shopfume-lite' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'shopfume-lite' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'shopfume-lite' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>