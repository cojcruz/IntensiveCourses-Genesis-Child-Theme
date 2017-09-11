<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );
//include_once( trailingslashit( get_stylesheet_directory() ) . 'inc/init.php' );\
// Load custom post types.
include_once( get_stylesheet_directory() . '/inc/post-types.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'intensivecourses', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'intensivecourses' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Intensive Courses Theme', 'intensivecourses' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/outreach/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Google fonts
add_action( 'wp_enqueue_scripts', 'intensivecourses_google_fonts' );
function intensivecourses_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:400,700|Material+Icons|Roboto:200,400,700', array(), CHILD_THEME_VERSION );
	
}

add_action( 'admin_enqueue_scripts', 'add_admin_font' );

function add_admin_font() {
	
  wp_enqueue_style( 'dt-font', get_stylesheet_directory_uri() . '/admin.css' );
  
}
  

//* Enqueue Responsive Menu Script
add_action( 'wp_enqueue_scripts', 'intensivecourses_enqueue_responsive_script' );
function intensivecourses_enqueue_responsive_script() {

	wp_enqueue_script( 'intensivecourses-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

}

//* Enqueue Custom Script
add_action( 'wp_enqueue_scripts', 'intensivecourses_enqueue_custom_script' );
function intensivecourses_enqueue_custom_script() {

	wp_enqueue_script( 'intensivecourses_custom_script', get_bloginfo( 'stylesheet_directory' ) . '/js/custom.js', array( 'jquery' ), '1.0.0' );

}

//* Enqueue Font Awesome Script
add_action( 'wp_enqueue_scripts', 'intensivecourses_enqueue_fontawesome_script' );
function intensivecourses_enqueue_fontawesome_script() {

	wp_enqueue_script( 'intensivecourses_fontawesome', 'https://use.fontawesome.com/7b30f1c378.js' );

}

//* Add new image sizes
add_image_size( 'home-top', 1140, 460, TRUE );
add_image_size( 'home-bottom', 285, 160, TRUE );
add_image_size( 'sidebar', 300, 150, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 100,
	'width'           => 340,
) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer',
) );

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

//* Set Genesis Responsive Slider defaults
add_filter( 'genesis_responsive_slider_settings_defaults', 'intensivecourses_responsive_slider_defaults' );
function intensivecourses_responsive_slider_defaults( $defaults ) {

	$args = array(
		'location_horizontal'             => 'Left',
		'location_vertical'               => 'bottom',
		'posts_num'                       => '4',
		'slideshow_excerpt_content_limit' => '100',
		'slideshow_excerpt_content'       => 'full',
		'slideshow_excerpt_width'         => '35',
		'slideshow_height'                => '460',
		'slideshow_more_text'             => __( 'Continue Reading', 'intensivecourses' ),
		'slideshow_title_show'            => 1,
		'slideshow_width'                 => '1140',
	);

	$args = wp_parse_args( $args, $defaults );
	
	return $args;
}

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'intensivecourses_after_entry', 5 );
function intensivecourses_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'intensivecourses_author_box_gravatar_size' );
function intensivecourses_author_box_gravatar_size( $size ) {

    return '80';
    
}

//* Button Shortcode

add_shortcode( 'dt_button' , 'dt_button_func' );
function dt_button_func( $atts , $content ) {
	
	$atts = shortcode_atts( array(
		'el_class' => '',
		'link' => '', 
		'size' => 'medium',
		'style' => 'default',
		'icon' => '',
		'icon_align' => '',
	), $atts, 'dt_button' );
	
	$icon = urldecode( base64_decode( $atts['icon'] ) );
	
	$ico = $icon != strip_tags( $icon ) ? $icon : '<i class="' . $atts['icon'] . '" aria-hidden="true"></i>';
	
	ob_start();
	?>
	<a href="<?= $atts['link']; ?>" class="button-link <?= $atts['class']; ?> <?= $atts['style'] === 'default' ? 'button-' . $atts['size'] : '' ; ?>"><?= $content; ?><?= $ico; ?></a>	
	<?php
	$output = ob_get_clean();
	
	return $output;
	
}

//* Social Shortcode

