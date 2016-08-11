<?php
/*
Plugin Name: WP Easy Poll
Plugin URI: http://avifoujdar.wordpress.com/category/my-wp-plugins/
Description: This is an easy poll plugin. Polls can be created from admin panel and displayed as widget in frontend. Users can submit vote and view poll results from frontend.
Version: 2.1.0
Text Domain: wp-easy-poll-afo
Domain Path: /languages
Author: avimegladon
Author URI: http://aviplugins.com/
*/

/**
	  |||||   
	<(`0_0`)> 	
	()(afo)()
	  ()-()
**/

include_once dirname( __FILE__ ) . '/settings.php';
include_once dirname( __FILE__ ) . '/paginate_class.php';
include_once dirname( __FILE__ ) . '/message_class.php';

class general_poll_class{
	public $poll_bar_height = '';
	public $poll_bar_color = '';
	
	public function __construct(){
		$this->poll_bar_height = '10'; // in px
		$this->poll_bar_color = '#B61F24'; // in hex
	}
	
	public function is_poll_started($p_id = ''){
		if($p_id == ''){
			return false;
		}
		global $wpdb;
		$pc = new poll_class;
		$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$pc->table." where p_id = %d and p_start <= now()", $p_id );
		$result = $wpdb->get_row( $query, ARRAY_A );
		if($result){
			return true;
		} else {
			return false;
		}
	}

	public function is_poll_closed($p_id = ''){
		if($p_id == ''){
			return false;
		}
		global $wpdb;
		$pc = new poll_class;
		$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$pc->table." where p_id = %d and p_end <= now()", $p_id );
		$result = $wpdb->get_row( $query, ARRAY_A );
		if($result){
			return true;
		} else {
			return false;
		}
	}
	
	public function is_poll_active($p_id = ''){
		if($p_id == ''){
			return false;
		}
		global $wpdb;
		$pc = new poll_class;
		$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$pc->table." where p_id = %d and p_start <= now() and p_end >= now()", $p_id );
		$result = $wpdb->get_row( $query, ARRAY_A );
		if($result){
			return true;
		} else {
			return false;
		}
	}
	
	public function poll_status_message($p_id = ''){
		if($p_id == ''){
			return array('status' => false, 'msg' => __('Zvolte možnost','wp-easy-poll-afo'));
		}
		global $wpdb;
		$pc = new poll_class;
		$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$pc->table." where p_id = %d and p_start <= now() and p_end >= now()", $p_id );
		$result = $wpdb->get_row( $query, ARRAY_A );
		$data = $pc->get_single_row_data($p_id);
		if($result){
			return array('status' => true);
		} else {
			if( !$this->is_poll_started($p_id) ){
				return array('status' => false, 'msg' => __('Voting will start on','wp-easy-poll-afo')." ".$data['p_start'].".");
			}
			if($this->is_poll_closed($p_id)){
				return array('status' => false, 'msg' => __('Voting is over.','wp-easy-poll-afo').$this->get_vote_result_link($p_id));
			}
		}
	}
	
	public function get_user_name_or_email($user_id = ''){
		if($user_id == ''){	
			return;
		}
		$user_info = get_userdata($user_id);
		$name_or_email = ($user_info->user_email == '' ? $user_info->display_name : $user_info->user_email);
		
		return $name_or_email == '' ? __('Visitor','eca') : $name_or_email;
	}
	
	function get_vote_result_link($poll_id = ''){
		if($poll_id == ''){
			return;
		} else {
			return '<a href="javascript:void(0);" class="view_result" onclick="LoadPollResult('.$poll_id.')">'.__('Zobrazit výsledky','wp-easy-poll-afo').'</a>';
		}
	}
	
	function get_polls_selected($sel_id = ''){
		global $wpdb;
		$pc = new poll_class;
		$ret = '';
		$query = "SELECT * FROM ".$wpdb->prefix.$pc->table." where p_status='Active' order by p_added desc";
		$results = $wpdb->get_results( $query, ARRAY_A );
		
		
		foreach ( $results as $key => $value ) {
			if($sel_id == $value['p_id']){
				$ret .= '<option value="'.$value['p_id'].'" selected="selected">'.stripslashes($value['p_ques']).'</option>';
			} else {
				$ret .= '<option value="'.$value['p_id'].'">'.stripslashes($value['p_ques']).'</option>';
			}
		}
		return $ret;
	}
	
	public function get_p_id_from_a_id($a_id = ''){
		if($a_id == ''){
			return false;
		}
		global $wpdb;
		$pc = new poll_class;
		$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$pc->table2." where a_id = %d", $a_id );
		$result = $wpdb->get_row( $query, ARRAY_A );
		
		if($result){
			return $result['p_id'];
		} else {
			return false;
		}
	}

	public function check_if_user_has_voted($user_id = '', $user_ip = '', $p_id = ''){
		global $wpdb;
		$pc = new poll_class;
		
		if($p_id == ''){
			return false;
		}
		if($user_id != '' and $user_ip == ''){
			$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$pc->table3." where p_id = %d and user_id = %d", $p_id, $user_id );
			$result = $wpdb->get_row( $query, ARRAY_A );
			if($result){
				return false;
			} else {
				return true;
			}
		} elseif($user_id == '' and $user_ip != ''){
			$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$pc->table3." where p_id = %d and user_ip = %s", $p_id, $user_ip );
			$result = $wpdb->get_row( $query, ARRAY_A );
			if($result){
				return false;
			} else {
				return true;
			}
		} elseif($user_id != '' and $user_ip != ''){
			$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$pc->table3." where p_id = %d and user_id = %d and user_ip = %s", $p_id, $user_id, $user_ip );
			$result = $wpdb->get_row( $query, ARRAY_A );
			if($result){
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	public function save_user_vote($data = array(), $data_format = array()){
		global $wpdb;
		$pc = new poll_class;
		
		if(empty($data) or !is_array($data)){
			return array('res' => 'error', 'msg' => 'Data is empty!');
		}
		
		// check if the user is logged in or not 
		if(is_user_logged_in()){
			// if logged in then check if this user has voted in this poll
			$user_id = get_current_user_id();
			$res = $this->check_if_user_has_voted($user_id, '', $data['p_id']);
			if($res){
				$wpdb->insert( $wpdb->prefix.$pc->table3, $data, $data_format );
				return array('res' => 'success', 'msg' => __('Váš hlas byl zaznamenán.','wp-easy-poll-afo'));
			} else {
				return array('res' => 'error', 'msg' => __('Již jste hlasovali.','wp-easy-poll-afo'));
			}
		}
		
		// if user is not logged in
		if(!is_user_logged_in()){
			// if logged in then check if this user has voted in this poll
			$res = $this->check_if_user_has_voted('', $data['user_ip'], $data['p_id']);
			if($res){
				$wpdb->insert( $wpdb->prefix.$pc->table3, $data, $data_format );
				return array('res' => 'success', 'msg' => __('Váš hlas byl zaznamenán.','wp-easy-poll-afo'));
			} else {
				return array('res' => 'error', 'msg' => __('Již jste hlasovali.','wp-easy-poll-afo'));
			}
		}
		return array('res' => 'error', 'msg' => __('Zkuste to znovu.','wp-easy-poll-afo'));
	}
	
	public function voting_result($p_id = ''){
		global $wpdb;
		$pc = new poll_class;
		$ret = '';
		if($p_id == ''){
			$ret .= __('Poll is empty!','wp-easy-poll-afo');
			return $ret;
		}
		$poll_result_after_it_ends = get_option('poll_result_after_it_ends');
		if($poll_result_after_it_ends == 'Yes' and !$this->is_poll_closed($p_id)){
			$ret .= __('Check result after poll ends.','wp-easy-poll-afo');
			return $ret;
		}
		// get poll options 
		$data1 = $pc->get_poll_answers_data($p_id);
		if(is_array($data1)){
			$ret .= '<ul class="poll_list">';
			foreach($data1 as $key => $value){
				$ret .= '<li>';
				$ret .= stripslashes($value['a_ans']);
				$ret .= $this->answer_bar($p_id,$value['a_id']);
				$ret .= '</li>';
			}
			$ret .= '</ul>';
		}
		return $ret;
	}
	
	
	public function answer_bar($p_id = '', $a_id = ''){
		if($p_id == '' or $a_id == ''){	
			return;
		}
		$total_votes = $this->get_total_votes($p_id);
		$total_votes_by_ans = $this->get_total_votes_by_a_id($a_id);
		
		if($total_votes){
			$ans_per = ((100/$total_votes) * $total_votes_by_ans);
			$ans_per = number_format($ans_per,2);
		} else {
			$ans_per = 0;
		}
		
		$bar = ' ('.$total_votes_by_ans.'/'.$total_votes.') ';
		$bar .= '<div style="height:'.$this->poll_bar_height.'px; border:1px solid #000000; width:100%;"><div style="background-color:'.$this->poll_bar_color.';height:'.$this->poll_bar_height.'px; width:'.$ans_per.'%;"></div></div>';
		return $bar;
	}
	
	public function get_total_votes_by_a_id($a_id = ''){
		if($a_id == ''){	
			return;
		}
		global $wpdb;
		$pc = new poll_class;
		$query = $wpdb->prepare( "SELECT count(*) as tot FROM ".$wpdb->prefix.$pc->table3." where a_id = %d", $a_id);
		$result = $wpdb->get_row( $query, ARRAY_A );
		if($result){
			return $result['tot']; 
		} else {
			return 0;
		}
	}
	
	public function get_total_votes($p_id = ''){
		if($p_id == ''){	
			return;
		}
		global $wpdb;
		$pc = new poll_class;
		$query = $wpdb->prepare( "SELECT count(*) as tot FROM ".$wpdb->prefix.$pc->table3." where p_id = %d", $p_id );
		$result = $wpdb->get_row( $query, ARRAY_A );
		if($result){
			return $result['tot']; 
		} else {
			return 0;
		}
	}
	
	public function get_ques_from_p_id($p_id = ''){
		if($p_id == ''){	
			return;
		}
		global $wpdb;
		$pc = new poll_class;
		$query = $wpdb->prepare( "SELECT p_ques FROM ".$wpdb->prefix.$pc->table." where p_id = %d", $p_id );
		$result = $wpdb->get_row( $query, ARRAY_A );
		if($result){
			return sanitize_text_field(stripslashes($result['p_ques'])); 
		} else {
			return;
		}
	}
	
	public function answer_data_for_csv($p_id = '', $a_id = ''){
		if($p_id == '' or $a_id == ''){	
			return;
		}
		$total_votes = $this->get_total_votes($p_id);
		$total_votes_by_ans = $this->get_total_votes_by_a_id($a_id);
		
		if($total_votes){
			$ans_per = ((100/$total_votes) * $total_votes_by_ans);
			$ans_per = number_format($ans_per,2);
		} else {
			$ans_per = 0;
		}
		
		$bar = ' ('.$total_votes_by_ans.'/'.$total_votes.') ';
		return $bar;
	}
	
	public function get_ans_from_a_id($a_id = ''){
		if($a_id == ''){	
			return;
		}
		global $wpdb;
		$pc = new poll_class;
		$query = $wpdb->prepare( "SELECT a_ans FROM ".$wpdb->prefix.$pc->table2." where a_id = %d", $a_id );
		$result = $wpdb->get_row( $query, ARRAY_A );
		if($result){
			return sanitize_text_field(stripslashes($result['a_ans'])); 
		} else {
			return;
		}
	}
	
	
}

