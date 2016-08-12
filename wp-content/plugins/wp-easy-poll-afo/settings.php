<?php
class poll_settings {

	public function __construct() {
		$this->load_settings();
	}
	
	public function easy_poll_afo_options_save_settings(){
		if(isset($_POST['option']) and $_POST['option'] == "easy_poll_afo_options_save_settings"){
			if ( ! isset( $_POST['easy_poll_afo_options_save_action_field'] ) || ! wp_verify_nonce( $_POST['easy_poll_afo_options_save_action_field'], 'easy_poll_afo_options_save_action' ) ) {
			   wp_die( 'Sorry, your nonce did not verify.');
			} 
			update_option( 'poll_result_after_it_ends', sanitize_text_field($_POST['poll_result_after_it_ends']) );
			$GLOBALS['msg'] = __('Data successfully updated.','wp-easy-poll-afo');
		}
	}
	
	public function help_support(){ ?>
	<table width="98%" border="0" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px 0px;">
	  <tr>
		<td align="right"><a href="http://www.aviplugins.com/support.php" target="_blank">Help and Support</a> <a href="http://www.aviplugins.com/rss/news.xml" target="_blank"><img src="<?php echo  plugin_dir_url( __FILE__ ) . '/images/rss.png';?>" style="vertical-align: middle;" alt="RSS"></a></td>
	  </tr>
	</table>
	<?php
	}
	
	public function donate(){	?>
	<table width="98%" border="0" style="background-color:#FFF; border:1px solid #ccc; margin:2px 0px; padding-right:10px;">
	 <tr>
	 <td align="right"><a href="http://www.aviplugins.com/donate/" target="_blank">Donate</a> <img src="<?php echo  plugin_dir_url( __FILE__ ) . '/images/paypal.png';?>" style="vertical-align: middle;" alt="PayPal"></td>
	  </tr>
	</table>
	<?php
	}
	
	public function  easy_poll_settings_afo_options () {
	global $wpdb;
	$poll_result_after_it_ends = get_option('poll_result_after_it_ends');
	echo '<div class="wrap">';
	$this->view_message();
	$this->wp_easy_poll_pro_add();
	$this->help_support();
	?>
	<form name="f" method="post" action="">
	<input type="hidden" name="option" value="easy_poll_afo_options_save_settings" />
    <?php wp_nonce_field( 'easy_poll_afo_options_save_action', 'easy_poll_afo_options_save_action_field' ); ?>
	<table border="0" style="background:#FFFFFF; border:1px solid #CCCCCC; width:98%; margin:2px 0px; padding:0px 0px 0px 10px;">
	  <tr>
		<td width="30%"><h1><?php _e('Poll Settings','wp-easy-poll-afo');?></h1></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td valign="top"><strong><?php _e('View Poll Result After Poll Ends','wp-easy-poll-afo');?></strong></td>
		<td><input type="checkbox" name="poll_result_after_it_ends" value="Yes" <?php echo $poll_result_after_it_ends == 'Yes'?'checked="checked"':'';?> /><p><?php _e('Check this so that users can view the poll results only after the poll ends.','wp-easy-poll-afo');?></p></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="submit" value="<?php _e('Save','wp-easy-poll-afo');?>" class="button button-primary button-large" /></td>
	  </tr>
      <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	</form>
	<?php 
	$this->donate();
	echo '</div>';
	}
	
	public function wp_easy_poll_pro_add(){ ?>
	<table border="0" style="width:98%;background-color:#FFFFD2; border:1px solid #E6DB55; padding:0px 0px 0px 10px; margin:2px 0px;">
  <tr>
    <td><p>The <strong>PRO</strong> version of this plugin has additional features. <strong>1)</strong> Export/ Email voting results to your users. <strong>2)</strong> Let users create polls from front end. <strong>3)</strong> Choose color for the voting result bar as per your liking. Get it <a href="http://aviplugins.com/wp-easy-poll-pro/" target="_blank">here</a> in <strong>USD 2.00</strong> </p></td>
  </tr>
</table>
	<?php 
	}
		
	public function view_message(){
		if($GLOBALS['msg']){
			echo '<div class="admin-success">'.$GLOBALS['msg'].'</div>';
			$GLOBALS['msg'] = '';
		}
	}
	
	public function easy_poll_scripts() {
		wp_enqueue_script( 'jquery' );	  
		wp_enqueue_script( 'jquery-ui-timepicker-addon', plugins_url('jquery-ui-timepicker-addon.js', __FILE__), array('jquery-ui-core' ,'jquery-ui-datepicker', 'jquery-ui-slider') );
		wp_enqueue_script( 'easy-poll-js', plugins_url('easy-poll-js.js', __FILE__));
		wp_enqueue_style( 'jquery-ui', plugins_url('jquery-ui.css', __FILE__) );
		wp_enqueue_style( 'style_easy_poll', plugins_url('style_easy_poll.css', __FILE__) );
	}

	public function wp_easy_poll_text_domain(){
		load_plugin_textdomain('wp-easy-poll-afo', FALSE, basename( dirname( __FILE__ ) ) .'/languages');
	}
	
	public function easy_polls_afo_options(){
		$pc = new poll_class();
		$pc->display_list();
	}
	
	public function easy_poll_afo_menu () {
		add_options_page( 'Easy Poll', 'Easy Poll Settings', 'activate_plugins', 'easy_poll_afo', array( $this,'easy_poll_settings_afo_options' ));
		add_menu_page( 'Polls', 'Polls', 'activate_plugins', 'easy_polls', array( $this,'easy_polls_afo_options' ) );	
	}
	
	public function load_settings(){
		add_action( 'admin_menu' , array( $this, 'easy_poll_afo_menu' ) );
		add_action( 'admin_init', array( $this, 'easy_poll_afo_options_save_settings' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'easy_poll_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'easy_poll_scripts' ) );
		add_action( 'plugins_loaded',  array( $this, 'wp_easy_poll_text_domain' ) );
	}

}
new poll_settings;