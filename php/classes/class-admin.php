<?php

class MSB_Admin {

    private $plugin_path;
    private $plugin_url;

	public function __construct($plugin_path, $plugin_url) {

		$this->plugin_path = $plugin_path;
		$this->plugin_url  = $plugin_url;

		$this->init();
	}

	public function init() {
		add_action( 'init', array( $this, 'mobile_sticky_button_latest_jquery' ) );
		add_action( 'admin_init', array( $this, 'mobile_sticky_button_admin_init' ) );
		add_action( 'add_meta_boxes', array( $this, 'mobile_sticky_buttons_options_add_meta_box' ) );
		add_action( 'save_post', array( $this, 'mobile_sticky_buttons_options_save' ) );
	}

	/**
	 * Hooks into init action
	 * Adding Latest jQuery from WordPress
	 * @todo is this necessary?
	 */
	public function mobile_sticky_button_latest_jquery() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'mobile_sticky_button_movement_script', $this->plugin_url . 'js/movement.js', array('jquery'), MSB_PLUGIN_VERSION, true );
		wp_enqueue_script( 'mobile_sticky_button_script', $this->plugin_url . 'js/script.js', array('jquery'), MSB_PLUGIN_VERSION, true  );
	}

	/**
	 * Hooks into admin_init action
	 * Loads back end scripts and styles
	 */
	public function mobile_sticky_button_admin_init() {
		wp_register_script( 'mobile_sticky_button_script', $this->plugin_url . 'js/script.js', array(), MSB_PLUGIN_VERSION, true );
		wp_enqueue_style( 'mobile_sticky_button_style', $this->plugin_url . '/css/backend-styles.css', array(), MSB_PLUGIN_VERSION, true );
	}

	/**
	 * Hooks into add_meta_boxes action
	 * Adds meta boxes
	 */
	public function mobile_sticky_buttons_options_add_meta_box() {
		add_meta_box(
			'mobile_sticky_buttons_options-mobile-sticky-buttons-options',
			__( 'Mobile Sticky Buttons Options', 'mobile_sticky_buttons_options' ),
			array( $this, 'mobile_sticky_buttons_options_html' ),
			'post',
			'side',
			'low'
		);
		add_meta_box(
			'mobile_sticky_buttons_options-mobile-sticky-buttons-options',
			__( 'Mobile Sticky Buttons Options', 'mobile_sticky_buttons_options' ),
			array( $this, 'mobile_sticky_buttons_options_html' ),
			'page',
			'side',
			'low'
		);
	}

	/**
	 * Meta box save callback
	 * Called from mobile_sticky_buttons_options_add_meta_box
	 *
	 * @param $post
	 */
	public function mobile_sticky_buttons_options_html( $post ) {
		$mobile_sticky_buttons_options_meta = $this->mobile_sticky_buttons_options_get_meta('mobile_sticky_buttons_options_hide_mobile_sticky_buttons' );
		$mobile_sticky_buttons = ( 'hide-mobile-sticky-buttons' === $mobile_sticky_buttons_options_meta ) ? 'checked' : '';
		wp_nonce_field( '_mobile_sticky_buttons_options_nonce', 'mobile_sticky_buttons_options_nonce' );
		?>
		<p>
			<input type="checkbox" name="mobile_sticky_buttons_options_hide_mobile_sticky_buttons"
			       id="mobile_sticky_buttons_options_hide_mobile_sticky_buttons"
			       value="hide-mobile-sticky-buttons" <?php echo $mobile_sticky_buttons; ?>>
			<label for="mobile_sticky_buttons_options_hide_mobile_sticky_buttons"><strong><?php _e( 'Hide Mobile Sticky Buttons', 'mobile_sticky_buttons_options' ); ?></strong></label>
		</p>
		<?php
	}

	/**
	 * Called from mobile_sticky_buttons_options_html
	 * @param $value
	 *
	 * @return bool|mixed|string
	 */
	public function mobile_sticky_buttons_options_get_meta( $value ) {
		global $post;
		$field = get_post_meta( $post->ID, $value, true );
		if ( ! empty( $field ) ) {
			return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
		}

		return false;
	}

	/**
	 * Hooked into save_post action
	 * Updates post meta for mobile_sticky_buttons_options
	 *
	 * @param $post_id
	 */
	public function mobile_sticky_buttons_options_save( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! isset( $_POST['mobile_sticky_buttons_options_nonce'] ) || ! wp_verify_nonce( $_POST['mobile_sticky_buttons_options_nonce'], '_mobile_sticky_buttons_options_nonce' ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['mobile_sticky_buttons_options_hide_mobile_sticky_buttons'] ) ) {
			update_post_meta( $post_id, 'mobile_sticky_buttons_options_hide_mobile_sticky_buttons', esc_attr( $_POST['mobile_sticky_buttons_options_hide_mobile_sticky_buttons'] ) );
		} else {
			update_post_meta( $post_id, 'mobile_sticky_buttons_options_hide_mobile_sticky_buttons', null );
		}
	}

}