class poll_class extends general_poll_class{
    
	public $plugin_page;
	public $plugin_page_base;
	public $table;
	public $table2;
	public $table3;
	
    function __construct(){
      $this->plugin_page_base = 'easy_polls';
	  $this->plugin_page = admin_url('admin.php?page='.$this->plugin_page_base);
	  $this->table = 'easy_poll_q';
	  $this->table2 = 'easy_poll_a';
	  $this->table3 = 'easy_poll_votes';
    }
	
	function get_table_colums(){
		$colums = array(
		'p_id' => __('ID','wp-easy-poll-afo'),
		'p_ques' => __('Poll','wp-easy-poll-afo'),
		'p_author' => __('Author','wp-easy-poll-afo'),
		'p_start' => __('Start','wp-easy-poll-afo'),
		'p_end' => __('End','wp-easy-poll-afo'),
		'p_status' => __('Status','wp-easy-poll-afo'),
		'action' => __('Action','wp-easy-poll-afo')
		);
		return $colums;
	}
	
	function add_message($msg,$class = 'error'){
		$_SESSION['msg'] = $msg;
	}
	
	function view_message(){
		if(isset($_SESSION['msg']) and $_SESSION['msg']){
			echo '<div class="updated"><p>'.$_SESSION['msg'].'</p></div>';
			$_SESSION['msg'] = '';
		}
	}
	
