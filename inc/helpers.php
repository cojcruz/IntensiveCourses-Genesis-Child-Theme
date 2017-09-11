<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'presscore_vc_is_inline' ) ) :

	function presscore_vc_is_inline() {
		return function_exists( 'vc_is_inline' ) && vc_is_inline();
	}

endif;

if ( ! function_exists( 'presscore_get_button_html' ) ) :

	/**
	 * Button helper.
	 * Look for filters in template-hooks.php
	 *
	 * @return string HTML.
	 */
	function presscore_get_button_html( $options = array() ) {
		$default_options = array(
			'title'		=> '',
			'target'	=> '',
			'href'		=> '',
			'class'		=> 'dt-btn',
			'atts'		=> ''
		);

		$options = wp_parse_args( $options, $default_options );

		$html = sprintf(
			'<a href="%1$s" class="%2$s"%3$s>%4$s</a>',
			$options['href'],
			esc_attr( $options['class'] ),
			( $options['target'] ? ' target="_blank"' : '' ) . $options['atts'],
			$options['title']
		);

		return apply_filters('presscore_get_button_html', $html, $options);
	}

endif;

if ( ! function_exists( 'presscore_get_social_icons' ) ) :

	/**
	 * Generate social icons links list.
	 * $icons = array( array( 'icon_class', 'title', 'link' ) )
	 *
	 * @param $icons array
	 *
	 * @return string
	 */
	function presscore_get_social_icons( $icons = array(), $common_classes = array() ) {
		if ( empty($icons) || !is_array($icons) ) {
			return '';
		}

		$classes = $common_classes;
		if ( !is_array($classes) ) {
			$classes = explode( ' ', trim($classes) );
		}

		$output = array();
		foreach ( $icons as $icon ) {

			if ( !isset($icon['icon'], $icon['link'], $icon['title']) ) {
				continue;
			}

			$output[] = presscore_get_social_icon( $icon['icon'], $icon['link'], $icon['title'], $classes );
		}

		return apply_filters( 'presscore_get_social_icons', implode( '', $output ), $output, $icons, $common_classes );
	}

endif;

if ( ! function_exists( 'presscore_get_social_icon' ) ) :

	/**
	 * Get social icon.
	 *
	 * @return string
	 */
	function presscore_get_social_icon( $icon = '', $url = '#', $title = '', $classes = array(), $target = '_blank' ) {
		$title = esc_attr( $title );

		$icon_attributes = array(
			'title="' . $title . '"',
		);

		if ( 'skype' === $icon ) {
			$url = esc_attr( $url );
		} else if ( 'mail' === $icon && is_email( $url ) ) {
			$url = 'mailto:' . esc_attr( $url );
			$target = '_top';
		} else {
			$url = esc_url( $url );
		}

		$icon_attributes[] = 'href="' . $url . '"';
		$icon_attributes[] = 'target="' . esc_attr( $target ) . '"';

		$icon_classes = is_array( $classes ) ? $classes : array();
		$icon_classes[] = $icon;

		$icon_attributes[] = 'class="' . esc_attr( implode( ' ',  $icon_classes ) ) . '"';

		$output = '<a ' . implode( ' ', $icon_attributes ) . '><span class="assistive-text">' . $title . '</span></a>';

		return $output;
	}

endif;

if ( ! function_exists( 'presscore_get_social_icons_data' ) ) :

	/**
	 * Return social icons array( 'class', 'title' ).
	 *
	 */
	function presscore_get_social_icons_data() {
		return array(
			'facebook'		=> __('Facebook', 'the7mk2'),
			'twitter'		=> __('Twitter', 'the7mk2'),
			'google'		=> __('Google+', 'the7mk2'),
			'dribbble'		=> __('Dribbble', 'the7mk2'),
			'you-tube'		=> __('YouTube', 'the7mk2'),
			'rss'			=> __('Rss', 'the7mk2'),
			'delicious'		=> __('Delicious', 'the7mk2'),
			'flickr'		=> __('Flickr', 'the7mk2'),
			'forrst'		=> __('Forrst', 'the7mk2'),
			'lastfm'		=> __('Lastfm', 'the7mk2'),
			'linkedin'		=> __('Linkedin', 'the7mk2'),
			'vimeo'			=> __('Vimeo', 'the7mk2'),
			'tumbler'		=> __('Tumblr', 'the7mk2'),
			'pinterest'		=> __('Pinterest', 'the7mk2'),
			'devian'		=> __('Deviantart', 'the7mk2'),
			'skype'			=> __('Skype', 'the7mk2'),
			'github'		=> __('Github', 'the7mk2'),
			'instagram'		=> __('Instagram', 'the7mk2'),
			'stumbleupon'	=> __('Stumbleupon', 'the7mk2'),
			'behance'		=> __('Behance', 'the7mk2'),
			'mail'			=> __('Mail', 'the7mk2'),
			'website'		=> __('Website', 'the7mk2'),
			'px-500'		=> __('500px', 'the7mk2'),
			'tripedvisor'	=> __('TripAdvisor', 'the7mk2'),
			'vk'			=> __('VK', 'the7mk2'),
			'foursquare'	=> __('Foursquare', 'the7mk2'),
			'xing'			=> __('XING', 'the7mk2'),
			'weibo'			=> __('Weibo', 'the7mk2'),
			'odnoklassniki'	=> __('Odnoklassniki', 'the7mk2'),
			'research-gate'	=> __('ResearchGate', 'the7mk2'),
			'yelp'			=> __('Yelp', 'the7mk2'),
			'blogger'		=> __('Blogger', 'the7mk2'),
			'soundcloud'	=> __('SoundCloud', 'the7mk2'),
		);
	}

endif; // presscore_get_social_icons_data