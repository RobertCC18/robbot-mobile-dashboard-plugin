<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:      Wp-Json-Auth
 * Plugin URI:       http://robbotdev.com
 * Description:      This plugin is to allow Access to your Wordpress Website From the Rob-Bot Mobile App
 * Version:           1.0.0
 * Author:            Robbot
 * Author URI:        http://robbot.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Wp-Auth-Json
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
$api_secret = get_option('api_secret');
define('JWT_AUTH_SECRET_KEY', $api_secret);
define('JWT_AUTH_CORS_ENABLE', true);
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-activator.php';
	Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Plugin_Name();
	$plugin->run();

}

function register_jwt_activate() {
    require_once plugin_dir_path( __FILE__ ) . 'wp-api-jwt-auth-develop/jwt-auth.php';
	run_jwt_auth();
    
}
register_jwt_activate();
run_plugin_name();

 add_action('admin_menu', 'my_cool_plugin_create_menu');

function my_cool_plugin_create_menu() {

	//create new top-level menu
	add_menu_page('Wp-Rest-Authentication', 'Cool Settings', 'administrator', __FILE__, 'my_cool_plugin_settings_page' , plugins_url('/images/icon.png', __FILE__) );

	//call register settings function

}


function register_robbot_settings() {
	//register our settings
	register_setting( 'robbot_plugin_options', 'api_secret' );
	
}
add_action( 'admin_init', 'register_robbot_settings' );
function my_cool_plugin_settings_page() {
?>
<div class="wrap">
<h1 style="text-align: center;">WP Mobile Dashboard Settings</h1>
<h2 style="text-align: center;">This is where you can change some of the basic settings for your Mobile Dashboard</h2>
<h3 style="text-align: center;">Be sure to download the app and follow the instructions to set up your awesome mobile dashboard!</h3>
<form method="post" action="options.php">
    <?php settings_fields( 'robbot_plugin_options' ); ?>
    <?php do_settings_sections( 'robbot_plugin_options' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Set Secret Key</th>
        <td><input type="text" name="api_secret" value="<?php echo esc_attr( get_option('api_secret') ); ?>" /></td>
        <td><?php echo $api_secret ?> </td>
        </tr>
         
      
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php }