add_shortcode( 'dt_social_icons' , 'social_wrap_func' );
function social_wrap_func( $atts, $content ) {
	$atts = shortcode_atts( array(
		'animations' => true,
	), $atts, 'dt_social_icons');
	
	ob_start();
	?>
	<div class="social_icon_wrapper">
		<?= do_shortcode( $content ); ?>
	</div>
	<?php
	$output = ob_get_clean();
	
	return $output;
}

add_shortcode( 'dt_social_icon' , 'socialicon_func' );
function socialicon_func( $atts, $content ) {

	$atts = shortcode_atts( array(
		'target_blank' => false,
		'link' => '',
		'icon' => '',
	), $atts, 'dt_social_icon' );
	
	$icon = '';
	
	switch ( $atts['icon'] ) {
		case 'facebook':
			$icon = '<i class="fa fa-facebook" aria-hidden="true"></i>';
		break;
		case 'twitter':
			$icon = '<i class="fa fa-twitter" aria-hidden="true"></i>';
		break;
		case 'linkedin':
			$icon = '<i class="fa fa-linkedin-square" aria-hidden="true"></i>';
		break;
		case 'youtube':
			$icon = '<i class="fa fa-youtube-play" aria-hidden="true"></i>';
		break;	
	}
	
	ob_start();
	?>
	<a title="<?= ucfirst( $atts['icon'] ); ?>" href="<?= $atts['link']; ?>" target="<?= $atts['target_blank'] ? '_blank' : '_self'; ?>" class="social_icon <?= $atts['icon']; ?>" style="visibility: visible;"><svg class="icon" viewBox="0 0 24 24"></svg><?= $icon; ?></a>
	<?php
	
	$output = ob_get_clean();
	
	return $output;
}

//* Social Shortcode

add_shortcode( 'dt_benefits_vc' , 'dt_slider_func' );
function dt_slider_func( $atts, $content ) {
	$atts = shortcode_atts( array(
		'animations' => true,
	), $atts, 'dt_benefits_vc ');
	
	ob_start();
	?>
	<section id="benefits-grid-1" class="benefits-grid wf-container benefits-style-two icons-bg accent-bg light-hover-bg custom-icon-color accent-icon-hover-color static-line" data-width="250px" data-columns="2">
		<style type="text/css">
			#benefits-grid-1.icons-bg .benefits-grid-ico {
				height: 50px;
				line-height: 50px;
				width: 50px;
			}
			
			#benefits-grid-1.icons-bg .benefits-grid-ico > .fa {
				font-size: 24px;
				line-height: 50px;
			}
			
			#benefits-grid-1.custom-icon-color .benefits-grid-ico > .fa,
			#benefits-grid-1.custom-icon-color .benefits-grid-ico > .fa:before {
				color: #ffffff;
			}
		</style>
		<div class="wf-cell" style="width: 50%; display: inline-block;">
			<div>
				<div class="text-big">
					<div class="wf-table">
						<div class="wf-td"><a href="https://www.intensivecourses.co.uk/price-list/" class="benefits-grid-ico"><i class="fa fa-car"></i></a></div>
						<div class="wf-td benefits-inner">
							<h4 class="benefit-title"><a href="https://www.intensivecourses.co.uk/price-list/">Driving Lessons</a></h4>
							<p>We offer great value for money using the best intensive driving instructors.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="wf-cell" style="width: 50%; display: inline-block;">
			<div>
				<div class="text-big">
					<div class="wf-table">
						<div class="wf-td"><a href="https://www.intensivecourses.co.uk/free-theory-test/" class="benefits-grid-ico"><i class="fa fa-shopping-cart"></i></a></div>
						<div class="wf-td benefits-inner">
							<h4 class="benefit-title"><a href="https://www.intensivecourses.co.uk/free-theory-test/">Theory Test Booking</a></h4>
							<p>You can buy your Theory Test today&nbsp;or you can get it for free if you&nbsp;book&nbsp;24 hour course or more.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="wf-cell" style="width: 50%; display: inline-block;">
			<div>
				<div class="text-big">
					<div class="wf-table">
						<div class="wf-td"><a href="https://www.intensivecourses.co.uk/product-category/practical-test-fee/" class="benefits-grid-ico"><i class="fa fa-shopping-cart"></i></a></div>
						<div class="wf-td benefits-inner">
							<h4 class="benefit-title"><a href="https://www.intensivecourses.co.uk/product-category/practical-test-fee/">Practical Test</a></h4>
							<p>Book your official DVSA practical driving test for cars from £62</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="wf-cell" style="width: 50%; display: inline-block;">
			<div>
				<div class="text-big">
					<div class="wf-table">
						<div class="wf-td"><a href="https://www.intensivecourses.co.uk/membership-signup/" class="benefits-grid-ico"><i class="fa fa-user"></i></a></div>
						<div class="wf-td benefits-inner">
							<h4 class="benefit-title"><a href="https://www.intensivecourses.co.uk/membership-signup/">Driving Resources</a></h4>
							<p>Get VIP access to our resources page so you can be confident to pass your driving test first time.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	$output = ob_get_clean();
	
	return $output;
}

