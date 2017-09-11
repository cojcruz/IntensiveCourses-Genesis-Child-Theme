<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// load constants.
require_once trailingslashit( get_stylesheet_directory() ) . 'inc/constants.php';

require_once PRESSCORE_CLASSES_DIR . '/template-config/presscore-config.class.php';

require_once PRESSCORE_DIR . '/helpers.php';

include_once locate_template( 'inc/shortcodes/load-shortcodes.php' );