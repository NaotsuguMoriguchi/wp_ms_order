<?php
/**
 * @package   Gradiant
 */

require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/extras.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/dynamic-style.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/sections/above-header.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/sections/above-footer.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/features/gradiant-header.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/features/gradiant-footer.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/features/gradiant-slider.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/features/gradiant-info.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/features/gradiant-service.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/features/gradiant-cta.php';
require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/features/gradiant-typography.php';

if ( ! function_exists( 'cleverfox_gradiant_frontpage_sections' ) ) :
	function cleverfox_gradiant_frontpage_sections() {	
		require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/sections/section-slider.php';
		require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/sections/section-info.php';
		require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/sections/section-service.php';
		require CLEVERFOX_PLUGIN_DIR . 'inc/gradiant/sections/section-cta.php';
    }
	add_action( 'gradiant_sections', 'cleverfox_gradiant_frontpage_sections' );
endif;