<?php

if( !function_exists('MSB_get_option_group') ){

	function MSB_get_option_group( $settings_file ){
		$option_group = preg_replace("/[^a-z0-9]+/i", "", basename( $settings_file, '.php' ));
		return $option_group;
	}
}

if( !function_exists('MSB_get_settings') ){

	function MSB_get_settings( $settings_file, $option_group = '' ){
		$opt_group = preg_replace("/[^a-z0-9]+/i", "", basename( $settings_file, '.php' ));
		if( $option_group ) $opt_group = $option_group;
		return get_option( $opt_group .'_settings' );
	}
}

if( !function_exists('MSB_get_setting') ){

	function MSB_get_setting( $option_group, $section_id, $field_id ){
		$options = get_option( $option_group .'_settings' );
		if(isset($options[$option_group .'_'. $section_id .'_'. $field_id])) return $options[$option_group .'_'. $section_id .'_'. $field_id];
		return false;
	}
}

if( !function_exists('MSB_delete_settings') ){

	function MSB_delete_settings( $settings_file, $option_group = '' ){
		$opt_group = preg_replace("/[^a-z0-9]+/i", "", basename( $settings_file, '.php' ));
		if( $option_group ) $opt_group = $option_group;
		delete_option( $opt_group .'_settings' );
	}
}

?>