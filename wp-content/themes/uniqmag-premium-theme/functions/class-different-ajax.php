<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Ajax {



	public function __construct() {
		add_action('wp_ajax_different_themes_update_homepage', array( $this, 'update_homepage' ));
		add_action('wp_ajax_different_themes_management_save', array( $this, 'management_save' ));

		add_action('wp_ajax_different_themes_update_sidebar', array( $this, 'update_sidebar'));
		add_action('wp_ajax_different_themes_delete_sidebar', array( $this, 'delete_sidebar'));
		add_action('wp_ajax_different_themes_edit_sidebar', array( $this, 'edit_sidebar'));


		add_action('wp_ajax_different_themes_dynamic_js', array( $this, 'dynamic_js'));
		add_action('wp_ajax_nopriv_different_themes_dynamic_js', array( $this, 'dynamic_js')); 
		add_action('wp_ajax_different_themes_dynamic_css', array( $this, 'dynamic_css'));
		add_action('wp_ajax_nopriv_different_themes_dynamic_css', array( $this, 'dynamic_css')); 


		add_action('wp_ajax_nopriv_different_themes_contact_form', array( $this, 'contact_form'));
		add_action('wp_ajax_different_themes_contact_form', array( $this, 'contact_form'));
	}


	/**
	* Update Homepage Content
	* @return 
	 */
	function update_homepage() {
		$post_id = $_REQUEST['post_id'];
		$layout = $_REQUEST['layout'];
		$values = $_REQUEST['values'];


		$decodedLayout = json_decode(stripslashes(utf8_encode($layout)));
		$values = json_decode(htmlspecialchars_decode(stripslashes($values)));

	//print_r($values);
		
		//grop values for multiple select 
		$gropedValues = array();
		foreach($values as $value) {
			if(isset($gropedValues[$value->name])) {
				if(!is_array($gropedValues[$value->name])) {
					$existingValue = $gropedValues[$value->name];
					$gropedValues[$value->name] = array();
					$gropedValues[$value->name][] = $existingValue;
					$gropedValues[$value->name][] = htmlentities($value->value, ENT_QUOTES | ENT_IGNORE, "UTF-8");
				} else {
					$gropedValues[$value->name][] = htmlentities($value->value, ENT_QUOTES | ENT_IGNORE, "UTF-8");
				}
			} else {
				$gropedValues[$value->name] = htmlentities($value->value, ENT_QUOTES | ENT_IGNORE, "UTF-8");	
			}
			
		}



		if($decodedLayout) {
			//foreach columns
			foreach ($decodedLayout->columnRows as $columRows) {
				//foreach column rows
				foreach ($columRows->columns as $row) {
					if(isset($row->layoutRows)) {
						//foreach layoutRows
						foreach ($row->layoutRows as $layoutRows) {								
							//foreach layoutColumns
							foreach ($layoutRows->layoutColumns as $layoutColumns) {					
								//foreach column row blocks
								foreach ($layoutColumns->contentBlocks as $rowBlock) {
									$blocksContent = array();
									//foreach blocks inputs
									foreach ($rowBlock->blocksContent as $inputs) {
										$blocksContent[$inputs] = $gropedValues[$inputs];
									}
									$rowBlock->blocksContent = $blocksContent;
								}
							}
						}
					} elseif (isset($row->contentBlocks)) {
						//foreach column row blocks
						foreach ($row->contentBlocks as $rowBlock) {
							$blocksContent = array();
							//foreach blocks inputs
							foreach ($rowBlock->blocksContent as $inputs) {

								$blocksContent[$inputs] = $gropedValues[$inputs];
							}
							$rowBlock->blocksContent = $blocksContent;
						}
					}
					if (isset($row->contentBlocksSettings)) {

						$blocksContent = array();
						//foreach blocks inputs
						foreach ($row->contentBlocksSettings as $inputs) {
							$blocksContent[$inputs] = $gropedValues[$inputs];
						}
						$row->contentBlocksSettings = $blocksContent;
					
					}
				}
			}
		}
		//print_r($decodedLayout);
		update_post_meta($post_id, "_".THEME_NAME."_pagebuilder_layout", $decodedLayout);

		die();

	}


	/**
	* Update Management Panel
	* @return Management Panel Content
	*/

	function management_save() {
		$different_themes_managment = Different_Themes()->themes_management;
		$options = $different_themes_managment->get_options();

		$nonsavable_types = array(
			'navigation', 
			'tab',
			'sub_navigation',
			'meta_sub_navigation',
			'sub_tab',
			'meta_sub_tab',
			'homepage_set_test',
			'save',
			'closesubtab',
			'closetab',
			'row',
			'close'
		);



		//insert the default values if the fields are empty
		foreach ($options as $value) {
			if( isset( $value['id'] ) && Different_Themes()->options->get($value['id'])=='' && isset($value['std']) && !in_array($value['type'], $nonsavable_types)){
				Different_Themes()->options->update( $value['id'], $value['std'], true);
			}
		}

		//save the field's values if the Save action is present

		if ( isset( $_REQUEST['action'] ) && 'different_themes_management_save' == $_REQUEST['action'] ) {

			//verify the nonce
			if ( empty($_REQUEST) || !wp_verify_nonce($_REQUEST['different-theme-options'],'different-theme-update-options') ) {
			   esc_html_e('Sorry, your nonce did not verify.','uniqmag');
			   exit;
			}else{
				if(Different_Themes()->options->get('different_themes_first_save')==''){
					Different_Themes()->options->update('different_themes_first_save', 'saved');
				}

				foreach ($options as $value) {
					if(isset($value['id']) && isset($_REQUEST[$value['id']]) && !in_array($value['type'],$nonsavable_types)) {
						Different_Themes()->options->update($value['id'],$_REQUEST[$value['id']]); 
					} elseif(!in_array($value['type'], $nonsavable_types) && isset($value['id'])){
						Different_Themes()->options->delete( $value['id'], true ); 
					}

					if($value['type']=='add_text') {
						$old_val = $_REQUEST[ $value['id'].'s' ];
						$old_val = explode( "|*|", $old_val );
						
						if (!in_array($_REQUEST[ $value['id'] ], $old_val)) {

		
							Different_Themes()->options->update( $value['id'].'s', $_REQUEST[ $value['id'].'s' ].sanitize_title($_REQUEST[ $value['id'] ])."|*|",true ); 
						}
						
					}
				}
				
			}		
		} 
		$options = new Different_Themes_Options();
		//save all data
		update_option('DifferentThemesManagementSettings',$options::$Management_Settings);
		theme_configuration();

		die();
	}   


	/**
	* Orange Themes Sidebar management
	* @return sidebar array
	 */
	function update_sidebar() {
		$sidebars = $_REQUEST['recordsArray'];
		Different_Themes()->options->update( THEME_NAME."_sidebar_names", $sidebars, true);
	}

	function delete_sidebar() {
		$sidebar_name = $_REQUEST['sidebar_name']."|*|";
		$sidebar_names = Different_Themes()->options->get( THEME_NAME."_sidebar_names" );
		$sidebar_names = explode( "|*|", $sidebar_names );
		$sidebar_name = explode( "|*|", $sidebar_name );
		$result = array_diff($sidebar_names, $sidebar_name);
		$last = array_pop($result);
		$update_sidebar = implode ("|*|", $result)."|*|".$last."|*|";
		Different_Themes()->options->update( THEME_NAME."_sidebar_names", $update_sidebar, true);
		print $update_sidebar;
	}

	function edit_sidebar() {
		$new_sidebar_name = sanitize_title($_REQUEST['sidebar_name']);
		$old_name = $_REQUEST['old_name'];

		$sidebar_names = Different_Themes()->options->get( THEME_NAME."_sidebar_names" );
		$sidebar_names = explode( "|*|", $sidebar_names );
		$new_sidebar_names=array();
		foreach ($sidebar_names as $sidebar_name) {
			if($sidebar_name!="") {
				if ($sidebar_name==$old_name) {
					$new_sidebar_names[]=$new_sidebar_name;
				} else {
					$new_sidebar_names[]=$sidebar_name;
				}
			}
		}
		$last = array_pop($new_sidebar_names);
		$update_sidebar = implode ("|*|", $new_sidebar_names)."|*|".$last."|*|";
		
		Different_Themes()->options->update( THEME_NAME."_sidebar_names", $update_sidebar, true);
		print $update_sidebar;
	}


	/**
	* Dynamic load css
	* @return css code
	 */
	function dynamic_css() {
	  	require_once(get_template_directory().'/css/dynamic-css.php');
	  	require_once(get_template_directory().'/css/fonts.php');
	  	die();
	}


	/**
	* Dynamic load js
	* @return js code
	 */
	function dynamic_js() {
	  	require_once(get_template_directory().'/js/scripts.php');
	  	die();
	}




	/**
	* Contact form to send email
	 */
	function contact_form() {

		if(isset($_REQUEST["post_id"])){
			$mail_to = sanitize_email(get_post_meta ($_REQUEST["post_id"],  "_".THEME_NAME."_contact_mail", true )); 
		}

		if(isset($_REQUEST["email"]) && is_email($_REQUEST["email"])){
			$email = sanitize_email($_REQUEST["email"]);
		}
		if(isset($_REQUEST["u_name"])){
			$u_name = esc_textarea($_REQUEST["u_name"]);
		}
		if(isset($cat_color["message"])){
			$message = stripslashes(esc_textarea(htmlspecialchars_decode($_REQUEST["message"])));
		}

		if(isset($_REQUEST["url"])){
			$url = esc_textarea($_REQUEST["url"]);
		}
		
		$ip = $_SERVER['REMOTE_ADDR'];

		
		if(isset($_REQUEST["form_type"])) {	
			
			$subject = ( esc_html__('From','uniqmag'))." ".get_bloginfo('name')." ".( esc_html__('Contact Page','uniqmag'));
					
			$eol="\n";
			$mime_boundary=md5(time());
			$headers = "From: ".$email." <".$email.">".$eol;
			//$headers .= "Reply-To: ".$email."<".$email.">".$eol;
			$headers .= "Message-ID: <".time()."-".$email.">".$eol;
			$headers .= "X-Mailer: PHP v".phpversion().$eol;
			$headers .= 'MIME-Version: 1.0'.$eol;
			$headers .= "Content-Type: text/html; charset=UTF-8; boundary=\"".$mime_boundary."\"".$eol.$eol;

			ob_start(); 
			?>
	<?php  esc_html_e('Message:','uniqmag');?> <?php echo nl2br($message);?>
	<div style="padding-top:100px;">
	<?php esc_html_e('Name:','uniqmag');?> <?php echo esc_html($u_name);?><br/>
	<?php esc_html_e('Url:','uniqmag');?> <?php echo esc_url($url);?><br/>
	<?php esc_html_e('E-mail:','uniqmag');?> <?php echo sanitize_email($email);?><br/>
	<?php esc_html_e('IP Address:','uniqmag');?> <?php echo esc_html($ip);?><br/>
	</div>
	<?php
			$message = ob_get_clean();
			wp_mail($mail_to,$subject,$message,$headers);
				
		}
		 
		die();

	}
}