	function table_start(){
		return '<table class="wp-list-table widefat">';
	} 
    
	function table_end(){
		return '</table>';
	}
	
	function get_table_header(){
		$header = $this->get_table_colums();
		$ret .= '<thead>';
		$ret .= '<tr>';
		foreach($header as $key => $value){
			$ret .= '<th>'.$value.'</th>';
		}
		$ret .= '</tr>';
		$ret .= '</thead>';
		return $ret;		
	}
	
	function table_td_column($value){
		if(is_array($value)){
			foreach($value as $vk => $vv){
				$ret .= $this->row_data($vk,$vv);
			}
		}
		
		$ret .= $this->row_actions($value['p_id']);
		return $ret;
	}
	
	function row_actions($id){
		return '<td><a href="'.$this->plugin_page.'&action=edit&id='.$id.'">'.__('Edit','eca').'</a> <a href="'.wp_nonce_url( $this->plugin_page.'&action=delete_p&id='.$id, 'poll_nonce_action'.$id, 'poll_nonce' ).'">'.__('Delete','eca').'</a></td>';
	}
	
	function add_link(){
		return '<a href="'.$this->plugin_page.'&action=add" class="add-new-h2">'.__('Add','eca').'</a>';
	}
	
	function poll_report_link($id){
		return '<a href="'.$this->plugin_page.'&action=poll_report&p_id='.$id.'">'.__('View Report','eca').'</a>';
	}
		
	function row_data($key,$value){
		$sh = false;
		switch ($key){
			case 'p_id':
			$v = $value.' ('.$this->poll_report_link($value).')';
			$sh = true;
			break;
			case 'p_ques':
			$v = stripslashes($value);
			$sh = true;
			break;
			case 'p_author':
			$v = $this->get_user_name_or_email($value);
			$sh = true;
			break;
			case 'p_start':
			$v = $value;
			$sh = true;
			break;
			case 'p_end':
			$v = $value;
			$sh = true;
			break;
			case 'p_status':
			$v = $value;
			$sh = true;
			break;
			default:
			//$v = $value; uncomment this line on your own risk
			break;
		}
		if($sh){
			return '<td>'.$v.'</td>';
		}
	}
	
