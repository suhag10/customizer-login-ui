<?php
/**
 * Customizer Login UI
 *
 * @package           Customizer_Login_UI
 * @author            Suhag Ahmed
 * @copyright         2024 Suhag Ahmed
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Customizer Login UI
 * Plugin URI:        https://wordpress.org/plugins/customizer-login-ui/
 * Description:       The Customizer Login UI plugin enables you to create a custom login page for your WordPress website.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            Suhag Ahmed
 * Author URI:        https://github.com/suhag10
 * Text Domain:       customizer-login-ui
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'customizer_login_ui' ) ) :

	// Define the required plugin constants.
	define( 'CLUIWP_VERSION', '1.0.0' );
	define( 'CLUIWP_FILE', __FILE__ );
	define( 'CLUIWP_DIR', __DIR__ );
	define( 'CLUIWP_URL', plugins_url( '', __FILE__ ) );
	define( 'CLUIWP_ASSETS', CLUIWP_URL . '/assets' );

	/**
	 * The main plugin function
	 */
	function customizer_login_ui() {

		/**
		 * Add menu page
		 */
		function cluiwp_add_admin_menu() {
			$parent_slug = 'customizer-login-ui';
			$capability  = 'manage_options';
			$icon_svg    = 'dashicons-lock';

			wp_enqueue_style( 'cluiwp-admin-style' );
			wp_enqueue_script( 'cluiwp-admin-script' );

			add_menu_page( __( 'Login Customizer', 'customizer-login-ui' ), 'Login Customizer', $capability, $parent_slug, 'cluiwp_admin_panel_content', $icon_svg, 70 );
		}
		add_action( 'admin_menu', 'cluiwp_add_admin_menu' );

		/**
		 * Register styles
		 *
		 * @param string $hook The current admin page hook.
		 */
		function cluiwp_register_assets( $hook ) {
			if ( 'toplevel_page_customizer-login-ui' == $hook ) {
				wp_register_style( 'cluiwp-admin-style', esc_url( CLUIWP_ASSETS . '/css/admin-page.css' ), array(), filemtime( esc_attr( CLUIWP_DIR . '/assets/css/admin-page.css' ) ) );
				wp_register_script( 'cluiwp-admin-script', esc_url( CLUIWP_ASSETS . '/js/admin-script.js' ), array( 'jquery' ), filemtime( esc_attr( CLUIWP_DIR . '/assets/js/admin-script.js' ) ), true );
			}
			wp_register_style( 'cluiwp-login-style', esc_url( CLUIWP_ASSETS . '/css/login-page.css' ), array(), filemtime( esc_attr( CLUIWP_DIR . '/assets/css/login-page.css' ) ) );
		}
		add_action( 'admin_enqueue_scripts', 'cluiwp_register_assets' );
		add_action( 'login_enqueue_scripts', 'cluiwp_register_assets' );

		/**
		 * Admin Content
		 */
		function cluiwp_admin_panel_content() {
			cluiwp_update_setting_options();
			?>
			<div class="wrap">
				<div class="ui-area">
					<div class="ui-body ui-pb-10">
						<form method="POST">
							<div class="ui-row">
								<div class="ui-col-9">
									<h2><?php esc_html_e( 'Customizer Login Ui', 'customizer-login-ui' ); ?></h2>
									<div class="ui-row ui-gap-3">
										<!-- Primary color -->
										<div class="ui-col-3">
											<div class="ui-box">
												<label for="cluiwp_color1"><?php esc_html_e( 'Primary Color', 'customizer-login-ui' ); ?></label>
												<div>
													<span>Add your Color</span>
													<input type="color" id="cluiwp_color1" name="cluiwp_color1" value="<?php print get_option( 'cluiwp_color1' ) ? esc_attr( get_option( 'cluiwp_color1' ) ) : '#6d28d9'; ?>">
												</div>
											</div>
										</div>
										<!-- Secondary color -->
										<div class="ui-col-3">
											<div class="ui-box">
												<label for="cluiwp_color2"><?php esc_html_e( 'Secondary Color', 'customizer-login-ui' ); ?></label>
												<div>
													<span>Add your Color</span>
													<input type="color" id="cluiwp_color2" name="cluiwp_color2" value="<?php print get_option( 'cluiwp_color2' ) ? esc_attr( get_option( 'cluiwp_color2' ) ) : '#0f172a'; ?>">
												</div>
											</div>
										</div>
									</div><!-- ui-row end -->
									<div class="ui-row ui-gap-4 ui-mt-30">
										<!-- Upload logo -->
										<div class="ui-col-7">
											<div class="ui-box logo">
												<label for="cluiwp_logo"><?php esc_html_e( 'Upload your logo', 'customizer-login-ui' ); ?></label>
												<div>
													<span>Square or 80x80 px image size Recomanded</span>
													<input type="url" id="cluiwp_logo" name="cluiwp_logo" value="<?php print esc_attr( get_option( 'cluiwp_logo' ) ); ?>" placeholder="URL here...">
												</div>
											</div>
										</div>
										<!-- Background image -->
										<div class="ui-col-7">
											<div class="ui-box">
												<label for="cluiwp_background"><?php esc_html_e( 'Upload your Background Image', 'customizer-login-ui' ); ?></label>
												<div>
													<span>Paste your Background Image URL here</span>
													<input type="url" id="cluiwp_background" name="cluiwp_background" value="<?php print esc_attr( get_option( 'cluiwp_background' ) ); ?>" placeholder="URL here...">
												</div>
											</div>
										</div>
										<!-- Background brightness -->
										<div class="ui-col-7">
											<div class="ui-box">
												<label for="cluiwp_brightness"><?php esc_html_e( 'Background Brightness', 'customizer-login-ui' ); ?></label>
												<div>
													<?php $print_brightness = get_option( 'cluiwp_brightness' ) ? ( get_option( 'cluiwp_brightness' ) == '0.0' ? '0' : get_option( 'cluiwp_brightness' ) ) : 30; ?>
													<span class="range-value"><?php print esc_attr( $print_brightness ); ?>%</span>
													<input type="range" data-input-type="range" id="cluiwp_brightness" name="cluiwp_brightness" value="<?php print esc_attr( $print_brightness ); ?>" title="<?php print esc_attr( $print_brightness ); ?>%">
												</div>
											</div>
										</div>
									</div><!-- row end -->
									<div class="ui-row ui-mt-30">
										<?php wp_nonce_field( 'add-setting-options-nonce' ); ?>
										<input type="submit" class="button-primary" name="submit_setting_options" value="<?php esc_attr_e( 'Save Changes', 'customizer-login-ui' ); ?>">
									</div>
								</div><!-- col-9 end -->
								<div class="ui-col-3">
									<h2 class="ui-mt-sm-20"><?php esc_html_e( 'About Author', 'customizer-login-ui' ); ?></h2>
									<div class="ui-author-about">
										<img src="<?php print esc_url( CLUIWP_ASSETS . '/img/author.jpeg' ); ?>" alt="Author Image">
										<div class="ui-author-details">
											<h2>Suhag Ahmed</h2>
                                            <p>Hey 👋 there! I'm a front-end web developer. I enjoy solving real-world problems and primarily work with WordPress. However, I also have experience working with technologies such as JavaScript and PHP.</p>
											<ul>
												<li><a href="https://www.linkedin.com/in/suhag11/" target="_blank"><span class="dashicons dashicons-linkedin"></span> Linkedin</a></li>
												<li><a href="https://twitter.com/suhag_11" target="_blank"><span class="dashicons dashicons-twitter"></span> Twitter</a></li>
												<li><a href="https://www.facebook.com/suhagahmed.dev" target="_blank"><span class="dashicons dashicons-facebook-alt"></span> Facebook</a></li>
												<li><a href="https://github.com/suhag10" target="_blank"><span class="dashicons dashicons-editor-code"></span> Github</a></li>
											</ul>
											<!-- <a href="https://www.buymeacoffee.com/suhag" target="_blank" style="border: none;box-shadow: none;"><img src="<?php // print esc_url( CLUIWP_ASSETS . '/img/buymeacoffee.png' ); ?>" alt="Buy Me A Coffee" style="height: 40px;width: 140px;" rel="noopener noreferrer"></a> -->
										</div>
									</div>
								</div><!-- col-3 end -->
							</div><!-- row end -->
						</form>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Update Settings Option
		 */
		function cluiwp_update_setting_options() {
			$nonce_name   = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( $_POST['_wpnonce'] ) : false;
			$nonce_action = 'add-setting-options-nonce';

			if ( ! isset( $_POST['submit_setting_options'] ) ) {
				return;
			}

			// Check if nonce is valid.
			if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
				return;
			}

			// Check if user has permissions to save data.
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Check and sanitize values.
			$check_color1     = isset( $_POST['cluiwp_color1'] )     ? sanitize_hex_color( $_POST['cluiwp_color1'] )      : '';
			$check_color2     = isset( $_POST['cluiwp_color2'] )     ? sanitize_hex_color( $_POST['cluiwp_color2'] )      : '';
			$check_logo       = isset( $_POST['cluiwp_logo'] )       ? sanitize_text_field( $_POST['cluiwp_logo'] )       : '';
			$check_background = isset( $_POST['cluiwp_background'] ) ? sanitize_text_field( $_POST['cluiwp_background'] ) : '';
			$check_brightness = isset( $_POST['cluiwp_brightness'] ) ? sanitize_key( $_POST['cluiwp_brightness'] )        : '';

			if ( $check_brightness == 0 ) {
				$check_brightness = '0.0';
			}

			update_option( 'cluiwp_color1',     $check_color1 );     // primary color.
			update_option( 'cluiwp_color2',     $check_color2 );     // secondary color.
			update_option( 'cluiwp_logo',       $check_logo );       // logo image.
			update_option( 'cluiwp_background', $check_background ); // background image.
			update_option( 'cluiwp_brightness', $check_brightness ); // brightness opacity.
		}

		/**
		 * Change logo url
		 */
		function cluiwp_change_logo_url() {
			return esc_url( home_url( '/' ) );
		}
		add_filter( 'login_headerurl', 'cluiwp_change_logo_url' );

		/**
		 * Change logo url title
		 */
		function cluiwp_change_logo_url_title() {
			return '';
		}
		add_filter( 'login_headertext', 'cluiwp_change_logo_url_title' );

		/**
		 * Login page customize
		 */
		function cluiwp_login_page_customize() {
			$print_color1     = get_option( 'cluiwp_color1' )     ? esc_attr( get_option( 'cluiwp_color1' ) )               : '#6d28d9';
			$print_color2     = get_option( 'cluiwp_color2' )     ? esc_attr( get_option( 'cluiwp_color2' ) )               : '#0f172a';
			$print_logo       = get_option( 'cluiwp_logo' )       ? esc_url( get_option( 'cluiwp_logo' ) )                  : esc_url( CLUIWP_ASSETS . '/img/logo.png' );
			$print_background = get_option( 'cluiwp_background' ) ? esc_url( get_option( 'cluiwp_background' ) )            : esc_url( CLUIWP_ASSETS . '/img/background.jpg' );
			$print_brightness = get_option( 'cluiwp_brightness' ) ? esc_attr( ( get_option( 'cluiwp_brightness' ) / 100 ) ) : ( 30 / 100 );

			$data_image_utf8 = 'data:image/svg+xml;utf8,';
			$svg_check       = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M14.83 4.89l1.34.94-5.81 8.38H9.02L5.78 9.67l1.34-1.25 2.57 2.4z' fill='{$print_color1}'/></svg>";
			$print_svg       = esc_attr( $data_image_utf8 . rawurlencode( $svg_check ) );

			wp_enqueue_style( 'cluiwp-login-style' );

			$custom_css = "
                :root {
                    --ui-color-1: {$print_color1};
                    --ui-color-2: {$print_color2};
                    --ui-color-white: white;
                }
                body.login {
                    background-image: url({$print_background}) !important;
                }
                body.login::after {
                    opacity: {$print_brightness};
                }
                #login h1 a, .login h1 a {
                    background-image: url({$print_logo}) !important;
                }
                .login input[type=checkbox]:checked::before {
                    content: url('{$print_svg}') !important;
                }
            ";

			wp_add_inline_style( 'cluiwp-login-style', $custom_css );
		}
		add_action( 'login_enqueue_scripts', 'cluiwp_login_page_customize' );

		/**
		 * Plugin activation
		 */
		function cluiwp_plugin_activation() {
			add_option( 'cluiwp_activation_redirect', true );
		}
		register_activation_hook( CLUIWP_FILE, 'cluiwp_plugin_activation' );

		/**
		 * Redirect page
		 */
		function cluiwp_plugin_redirect_page() {
			if ( get_option( 'cluiwp_activation_redirect', false ) ) {
				delete_option( 'cluiwp_activation_redirect' );
				if ( ! isset( $_GET['active-multi'] ) || wp_verify_nonce( isset( $_REQUEST['_wpnonce'] ) ) ) {
					wp_safe_redirect( admin_url( 'admin.php?page=customizer-login-ui' ) );
					exit;
				}
			}
		}
		add_action( 'admin_init', 'cluiwp_plugin_redirect_page' );
	}
endif;

// kick-off the plugin.
customizer_login_ui();
