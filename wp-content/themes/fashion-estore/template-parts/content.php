<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fashion Estore
 */
?>

<div class="col-lg-6 col-md-6 col-sm-6">
    <article id="post-<?php the_ID(); ?>" <?php post_class('article-box'); ?>>
        <header class="entry-header">
            <?php the_title('<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>');?>
            <hr>
            <?php if ('post' === get_post_type()) : ?>
                <div class="entry-meta">
                    <?php
                    fashion_estore_posted_on();
                    ?>
                </div>
            <?php endif; ?>
        </header>
        <?php fashion_estore_post_thumbnail(); ?>
        <div class="entry-summary">
            <?php
                the_excerpt();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'fashion-estore'),
                    'after' => '</div>',
                ));
            ?>
        </div>
        <footer class="entry-footer">
            <?php fashion_estore_entry_footer(); ?>
        </footer>
    </article>
</div>