	function get_table_body($data){
		$cnt = 0;
		if(is_array($data)){
			$ret .= '<tbody id="the-list">';
			foreach($data as $k => $v){
				$ret .= '<tr class="'.($cnt%2==0?'alternate':'').'">';
				$ret .= $this->table_td_column($v);
				$ret .= '</tr>';
				$cnt++;
			}
			$ret .= '</tbody>';
		}
		return $ret;
	}
	
	function get_single_row_data($id){
		global $wpdb;
		$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$this->table." where p_id = %d", $id );
		$result = $wpdb->get_row( $query, ARRAY_A );
		return $result;
	}
	
	function get_poll_answers_data($id){
		global $wpdb;
		$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$this->table2." where p_id = %d order by a_order", $id );
		$result = $wpdb->get_results( $query, ARRAY_A );
		return $result;
	}
	
	function prepare_data(){
		global $wpdb;
		$query = "SELECT * FROM ".$wpdb->prefix.$this->table." where p_status <> 'Deleted' order by p_added desc";
		//$data = $wpdb->get_results($query,ARRAY_A);
		$ap = new afo_paginate(10,$this->plugin_page);
		$data = $ap->initialize($query,0);
		return $data;
	}
	
	function search_form(){
	?>
	<form name="sub_search" action="" method="get">
	<input type="hidden" name="page" value="<?php echo $this->plugin_page_base;?>" />
	<input type="hidden" name="search" value="p_search" />
	<table width="100%" border="0">
	  <tr>
		<td><input type="text" name="p_ques" value="<?php echo sanitize_text_field($_REQUEST['p_ques']);?>" placeholder="<?php _e('Poll','wp-easy-poll-afo');?>"/> <input type="submit" name="submit" value="<?php _e('Filter','wp-easy-poll-afo');?>" class="button"/></td>
	  </tr>
	</table>
	</form>
	<?php
	}
	
	function process_selector($v = 'data'){
		echo '<input type="hidden" name="action" value="'.$v.'" />';
	}
	
	function get_poll_author_selected($sel_id = ''){
		$authors = get_users();
		$ret = '';
		foreach ( $authors as $author ) {
			if($sel_id == $author->ID){
				$ret .= '<option value="'.$author->ID.'" selected="selected">'.esc_html($author->user_email).'</option>';
			} else {
				$ret .= '<option value="'.$author->ID.'">'.esc_html($author->user_email).'</option>';
			}
		}
		return $ret;
	}
	
	function get_poll_status_selected($sel_id = ''){
		$statuses = array('Active','Inactive','Deleted');
		$ret = '';
		foreach ( $statuses as $status ) {
			if($sel_id == $status){
				$ret .= '<option value="'.$status.'" selected="selected">'.$status.'</option>';
			} else {
				$ret .= '<option value="'.$status.'">'.$status.'</option>';
			}
		}
		return $ret;
	}
	
	function dateTimeJsCall($id = 'datetime'){?>
	 <script type="text/javascript">
		jQuery(function() {
			jQuery( "#<?php echo $id;?>" ).datetimepicker({
				dateFormat: "yy-mm-dd",
				timeFormat: "HH:mm:ss"
			});
		});
	</script>
	<?php }
	
	function jQueryDynamicAnswersJs(){?>
	 <script type="text/javascript">
	jQuery(document).ready(function() {
		var max_fields      = 5; 
		var wrapper         = jQuery(".ans_fields_wrap"); 
		var add_button      = jQuery(".add_more_ans"); 
		
		var x = wrapper.children('div').length; 
		jQuery(add_button).click(function(e){ 
			e.preventDefault();
			if(x < max_fields){ 
				x++; 
				jQuery(wrapper).append('<div><input type="text" name="p_anss[]"/><a href="#" class="remove_field"><?php echo _e('Remove','wp-easy-poll-afo');?></a></div>'); 
			}
		});
	   
		jQuery(wrapper).on("click",".remove_field", function(e){
			e.preventDefault(); jQuery(this).parent('div').remove(); x--;
		})
	});
	</script>
	<?php }
	
	
	function add(){
	$this->view_message();
	?>
	<form name="f" action="" method="post">
	<?php $this->process_selector('p_add');?>
	<?php wp_nonce_field( 'poll_nonce_action', 'poll_nonce_field' ); ?>
	<h2><?php _e('Poll Add','wp-easy-poll-afo');?></h2>
	<table width="95%" border="0" cellspacing="10" style="background-color:#FFFFFF; margin:2%; padding:5px; border:1px solid #CCCCCC;">
		<tr>
			<td><strong><?php _e('Poll Question','wp-easy-poll-afo');?></strong></td>
			<td><input type="text" name="p_ques" /></td>
		</tr>
		<tr>
			<td><strong><?php _e('Author','wp-easy-poll-afo');?></strong></td>
			<td><select name="p_author"><?php echo $this->get_poll_author_selected();?></select></td>
		</tr>
		<tr>
			<td><strong><?php _e('Start','wp-easy-poll-afo');?></strong></td>
			<td><input type="text" name="p_start" id="p_start" required="required"/><?php $this->dateTimeJsCall('p_start');?></td>
		</tr>
		<tr>
			<td><strong><?php _e('End','wp-easy-poll-afo');?></strong></td>
			<td><input type="text" name="p_end" id="p_end" required="required"/><?php $this->dateTimeJsCall('p_end');?></td>
		</tr>
		<tr>
			<td><strong><?php _e('Status','wp-easy-poll-afo');?></strong></td>
			<td><select name="p_status"><?php echo $this->get_poll_status_selected();?></select></td>
		</tr>
		<tr>
			<td><h3><?php _e('Poll Answers','wp-easy-poll-afo');?></h3></td>
			<td><button class="add_more_ans button"><?php _e('Add More Answers','wp-easy-poll-afo');?></button></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><div class="ans_fields_wrap"><div><input type="text" name="p_anss[]"></div></div></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="<?php _e('Odeslat','wp-easy-poll-afo');?>" class="button" /></td>
		</tr>
	</table>
	</form>
	<?php
	$this->jQueryDynamicAnswersJs();
	}	
	
	function edit(){
	$id = sanitize_text_field($_REQUEST['id']);
	$data = $this->get_single_row_data($id);
	$data1 = $this->get_poll_answers_data($id);
	$this->view_message();
	?>
	<form name="f" action="" method="post">
	<?php $this->process_selector('p_edit');?>
	<input type="hidden" name="p_id" id="p_id" value="<?php echo $id;?>" />
	<?php wp_nonce_field( 'poll_nonce_action', 'poll_nonce_field' ); ?>
	<h2><?php _e('Poll Edit','eca');?></h2>
	<table width="95%" border="0" cellspacing="10" style="background-color:#FFFFFF; margin:2%; padding:5px; border:1px solid #CCCCCC;">
		<tr>
			<td><strong><?php _e('Poll Question','wp-easy-poll-afo');?></strong></td>
			<td><input type="text" name="p_ques" value="<?php echo stripslashes($data['p_ques']);?>"/></td>
		</tr>
		<tr>
			<td><strong><?php _e('Author','wp-easy-poll-afo');?></strong></td>
			<td><select name="p_author"><?php echo $this->get_poll_author_selected($data['p_author']);?></select></td>
		</tr>
		<tr>
			<td><strong><?php _e('Start','wp-easy-poll-afo');?></strong></td>
			<td><input type="text" name="p_start" id="p_start" value="<?php echo $data['p_start'];?>" required="required" /><?php $this->dateTimeJsCall('p_start');?></td>
		</tr>
		<tr>
			<td><strong><?php _e('End','wp-easy-poll-afo');?></strong></td>
			<td><input type="text" name="p_end" id="p_end" value="<?php echo $data['p_end'];?>" required="required"/><?php $this->dateTimeJsCall('p_end');?></td>
		</tr>
		<tr>
			<td><strong><?php _e('Status','wp-easy-poll-afo');?></strong></td>
			<td><select name="p_status" id="p_status"><?php echo $this->get_poll_status_selected($data['p_status']);?></select>
			<input type="button" name="submit" value="<?php _e('Save','eca');?>" class="button" onclick="updatePollStatus();" />
			</td>
		</tr>
		<tr>
			<td><h3><?php _e('Poll Answers','wp-easy-poll-afo');?></h3></td>
			<td><button class="add_more_ans button"><?php _e('Add More Answers','wp-easy-poll-afo');?></button></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><div class="ans_fields_wrap">
			<?php 
			if(is_array($data1)){
				foreach($data1 as $key => $value){
					echo '<div><input type="text" name="p_anss[]" value="'.$value['a_ans'].'"><a href="#" class="remove_field">'.__('Remove','wp-easy-poll-afo').'</a></div>';
				}
			}
			?></div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<?php if($this->is_poll_started($id)){
			_e('Poll is started & cannot be updated now!','wp-easy-poll-afo');
			} else { ?>
			<input type="submit" name="submit" value="<?php _e('Odeslat','eca');?>" class="button" />
			<?php } ?>
			</td>
		</tr>
	</table>
	</form>
	<?php
	$this->jQueryDynamicAnswersJs();
	}	
	
	function lists(){
	$this->view_message();
	?>
	<h2><?php _e('Polls','wp-easy-poll-afo');?> <?php echo $this->add_link();?></h2>
	<?php
		global $wpdb;
		
		if(isset($_REQUEST['search']) and $_REQUEST['search'] == 'p_search'){
			if(sanitize_text_field($_REQUEST['p_search'])){
				$query = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$this->table." where p_status <> 'Deleted' and p_ques like %s order by p_added desc", '%'.sanitize_text_field($_REQUEST['p_search']).'%' );
			}
		} else {
			$query = "SELECT * FROM ".$wpdb->prefix.$this->table." where p_status <> 'Deleted' order by p_added desc";
		}
		
		$ap = new afo_paginate(10,$this->plugin_page);
		$data = $ap->initialize($query,$_REQUEST['paged']);
		
		echo $this->search_form();
		echo $this->table_start();
		echo $this->get_table_header();
		echo $this->get_table_body($data);
		echo $this->table_end();
		
		echo $ap->paginate($_REQUEST);
	}
	
	function poll_report($p_id = ''){
	?>
	<h2><?php _e('Poll Report','wp-easy-poll-afo');?></h2>
	<table width="95%" border="0" cellspacing="10" style="background-color:#FFFFFF; margin:2%; padding:5px; border:1px solid #CCCCCC;">
		<tr>
			<td><?php echo $this->get_report($p_id);?></td>
		</tr>
	</table>
	<?php
	}	
	
	function get_report($p_id = ''){
		if($p_id == ''){
			return;
		}
		global $wpdb;
		$ret = '';
		$query =  $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix.$this->table3." where p_id = %d order by v_added desc", $p_id );
		$result = $wpdb->get_results( $query, ARRAY_A );
		$p_ans_data = $this->get_poll_answers_data($p_id);
		
		$ret .= '<h3>'.$this->get_ques_from_p_id($p_id).'</h3>';
		$ret .= '<table width="100%" border="0">';
		foreach ($p_ans_data as $key => $value){
		$ret .= '<tr>';
		$ret .= '<td><strong>'.stripslashes($value['a_ans']).$this->answer_data_for_csv($p_id,$value['a_id']).'</strong></td>';
		$ret .= '</tr>';
		}
		$ret .= '</table>';
		
		$ret .= '<table width="100%" border="0">';
		$ret .= '<tr>';
		$ret .= '<td><strong>'.__('Answer','wp-easy-poll-afo').'</strong></td>';
		$ret .= '<td><strong>'.__('User','wp-easy-poll-afo').'</strong></td>';
		$ret .= '<td><strong>'.__('IP','wp-easy-poll-afo').'</strong></td>';
		$ret .= '<td><strong>'.__('Date','wp-easy-poll-afo').'</strong></td>';
		$ret .= '</tr>';
		foreach ($result as $key => $value){
		$ret .= '<tr>';
		$ret .= '<td>'.$this->get_ans_from_a_id($value['a_id']).'</td>';
		$ret .= '<td>'.$this->get_user_name_or_email($value['user_id']).'</td>';
		$ret .= '<td>'.$value['user_ip'].'</td>';
		$ret .= '<td>'.$value['v_added'].'</td>';
		$ret .= '</tr>';
		} 
 		$ret .= '</table>';
		return $ret;
	}
	
	function start_wrap(){
		echo '<div class="wrap">';
	}
	
	function end_wrap(){
		echo '</div>';
	}
	
	
    function display_list() {
		$this->start_wrap();
		if(isset($_REQUEST['action']) and $_REQUEST['action'] == 'edit'){
			$this->edit();
		} elseif(isset($_REQUEST['action']) and $_REQUEST['action'] == 'add'){
			$this->add();
		} elseif(isset($_REQUEST['action']) and $_REQUEST['action'] == 'poll_report'){
			$this->poll_report($_REQUEST['p_id']);
		} else{
			$this->lists();
		}
		$this->end_wrap();
  }
}

