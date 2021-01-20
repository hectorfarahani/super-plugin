<?php

add_action( 'wp_ajax_SPSP_save_settings', 'SPSP_save_settings' );

function SPSP_save_settings() {

	check_ajax_referer( 'SPSP_save_settings', 'nonce' );

	$post_type = sanitize_text_field( $_POST['option'] );
	$value     = sanitize_text_field( $_POST['value'] );


}
