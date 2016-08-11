<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

		<form method="get" action="<?php echo esc_url(home_url('/')); ?>" name="searchform" class="search_form">
				<input type="text" placeholder="<?php esc_attr_e('search here','uniqmag');?>" class="search_field" name="s" id="s" />
		</form>