function process_poll_data(){
	if(!session_id()){
		session_start();
	}
	
	if(isset($_REQUEST['action']) and $_REQUEST['action'] == 'delete_p'){
		if ( ! isset( $_REQUEST['poll_nonce'] ) || ! wp_verify_nonce( $_REQUEST['poll_nonce'], 'poll_nonce_action'.sanitize_text_field($_REQUEST['id']) ) ) {
		   wp_die( 'Sorry, your nonce did not verify.');
		} 
		global $wpdb;
		$pc = new poll_class;
		$update =  array('p_status' => 'Deleted');
		$data_format = array( '%s' );
		$where = array('p_id' => sanitize_text_field($_REQUEST['id']));
		$data_format1 = array( '%d' );
		$wpdb->update( $wpdb->prefix.$pc->table, $update, $where, $data_format, $data_format1 );
		$pc->add_message('Poll deleted successfully.', 'success');
		wp_redirect($pc->plugin_page);
		exit;
	}
	
	if(isset($_REQUEST['action']) and $_REQUEST['action'] == 'updatePollStatus'){
		if ( ! isset( $_REQUEST['poll_nonce_field'] ) || ! wp_verify_nonce( $_REQUEST['poll_nonce_field'], 'poll_nonce_action') ) {
		echo 'Sorry, your nonce did not verify.';
		exit;
		} 
		
		global $wpdb;
		$pc = new poll_class;
		$update =  array('p_status' => sanitize_text_field($_REQUEST['p_status']));
		$data_format = array( '%s' );
		$where = array('p_id' => sanitize_text_field($_REQUEST['p_id']));
		$data_format1 = array( '%d' );
		$wpdb->update( $wpdb->prefix.$pc->table, $update, $where, $data_format, $data_format1 );
		echo 'Poll status updated successfully.';
		exit;
	}
	
	if(isset($_REQUEST['action']) and $_REQUEST['action'] == 'p_edit'){
		if ( ! isset( $_REQUEST['poll_nonce_field'] ) || ! wp_verify_nonce( $_REQUEST['poll_nonce_field'], 'poll_nonce_action') ) {
		wp_die( 'Sorry, your nonce did not verify.');
		exit;
		} 
		global $wpdb;
		$pc = new poll_class;
		$gc = new general_poll_class;
		
		if($gc->is_poll_started(sanitize_text_field($_REQUEST['p_id']))){
			$pc->add_message(__('Poll is started & cannot be updated now!','wp-easy-poll-afo'), 'error');
			wp_redirect($pc->plugin_page."&action=edit&id=".$_REQUEST['p_id']);
			exit;
		}
		
		$update =  array(
		'p_ques' => sanitize_text_field($_REQUEST['p_ques']), 
		'p_author' => sanitize_text_field($_REQUEST['p_author']), 
		'p_start' => sanitize_text_field($_REQUEST['p_start']), 
		'p_end' => sanitize_text_field($_REQUEST['p_end']), 
		'p_status' => sanitize_text_field($_REQUEST['p_status'])
		);
		$data_format = array( 
		'%s',
		'%s',
		'%s',
		'%s',
		'%s',
		);
		$where = array('p_id' => sanitize_text_field($_REQUEST['p_id']));
		$data_format1 = array( 
		'%d',
		);
		$wpdb->update( $wpdb->prefix.$pc->table, $update, $where, $data_format, $data_format1 );
		
		// remove old answers and add new ones //
		$wpdb->delete( $wpdb->prefix.$pc->table2, $where, $data_format1 );
		$p_anss = $_REQUEST['p_anss'];
		if(is_array($p_anss) and sanitize_text_field($_REQUEST['p_id'])){
			foreach($p_anss as $key => $value){
				if($value != ''){
					$insert1 = array(
					'p_id' => sanitize_text_field($_REQUEST['p_id']), 
					'a_ans' => sanitize_text_field($value), 
					'a_order' => $key+1
					);
					$data_format = array( 
					'%d',
					'%s',
					'%d',
					);
					$wpdb->insert( $wpdb->prefix.$pc->table2, $insert1, $data_format );
				}
			}
		}
		// remove old answers and add new ones //
		
		$pc->add_message(__('Poll updated successfully','wp-easy-poll-afo'), 'success');
		wp_redirect($pc->plugin_page."&action=edit&id=".$_REQUEST['p_id']);
		exit;
	}
	
	if(isset($_REQUEST['action']) and $_REQUEST['action'] == 'p_add'){
		if ( ! isset( $_REQUEST['poll_nonce_field'] ) || ! wp_verify_nonce( $_REQUEST['poll_nonce_field'], 'poll_nonce_action') ) {
		wp_die( 'Sorry, your nonce did not verify.');
		exit;
		} 
		global $wpdb;
		$pc = new poll_class;
		$insert = array(
		'p_ques' => sanitize_text_field($_REQUEST['p_ques']), 
		'p_author' => sanitize_text_field($_REQUEST['p_author']), 
		'p_start' => sanitize_text_field($_REQUEST['p_start']), 
		'p_end' => sanitize_text_field($_REQUEST['p_end']), 
		'p_added' => date("Y-m-d H:i:s"), 
		'p_status' => sanitize_text_field($_REQUEST['p_status'])
		);
		$data_format = array( 
		'%s',
		'%s',
		'%s',
		'%s',
		'%s',
		'%s',
		);
		
		$wpdb->insert( $wpdb->prefix.$pc->table, $insert, $data_format );
		$new_poll_id = $wpdb->insert_id;
		
		$p_anss = $_REQUEST['p_anss'];
		if(is_array($p_anss) and $new_poll_id){
			foreach($p_anss as $key => $value){
				if($value != ''){
					$insert1 = array(
					'p_id' => $new_poll_id, 
					'a_ans' => sanitize_text_field($value), 
					'a_order' => $key+1
					);
					$data_format = array( 
					'%d',
					'%s',
					'%d',
					);
					$wpdb->insert( $wpdb->prefix.$pc->table2, $insert1, $data_format );
				}
			}
		}
		
		$pc->add_message(__('New Poll data added successfully','wp-easy-poll-afo'), 'success');
		wp_redirect($pc->plugin_page."&action=edit&id=".$new_poll_id);
		exit;
	}
	
}
add_action( 'admin_init', 'process_poll_data' );

