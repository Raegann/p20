<?php

class Simple_Slider_Admin extends Simple_Slider {
	/**
	 * Error messages to diplay
	 *
	 * @var array
	 */
	private $_messages = array();
	
	
	/**
	 * Class constructor
	 *
	 */
	public function __construct() {
		
		defined('DIRECTORY_SEPARATOR') or define('DIRECTORY_SEPARATOR', '/');
		
		
		$this->_plugin_dir   = DIRECTORY_SEPARATOR . str_replace(basename(__FILE__), null, plugin_basename(__FILE__));
		$this->_settings_url = 'options-general.php?page=' . plugin_basename(__FILE__);
		
		$allowed_options = array(
			
		);
		
		// set watermark options
		if(array_key_exists('option_name', $_GET) && array_key_exists('option_value', $_GET)
			&& in_array($_GET['option_name'], $allowed_options)) {
			update_option($_GET['option_name'], $_GET['option_value']);
			
			header("Location: " . $this->_settings_url);
			die();	
			
		} else {
			// register installer function
			register_activation_hook(SS_LOADER, array(&$this, 'activate_simple_slider'));
		
			// add plugin "Settings" action on plugin list
			add_action('plugin_action_links_' . plugin_basename(SS_LOADER), array(&$this, 'add_plugin_actions'));
			
			// add links for plugin help, donations,...
			add_filter('plugin_row_meta', array(&$this, 'add_plugin_links'), 10, 2);
			
			// push options page link, when generating admin menu
			add_action('admin_menu', array(&$this, 'admin_menu'));
	
			//add help menu
			add_filter('contextual_help', array(&$this,'admin_help'), 10, 3);

		}
		
		add_action( 'wp_enqueue_scripts', array(&$this, 'loadScripts'));

	}
	
	/**
	 * Add "Settings" action on installed plugin list
	 */
	public function add_plugin_actions($links) {
		array_unshift($links, '<a href="options-general.php?page=' . plugin_basename(__FILE__) . '">' . __('Settings') . '</a>');
		
		return $links;
	}
	
	/**
	 * Add links on installed plugin list
	 */
	public function add_plugin_links($links, $file) {
		if($file == plugin_basename(SS_LOADER)) {
			$upgrade_url = 'http://mywebsiteadvisor.com/tools/wordpress-plugins/simple-slider/';
			$links[] = '<a href="'.$upgrade_url.'" target="_blank" title="Click Here to Upgrade this Plugin!">Upgrade Plugin</a>';

			$rate_url = 'http://wordpress.org/support/view/plugin-reviews/' . basename(dirname(__FILE__)) . '?rate=5#postform';
			$links[] = '<a href="'.$rate_url.'" target="_blank" title="Click Here to Rate and Review this Plugin on WordPress.org">Rate This Plugin</a>';
		}
		
		return $links;
	}
	
	/**
	 * Add menu entry for Simple Slider settings 
	 */
	public function admin_menu() {		
		// add option in admin menu,
		global $simple_slider_admin_page;
		$simple_slider_admin_page = add_options_page('Simple Slider Plugin Options', 'Simple Slider', 8, __FILE__, array(&$this, 'optionsPage'));

		add_action('admin_print_styles-' . $simple_slider_admin_page, array(&$this, 'installStyles'));
		add_action('admin_print_scripts-' . $simple_slider_admin_page, array(&$this, 'loadScripts'));
	}
	
	
	
