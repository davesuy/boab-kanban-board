<?php

namespace BKB\Includes;

class Gf_Wpm_Projects_Endpoints_Kanboard {


	public $project_id_boab_aiml_community = 6;
	public $boab_step_id_approval = 13;
	public $field_user = 1;
	public $waiting_task_list_id = 86;
	public $waiting_kanboard_id = 90;

	/*** Table Name ***/

	public $db_table_assignees = 'pm_assignees';
	public $db_table_tasks = 'pm_tasks';
	public $db_table_boardables = 'pm_boardables';

	/*** Endpoints URL get_bloginfo('url') for Home URL ***/

	public $endpoint_save_post_type = "/wp-json/gf/v2/workflow/webhooks/6/H6OyUkGjNyl90ZDMF3q56TXew";
	public $endpoint_approver_field = "/wp-json/gf/v2/workflow/webhooks/19/jd5nmLAhJF7uz67PKIo7VmyW6";

	/*** Incoming Web Hook on Workflow Steps API Key and Secret ***/

	public $workflow_api_key = '4af481f2260f99260f5e76a949e31d0e';
	public $workflow_api_secret = 'a4b0d2185c16aa753208d79975f2bd5a';


	public function __construct() {
	

	}

	public function get_project_id_boab_aiml_community() {

		return $this->project_id_boab_aiml_community;

	}	

	public function get_endpoint_save_post_type() {

		$endpoint = get_bloginfo('url') . $this->endpoint_save_post_type;

		return $endpoint;

	}	

	public function get_endpoint_approver_field() {

		$endpoint = get_bloginfo('url') . $this->endpoint_approver_field;

		return $endpoint;

	}

	private function wp_prefix() {

		global $wpdb;

		return 	 $wpdb->prefix;

	}

	public function db_table_assignees() {
		
		return $this->wp_prefix() . $this->db_table_assignees;   

	}

	public function db_table_tasks() {
		
		return  $this->wp_prefix() . $this->db_table_tasks; 

	}

	public function db_table_boardables() {

		return $this->wp_prefix() . $this->db_table_boardables; 

	}

	/*******************/

	/**** Functions ****/

	public function boab_assigned_to() { 
      
		global $wpdb;   
		
		$table_name = $this->db_table_assignees();     
	
		$date = date('Y-m-d H:i:s');     
		$format = array('%d','%d','%d','%d','%d','%s','%s','%s','%d', '%s','%s');
	
	
		$exists = $wpdb->insert( $table_name, array(
			'task_id' => 101,
			'assigned_to' => 2,
			'status' => 0,
			'created_by' => 1,
			'updated_by' => 1,
			'assigned_at' => $date,
			'started_at' => NULL,
			'completed_at' => NULL,
			'project_id' => 2,
			'created_at' => $date,
			'updated_at' => $date,
		  
		));

	} 

		
	public function assigned_user($task_id, $assigned_to, $project_id) {

		global $wpdb;  

		// Assign User
			
		$table_name = $this->db_table_assignees();   

		$date = date('Y-m-d H:i:s');
		$current_user_id = get_current_user_id();

		$exists = $wpdb->insert( $table_name, array(
			'task_id' => $task_id,
			'assigned_to' => $assigned_to,
			'status' => 0,
			'created_by' => $current_user_id,
			'updated_by' => $current_user_id,
			'assigned_at' => $date,
			'started_at' => NULL,
			'completed_at' => NULL,
			'project_id' => $project_id,
			'created_at' => $date,
			'updated_at' => $date,
		
		));

	}

	public function add_task_from_gf($title, $description, $project_id, $assigned_to, $start_at, $due_date) {

		global $wpdb;  
	
		$date = date('Y-m-d H:i:s');     
	
		
		$table_name = $this->db_table_tasks();     
	
		$exists_task_id = $wpdb->insert( $table_name, array(
			'title' => $title,
			'description' => $description,
			'estimation' => 0,
			'start_at' => $start_at,
			'due_date' => $due_date,
			'complexity' => NULL,
			'priority' => 1,
			'payable' => 0,
			'recurrent' => 0,
			'status' => 0,
			'is_private' => 0,
			'project_id' => $project_id,
			'parent_id' => 0,
			'completed_by' => NULL,
			'completed_at' => NULL,
			'created_by' => 1,
			'updated_by' => 1,
			'created_at' => $date,
			'updated_at' => $date,
		));
	
		$table_boardables = $this->db_table_boardables();  
	
		if($exists_task_id) {
	
			$task_id = $wpdb->insert_id;
			
			//$exists_board_id = $wpdb->insert( $table_boardables,);
			//$exists_kanboard_id = $wpdb->insert( $table_boardables, );
	
			$waiting_task_list_id = $this->waiting_task_list_id;
			$waiting_kanboard_id = $this->waiting_kanboard_id;
	
			$order_task_list =  $this->get_data_order($table_boardables, 'task_list');
			$order_kanboard =  $this->get_data_order($table_boardables, 'kanboard');
	
			$rows = array(
				array(
					'board_id' => $waiting_task_list_id,
					'board_type' => 'task_list',
					'boardable_id' => $task_id,
					'boardable_type' => 'task',
					'order' => $order_task_list,
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => 0,
					'updated_at' => 0,
				),
				array(
					'board_id' => $waiting_kanboard_id,
					'board_type' => 'kanboard',
					'boardable_id' => $task_id ,
					'boardable_type' => 'task',
					'order' => $order_kanboard,
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => 0,
					'updated_at' => 0,
				)
			);
		
			foreach( $rows as $row )
			{
				$wpdb->insert( $table_boardables, $row);  
			}
	
			$this->assigned_user($task_id, $assigned_to, $project_id);
		   
		}
		
	}
	