//* Fancy Seperator 
add_shortcode( 'dt_fancy_separator' , 'fancy_separator_func' );
function fancy_separator_func() {
	return '<div class="hr-thin style-line" style="width: 100%;"></div>';	
}

//* Slider Shortcode 
add_shortcode( 'dt_portfolio_slider' , 'portfolio_slider_func' );
function portfolio_slider_func() {
	
	$atts = shortcode_atts( array(
		'width' => '320',
		'height' => '240', 
		'padding' => '30',
		'arrows' => 'rectangular_accent', 
		'show_title' => true,		
	), $atts, 'dt_portfolio_slider' );
	// [dt_portfolio_slider height="240" width="320" padding="30" arrows="rectangular_accent" show_title="true" show_date="true" show_details="true" show_zoom="true" number="10" category="4-misc"]

	ob_start();
	?>
	<div class="dt-portfolio-shortcode slider-wrapper arrows-accent description-under-image hide-arrows" data-padding-side="30" data-autoslide="false" data-delay="0" data-loop="false" style="visibility: visible;">
		<div class="frame fullwidth-slider">
			<div class="ts-wrap ts-autoHeight ts-ready">
				<div class="ts-viewport" style="width: 1903px; height: 371px;">
					<ul class="clearfix ts-cont" style="transform: translate3d(0px, 0px, 0px); left: 791.5px;">
						<li class="fs-entry ts-cell ts-loaded" data-width="320" style="width: 320px; opacity: 1; height: 100%; left: 0px;">
							<article class="post post-38827 dt_portfolio type-dt_portfolio status-publish has-post-thumbnail hentry dt_portfolio_category-4-misc text-centered" style="height: 100%;">
								<div class="project-list-media">
									<div class="buttons-on-img">
										<a href="https://www.intensivecourses.co.uk/membership-signup" class="alignnone rollover this-ready blur-this blur-ready" style="height: 240px;"><img class="preload-me retinized" srcset="https://www.intensivecourses.co.uk/wp-content/uploads/2016/08/UK-most-comprehensive-resources-02-320x240.jpg 1x, https://www.intensivecourses.co.uk/wp-content/uploads/2016/08/UK-most-comprehensive-resources-02-640x480.jpg 2x" alt="" width="320" height="240" src="https://www.intensivecourses.co.uk/wp-content/uploads/2016/08/UK-most-comprehensive-resources-02-320x240.jpg"><i></i></a>
										<div class="rollover-content">
											<div class="wf-table">
												<div class="links-container wf-td "><a href="https://www.intensivecourses.co.uk/wp-content/uploads/2016/08/UK-most-comprehensive-resources-02.jpg?x19816" class="project-zoom dt-mfp-item dt-single-mfp-popup mfp-image mfp-ready height-ready" title="uk-most-comprehensive-resources-02" data-dt-img-description="">Zoom<span></span></a><a href="https://www.intensivecourses.co.uk/membership-signup" class="project-details height-ready">Detailsggggggg<span></span></a></div>
											</div>
										</div>
									</div>
								</div>
								<div class="project-list-content">
									<h3 class="entry-title"><a href="https://www.intensivecourses.co.uk/project/hazard-perception-info-test/" title="Driving Resources" rel="bookmark">Driving Resources</a></h3>
									<div class="portfolio-categories">
										<a href="javascript: void(0);" title="4:06 pm" class="data-link" rel="bookmark">
											<time class="entry-date updated" datetime="2017-01-06T16:06:09+00:00">January 6, 2017</time>
										</a>
									</div>
									<p><a href="https://www.intensivecourses.co.uk/wp-admin/post.php?post=38827&amp;action=edit" class="edit-link" target="_blank">Edit</a></p>
								</div>
							</article>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="prev disabled"><i></i></div>
		<div class="next disabled"><i></i></div>
		<a href="#" class="auto-play-btn"></a>
	</div>
	<?php
	$output = ob_get_clean();
	
	return $output;
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'mpp_remove_comment_form_allowed_tags' );
function mpp_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add the sub footer section
add_action( 'genesis_before_footer', 'intensivecourses_sub_footer', 5 );
function intensivecourses_sub_footer() {

	if ( is_active_sidebar( 'sub-footer-left' ) || is_active_sidebar( 'sub-footer-right' ) ) {
		echo '<div class="sub-footer"><div class="wrap">';
		
		   genesis_widget_area( 'sub-footer-left', array(
		       'before' => '<div class="sub-footer-left">',
		       'after'  => '</div>',
		   ) );
	
		   genesis_widget_area( 'sub-footer-right', array(
		       'before' => '<div class="sub-footer-right">',
		       'after'  => '</div>',
		   ) );
	
		echo '</div><!-- end .wrap --></div><!-- end .sub-footer -->';	
	}
	
}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'intensivecourses' ),
	'description' => __( 'This is the top section of the Home page.', 'intensivecourses' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'intensivecourses' ),
	'description' => __( 'This is the bottom section of the Home page.', 'intensivecourses' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'intensivecourses' ),
	'description' => __( 'This is the after entry widget area.', 'intensivecourses' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-footer-left',
	'name'        => __( 'Sub Footer - Left', 'intensivecourses' ),
	'description' => __( 'This is the left section of the sub footer.', 'intensivecourses' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-footer-right',
	'name'        => __( 'Sub Footer - Right', 'intensivecourses' ),
	'description' => __( 'This is the right section of the sub footer.', 'intensivecourses' ),
) );