	public function admin_help($contextual_help, $screen_id, $screen){
	
		global $simple_slider_admin_page;
		
		if ($screen_id == $simple_slider_admin_page) {
			
			$support_the_dev = $this->display_support_us();
			$screen->add_help_tab(array(
				'id' => 'developer-support',
				'title' => "Support the Developer",
				'content' => "<h2>Support the Developer</h2><p>".$support_the_dev."</p>"
			));
			
			
			$screen->add_help_tab(array(
				'id' => 'plugin-support',
				'title' => "Plugin Support",
				'content' => "<h2>Support</h2><p>For Plugin Support please visit <a href='http://mywebsiteadvisor.com/support/' target='_blank'>MyWebsiteAdvisor.com</a></p>"
			));
			
			$screen->add_help_tab(array(
				'id' => 'plugin-upgrades',
				'title' => "Plugin Upgrades",
				'content' => "<h2>Plugin Upgrades</h2><p>We also offer a premium version of this pluign with extended features!<br>You can learn more about it here: <a href='http://mywebsiteadvisor.com/tools/wordpress-plugins/simple-slider/' target='_blank'>MyWebsiteAdvisor.com</a></p><p>Learn about all of our free plugins for WordPress here: <a href='http://mywebsiteadvisor.com/tools/wordpress-plugins/' target='_blank'>MyWebsiteAdvisor.com</a></p>"
			));
	
			$screen->set_help_sidebar("<p>Please Visit us online for more Free WordPress Plugins!</p><p><a href='http://mywebsiteadvisor.com/tools/wordpress-plugins/' target='_blank'>MyWebsiteAdvisor.com</a></p><br>");
			
		}
			
		

	}
	
	
	
	
	public function display_support_us(){
				
		$string = '<p><b>Thank You for using the Bulk Watermark Plugin for WordPress!</b></p>';
		$string .= "<p>Please take a moment to <b>Support the Developer</b> by doing some of the following items:</p>";
		
		$rate_url = 'http://wordpress.org/support/view/plugin-reviews/' . basename(dirname(__FILE__)) . '?rate=5#postform';
		$string .= "<li><a href='$rate_url' target='_blank' title='Click Here to Rate and Review this Plugin on WordPress.org'>Click Here</a> to Rate and Review this Plugin on WordPress.org!</li>";
		
		$string .= "<li><a href='http://facebook.com/MyWebsiteAdvisor' target='_blank' title='Click Here to Follow us on Facebook'>Click Here</a> to Follow MyWebsiteAdvisor on Facebook!</li>";
		$string .= "<li><a href='http://twitter.com/MWebsiteAdvisor' target='_blank' title='Click Here to Follow us on Twitter'>Click Here</a> to Follow MyWebsiteAdvisor on Twitter!</li>";
		$string .= "<li><a href='http://mywebsiteadvisor.com/tools/premium-wordpress-plugins/' target='_blank' title='Click Here to Purchase one of our Premium WordPress Plugins'>Click Here</a> to Purchase Premium WordPress Plugins!</li>";
	
		return $string;
	}





	/**
	 * Include styles used by Plugin
	 */
	public function installStyles() {
		//wp_enqueue_style('simple-slider', WP_PLUGIN_URL . $this->_plugin_dir . 'style.css');
	}
	

	public function loadScripts(){
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('j-cycle', WP_PLUGIN_URL . $this->_plugin_dir . 'js/jquery.cycle.all.js', array('jquery'), '', false);
		wp_enqueue_script('j-easing', WP_PLUGIN_URL . $this->_plugin_dir . 'js/jquery.easing.1.3.js', array('jquery'), '', false);
		wp_enqueue_script('cufon-yui', WP_PLUGIN_URL . $this->_plugin_dir . 'cufon/cufon-yui.js', '', '', false);
    	wp_enqueue_script('cufon-font', WP_PLUGIN_URL . $this->_plugin_dir . 'cufon/fonts/impact_400.font.js', '', '', false);
			
	}


	function HtmlPrintBoxHeader($id, $title, $right = false) {
		
		?>
		<div id="<?php echo $id; ?>" class="postbox">
			<h3 class="hndle"><span><?php echo $title ?></span></h3>
			<div class="inside">
		<?php
		
		
	}
	