	/**
	 * Latest Order Number
	 */

	public function get_data_order($table_boardables, $board_type){
	
		global $wpdb;
	
		$wpdb->show_errors();
	
		//$table_boardables = $this->db_table_boardables(); 
		
		$result = $wpdb->get_results("SELECT * FROM $table_boardables WHERE  board_type = '{$board_type}'  ORDER BY id DESC");
	
		return $result[0]->order + 1; 
	   
	}

	
	/**
	 *  Get Results Task for Loggedin User
	 */

	public function query_task_for_user($project_id, $board_id, $logged_user_id) {

		global $wpdb;

		$wpdb->show_errors();

		$table_tasks = $this->db_table_tasks();    
		$table_assignees = $this->db_table_assignees();   
		$table_boardables = $this->db_table_boardables(); 
		$project_id = $this->project_id_boab_aiml_community;
		$board_type = "kanboard";


		// if($_GET['user']) {

		// 	$logged_user_id = $_GET['user'];

		// } elseif($_GET['user_add']) {

		// 	$val = preg_replace('/[\s\+]/', ' ', $_GET['user_add']);

		// 	$user = get_users(array('search' =>  $val));
		
		// 	if (!empty($user))
		// 		$logged_user_id  = $user[0]->ID;

		// }

		//$logged_user_id = 2;




		//$results = $wpdb->get_results("SELECT $table_tasks.title, $table_tasks.description, $table_tasks.start_at, $table_tasks.due_date, $table_assignees.task_id FROM $table_tasks 
		//INNER JOIN $table_assignees ON $table_tasks.id = $table_assignees.task_id WHERE $table_assignees.assigned_to = '{$logged_user_id}'
		//");

		//$query = "SELECT $table_tasks.title, $table_tasks.id, $table_tasks.description, $table_assignees.task_id, $table_tasks.start_at, $table_tasks.due_date, $table_assignees.assigned_to FROM $table_tasks INNER JOIN $table_assignees ON $table_tasks.id = $table_assignees.task_id WHERE $table_assignees.assigned_to = '{$logged_user_id}' AND $table_assignees.project_id = '{$project_id}' ORDER BY $table_tasks.id DESC
		//";

		$query = "SELECT $table_tasks.title, $table_tasks.id, $table_tasks.description, $table_assignees.task_id, $table_tasks.start_at, $table_tasks.due_date, $table_assignees.assigned_to, $table_boardables.boardable_id, $table_boardables.board_id, $table_boardables.board_type, $table_boardables.order FROM $table_tasks INNER JOIN $table_assignees ON $table_tasks.id = $table_assignees.task_id INNER JOIN $table_boardables ON $table_tasks.id = $table_boardables.boardable_id WHERE $table_assignees.assigned_to = '{$logged_user_id}' AND $table_assignees.project_id = '{$project_id}' AND $table_boardables.board_id = '{$board_id}' AND $table_boardables.board_type = '{$board_type}' ORDER BY $table_boardables.order ASC
		";
				
		$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		$total = $wpdb->get_var($total_query);
		$items_per_page = 100;
		$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset = ( $page * $items_per_page ) - $items_per_page;
		$results = $wpdb->get_results( $query . " LIMIT ${offset}, ${items_per_page}" );
		
		//$results = $wpdb->get_results($query);
		
		// $results = $wpdb->get_results("SELECT * FROM $table_tasks, $table_assignees 
			
		// LEFT JOIN $table_assignees ON  $table_tasks =  $table_assignees.task_id WHERE project_id = '{$project_id}' ORDER BY id DESC");

		// return '<pre>'.print_r($results ,true).'</pre>';

		return $results;
	
	}

	public function update_kanban_board_id( $task_id,  $board_id ) {

		global $wpdb;  

		$wpdb->show_errors();
	
		$table_tasks = $this->db_table_tasks();      
		$table_boardables = $this->db_table_boardables(); 
		
		$query = $wpdb->prepare("
		UPDATE $table_boardables
		SET $table_boardables.board_id = '{$board_id}' WHERE  $table_boardables.boardable_id = {$task_id}
		");

		$results = $wpdb->get_results( $query );

		//echo '<pre>'.print_r($query, true).'</pre>';


	}

	public function update_kanban_board_order_col($data_id ,  $order_update_db) {

		global $wpdb;  

		$wpdb->show_errors();
	   
		$table_boardables = $this->db_table_boardables(); 
		
		$query = $wpdb->prepare("
		UPDATE $table_boardables
		SET $table_boardables.order = '{$order_update_db}' WHERE  $table_boardables.boardable_id = {$data_id}
		");

		$results = $wpdb->get_results( $query );

	
	}

	public function update_kanban_board_order( $current_order, $current_id, $down_order, $down_id) {

		global $wpdb;  

		$wpdb->show_errors();
	
		$table_tasks = $this->db_table_tasks();      
		$table_boardables = $this->db_table_boardables(); 
		
		$query = $wpdb->prepare("
		UPDATE $table_boardables
		SET $table_boardables.order = '{$down_order}' WHERE  $table_boardables.boardable_id = {$current_id}
		");

		$results = $wpdb->get_results( $query );

		/**
		 * Down List
		 */

		$query2 = $wpdb->prepare("
		UPDATE $table_boardables
		SET $table_boardables.order = '{$current_order}' WHERE  $table_boardables.boardable_id = {$down_id}
		");

		$results2 = $wpdb->get_results( $query2 );

		//echo '<pre>'.print_r($query, true).'</pre>';


	}

	public function test_trigger() {
		return 'xxaa';
	}


}
