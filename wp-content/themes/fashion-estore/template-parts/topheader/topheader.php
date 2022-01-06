<?php
/**
 * Displays top header
 *
 * @package Fashion Estore
 */
?>

<div class="top-info text-right">
	<div class="container">
		<div class="social-link">
            <?php if(get_theme_mod('fashion_estore_facebook_url') != ''){ ?>
                <a href="<?php echo esc_url(get_theme_mod('fashion_estore_facebook_url','')); ?>"><i class="fab fa-facebook-f"></i></a>
            <?php }?>
            <?php if(get_theme_mod('fashion_estore_twitter_url') != ''){ ?>
                <a href="<?php echo esc_url(get_theme_mod('fashion_estore_twitter_url','')); ?>"><i class="fab fa-twitter"></i></a>
            <?php }?>
            <?php if(get_theme_mod('fashion_estore_intagram_url') != ''){ ?>
                <a href="<?php echo esc_url(get_theme_mod('fashion_estore_intagram_url','')); ?>"><i class="fab fa-instagram"></i></a>
            <?php }?>
            <?php if(get_theme_mod('fashion_estore_linkedin_url') != ''){ ?>
                <a href="<?php echo esc_url(get_theme_mod('fashion_estore_linkedin_url','')); ?>"><i class="fab fa-linkedin-in"></i></a>
            <?php }?>
            <?php if(get_theme_mod('fashion_estore_pintrest_url') != ''){ ?>
                <a href="<?php echo esc_url(get_theme_mod('fashion_estore_pintrest_url','')); ?>"><i class="fab fa-pinterest-p"></i></a>
            <?php }?>
            <?php if(class_exists('woocommerce')){ ?>
                <?php if ( is_user_logged_in() ) { ?>
                    <a class="account-btn" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('My Account','fashion-estore'); ?>"><?php esc_html_e('My Account','fashion-estore'); ?></a>
                <?php } 
                else { ?>
                    <a class="account-btn" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Login / Register','fashion-estore'); ?>"><?php esc_html_e('Login / Register','fashion-estore'); ?></a>
                <?php } ?>
        	<?php }?>
        </div>
	</div>
</div>