	function HtmlPrintBoxFooter( $right = false) {
		?>
			</div>
		</div>
		<?php
		
	}
	

	
	public function build_slider(){
	
		$simple_slider = get_option('simple_slider');
		$ss_config = $simple_slider['slideshow_config'];
		$ss_options = $simple_slider['plugin_config'];
		
		$output = "<script>
	
				jQuery(document).ready(function($) {
				
					Cufon.replace('#slider_holder h2, #slider_holder #aio-nav');
				
					jQuery('#slider_holder ul').cycle({ 
						fx: '" . $ss_options['slider_effect']. "',
						timeout: ". $ss_options['slider_timeout'] * 1000 .",
						speed: ".  $ss_options['slider_speed'] * 1000 .",
						pause: 1,
						fit: 1,
						next:   '#next',
						prev:   '#prev',
						pager:  '#aio-nav'
					});
				
    
					jQuery('#slider_holder').hover(function() { 
						//mouse in	
						jQuery('#slider_holder #prevnext').fadeIn('slow');             
					}, function() { 
						//mouse out
						jQuery('#slider_holder #prevnext').fadeOut('slow');	
					});
					
				});
				
				</script>";
				
				
		$output .= "<style type='text/css' media='screen'>
		.entry-content img, .comment-content img, .widget img{
			max-width:100% !important;
		}";	
		
		/*slider*/
		$output .= "
			#slider_holder {
				position: relative;
				width: ".$ss_options['width']."px;
				height: ".$ss_options['height']."px;
				margin: 0; padding: 0;
				overflow: hidden;
			}
			
