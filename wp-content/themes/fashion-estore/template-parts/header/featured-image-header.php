<?php
/**
 * Displays featured image header
 *
 * @package Fashion Estore
 */
?>

<div class="featured-header-image">
    <img src="<?php esc_url(the_post_thumbnail_url( 'fashion-estore-featured-header-image' )); ?>">
    <div class="bg-gradient">
        <header class="entry-header centered">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        </header>
    </div>
</div>