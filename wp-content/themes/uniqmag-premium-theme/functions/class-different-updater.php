<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Updater {

    public $user_name;

    public $api_key;

    public $purchase_key;

    public $cache_interval = 21600; //21600 default

    public $errors = array( 'errors' => '' );

    //existing theme data
    public $theme_version;
    public $theme_author;
    public $theme_name;
    //new theme data
    public $new_theme_name;
    public $new_theme_author;
    public $new_theme_version;




    public function __construct( $user_name = '', $api_key = '' , $purchase_key = '' ) {
		// Add an update notification to the WordPress Dashboard menu
		add_action('admin_menu', array( $this, 'update_notifier_menu' ));  
		// Adds an update notification to the Admin Bar
		add_action( 'admin_bar_menu', array( $this, 'update_notifier_bar_menu' ), 1000 );
		// add error notices in wp admin
		add_action( 'admin_notices', array( $this, 'error_notice' ) ); 





      	if ( $user_name == '' ) {
        	$this->set_error( 'user_name', esc_html__('Please enter your Envato Marketplace Username.','uniqmag') );
      	}
        
      	if ( $api_key == '' ) {
        	$this->set_error( 'api_key', esc_html__('Please enter your Envato Marketplace API Key.','uniqmag') );
      	}        
      	if ( $purchase_key == '' ) {
        	$this->set_error( 'purchase_key', esc_html__('Please enter your purchase key.','uniqmag') );
      	}
        
      	$this->user_name  = $user_name;
      	$this->api_key    = $api_key;
      	$this->purchase_key    = $purchase_key;

      	// Read theme current version from the style.css 

        $theme_data = wp_get_theme(THEME_NAME . '-premium-theme' );
      	$this->theme_version = wp_strip_all_tags($theme_data->version);
      	$this->theme_author = wp_strip_all_tags($theme_data->author);
      	$this->theme_name = wp_strip_all_tags($theme_data->name);
      	$this->stylesheet = wp_strip_all_tags($theme_data->stylesheet);

      	//Read new theme data from envato and store it in the cache
      	$this->private_user_data( $this->purchase_key, $this->user_name );


	}

    /**
     * Add update section in wp-admin menu
     */
	function update_notifier_menu() {  

		if( $this->theme_author === $this->new_theme_author ) {
			if( version_compare($this->new_theme_version, $this->theme_version, '>') ) { // Compare current theme version with the remote envato version
				add_theme_page( $this->theme_name.' '.esc_html__("Theme Updates",'uniqmag') , $this->theme_name.' '.esc_html__("1 Update",'uniqmag'), 'administrator', 'theme-update-notifier', array( $this, 'update_notifier' ));
			}
		}
		
	}

    /**
     * Add update notification in admin bar
     */
	function update_notifier_bar_menu() {
		global $wp_admin_bar;
	
		if ( !is_super_admin() || !is_admin_bar_showing() ) // Don't display notification in admin bar if it's disabled or the current user isn't an administrator
		return;
		

		if( $this->theme_author === $this->new_theme_author ) {
			if( version_compare($this->new_theme_version, $this->theme_version, '>') ) { // Compare current theme version with the remote envato version
				$wp_admin_bar->add_menu( array( 'id' => 'update_notifier', 'title' => '<span>' . $this->theme_name . ' <span id="ab-updates">'.esc_html__("1 Update",'uniqmag').'</span></span>', 'href' => esc_url(get_admin_url()) . 'index.php?page=theme-update-notifier' ) );
			}
		}
	}


	function update_notifier() { 
		if ( ! current_user_can( 'manage_options' ) )
        	wp_die( esc_html__('You do not have sufficient permissions to access this page.','uniqmag') );

  
      	$user_name = ( isset( $this->user_name ) ) ? $this->user_name : '';
      	$api_key = ( isset( $this->api_key ) ) ? $this->api_key : '';
      	$purchase_key = ( isset( $this->purchase_key ) ) ? $this->purchase_key : '';


		if ( $user_name == '' ) {
			$this->set_error( 'user_name', esc_html__('Please enter your Envato Marketplace Username.','uniqmag') );
		}


      	//create update link
		$update_url = wp_nonce_url( network_admin_url( 'index.php?page=theme-update-notifier&action=upgrade-theme&amp;theme=' . $this->stylesheet), 'upgrade-theme_' . $this->stylesheet, 'ot-nonce' );
		$update_onclick = ' onclick="if ( confirm(\'' . esc_js( esc_html__("Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.",'uniqmag') ) . '\') ) {return true;}return false;"';


		if(!isset($_GET['action'])) {

			echo '<style>';
			echo '.update-nag { display: none; }';
			echo '#instructions {max-width: 670px;}';
			echo 'h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}';
			echo '</style>';

			echo '<div class="wrap">';
			
			echo '	<div id="icon-tools" class="icon32"></div>';
			echo '	<h2>'.esc_html($this->theme_name).' '.esc_html__("Theme Updates",'uniqmag').'</h2>';
			
	      	/* display API errors */
	      	if ( $errors = $this->api_errors() ) {
	        	foreach( $errors as $k => $v ) {
	          	if ( $k !== 'http_code' && ( $user_name || $api_key || $purchase_key ) )
	            	echo '<div class="error below-h2"><p>' . $v . '</p></div>';
	        	}
		    } else {
				echo '    <div id="message" class="updated below-h2"><p><strong>'.sprintf(esc_html__('There is a new version of the %1$s theme available.','uniqmag'),$this->theme_name).'</strong> '.sprintf(esc_html__('You have version %1$s installed. Update to version %2$s.','uniqmag'),$this->theme_version,$this->new_theme_version).' '.sprintf(esc_html__('To update the theme automatically, click %1$shere%2$s','uniqmag'),'<a href="'.$update_url.'"'.$update_onclick.'>', '</a>').'</p></div>';

				echo '	<img style="float: left; margin: 0 20px 20px 0; border: 1px solid #ddd;" src="'.esc_url(get_template_directory_uri().'/screenshot.png').'" />';
					
				echo '	<div id="instructions">';
				echo '	    <h3>'.esc_html__("Update Download and Instructions",'uniqmag').'</h3>';
				echo '	    <p>'.sprintf(esc_html__('%1$sPlease note:%2$s make a %1$sbackup%2$s of the Theme inside your WordPress installation folder %1$s%3$s%2$s. I also encourage you to make a full backup your site and database before performing an update.','uniqmag'),'<strong>', '</strong>', get_template_directory()).'</p>';
				echo '	    <h3>'.esc_html__("Auto Update",'uniqmag').'</h3>';
				echo '	    <p>'.sprintf(esc_html__('To update the theme automatically, click %1$shere%2$s','uniqmag'),'<a href="'.$update_url.'"'.$update_onclick.'>', '</a>').'</p>';
				echo '	    <h3>'.esc_html__("Manual Update",'uniqmag').'</h3>';
				echo '	    <p>'.sprintf(esc_html__('To get the latest update of the Theme, login to %1$sThemeForest%2$s, head over to your %3$sDownloads%4$s section and re-download the theme like you did when you bought it.','uniqmag'),'<a href="http://www.themeforest.net/" target="_blank">', '</a>','<strong>', '</strong>').'</p>';
				echo '	    <p>'.sprintf(esc_html__('Extract the contents of the zip file, look for the extracted theme folder, and after you have all the new files upload them using FTP to the %1$s%3$s%2$s folder overwriting the old ones (this is why it\'s important to backup any changes you\'ve made to the theme files).','uniqmag'),'<strong>', '</strong>', get_template_directory()).'</p>';
				echo '	    <p>'.esc_html__("If you didn't make any changes to the theme files, you are free to overwrite them with the new ones without the risk of losing theme settings, pages, posts, slider images, etc.",'uniqmag').'</p>';
				echo '	    <p>'.esc_html__("Now if you have modified files like CSS or some php files and you haven't kept track of your changes then you can use some 'diff' tools to compare the two versions' files and folders. That way you'd know exactly what files to update and where, line by line. Otherwise you'll loose your customizations.",'uniqmag').'</p>';
				echo '	</div>';
			}
		}

          
    		/* execute theme actions */
        if ( isset( $_GET['action'] ) && isset( $_GET['theme'] ) && wp_verify_nonce($_GET['ot-nonce'], 'upgrade-theme_'.$this->stylesheet)) {
			if ( 'upgrade-theme' == $_GET['action']) {
          		$this->upgrade_theme( $_GET['theme']);
        	}
        }


	} 


    /**
     * Get wordpress download url and theme details from envato
     * @return stdClass wordpress url 
     */
    public function private_user_data($purchase_key = '', $user_name = '', $allow_cache = true) { 
        
      	if ( $user_name == '' ) {
       	 	$user_name = $this->user_name;
      	}	        
      	if ( $purchase_key == '' ) {
       	 	$purchase_key = $this->purchase_key;
      	}	
      
      	if ( $user_name == '' ) {
        	$this->set_error( 'user_name', esc_html__('Please enter your Envato Marketplace Username.','uniqmag') );
      	}      
      	if ( $purchase_key == '' ) {
        	$this->set_error( 'purchase_key', esc_html__('Please enter items purchase code.','uniqmag') );
      	}
        

      
      	if ( $errors = $this->api_errors() ) {
       	 	return $errors;
      	}
        

      	//validate the item
      	$url = "https://api.envato.com/v2/market/buyer/purchase?code=".$purchase_key;
      	$transient_hash = substr( md5( $purchase_key ), 0, 16 );

    	$this->new_theme_name = $new_theme_name = $this->set_cache( "new_theme_name_".$transient_hash);
    	$this->new_theme_author = $new_theme_author = $this->set_cache( "new_theme_author_".$transient_hash);
    	$this->new_theme_version = $new_theme_version = $this->set_cache( "new_theme_version_".$transient_hash);
    	if ( !$new_theme_name || !$new_theme_author || !$new_theme_version) {
    		
    		//get all new data
    		$results = $this->remote_request( $url );

    		if( !isset($results->error) ) {
                if(isset($results->item->wordpress_theme_metadata->theme_name)) {
                    $this->new_theme_name = $new_theme_name = $results->item->wordpress_theme_metadata->theme_name;
                }
                if(isset($results->item->wordpress_theme_metadata->author_name)) {
                    $this->new_theme_author = $new_theme_author = $results->item->wordpress_theme_metadata->author_name;
                }
                if(isset($results->item->wordpress_theme_metadata->version)) {
                    $this->new_theme_version = $new_theme_version = $results->item->wordpress_theme_metadata->version;
                }

	        	//store it in the cache
				$this->set_cache( "new_theme_name_".$transient_hash, $new_theme_name, $this->cache_interval );
				$this->set_cache( "new_theme_author_".$transient_hash, $new_theme_author, $this->cache_interval );
				$this->set_cache( "new_theme_version_".$transient_hash, $new_theme_version, $this->cache_interval );
    		} else {
    			$this->set_error( 'api_error', $results->description);

    		}

    	}


    	if( version_compare($new_theme_version, $this->theme_version, '>')  && $this->theme_author == $new_theme_author) {
	      	$url = "https://api.envato.com/v1/market/private/user/download-purchase:".$purchase_key.".json";


	      	/* set transient ID for later */
	      	$transient = substr( md5( $user_name . '_' . $purchase_key ), 0, 16 );
	      	//$this->clear_cache( $transient);
	      	if ( $allow_cache ) {
	        	$cache_results = $this->set_cache( $transient);
	        	if( !$cache_results ) {
	        		//get all new data
	        		$results = $this->remote_request( $url );
	        		//store it in the cache
	        		$cache_results = $this->set_cache( $transient, $results, $this->cache_interval );
	        	}

	        	$results = $cache_results;
	      	} else {
	        	$results = $this->remote_request( $url );
	      	}
	      	
	      

	      	if ( isset( $results->error ) ) {
	        	$this->set_error( 'error_' . $set, $results->error );
	      	}
	      
	      	if ( $errors = $this->api_errors() ) {
	        	$this->clear_cache( $transient );
	        	return $errors;
	      	}
	      
	      	if ( isset( $results->{'download-purchase'} ) ) {
	        	return $results->{'download-purchase'};
	      	}

    	} 


      	if( version_compare($new_theme_version, $this->theme_version, '<') ) {
        	$this->set_error( 'error_version', esc_html__('Your theme is up to date','uniqmag'));
      	}

      	if( $this->theme_author !== $new_theme_author) {
        	$this->set_error( 'error_author', esc_html__('The purchase key you entered doesn\'t match with this theme. Please edit it in the theme management panel.','uniqmag'));
      	}
    	

      
      	return false;
      	
    }

    /**
     * Set page errors
     */
    public function set_error( $id, $error ) {
    
      	$this->errors['errors'][$id] = $error;
      
    }

    /**
     * Return all errors
     * @return [errors]
     */
    public function api_errors() {
    
      	if ( ! empty( $this->errors['errors'] ) ) {
        	return $this->errors['errors'];
      	}
      
    }

    /**
     * Add error notice in wp-admin
     */
 	function error_notice() {
 		if ( $errors = $this->api_errors() ) {
        	foreach( $errors as $k => $v ) {
          	if ( ( $k === 'error_author' || $k === 'api_error') && ( $this->user_name || $this->api_key || $this->purchase_key ) )
            	echo '<div class="error below-h2"><p>' . $v . '</p></div>';
        	}
        }
	}

    /**
     * Direct wordpress download url
     * @return string url
     */
    public function wp_download() {

      	$download = $this->private_user_data( $this->purchase_key, $this->user_name );
      	
      	
      	if ( $errors = $this->api_errors() ) {
        	return $errors;
      	} else if ( isset( $download->wordpress_theme ) ) {
        	return $download->wordpress_theme;
      	}
      
      	return false;
    }

    /**
     * Request information from envato
     * @return stdClass
     */
	protected function remote_request( $url ) {
    
      	if ( empty( $url ) ) {
       		return false;
      	}
      	
		$request = wp_safe_remote_request($url, array(
		    'user-agent' => 'Orange Themes Auto Updater',
		    'headers' => array(
		        'Authorization' => 'Bearer ' . $this->api_key,
		    ),
		));


      	if ( is_wp_error( $request ) ) {
      		$this->set_error( 'api_error', $request->get_error_message() );
      		return false;
      	}
  
      	$data = json_decode( $request['body'] );
     	
      	if ( $request['response']['code'] == 200 ) {
        	return $data;
      	} else {
        	$this->set_error( 'http_code', $request['response']['code'] );
      	}
        
      	if ( isset( $data->error ) ) {
        	$this->set_error( 'api_error', $data->error.' '.esc_html__('Please make sure, that you have entered a valid API key and user name','uniqmag') ); 
      	}
      
      	return false;
    }

    /**
     * validate wp transient
     * @return string
     */
    public function validate_transient( $id = '' ) {
 
      	return preg_replace( '/[^A-Za-z0-9\_\-]/i', '', str_replace( ':', '_', $id ) );
     
    }

    /**
     * set wp cache
     * @return $cache
     */
    public function set_cache( $transient = '', $cache = '', $timeout = 300 ) {
    
      	if ( $transient == '') {
        	return false;
      	}
      
      	/* keep the code below cleaner */
      	$transient = $this->validate_transient( $transient );
      	$transient_timeout = '_transient_timeout_' . $transient;
      
      	/* set original cache before we destroy it */
      	$old_cache = get_option( $transient_timeout ) < time() ? get_option( $transient ) : '';
      
      	/* look for a cached result and return if exists */
      	if ( false !== $results = get_transient( $transient ) ) {
        	return $results;
       	/* create the cache */
      	} else if ( $cache !== '' ) {
        	set_transient( $transient, $cache, $timeout );
        	return $cache;
      	}
      
      	return false;
      
    }

    /**
     * delete wp cache
     */
    public function clear_cache( $transient = '' ) {

      	delete_transient( $transient );

    }


    /**
     * Update theme
     */
	protected function upgrade_theme( $theme ) {

      	global $current_screen;
      	
      	if ( $errors = $this->api_errors() ) {
       	 	return $errors;
      	}

      	check_admin_referer( 'upgrade-theme_' . $theme );
      
      	if ( ! current_user_can( 'update_themes' ) )
        	wp_die( esc_html__('You do not have sufficient permissions to update themes for this site.','uniqmag') );
      
      	$title = esc_html__('Update Theme','uniqmag');
      	$nonce = 'upgrade-theme_' . $theme;
      	$url = network_admin_url( 'index.php?page=theme-update-notifier&action=upgrade-theme&tab=themes&theme=' . $theme  );
      
      	/* trick WP into thinking it's the themes page for the icon32 */
      	$current_screen->parent_base = 'themes';
      
        /* new Orange_Theme_Upgrader */
        $upgrader = new Orange_Theme_Upgrader( new Theme_Upgrader_Skin( compact( 'title', 'nonce', 'url', 'theme' ) ) );
        
        /* upgrade the theme */
        $upgrader->upgrade( $theme, $this->wp_download());
    }

}

if ( ! class_exists( 'Theme_Upgrader' ) && isset( $_GET['page'] ) && $_GET['page'] == 'theme-update-notifier' )
	include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

if ( class_exists( 'Theme_Upgrader' ) ) {
  	class Orange_Theme_Upgrader extends Theme_Upgrader {

	    function upgrade_strings() {
	      	parent::upgrade_strings();
	      	$this->strings['downloading_package'] = esc_html__('Downloading update from the Envato API&#8230;','uniqmag');

   
	    }

	    function upgrade( $theme, $package = array() ) {
	  
	      	$this->init();
	      	$this->upgrade_strings();
	  
	      	$options = array(
	        	'package' => $package,
	        	'destination' => get_theme_root( $theme ),
	        	'clear_destination' => true,
	        	'clear_working' => true,
	        	'hook_extra' => array(
	          	'theme' => $theme
	        	)
	      	);
	  
	      	$this->run( $options );
	  
	      	if ( ! $this->result || is_wp_error($this->result) )
	        	return $this->result;
	  
	      	return true;
	    }
  	}
}