add_action( 'genesis_header' , 'intensivecourses_top_bar_widgets' , 1 );
function intensivecourses_top_bar_widgets() {

	?>
	<div id="topbar">
		<div class="wrap">
			<div class="one-half first">
				<span class="mini-contacts phone">Tel: 0800 056 9418 / 0207 205 2251</span>
			</div>
			<div class="one-half last">
				<?php minicart_init(); ?>
				<?php minilogin_init(); ?>
			</div>
		</div>
	</div>
	<?php
	
}

function minicart_init() {
	?>
	<div class="shopping-cart">

		<a class="wc-ico-cart" href="<?php echo WC()->cart->get_cart_url(); ?>"><i class="material-icons">shopping_cart</i> Your cart:&nbsp;<?php _e( 'Subtotal', 'intensivecourses' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></a>
	
		<div class="shopping-cart-wrap">
			<div class="shopping-cart-inner">
	
				<?php
				$cart_is_empty = count(WC()->cart->get_cart()) <= 0;
				$list_class = array( 'cart_list', 'product_list_widget' );
	
				if ( $cart_is_empty ) {
					$list_class[] = 'empty';
				}
				?>
	
				<ul class="<?php echo implode(' ', $list_class); ?>">
	
					<?php if ( !$cart_is_empty ) : ?>
	
						<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
	
							$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
	
							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
	
								$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
								$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								?>
								<li>
									<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'the7mk2' ) ), $cart_item_key ); ?>
									<?php if ( ! $_product->is_visible() ) : ?>
										<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name; ?>
									<?php else : ?>
										<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
											<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name; ?>
										</a>
									<?php endif; ?>
									<?php echo WC()->cart->get_item_data( $cart_item ); ?>
	
									<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
								</li>
								<?php
							}
	
						endforeach; ?>
	
					<?php else : ?>
	
						<li><?php _e( 'No products in the cart.', 'intensivecourses' ); ?></li>
	
					<?php endif; ?>
	
				</ul><!-- end product list -->
	
				<?php if ( sizeof( WC()->cart->get_cart() ) <= 0 ) : ?>
					<div style="display: none;">
				<?php endif; ?>
	
					<p class="total"><strong><?php _e( 'Subtotal', 'intensivecourses' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>
	
					<p class="buttons">
						<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button view-cart"><?php _e( 'View Cart', 'intensivecourses' ); ?></a>
						<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button checkout"><?php _e( 'Checkout', 'intensivecourses' ); ?></a>
					</p>
	
				<?php if ( sizeof( WC()->cart->get_cart() ) <= 0 ) : ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	
	</div>
	<?php	
}

