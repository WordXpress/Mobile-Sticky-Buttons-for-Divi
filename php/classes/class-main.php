<?php

/**
 * Class LCBMain
 */
class LCBMain {

	private $plugin_path;
	private $plugin_url;

	private $admin;
	private $LCB; //phpcs:ignore

	function __construct() {

		$this->plugin_path = LEAD_CALL_BUTTON_PLUGIN_PATH;
		$this->plugin_url  = LEAD_CALL_BUTTON_PLUGIN_URL;

		$this->LCB = new LCB_setting( $this->plugin_path . 'php/includes/lead-call-button-settings-general.php' );
		$this->admin = new LCB_Admin();

		// @todo remove this on clean up
		//wp_enqueue_style('lead_call_button_css', LEAD_CALL_BUTTON_HOOK.'css/plugin-main.css');

		$this->init();
	}

	/**
	 * Initialises action and filter hooks
	 */
	protected function init() {
		add_action( 'wp_head', array( $this, 'lead_call_button_custom_css' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'lead_call_button_wp_enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'wp_footer', array( $this, 'lead_call_button_active_hook' ) );

		add_filter( 'plugin_action_links', array( $this, 'settings_link' ), 10, 2 );
		add_filter( $this->LCB->get_option_group() . '_settings_validate', array( $this, 'validate_settings' ) );
	}

	/**
	 * Hooks into the wp_head action
	 * Loads inline custom CSS from the lead_call_buttons setting
	 */
	public function lead_call_button_custom_css() {
		?>
		<style type="text/css">
			<?php echo LCB_get_setting( 'lead_call_buttons', 'general', 'custom-css' ); ?>
		</style>
		<?php
	}

	/**
	 * Hooks into wp_enqueue_scripts
	 * Loads custom scripts and styles
	 */
	public function lead_call_button_wp_enqueue_scripts() {
		wp_enqueue_style(
			'font-awesome',
			'//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
		);
		wp_enqueue_style(
			'lcb-css-movement',
			$this->plugin_url . '/css/movement.css'
		);
		wp_enqueue_style(
			'lcb-css-main',
			$this->plugin_url . '/css/plugin-main.css'
		);
	}

	/**
	 * Hooks into admin_menu
	 * Adds options link
	 */
	public function admin_menu() {
		$page_hook = add_options_page(
			__( 'Lead Call Buttons', 'lead-call-button-frame' ),
			__( 'Lead Call Buttons', 'lead-call-button-frame' ),
			'manage_options',
			'lead_call_buttons',
			array(
				&$this,
				'settings_page',
			)
		);
	}

	/**
	 * Generate the settings page from the options link hooked into the admin_menu
	 */
	public function settings_page() { ?>
		<div class="wrap">
			<h2>Lead Call Buttons Settings</h2>
			<div class="postbox-container">
				<div class="postbox">
					<div id="icon-options-general" class="icon32"></div>
					<div class="inside">
						<?php
						// Output your settings form
						$this->LCB->settings();
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Add an optional settings validation filter (recommended)
	 *
	 * @param $input
	 *
	 * @return mixed
	 */
	public function validate_settings( $input ) {
		return $input;
	}

	/**
	 * Hooks into the plugin_action_links filter
	 * Adds the Settings link for the plugin list
	 *
	 * @param $links
	 * @param $file
	 *
	 * @return mixed
	 */
	public function settings_link( $links, $file ) {
		static $this_plugin;
		if ( ! $this_plugin ) {
			$this_plugin = plugin_basename( __FILE__ );
		}
		if ( $file === $this_plugin ) {
			$settings_link = '<a href="admin.php?page=lead_call_buttons">' . __( "Settings" ) . '</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}

	/**
	 * Hooks into wp_footer
	 * Includes the actual lead buttons functionality
	 */
	public function lead_call_button_active_hook() {
		include_once( $this->plugin_path . 'php/templates/lead-call-buttons.php' );
	}
}