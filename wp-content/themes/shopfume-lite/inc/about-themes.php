<?php
/**
 * Shopfume Lite About Theme
 *
 * @package Shopfume Lite
 */

//about theme info
add_action( 'admin_menu', 'shopfume_lite_abouttheme' );
function shopfume_lite_abouttheme() {    	
	add_theme_page( __('About Theme Info', 'shopfume-lite'), __('About Theme Info', 'shopfume-lite'), 'edit_theme_options', 'shopfume_lite_guide', 'shopfume_lite_mostrar_guide');   
} 

//Info of the theme
function shopfume_lite_mostrar_guide() { 	
?>

<h1><?php esc_html_e('About Theme Info', 'shopfume-lite'); ?></h1>
<hr />  

<p><?php esc_html_e('Shopfume Lite is an electronics store WordPress theme that flaunts a highly impressive appeal for electronic stores, electronic manufacturers, gadget suppliers, online gadget stores, headphone manufacturers, smart device producers, online electronic gadget supplier services, eCommerce stores for electronics, and many more.', 'shopfume-lite'); ?></p>

<h2><?php esc_html_e('Theme Features', 'shopfume-lite'); ?></h2>
<hr />  
 
<h3><?php esc_html_e('Theme Customizer', 'shopfume-lite'); ?></h3>
<p><?php esc_html_e('The built-in customizer panel quickly change aspects of the design and display changes live before saving them.', 'shopfume-lite'); ?></p>


<h3><?php esc_html_e('Responsive Ready', 'shopfume-lite'); ?></h3>
<p><?php esc_html_e('The themes layout will automatically adjust and fit on any screen resolution and looks great on any device. Fully optimized for iPhone and iPad.', 'shopfume-lite'); ?></p>


<h3><?php esc_html_e('Cross Browser Compatible', 'shopfume-lite'); ?></h3>
<p><?php esc_html_e('Our themes are tested in all mordern web browsers and compatible with the latest version including Chrome,Firefox, Safari, Opera, IE11 and above.', 'shopfume-lite'); ?></p>


<h3><?php esc_html_e('E-commerce', 'shopfume-lite'); ?></h3>
<p><?php esc_html_e('Fully compatible with WooCommerce plugin. Just install the plugin and turn your site into a full featured online shop and start selling products.', 'shopfume-lite'); ?></p>

<hr />  	
<p><a href="https://netnus.com/Documentation/" target="_blank"><?php esc_html_e('Documentation', 'shopfume-lite'); ?></a></p>

<?php } ?>