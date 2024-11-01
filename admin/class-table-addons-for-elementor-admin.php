<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://fusionplugin.com/
 * @since      1.0.0
 *
 * @package    Table_Addons_For_Elementor
 * @subpackage Table_Addons_For_Elementor/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Table_Addons_For_Elementor
 * @subpackage Table_Addons_For_Elementor/admin
 * @author     FusionPlugin <support@fusionplugin.com>
 */
class Table_Addons_For_Elementor_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/table-addons-for-elementor-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/table-addons-for-elementor-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Elementor Settings Style
	 */
	public function elementor_settings_styles() {
		wp_enqueue_style( 'tafe-elementor-settings', plugin_dir_url( __FILE__ ) . 'css/elementor-settings.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the menu page for the plugin.
	 *
	 * @since    2.1.0
	 */
	public function add_menu_page() {
		
		add_menu_page(
			__( 'Table Addons For Elementor', 'table-addons-for-elementor' ),
			__( 'Elementor Table', 'table-addons-for-elementor' ),
			'manage_options',
			'tafe-settings',
			[ $this, 'display_menu_page' ],
			'dashicons-editor-table',
			'58.7'
		);
	}

	public function display_menu_page() {
		?>
		<div class="wrap tafe-wrapper">
			<h1><?php esc_html_e( 'Table Addons For Elementor', 'table-addons-for-elementor' ); ?></h1>
			<div class="tafe-box-info">
				<div class="tafe-box-info-single">
					<h4><?php esc_html_e( 'Documentation', 'table-addons-for-elementor' ); ?></h4>
					<p><?php esc_html_e( 'Explore our documentation to get familiar with our plugin settings', 'table-addons-for-elementor' ); ?></p>
					<a class="tafe-btn" href="https://fusionplugin.com/docs/table-addons-for-elementor/" target="_blank"><?php esc_html_e( 'Documentation', 'table-addons-for-elementor' ); ?></a>
				</div>
				<div class="tafe-box-info-single">
					<h4><?php esc_html_e( 'Support', 'table-addons-for-elementor' ); ?></h4>
					<p><?php esc_html_e( 'Require additional assistance? Please feel free to contact us.', 'table-addons-for-elementor' ); ?></p>
					<a class="tafe-btn" href="https://fusionplugin.com/contact/" target="_blank"><?php esc_html_e( 'Contact Us', 'table-addons-for-elementor' ); ?></a>
				</div>
				<div class="tafe-box-info-single">
					<h4><?php esc_html_e( 'Rate Us', 'table-addons-for-elementor' ); ?></h4>
					<p><?php esc_html_e( 'Enjoying our plugin? Please rate us; it will encourage us to improve the plugin.', 'table-addons-for-elementor' ); ?></p>
					<a class="tafe-btn" href="https://wordpress.org/support/plugin/table-addons-for-elementor/reviews/#new-post" target="_blank"><?php esc_html_e( 'Rate Us', 'table-addons-for-elementor' ); ?></a>
				</div>
			</div>
			<?php if( !defined( 'TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION' ) ): ?>
			<div class="tafe-cta">
				<div class="tafe-cta-content">
					<h3><?php esc_html_e('Do more with Table Addons Pro for Elementor', 'table-addons-for-elementor'); ?></h3>
					<p><?php esc_html_e('Unlock more features and get premium support with Table Addons Pro for Elementor.', 'table-addons-for-elementor'); ?></p>
					<ul class="tafe-list-narrow">
						<li><?php esc_html_e('Icon Field', 'table-addons-for-elementor'); ?></li>
						<li><?php esc_html_e('Image Field', 'table-addons-for-elementor'); ?></li>
						<li><?php esc_html_e('Link Field', 'table-addons-for-elementor'); ?></li>
					</ul>
					<ul>
						<li><?php esc_html_e('Icon + Content Field', 'table-addons-for-elementor'); ?></li>
						<li><?php esc_html_e('Button Field', 'table-addons-for-elementor'); ?></li>
						<li><?php esc_html_e('Rich Text Editor (WYSIWYG)', 'table-addons-for-elementor'); ?></li>
					</ul>
				</div>
				<a class="tafe-btn" href="https://fusionplugin.com/plugins/table-addons-for-elementor/?utm_source=activesite&utm_campaign=elementortable&utm_medium=link" target="_blank"><?php esc_html_e('Upgrade to Pro', 'table-addons-for-elementor'); ?></a>
			</div>
			<?php endif;?>
			<h2 class="tafe-h2"><?php esc_html_e( 'Table Library', 'table-addons-for-elementor' ); ?></h2>
			<div class="tafe-table-library">
				<div class="tafe-table-library-single">
					<div class="tafe-table-library-img"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . 'img/sample-table-1.png'); ?>"></div>
					<div class="tafe-table-library-content">
						<h3><?php esc_html_e( 'Sample Table 1', 'table-addons-for-elementor' ); ?></h3>
						<a target="_blank" href="https://fusionplugin.com/plugin-data/elementor-table/sample-1.json" download><?php esc_html_e('Download Table', 'table-addons-for-elementor' );?></a>
					</div>
				</div>
				<div class="tafe-table-library-single">
					<div class="tafe-table-library-img"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . 'img/sample-table-2.png'); ?>"></div>
					<div class="tafe-table-library-content">
						<h3><?php esc_html_e( 'Sample Table 2', 'table-addons-for-elementor' ); ?></h3>
						<a target="_blank" href="https://fusionplugin.com/plugin-data/elementor-table/sample-2.json" download><?php esc_html_e('Download Table', 'table-addons-for-elementor' );?></a>
					</div>
				</div>
				<div class="tafe-table-library-single">
					<div class="tafe-table-library-img"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . 'img/sample-table-3.png'); ?>"></div>
					<div class="tafe-table-library-content">
						<h3><?php esc_html_e( 'Sample Table 3', 'table-addons-for-elementor' ); ?></h3>
						<a target="_blank" href="https://fusionplugin.com/plugin-data/elementor-table/sample-3.json" download><?php esc_html_e('Download Table', 'table-addons-for-elementor' );?></a>
					</div>
				</div>
				<div class="tafe-table-library-single">
					<div class="tafe-table-library-img"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . 'img/sample-table-4.png'); ?>"></div>
					<div class="tafe-table-library-content">
						<h3><?php esc_html_e( 'Sample Table 4', 'table-addons-for-elementor' ); ?></h3>
						<a target="_blank" href="https://fusionplugin.com/plugin-data/elementor-table/sample-4.json" download><?php esc_html_e('Download Table', 'table-addons-for-elementor' );?></a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Add settings link to plugin page
	 *
	 * @since 1.0.0
	 */
	public function settings_link($links, $file) {
		$settings_link = '<a href="' . admin_url( 'admin.php?page=tafe-settings' ) . '">' . __( 'Settings', 'table-addons-for-elementor' ) . '</a>';

		array_unshift( $links, $settings_link );

		if( !defined('TABLE_ADDONS_PRO_FOR_ELEMENTOR_VERSION') ){
			$links['get_pro'] = '<a class="tafe-get-pro" href="https://fusionplugin.com/plugins/table-addons-for-elementor/?utm_source=activesite&utm_campaign=elementortable&utm_medium=link" target="_blank">' . __( 'Upgrade to Pro', 'table-addons-for-elementor' ) . '</a>';
		}

		return $links;
	}

	/**
	 * Plugin update message
	 */

	public function plugin_update_message( $plugin_data, $response ) {
		$current_version_major_part = explode( '.', TABLE_ADDONS_FOR_ELEMENTOR_VERSION )[0];
		$new_version_major_part = explode( '.', $response->new_version )[0];

		if ( $current_version_major_part === $new_version_major_part ) {
			return;
		}
		echo '<hr class="tafe-update-warning__separator" /><div class="tafe-update-warning__message">';
		printf(
			/* translators: 1: strong tag start 2: strong tag end 3: break tag 4: new version */
			esc_html__( '%1$sImportant:%2$s The latest update introduces significant changes throughout the plugin. We strongly recommend backing up %3$syour site before upgrading to version %4$s and testing the update in a staging environment first.', 'table-addons-for-elementor' ),
			'<strong>',
			'</strong>',
			'<br/>',
			esc_html($response->new_version)
		);
		echo '</div>';
	}
}
