<?php
namespace BKB\Api;

use WP_REST_Controller;
use BKB\Api\Admin\Settings_Route;
use BKB\Includes\Gf_Wpm_Projects_Endpoints_Kanboard;
/**
 * Rest API Handler
 */
class Api extends WP_REST_Controller {

    
    protected $namespace;
    protected $rest_base;
    protected $endpoints_func;

    /**
     * Construct Function
     */
    public function __construct() {

        $this->namespace = 'bkb/v1';
        $this->rest_base = 'tasks';
        $this->endpoints_func = new Gf_Wpm_Projects_Endpoints_Kanboard;

        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
        add_action( 'rest_api_init', [ $this, 'update_task_routes' ] );

    }

    /**
     * Register API routes
     */
    public function register_routes() {
        ( new Settings_Route() )->register_routes();
    }

    public function update_task_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base.'/kanban-board-id',
            [
                [
                    'methods'             => \WP_REST_Server::EDITABLE,
                    'callback'            => [ $this, 'update_kanban_board_id' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                    'args'                => $this->get_collection_params()
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base.'/kanban-board-order',
            [
                [
                    'methods'             => \WP_REST_Server::EDITABLE,
                    'callback'            => [ $this, 'update_kanban_board_order' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                    'args'                => $this->get_collection_params()
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base.'/kanban-board-order-col',
            [
                [
                    'methods'             => \WP_REST_Server::EDITABLE,
                    'callback'            => [ $this, 'update_kanban_board_order_col' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                    'args'                => $this->get_collection_params()
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base.'/kanban-board-add',
            [
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'add_task_kanban_board' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                    'args'                => $this->get_collection_params()
                ]
            ]
        );
    }

        
    public function add_task_kanban_board( $request ) {

        $title = $request['title'];
        $user = $request['user'];
        $due_date = $request['due_date'];
        $board_id = $request['board_id'];
        $board_task_id = $request['board_task_id'];

        $response = $this->endpoints_func->add_task_kanban_board_func( $title , $user, $due_date, $board_id, $board_task_id);  

        return rest_ensure_response( $response );

       //return 'Api.php - '.$title.' - '.$user.' - '.$due_date.' - '.   $board_id .' - '.$board_task_id;

    }

    
    public function update_kanban_board_order_col( $request ) {

     
        $data_id = $request['data_id'];
        $order_update_db = $request['order_update_db'];

        $response = $this->endpoints_func->update_kanban_board_order_col( $data_id ,  $order_update_db );  

        return rest_ensure_response( $response );

    }


    public function update_kanban_board_order( $request ) {

        $current_order = $request['current_order'];
        $current_id = $request['current_id'];
        $down_order = $request['down_order'];
        $down_id = $request['down_id'];

        $response = $this->endpoints_func->update_kanban_board_order($current_order, $current_id, $down_order, $down_id);  

        return rest_ensure_response( $response );

    }


    public function update_kanban_board_id( $request ) {
        // $response = [
        //     'firstname' => get_option( 'bkb_settings_firstname', true ),
        //     'lastname'  => get_option( 'bkb_settings_lastname', true ),
        //     'email'     => get_option( 'bkb_settings_email', true ),
        // ];

        // return rest_ensure_response( $response );

        $task_id = $request['task_id'];
        $board_id = $request['board_id'];


        $response = $this->endpoints_func->update_kanban_board_id($task_id, $board_id );  

        //return rest_ensure_response( $response );

        return  print_r($task_id. ' '.$board_id, true);

         //return $request;

        //return $task_query->test_trigger();

    }

    
        /**
     * Get items permission check
     */
    public function get_items_permission_check( $request ) {
        // if( current_user_can( 'administrator' ) ) {
        //     return true;
        // }

        return true;
    }

       /**
     * Retrives the query parameters for the items collection
     */
    public function get_collection_params() {
        return [];
    }

}