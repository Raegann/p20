<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $DF_builder = new different_themes_home_builder; 
    //get block data
    $data = $DF_builder->get_data(); 
    //extract array data
    extract($data[0]); 

?>


    <div class="post_content">
		<?php echo do_shortcode(uniqmag_different_themes_html_output($code));?>
	</div>