			#slider_holder ul {	
				margin: 0 !important; padding: 0 !important;		
			}
			
			#slider_holder ul li {
				position: relative;
				width: ".$ss_options['width']."px;
				height: ".$ss_options['height']."px;
				margin: 0; padding: 0;
				overflow: hidden;
			}
			
			#slider_holder ul li .text-bg {
				position: absolute;
				min-width: 80%;
				min-height: 20px;
				left: 0;
				bottom: 5%;
				padding: 5px 10px 5px 10px;
				text-align: left;
				background: #ffffff;
				opacity: 0.7;
			}
			
			#slider_holder ul li .text-bg h2 {
				position: relative;        
				margin: 0 0 0 0px;        
				font-size: 24px;
				line-height: 1;
				color: #000;
				opacity: 1.0 !important;
			}  
			
			#slider_holder ul li .text-bg h2:hover {
				
				color: #ff0000;
				
			}    
			
			#slider_holder ul li .text-bg h2 .cufon.cufon-canvas cufontext {
			   opacity: 1.0 !important;
			}";
			
	
		/*previous/next*/
		$output .= " 
	   #slider_holder #prevnext {
			position: absolute;
			width: ".$ss_options['width']."px;
			height: 48px;
			top: ".($ss_options['height']/2-24)."px;
			text-indent: -9999px;
			left: 0px;
			z-index: 9999999;  
		}
		
		#slider_holder #prevnext.hidden {
			z-index: -999999;
			opacity: 1 !important;
		}
		
		#slider_holder #prevnext a { position: absolute; display: block; width: 38px; height: 48px; outline: none; border: none;  }
	
		#slider_holder #prevnext a#prev { left: 0px; background: url(". WP_CONTENT_URL ."/uploads/2016/08/left.png) no-repeat; }
		
		#slider_holder #prevnext a#next { right: 0px; background: url(". WP_CONTENT_URL ."/uploads/2016/08/right.png) no-repeat; }";
				
		$output .= "</style>";		
				
		
		$nl = "\n"; 
		
		$output .= '<div id="slider_holder">'.$nl;
		
		$output .= '<ul>'.$nl;
		
		foreach($ss_config as $data) {
			if(isset($data['img_url']) && $data['img_url'] !== ''){
				$output .= '<li>';
			   
				if(isset($data['link_url'])){
					$output .= '<a href="'.htmlentities($data['link_url']).'">';
				}
				
				
				$img_url = $data['img_url'];
				
				if("" != $data['img_size'] && "Full Size" != $data['img_size']){
					global $wpdb;
					$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='".$data['img_url']."'";
					$attachment_id = $wpdb->get_var($query);
					$attachment_info = wp_get_attachment_metadata($attachment_id);
					$size = $data['img_size'];
					
					
					$img_url = dirname($data['img_url'])."/".$attachment_info['sizes'][$size]['file'];
				}
				
				
				$id = isset($data['id']) ? $data['id'] : "";
				$output .= '<img src="'.htmlentities($img_url).'" width="'. htmlentities($ss_options['width']) .'" height="'. htmlentities($ss_options['height']) .'"  class="'.$id.'" alt="'.html_entity_decode($data['img_title']).'" title="'.html_entity_decode($data['img_title']).'"  />';
				
				if( isset($data['img_text']) && $data['img_text'] != ''  ){
					$output .= '<div class="text-bg">';
					$output .= '<h2>';        
					$output .= html_entity_decode($data['img_text']);    
					$output .= '</h2>';
					$output .= '</div>';
				}
				
				if(isset($data['link_url']))
					$output .= '</a>';
				
				$output .= '</li>';
				
				$output .= $nl;
			}
		}
		
		$output .= '</ul>'.$nl;
		$output .= '<div id="prevnext"><a id="prev" href="#prevslide">Prev</a> <a id="next" href="#nextslide">Next</a></div>';
		$output .= '</div>'.$nl;  
		
		return $output;  
	}
	
	


	
	/**
	 * Display options page
	 */
	public function optionsPage() {
		// if user clicked "Save Changes" save them
		if(isset($_POST['Submit'])) {
		
			if(is_admin()){
		
				if($_POST['simple_slider']['plugin_config']){
					$_POST['simple_slider']['plugin_config']['width'] = filter_var($_POST['simple_slider']['plugin_config']['width'], FILTER_SANITIZE_NUMBER_INT);
					$_POST['simple_slider']['plugin_config']['height'] = filter_var($_POST['simple_slider']['plugin_config']['height'], FILTER_SANITIZE_NUMBER_INT);
					$_POST['simple_slider']['plugin_config']['slider_speed'] = filter_var($_POST['simple_slider']['plugin_config']['slider_speed'], FILTER_SANITIZE_NUMBER_INT);
					$_POST['simple_slider']['plugin_config']['slider_timeout'] = filter_var($_POST['simple_slider']['plugin_config']['slider_timeout'], FILTER_SANITIZE_NUMBER_INT);
				}
					
			
				$i = 0;
				
				foreach($_POST['simple_slider']['slideshow_config'] as  $id => $slide){
					
						
					if(isset($slide['img_title']))
						$_POST['simple_slider']['slideshow_config'][$i]['img_title'] = htmlentities($slide['img_title']);
					
					if(isset($slide['img_text']))
						$_POST['simple_slider']['slideshow_config'][$i]['img_text'] = htmlentities($slide['img_text']);
					
					
					if(isset($slide['img_url'])){
						if(!filter_var($slide['img_url'], FILTER_VALIDATE_URL)) {
							unset($_POST['simple_slider']['slideshow_config'][$i]);
							
							if($slide['img_url'] != ''){
								$this->_messages['error'][] = htmlentities($slide['img_url']). " is not a valid Image URL";
							}
						}else{
							$_POST['simple_slider']['slideshow_config'][$i]['img_url'] = htmlentities($slide['img_url']);
						}
					}
					
					
					if(isset($slide['link_url'])){
						if(!filter_var($slide['link_url'], FILTER_VALIDATE_URL)) {
							unset($_POST['simple_slider']['slideshow_config'][$i]['link_url']);
							
							if($slide['link_url'] != ''){
								$this->_messages['error'][] = htmlentities($slide['link_url']). " is not a valid Link URL";
							}
						}else{
							$_POST['simple_slider']['slideshow_config'][$i]['link_url'] = htmlentities($slide['link_url']);
						}
					}
					
					
					if (isset($_POST['simple_slider']['slideshow_config'][$i])){
						if( count($_POST['simple_slider']['slideshow_config'][$i]) == 0){
							unset($_POST['simple_slider']['slideshow_config'][$i]);
						}
					}
				
				
					if($slide['img_url'] == '')
						unset($_POST['simple_slider']['slideshow_config'][$i]);
						
					
					$i++;
				}
			
				ksort($_POST['simple_slider']['slideshow_config']);
				
				foreach($this->_options as $option => $value) {
			
					if(array_key_exists($option, $_POST)) {
						update_option($option, $_POST[$option]);
					} else {
						update_option($option, $value);
					}
				}
				
	
				$this->_messages['updated'][] = 'Options updated!';
			}
		}


		
		
	
		foreach($this->_messages as $namespace => $messages) {
			foreach($messages as $message) {
?>
<div class="<?php echo $namespace; ?>">
	<p>
		<strong><?php echo $message; ?></strong>
	</p>
</div>
<?php
			}
		}
		
		
			
?>


	
									  
<script type="text/javascript">var wpurl = "<?php bloginfo('wpurl'); ?>";</script>

<style>

.fb_edge_widget_with_comment {
	position: absolute;
	top: 0px;
	right: 200px;
}

</style>

<div  style="height:20px; vertical-align:top; width:50%; float:right; text-align:right; margin-top:5px; padding-right:16px; position:relative;">

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=253053091425708";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<div class="fb-like" data-href="http://www.facebook.com/MyWebsiteAdvisor" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false"></div>
	
	
	<a href="https://twitter.com/MWebsiteAdvisor" class="twitter-follow-button" data-show-count="false"  >Follow @MWebsiteAdvisor</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


</div>

<div class="wrap" id="sm_div">

	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>Simple Slider Plugin Settings</h2>
	
		
		
	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<div class="inner-sidebar">
			<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">
			
<?php $this->HtmlPrintBoxHeader('pl_diag',__('Plugin Diagnostic Check','diagnostic'),true); ?>

				<?php
				
				echo "<p>Server OS: ".PHP_OS."</p>";
				
				echo "<p>Required PHP Version: 5.0+<br>";
				echo "Current PHP Version: " . phpversion() . "</p>";
			
				echo "<p>Memory Use: " . number_format(memory_get_usage()/1024/1024, 1) . " / " . ini_get('memory_limit') . "</p>";
				
				echo "<p>Peak Memory Use: " . number_format(memory_get_peak_usage()/1024/1024, 1) . " / " . ini_get('memory_limit') . "</p>";
				
				if ( function_exists('sys_getloadavg') ){
					$lav = sys_getloadavg();
					echo "<p>Server Load Average: ".$lav[0].", ".$lav[1].", ".$lav[2]."</p>";
				}
				?>

<?php $this->HtmlPrintBoxFooter(true); ?>



<?php $this->HtmlPrintBoxHeader('pl_resources',__('Plugin Resources','resources'),true); ?>

	<p><a href='http://mywebsiteadvisor.com/tools/wordpress-plugins/simple-slider/' target='_blank'>Plugin Homepage</a></p>
	<p><a href='http://mywebsiteadvisor.com/support/'  target='_blank'>Plugin Support</a></p>
	<p><a href='http://mywebsiteadvisor.com/contact-us/'  target='_blank'>Contact Us</a></p>
	<p><a href='http://wordpress.org/support/view/plugin-reviews/simple-slider?rate=5#postform'  target='_blank'>Rate and Review This Plugin</a></p>
	
	
<?php $this->HtmlPrintBoxFooter(true); ?>


<?php $this->HtmlPrintBoxHeader('pl_upgrade',__('Plugin Upgrades','upgrade'),true); ?>
	
	<p>
	<a href='http://mywebsiteadvisor.com/products-page/premium-wordpress-plugin/simple-slider-ultra/'  target='_blank'>Upgrade to Simple Slider Ultra!</a><br />
	<br />
	<b>Features:</b><br />
	-Unlimited Number of Slideshows!<br />
	-Enhanced Shortcode to Display Plugin!<br />
	-And Much More!<br />
	</p>
	
<?php $this->HtmlPrintBoxFooter(true); ?>



<?php $this->HtmlPrintBoxHeader('more_plugins',__('More Plugins','more_plugins'),true); ?>
	
	<p><a href='http://mywebsiteadvisor.com/tools/premium-wordpress-plugins/'  target='_blank'>Premium WordPress Plugins!</a></p>
	<p><a href='http://profiles.wordpress.org/MyWebsiteAdvisor/'  target='_blank'>Free Plugins on Wordpress.org!</a></p>
	<p><a href='http://mywebsiteadvisor.com/tools/wordpress-plugins/'  target='_blank'>Free Plugins on MyWebsiteAdvisor.com!</a></p>	
				
<?php $this->HtmlPrintBoxFooter(true); ?>


<?php $this->HtmlPrintBoxHeader('follow',__('Follow MyWebsiteAdvisor','follow'),true); ?>

	<p><a href='http://facebook.com/MyWebsiteAdvisor/'  target='_blank'>Follow us on Facebook!</a></p>
	<p><a href='http://twitter.com/MWebsiteAdvisor/'  target='_blank'>Follow us on Twitter!</a></p>
	<p><a href='http://www.youtube.com/mywebsiteadvisor'  target='_blank'>Watch us on YouTube!</a></p>
	<p><a href='http://MyWebsiteAdvisor.com/'  target='_blank'>Visit our Website!</a></p>	
	
<?php $this->HtmlPrintBoxFooter(true); ?>


</div>
</div>



	<div class="has-sidebar sm-padded" >			
		<div id="post-body-content" class="has-sidebar-content">
			<div class="meta-box-sortabless">
	
			
	
			<form method='post'>
	
			<?php $this->HtmlPrintBoxHeader('config',__('Simple Slider Plugin Configuration','slider-config'),false); ?>	
			
				<table width="100%">
				<tr valign="top">
				<td>
			
			<?php $this->HtmlPrintBoxHeader('config',__('Plugin Configuration','slider-config'),false); ?>	
				<?php 
					$simple_slider = $this->get_option('simple_slider'); 
					$ss_config = $simple_slider['slideshow_config'];
					$ss_options = $simple_slider['plugin_config'];
					
					$fx_list = array(
						'blindX',
						'blindY',
						'blindZ',
						'cover',
						'curtainX',
						'curtainY',
						'fade',
						'fadeZoom',
						'growX',
						'growY',
						'scrollUp',
						'scrollDown',
						'scrollLeft',
						'scrollRight',
						'scrollHorz',
						'scrollVert',
						'shuffle',
						'slideX',
						'slideY',
						'toss',
						'turnUp',
						'turnDown',
						'turnLeft',
						'turnRight',
						'uncover',
						'wipe',
						'zoom'
					);
					
				?>
			
				
					
					Slideshow Width: <input  type='text' name='simple_slider[plugin_config][width]'  value='<?php echo $ss_options['width']; ?>' size="5" /> (px)<br />
					
					Slideshow Height: <input type='text' name='simple_slider[plugin_config][height]' value='<?php echo $ss_options['height']; ?>' size="5" /> (px)<br />

					Slideshow Timeout: <input  type='text' name='simple_slider[plugin_config][slider_timeout]'  value='<?php echo $ss_options['slider_timeout']; ?>' size="5" /> (sec)<br />
					
					Slideshow Speed: <input type='text' name='simple_slider[plugin_config][slider_speed]' value='<?php echo $ss_options['slider_speed']; ?>' size="5" /> (sec)<br />
					
					Slideshow Effect: 
					
					<select name = 'simple_slider[plugin_config][slider_effect]'>
						<option value=''>Select An Effect...</option>
						<?php
						foreach($fx_list as $fx){
						
							$selected = ($fx == $ss_options['slider_effect']) ? "selected='selected'" : "";
							echo "<option value='$fx' $selected>$fx</option>";
						
						}
						?>
						
					</select>
					
					<br />
					
					<input type="submit" name='Submit' value='Save Settings' />
				
			<?php $this->HtmlPrintBoxFooter(false); ?>
			
			</td><td>
			
				<?php $this->HtmlPrintBoxHeader('config',__('Plugin Use','slider-config'),false); ?>	
				
				<b>Front End Plugin Useage:</b><br />
				
				<p>Plugin Shortcode: (use this on a post or page) <br />
				<pre>[simple_slider]</pre></p>
				
				<p>Template Tag: (use this in a template)<br />
				<pre>&lt;?php echo do_shortcode('[simple_slider]'); ?></pre></p>
				
				
				<?php $this->HtmlPrintBoxFooter(false); ?>
				
			</td>
			</tr>
			</table>
				
			<?php $this->HtmlPrintBoxFooter(false); ?>
			
			
			
	
	
			<?php $this->HtmlPrintBoxHeader('config',__('Slideshow Configuration','slider-config'),false); ?>	
			
					<p><b>Add A Slide to the Slideshow</b></p>
					New Image URL: <input type='text' size='100' name='simple_slider[slideshow_config][0][img_url]' /><br />
		
					<input type="submit" name='Submit' value='Save Settings' />
					
		
					<?php
						
						$i = 1;
						
						global $wpdb;
						
						if(count($ss_config) > 0){
						
							echo "<p><b>Drag and Drop Slides to change the order of the slideshow! (Don't forget to save!) </b> </p>";
							echo "<br />";
							echo "<div id='slider-items-box' class='slider-items-box'>";
							foreach($ss_config as $slider){
								
								if($slider['img_url'] != ""){
									$this->HtmlPrintBoxHeader('config',__("Slide #".($i).": ".html_entity_decode($slider['img_title']),'slider-config'),false);
									echo "<div class='slider-item' style='cursor:move;'>";
									
									
									$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='".$slider['img_url']."'";
									$attachment_id = $wpdb->get_var($query);
									$attachment_info =  wp_get_attachment_metadata($attachment_id);
									
									$url_info = parse_url($slider['img_url']);
										
									$path_base = pathinfo($url_info['path']);
										
									$file = $url_info['scheme']."://".$url_info['host'].$path_base['dirname']."/".$attachment_info['sizes']['thumbnail']['file'];
									echo "<img src='$file' style='float:right;'>";
									
									
									if($attachment_info){
										echo "<p>Image URL: <input size='100' type='text' name='simple_slider[slideshow_config][$i][img_url]' value='".htmlentities($slider['img_url'])."'></p>";
										
										$selected = ($slider['img_size'] == "Full Size") ? "selected='selected'" : "";
										echo "<p>Image Size: <select name='simple_slider[slideshow_config][$i][img_size]' value='".$slider['img_size']."'  $selected>";
										
										echo "<option value='Full Size'>Full Size (".$attachment_info['width']."x".$attachment_info['height'].")</option>";
											
										foreach($attachment_info['sizes'] as $size => $details){
											//$file = $url_info['scheme']."://".$url_info['host'].$path_base['dirname']."/".$details['file'];
											$selected = ($size == $slider['img_size']) ? "selected='selected'" : "";
											echo "<option value='$size' $selected>".ucfirst($size)." (".$details['width']."x".$details['height'].")</option>";
										}
										
										echo "</select>";
										
										echo "</p>";
										
									}else{
										echo "<p>Image URL: <input size='100' type='text' name='simple_slider[slideshow_config][$i][img_url]' value='".htmlentities($slider['img_url'])."'></p>";
									}
									
									
									$title = isset($slider['img_title']) ? html_entity_decode($slider['img_title']) : "";
									$text = isset($slider['img_text']) ? html_entity_decode($slider['img_text']) : "";
									$url = isset($slider['link_url']) ? html_entity_decode($slider['link_url']) : "";
									
									echo "<p>Title: <input size='40' type='text' name='simple_slider[slideshow_config][$i][img_title]' value='".$title."'> ";
									echo " Text: <input size='40' type='text' name='simple_slider[slideshow_config][$i][img_text]' value='".$text."'></p>";
									echo "<p>Link URL: <input size='100' type='text' name='simple_slider[slideshow_config][$i][link_url]' value='".$url."'></p>";
									echo "<br>";
									
									echo "</div>";
									$this->HtmlPrintBoxFooter(false);
									$i++;
								}		
							}
							echo "</div>";
							echo "<br>";
							echo "<input type='submit' name='Submit' value='Save Settings' /><br />";
							
							
														

						}else{
							echo "<p>No Sliders Defined!</p>";
						}	
								
						//echo "<pre>";
						//print_r($ss_config);
						//echo "</pre>";
					
					?>

				
				
				
			
			
				<script>
				jQuery(document).ready(function($) {
  
  					$('#slider-items-box').sortable({
						
					});
  
  				});
				</script>
				
				
			<?php $this->HtmlPrintBoxFooter(false); ?>
			
			
			</form>
			
			
			<?php if(count($ss_config) > 0){ ?>
				
				<?php $this->HtmlPrintBoxHeader('preview',__('Simple Slider Preview','slider-preview'),false); ?>	
				
					<?php echo $this->build_slider(); ?>
		
				<?php $this->HtmlPrintBoxFooter(false); ?>
			
			<?php } ?>
		
		
</div></div></div></div>

</div>


<?php
	}
	
}

?>