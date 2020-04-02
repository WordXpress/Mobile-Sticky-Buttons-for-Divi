<?php

class LCB_Admin {
	function __construct() {
		$this->init();
	}

	public function init() {
		add_action( 'init', array( $this, 'lead_call_button_latest_jquery' ) );
		add_action( 'admin_init', array( $this, 'lead_call_button_admin_init' ) );
		add_action( 'add_meta_boxes', array( $this, 'lead_call_buttons_options_add_meta_box' ) );
		add_action( 'save_post', array( $this, 'lead_call_buttons_options_save' ) );
	}

	/**
	 * Hooks into init action
	 * Adding Latest jQuery from WordPress
	 * @todo is this necessary?
	 */
	public function lead_call_button_latest_jquery() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'lead_call_button_movement_script', plugins_url( '/js/movement.js', __FILE__ ) );
		wp_enqueue_script( 'lead_call_button_script', plugins_url( '/js/script.js', __FILE__ ) );
	}

	/**
	 * Hooks into admin_init action
	 * Loads back end scripts and styles
	 */
	public function lead_call_button_admin_init() {
		wp_register_script( 'lead_call_button_script', plugins_url( '/js/script.js', __FILE__ ) );
		wp_enqueue_style( 'lead_call_button_style', plugins_url( '/css/backend-styles.css', __FILE__ ) );
	}

	/**
	 * Hooks into add_meta_boxes action
	 * Adds meta boxes
	 */
	public function lead_call_buttons_options_add_meta_box() {
		add_meta_box(
			'lead_call_buttons_options-lead-call-buttons-options',
			__( 'Lead Call Buttons Options', 'lead_call_buttons_options' ),
			array( $this, 'lead_call_buttons_options_html' ),
			'post',
			'side',
			'low'
		);
		add_meta_box(
			'lead_call_buttons_options-lead-call-buttons-options',
			__( 'Lead Call Buttons Options', 'lead_call_buttons_options' ),
			array( $this, 'lead_call_buttons_options_html' ),
			'page',
			'side',
			'low'
		);
	}

	/**
	 * Meta box save callback
	 * Called from lead_call_buttons_options_add_meta_box
	 *
	 * @param $post
	 */
	public function lead_call_buttons_options_html( $post ) {
		$lead_call_buttons_options_meta = $this->lead_call_buttons_options_get_meta('lead_call_buttons_options_hide_lead_call_buttons' );
		$hide_lead_call_buttons = ( 'hide-lead-call-buttons' === $lead_call_buttons_options_meta ) ? 'checked' : '';
		wp_nonce_field( '_lead_call_buttons_options_nonce', 'lead_call_buttons_options_nonce' );
		?>
		<p>
			<input type="checkbox" name="lead_call_buttons_options_hide_lead_call_buttons"
			       id="lead_call_buttons_options_hide_lead_call_buttons"
			       value="hide-lead-call-buttons" <?php echo $hide_lead_call_buttons; ?>>
			<label for="lead_call_buttons_options_hide_lead_call_buttons"><strong><?php _e( 'Hide Lead Call Buttons', 'lead_call_buttons_options' ); ?></strong></label>
		</p>
		<?php
	}

	/**
	 * Called from lead_call_buttons_options_html
	 * @param $value
	 *
	 * @return bool|mixed|string
	 */
	public function lead_call_buttons_options_get_meta( $value ) {
		global $post;
		$field = get_post_meta( $post->ID, $value, true );
		if ( ! empty( $field ) ) {
			return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
		}

		return false;
	}

	/**
	 * Hooked into save_post action
	 * Updates post meta for lead_call_buttons_options
	 *
	 * @param $post_id
	 */
	public function lead_call_buttons_options_save( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! isset( $_POST['lead_call_buttons_options_nonce'] ) || ! wp_verify_nonce( $_POST['lead_call_buttons_options_nonce'], '_lead_call_buttons_options_nonce' ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['lead_call_buttons_options_hide_lead_call_buttons'] ) ) {
			update_post_meta( $post_id, 'lead_call_buttons_options_hide_lead_call_buttons', esc_attr( $_POST['lead_call_buttons_options_hide_lead_call_buttons'] ) );
		} else {
			update_post_meta( $post_id, 'lead_call_buttons_options_hide_lead_call_buttons', null );
		}
	}

}