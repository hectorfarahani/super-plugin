<?php

function SPSP_get_option( string $option, $default = null ) {
	$options = get_option( 'SPSP_config', array() );
	return $options[ $option ] ?? $default;
}

function SPSP_update_option( $option, $new_value ) {
	$config            = get_option( 'SPSP_config', array() );
	$config[ $option ] = $new_value;
	return update_option( 'SPSP_config', $config );
}