function minilogin_init() {
	
	if ( is_user_logged_in() ) {
			$caption = "Logout";
			$login_link = wp_logout_url();
	} else {
		$caption = "Login";
		$login_link = wp_login_url();
		if ( ! $login_link ) {
			$login_link = wp_login_url();
		}
	}

	?>
	<div class="mini-login"><i class="material-icons">exit_to_app</i> <a href="<?php echo $login_link; ?>" class="submit<?php echo $class; ?>"><?php echo esc_html($caption); ?></a></div>
	<?php	
}

add_action( 'wp_footer' , 'search_init' );

function search_init() {
	?>
	<script type="text/javascript">
	jQuery( function($) {
		
		// Mini Search Toolbar DOM
		$('#mega-menu-max_mega_menu_1').append('<li class="mini-search mega-menu-item"><form class="searchform" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"><input type="text" class="field searchform-s" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php _e( 'Type and hit enter &hellip;', 'intensivecourses' ); ?>" /><?php do_action( 'presscore_header_searchform_fields' ); ?><input type="submit" class="assistive-text searchsubmit" value="<?php esc_attr_e( 'Go!', 'intensivecourses' ); ?>" /></form><a href="#go" id="trigger-overlay" class="submit<?php echo $class; ?>"><i class="material-icons search">search</i><i class="material-icons close">close</i></a></li>');
		
		// Mini Search Toolbar Toggle
		$('.mini-search #trigger-overlay').click( function(e) {
			e.preventDefault();
			
			$(this).parent().toggleClass('active');
			
		});
	});
	</script>
	
	<?php	
}

add_filter( 'wc_memberships_get_restricted_posts_query_args', 'sv_wc_memberships_sort_my_content', 10, 2 );

function sv_wc_memberships_sort_my_content( $query_args, $type ) {

    // bail if we're not looking at "My Content"
    if ( 'content_restriction' !== $type ) {
        return $query_args;
    }

    $query_args['order']   = 'ASC';
    $query_args['orderby'] = 'date';
	$query_args['posts_per_page'] = -1;

    return $query_args;
	
}

add_action( 'wp_footer' , 'topbar_additions' );

function topbar_additions() {
	if ( is_user_logged_in() ):
		$myaccount_uri = get_bloginfo('url') . '/shop_1/my-account';
		?>
		<style type="text/css">
		.mini-login .my-account-link {
			padding: 0 11px;			
		}
		</style>
		<script type="text/javascript">
		jQuery( function($) {
			$('.mini-login').prepend('<a href="<?= $myaccount_uri ?>" class="my-account-link">My Account</a> <a href="<?= $myaccount_uri . '/members-area'; ?>" class="my-account-link">My Membership</a> ')
		});
		</script> 
		<?php
	endif;
}

add_shortcode( 'hpv' , 'hpv_init' );

