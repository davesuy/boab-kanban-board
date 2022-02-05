<?php
namespace BKB\Includes;

class Admin {

    /**
     * Construct Function
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts_styles' ] );
    }

    public function register_scripts_styles() {
        //$this->load_scripts();
       // $this->load_styles();
    }

    /**
     * Load Scripts
     *
     * @return void
     */
    public function load_scripts() {
        wp_register_script( 'bkb-manifest', BKB_PLUGIN_URL . 'assets/js/manifest.js', [], rand(), true );
        wp_register_script( 'bkb-vendor', BKB_PLUGIN_URL . 'assets/js/vendor.js', [ 'bkb-manifest' ], rand(), true );
        wp_register_script( 'bkb-admin', BKB_PLUGIN_URL . 'assets/js/admin.js', [ 'bkb-vendor' ], rand(), true );

        wp_enqueue_script( 'bkb-manifest' );
        wp_enqueue_script( 'bkb-vendor' );
        wp_enqueue_script( 'bkb-admin' );

        wp_localize_script( 'bkb-admin', 'bkbAdminLocalizer', [
            'adminUrl'  => admin_url( '/' ),
            'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
            'apiUrl'    => home_url( '/wp-json' ),
        ] );

        // wp_localize_script('bkb-admin', 'taskData', array( 
		// 	'data_var_1' => 'valusd1',
		// 	'data_var_2' => 'value 2',
		// ));
    }

    public function load_styles() {
        wp_register_style( 'bkb-admin', BKB_PLUGIN_URL . 'assets/css/admin.css' );

        wp_enqueue_style( 'bkb-admin' );
    }

    /**
     * Register Menu Page
     * @since 1.0.0
     */
    public function admin_menu() {
        global $submenu;

        $capability = 'manage_options';
        $slug       = 'boab-kanban-board';

        $hook = add_menu_page(
            __( 'Boab Kanban Board', 'textdomain' ),
            __( 'Boab Kanban Board', 'textdomain' ),
            $capability,
            $slug,
            [ $this, 'menu_page_template' ],
            'dashicons-buddicons-replies'
        );

        if( current_user_can( $capability )  ) {
            $submenu[ $slug ][] = [ __( 'General', 'textdomain' ), $capability, 'admin.php?page=' . $slug . '#/' ];
            $submenu[ $slug ][] = [ __( 'Kanban Board', 'textdomain' ), $capability, 'admin.php?page=' . $slug . '#/kanban-board' ];
            $submenu[ $slug ][] = [ __( 'Settings', 'textdomain' ), $capability, 'admin.php?page=' . $slug . '#/settings' ];
        }

        // add_action( 'load-' . $hook, [ $this, 'init_hooks' ] );
    }

    /**
     * Init Hooks for Admin Pages
     * @since 1.0.0
     */
    public function init_hooks() {
        add_action( 'admin_enqueu_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Load Necessary Scripts & Styles
     * @since 1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'bkb-admin' );
        wp_enqueue_script( 'bkb-admin' );
    }

    /**
     * Render Admin Page
     * @since 1.0.0
     */
    public function menu_page_template() {

        echo '<div class="wrap">
        
            <div id="bkb-admin-app">
            
            </div>
        
        </div>';
    }

}