class poll_wid extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
	 		'poll_wid',
			'Easy Poll Widget',
			array( 'description' => __( 'Widget to display selected poll.', 'lwa' ), )
		);
	 }

	public function widget( $args, $instance ) {
		extract( $args );
		$wid_title = apply_filters( 'widget_title', $instance['wid_title'] );
		echo $args['before_widget'];
		if ( ! empty( $wid_title ) )
			echo $args['before_title'] . $wid_title . $args['after_title'];
			$this->easyPoll($instance);
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['wid_title'] = sanitize_text_field( $new_instance['wid_title'] );
		$instance['poll_id'] = sanitize_text_field( $new_instance['poll_id'] );
		return $instance;
	}

	public function form( $instance ) {
		$wid_title = $instance[ 'wid_title' ];
		$poll_id = $instance[ 'poll_id' ];
		$gc = new general_poll_class;
		?>
		<p><label for="<?php echo $this->get_field_id('wid_title'); ?>"><?php _e('Title:'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('wid_title'); ?>" name="<?php echo $this->get_field_name('wid_title'); ?>" type="text" value="<?php echo $wid_title; ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('poll_id'); ?>"><?php _e('Poll:'); ?> </label>
		<select class="widefat" id="<?php echo $this->get_field_id('poll_id'); ?>" name="<?php echo $this->get_field_name('poll_id'); ?>"><?php echo $gc->get_polls_selected($poll_id);?></select></p>
		<?php 
	}
	
	public function easyPoll($instance = array()){
		global $post;
		$pc = new poll_class;
		$mc = new message_class;
		$gc = new general_poll_class;
		$data = $pc->get_single_row_data($instance['poll_id']);
		$data1 = $pc->get_poll_answers_data($instance['poll_id']);
		$mc->view_message();
		$poll_status = $gc->poll_status_message($instance['poll_id']);
		if($data['p_status'] != 'Active'){
			_e('Poll is Inactive','wp-easy-poll-afo');
			return;
		}
		?>
		<h3><?php echo stripslashes($data['p_ques']);?></h3>
		<div id="poll_<?php echo $instance['poll_id'];?>" class="poll_wrap">
			<?php if($poll_status['status']){ ?>
				<form name="poll" id="poll" method="post" action="">
					<input type="hidden" name="action" value="submit_poll" />
					<?php 
					if(is_array($data1)){
					echo '<ul class="poll_list">';
						foreach($data1 as $key => $value){
							echo '<label><li>';
							echo '<input type="radio" name="poll_ans" value="'.$value['a_id'].'" />';
							echo stripslashes($value['a_ans']);
							echo '</li></label>';
						}
					echo '</ul>';
					}
					?>
					<input type="submit" name="submit" value="Odeslat" />
                    <?php echo $gc->get_vote_result_link($instance['poll_id']);?>
				</form>
				
			<?php } else { ?>
				<p><?php echo $poll_status['msg'];?></p>
			<?php } ?>
		</div>
		<div id="poll_ans_<?php echo $instance['poll_id'];?>" style="display:none;">
			<?php echo $gc->voting_result($instance['poll_id']);?>
			<p><a href="javascript:void(0);" onclick="LoadPollForm('<?php echo $instance['poll_id'];?>')"><?php _e('Zpět','wp-easy-poll-afo');?></a></p>
		</div>
		<?php 
	}
} 