function hpv_init( $atts ) {
	$atts = shortcode_atts( array( 
		'vid'	=> '', 
		'hpv'	=> true,
		'debug'	=> false,
	), $atts );	 
	
	$clips = array(
		'Clip_1-8'	=> array(
			'src'		=> 'Clip_1-8.mp4',
			'poster'	=> 'Clip_1-8.png',
			'time'		=> '31.49,41.18',
		),
		'Clip_2-3'	=> array(
			'src'		=> 'Clip_2-3.mp4',
			'poster'	=> 'Clip_2-3.png',
			'time'		=> '51.60,59.00',
		),
		'Clip_3-4'	=> array(
			'src'		=> 'Clip_3-4.mp4',
			'poster'	=> 'Clip_3-4.png',
			'time'		=> '9.05,18.55',
		),
		'Clip_4-5'	=> array(
			'src'		=> 'Clip_4-5.mp4',
			'poster'	=> 'Clip_4-5.png',
			'time'		=> '14.55,24.24',
		),
		'Clip_5-6'	=> array(
			'src'		=> 'Clip_5-6.mp4',
			'poster'	=> 'Clip_5-6.png',
			'time'		=> '21.25,24.58',
		),
		'Clip_6-7'	=> array(
			'src'		=> 'Clip_6-7.mp4',
			'poster'	=> 'Clip_6-7.png',
			'time'		=> '42.18,52.17',
		),
		'Clip_7-8'	=> array(
			'src'		=> 'Clip_7-8.mp4',
			'poster'	=> 'Clip_7-8.png',
			'time'		=> '10.42,15.60',
		),
		'Clip_8-9'	=> array(
			'src'		=> 'Clip_8-9.mp4',
			'poster'	=> 'Clip_8-9.png',
			'time'		=> '9.50,13.58',
		),
		'Hp708'	=> array(
			'src'		=> 'Hp708.mp4',
			'poster'	=> 'Hp708.png',
			'time'		=> '41.00,45.38',
		),
		'Hp728'	=> array(
			'src'		=> 'Hp728.mp4',
			'poster'	=> 'Hp728.png',
			'time'		=> '31.04,33.45',
		),
		'Hp730'	=> array(
			'src'		=> 'Hp730.mp4',
			'poster'	=> 'Hp730.png',
			'time'		=> '18.30,24.02',
		),
		'Hp734'	=> array(
			'src'		=> 'Hp734.mp4',
			'poster'	=> 'Hp734.png',
			'time'		=> '20.45,29.44',
		),
		'Hp742'	=> array(
			'src'		=> 'Hp742.mp4',
			'poster'	=> 'Hp742.png',
			'time'		=> '19.50,31.28',
		),
		'Hp752'	=> array(
			'src'		=> 'Hp752.mp4',
			'poster'	=> 'Hp752.png',
			'time'		=> '27.03,36.55',
		),
		'Hp755'	=> array(
			'src'		=> 'Hp755.mp4',
			'poster'	=> 'Hp755.png',
			'time'		=> '33.42,38.39',
		),
		'Hp763'	=> array(
			'src'		=> 'Hp763.mp4',
			'poster'	=> 'Hp763.png',
			'time'		=> '11.44,11.44',
		),
		'Clip_1-1'	=> array(
			'src'		=> 'Clip_1-1.mp4',
			'poster'	=> 'Clip_1-1.png',
			'time'		=> '18.19,23.18',
		),
		'Clip_2_1-3'	=> array(
			'src'		=> 'Clip_2_1-3.mp4',
			'poster'	=> 'Clip_2_1-3.png',
			'time'		=> '32.06,36.05',
		),
		'Clip_3_1-4'	=> array(
			'src'		=> 'Clip_3_1-4.mp4',
			'poster'	=> 'Clip_3_1-4.png',
			'time'		=> '28.13,32.12',
		),
		'Clip_4_1-5'	=> array(
			'src'		=> 'Clip_4_1-5.mp4',
			'poster'	=> 'Clip_4_1-5.png',
			'time'		=> '31.00,35.24',
		),
		'Clip_5_1-6'	=> array(
			'src'		=> 'Clip_5_1-6.mp4',
			'poster'	=> 'Clip_5_1-6.png',
			'time'		=> '32.09,40.08',
		),
		'Clip_6_1-7'	=> array(
			'src'		=> 'Clip_6_1-7.mp4',
			'poster'	=> 'Clip_6_1-7.png',
			'time'		=> '14.18,25.17',
		),
		'Clip_7_1-8'	=> array(
			'src'		=> 'Clip_7_1-8.mp4',
			'poster'	=> 'Clip_7_1-8.png',
			'time'		=> '44.02,51.12',
		),
		'Clip_8_1-9'	=> array(
			'src'		=> 'Clip_8_1-9.mp4',
			'poster'	=> 'Clip_8_1-9.png',
			'time'		=> '30.00,39.24',
		),
		'Clip_9_1-10'	=> array(
			'src'		=> 'Clip_9_1-10.mp4',
			'poster'	=> 'Clip_9_1-10.png',
			'time'		=> '34.00,38.04',
		),
		'Clip_10_1-2'	=> array(
			'src'		=> 'Clip_10_1-2.mp4',
			'poster'	=> 'Clip_10_1-2.png',
			'time'		=> '15.00,21.24',
		),
	);
	
	$activeclip = $clips[ $atts['vid'] ];
			
	ob_start();
	?>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="<? get_bloginfo( 'stylesheet_directory' ) . '/hpv.css' ?>" rel="stylesheet">
	<script type="text/javascript">
	jQuery( function($) {
		"use strict";
		
		var vid;
		var score = 0;
		var debug = <?= $atts['debug'] == 1 ? 'true' : 'false'; ?>;
		var debugInt;
		
		$('body').append('<div id="hpv_wrapper"><div class="hpv_wrap"></div><div class="close"><i class="material-icons">close</i></div></div>');
		$('#hpv_poster').click( function(e){
			
			$('#hpv_wrapper .hpv_wrap').append('<div class="vcon" data-src="" data-ui=""><video id="hpv_player"><source src="<?= get_bloginfo('stylesheet_directory'); ?>/hpv/media/<?= $activeclip['src']; ?>" type="video/mp4"></video><div class="hpv_footer"><div class="hpv_ui"><div class="button reset"><i class="material-icons">replay</i></div><div class="button hazard"><i class="material-icons">warning</i></div></div></div><div id="results"><div class="wrap"><h4>Your Score Is: </h4><div class="button ok">Close</div></div></div></div>');	
			$('#hpv_wrapper').fadeIn( 250 );		
			
			vid = document.getElementById('hpv_player');
			score = 0;
			
			// Check if video able to play already
			vid.oncanplay = function() {
				
				vid.play();
				
				
				if ( debug && $('#debugger').length == 0 ) {
					
					$('#hpv_wrapper').prepend('<div id="debugger" style="padding: 10px; color: #fff; font-size: 12px; position: absolute; top: 20px; left: 20px; background-color: #000; width: 200px; height: auto;"><strong>Debugger:</strong><div class="time"></div><div class="hstart"></div><div class="hend"></div><div class="click-time">Click Time: </div><div class="score">Possible Score: <span>0</span></div></div>');
					
					debugInt = setInterval( function() {
						$('#debugger .time').empty().append( 'Current Time: ' + vid.currentTime.toFixed(2) + 'ms' );
					}, 50);
					
					<?php $debugtime = split(',', $activeclip['time']); ?>
					
					$('#debugger .hstart').empty().append( 'Hazard Time Start: <?= $debugtime[0]; ?> ');
					$('#debugger .hend').empty().append( 'Hazard Time End: <?= $debugtime[1];; ?> ' );
					
				}
				
			};		
			// Init buttons		
			$('#hpv_player, .hpv_ui > .hazard').click( { 'hp_time' : '<?= $activeclip['time']; ?>' }, setScore );		
			$('.hpv_ui .reset').click( reset_video );		
			$('#results .button, #hpv_wrapper .close').click(function() {	
					
				$('#hpv_wrapper').fadeOut( 250 , function() { $(this).find('.vcon').remove(); } ); // Close lightbox	
				$('#debugger').remove();
				clearInterval( debugInt );		
				
			});
						
			// Check if the video has ended and display score
			vid.onended = function() {
				
				$('#results h4').append( '<span class="score">' + score + '</span>');				
				$('#results').fadeIn( 250 );
				
			};
			
		});	
		
		function reset_video() {
			
			vid.currentTime = 0;
			score = 0;
			vid.play();	
			// Cleanup
			$('.hpv_footer .flag').remove();
			$('#results h4 .score').remove();
			
		}
		
		function setScore(e) {
			
			var time = vid.currentTime.toFixed(2);	
			var dur = vid.duration;
			var flag = '<span class="flag"><i class="material-icons">flag</i></span>';	
			var hp_time = JSON.parse('[' + e.data.hp_time + ']');
			var hp_start = hp_time[0];
			var hp_end = hp_time[1];
			var hp_total = hp_end - hp_start;
			var hp_click = time - hp_start;
			var hp_factor = hp_total / 5;
												
			if ( time < dur ) {
								
				$('.hpv_footer').append( flag );
				$('#debugger .click-time').empty().append( 'Click Time: ' + time );
				
				// Compute for the Reaction Time Score
				if ( score == 0 && time > hp_start && time < hp_end ) {
					
					score = Math.ceil( ( hp_total - hp_click ) / hp_factor ) ;
					
					if ( debug ) { 
					
						$('#debugger .score span').empty().append( score ); 						
						$('#results').append( '<div style="padding: 10px;">Click Time: ' + time + '</div>' );
						
					}
								
				}
			}		
		}
		
	});
	</script>
	
	<div id="hpv_poster" style="background-image: url(<?= get_bloginfo('stylesheet_directory'); ?>/hpv/media/<?= $activeclip['poster']; ?>);"><div class="button begin"><i class="material-icons">play_arrow</i> Begin</div></div>	
	<?php
	$output = ob_get_clean();
	
	return $output;
}