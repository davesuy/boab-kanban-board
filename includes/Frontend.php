<?php

namespace BKB\Includes;

class Frontend {

    public function __construct() {

        add_shortcode( 'bkb-app', [ $this, 'render_frontend' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts_styles' ] );
        add_action('init', [$this, 'test_display'] );

        
    }

    public function test_display() {
        
     $task_query = new Gf_Wpm_Projects_Endpoints_Kanboard;
     //$task_query->update_kanban_board_id(139, 90 );
     
    //echo '<pre>'.print_r($task_query->update_kanban_board_task(55, 'title',  'sa', 91  ), true).'</pre>';
    }

    /**
     * Render Frontend
     * @since 1.0.0
     */
    public function render_frontend( $atts, $content = '' ) {
        wp_enqueue_style( 'bkb-frontend' );
        wp_enqueue_script( 'bkb-frontend' );

        $content .= '<div id="bkb-frontend-app"></div>';

        return $content;

        // add_action( 'load-' . $hook, [ $this, 'init_hooks' ] );
    }

    public function register_scripts_styles() {
        $this->load_scripts();
        $this->load_styles();
    }

    public function load_scripts() {
        wp_register_script( 'bkb-manifest', BKB_PLUGIN_URL . 'assets/js/manifest.js', [], rand(), true );
        wp_register_script( 'bkb-vendor', BKB_PLUGIN_URL . 'assets/js/vendor.js', [ 'bkb-manifest' ], rand(), true );
        wp_register_script( 'bkb-frontend', BKB_PLUGIN_URL . 'assets/js/frontend.js', [ 'bkb-vendor' ], rand(), true );

        wp_enqueue_script( 'bkb-manifest' );
        wp_enqueue_script( 'bkb-vendor' );
        wp_enqueue_script( 'bkb-admin' );

        wp_localize_script( 'bkb-frontend', 'bkbFrontendLocalizer', [
            'adminUrl'  => admin_url( '/' ),
            'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
            'apiUrl'    => home_url( '/wp-json' ),
        ] );

        $task_query = new Gf_Wpm_Projects_Endpoints_Kanboard;

        //echo '<pre>'.print_r( $task_query->query_task_for_user(6), true).'</pre>';

        $project_id = 6;
        $logged_in_user = 2;
        $board_id_wating = 90;
        $board_id_inprogress = 91;

        wp_localize_script('bkb-frontend', 'taskData', array( 
			'task_waiting' => $task_query->query_task_for_user($project_id, $board_id_wating , $logged_in_user ),
			'task_inprogress' => $task_query->query_task_for_user( $project_id , $board_id_inprogress, $logged_in_user ),
		));

    }

    public function load_styles() {
        wp_register_style( 'bkb-frontend', BKB_PLUGIN_URL . 'assets/css/frontend.css' );
        wp_enqueue_style( 'bkb-frontend' );
    }

     /**
     * Init Hooks for Admin Pages
     * @since 1.0.0
     */
    public function init_hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

        /**
     * Load Necessary Scripts & Styles
     * @since 1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'bkb-frontend' );
        wp_enqueue_script( 'bkb-frontend' );
    }



}