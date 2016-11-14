<?php
/*
 Plugin Name: Lucky Countdown
 Plugin URI:
 Description:
 Author: Yokoyama
 Version: 0.0.1
 Author URI: http://www.k-kawamata.co.jp
 */

function path_upload_dir( $eventname ) {
	$upload_dir = wp_upload_dir();
	$countimagedir = $upload_dir['baseurl'] . "/countdown/" . $eventname . "/";
	return $countimagedir;
}

function make_upload_dir() {
	$kokutaidir = path_upload_dir( 'kokutai' );
	$taikaidir = path_upload_dir( 'taikai' );

	if ( ! file_exists( $kokutaidir ) ) {
		wp_mkdir_p( $kokutaidir );
	}

	if ( ! file_exists( $taikaidir ) ) {
		wp_mkdir_p( $taikaidir );
	}
}

function countdown_image( $atts ) {
	$event = $atts[ 'event' ];
	if ( $event === "taikai" ) {
		$eventdate = strtotime( '2019/10/12' );
	} else {
		$eventdate = strtotime( '2019/9/28' );
	}
	$currentday = strtotime( 'now' );
	$date_interval = round( ( $eventdate - $currentday ) / (60*60*24));
	if ( $date_interval > 0) {
		$countdownhtml = '<p><img src="' . path_upload_dir( $event ) . $date_interval . '.jpg"></p>';
	}

	return $countdownhtml;
}

register_activation_hook( __FILE__, 'make_upload_dir');

add_shortcode( 'CDImg', 'countdown_image' );
