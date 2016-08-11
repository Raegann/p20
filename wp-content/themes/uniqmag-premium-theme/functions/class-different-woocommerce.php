<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Different_Themes_Woocommerce {



	public function __construct() {
		add_theme_support( 'woocommerce' );


		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'woocommerce_header_add_to_cart_fragment' ) );

		remove_action( 'woocommerce_before_main_content', array( $this, 'woocommerce_output_content_wrapper' ), 10);
		remove_action( 'woocommerce_after_main_content', array( $this, 'woocommerce_output_content_wrapper_end' ), 10);
		add_action('woocommerce_before_main_content', array( $this, 'wrapper_start' ), 10);
		add_action('woocommerce_after_main_content', array( $this, 'wrapper_end' ), 10);
		//remove woocommerce title 
		add_filter('woocommerce_show_page_title', array( $this, 'woo_title' ));

		$shopCount = 6; 
		if($shopCount) {
			add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$shopCount.';' ), 20 );
		}

		if ( $this->is_activated() == true && version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );
		} else {
			define( 'WOOCOMMERCE_USE_CSS', false );
		}


	}



	/**
	 * Update small cart size. Ensure cart contents update when products are added to the cart via AJAX
	* @return cart array
	 */
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		if ( $this->is_activated() == true ) { 
			global $woocommerce;
			$cart_url = $woocommerce->cart->get_cart_url();
			ob_start();
			?>
				<a href="<?php echo esc_url($cart_url);?>" class="ot-cart-contents">
					<i class="fa fa-shopping-cart green-icon"></i>
					<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'uniqmag'), $woocommerce->cart->cart_contents_count);?> 
				</a>
			<?php
			
			$fragments['a.ot-cart-contents'] = ob_get_clean();
			
			return $fragments;
		}
	}


	

	function wrapper_start() {
		echo '<section id="main">';
	}

	function wrapper_end() {
	  	echo '</section>';
	}
	
	function woo_title() {
		return false;
	}
	
	
	function is_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}


}
?>