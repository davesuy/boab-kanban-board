<?php
/**
 * Plugin Name: Boab Kanban Board
 * Plugin URI: https://github.com/davesuy
 * Description: Boab Kanban Board with Vue JS
 * Version: 1.0.0
 * Author: Dave Ramirez
 * Author URI: https://github.com/davesuy
 * License: GPL v3
 * Text-Domain: textdomain
 */

if( ! defined( 'ABSPATH' ) ) exit(); // No direct access allowed

/**
 * Require Autoloader
 */
require_once 'vendor/autoload.php';
//require_once 'C:\xampp\htdocs\boab.aiml.community\wp-content\plugins\boab-kanban-board\includes\Admin.php';

use BKB\Api\Api;
use BKB\Includes\Admin;
use BKB\Includes\Frontend;

use BKB\Includes\Gf_Wpm_Projects_Endpoints_Kanboard;

final class Boab_Kanban_Board {

    /**
     * Define Plugin Version
     */
    const VERSION = '1.0.0';

    /**
     * Construct Function
     */
    public function __construct() {
        $this->plugin_constants();
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
        
    }

    /**
     * Plugin Constants
     * @since 1.0.0
     */
    public function plugin_constants() {
        define( 'BKB_VERSION', self::VERSION );
        define( 'BKB_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'BKB_PLUGIN_URL', trailingslashit( plugins_url( '', __FILE__ ) ) );
        define( 'BKB_NONCE', 'b?le*;K7.T2jk_*(+3&[G[xAc8O~Fv)2T/Zk9N:GKBkn$piN0.N%N~X91VbCn@.4' );
    }

    /**
     * Singletone Instance
     * @since 1.0.0
     */
    public static function init() {
        static $instance = false;

        if( !$instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * On Plugin Activation
     * @since 1.0.0
     */
    public function activate() {
        $is_installed = get_option( 'bkb_is_installed' );

        if( ! $is_installed ) {
            update_option( 'bkb_is_installed', time() );
        }

        update_option( 'bkb_is_installed', BKB_VERSION );
    }

    /**
     * On Plugin De-actiavtion
     * @since 1.0.0
     */
    public function deactivate() {
        // On plugin deactivation
    }

    /**
     * Init Plugin
     * @since 1.0.0
     */
    public function init_plugin() {
                
        // init
        new Admin();
        new Frontend();
        new Api();
    }

}

/**
 * Initialize Main Plugin
 * @since 1.0.0
 */
function boab_kanban_board() {
    return Boab_Kanban_Board::init();
}

// Run the Plugin
boab_kanban_board();