function poll_validate(){
	if(!session_id()){
		session_start();
	}
	
	if( isset($_POST['action']) and $_POST['action'] == "submit_poll"){
		global $wpdb;
		$gc = new general_poll_class;
		$pc = new poll_class;
		$mc = new message_class;
		$a_id = sanitize_text_field($_REQUEST['poll_ans']);
		$p_id = $gc->get_p_id_from_a_id($a_id);
		if($p_id){
			$poll_data = array(
			'p_id' => $p_id, 
			'a_id' => $a_id, 
			'user_id' => get_current_user_id(), 
			'user_ip' => $_SERVER['REMOTE_ADDR'], 
			'v_added' => date("Y-m-d H:i:s") 
			);
			$data_format = array(
			'%d',
			'%d',
			'%d',
			'%s',
			'%s',
			);
			$res = $gc->save_user_vote($poll_data,$data_format);
			$mc->add_message($res['msg'], $res['res']);
			wp_redirect(site_url());
		} else {
			$mc->add_message(__('Poll is empty!','wp-easy-poll-afo'), 'error');
			wp_redirect(site_url());
		}
		exit;
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "poll_wid" );' ) );
add_action( 'init', 'poll_validate' );


class wp_easy_poll_init {
     static function install() {
        global $wpdb;
		$create_table = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."easy_poll_q` (
		  `p_id` int(11) NOT NULL AUTO_INCREMENT,
		  `p_ques` varchar(255) NOT NULL,
		  `p_author` int(11) NOT NULL,
		  `p_start` datetime NOT NULL,
		  `p_end` datetime NOT NULL,
		  `p_added` datetime NOT NULL,
		  `p_status` enum('Active','Inactive','Deleted') NOT NULL,
		  PRIMARY KEY (`p_id`)
		)";
		$wpdb->query($create_table);
		$create_table = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."easy_poll_a` (
		  `a_id` int(11) NOT NULL AUTO_INCREMENT,
		  `p_id` int(11) NOT NULL,
		  `a_ans` varchar(255) NOT NULL,
		  `a_order` int(11) NOT NULL,
		  PRIMARY KEY (`a_id`)
		)";
		$wpdb->query($create_table);
		$create_table = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."easy_poll_votes` (
		  `v_id` int(11) NOT NULL AUTO_INCREMENT,
		  `p_id` int(11) NOT NULL,
		  `a_id` int(11) NOT NULL,
		  `user_id` int(11) NOT NULL,
		  `user_ip` varchar(50) NOT NULL,
		  `v_added` datetime NOT NULL,
		  PRIMARY KEY (`v_id`)
		)";
		$wpdb->query($create_table);
     }
	 static function uninstall() {}
}
register_activation_hook( __FILE__, array( 'wp_easy_poll_init', 'install' ) );
register_deactivation_hook( __FILE__, array( 'wp_easy_poll_init', 'uninstall' ) );