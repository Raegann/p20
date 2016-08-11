<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $DF_builder = new different_themes_home_builder; 
    //get block data
    $data = $DF_builder->get_data(); 
    //extract array data
    extract($data[0]); 

    $contactID = uniqmag_different_themes_get_page('contact', false);
   
?>
<div class="cs-row">
    <div class="cs-col cs-col-12-of-12">
        <!-- Banner container -->
        <div class="cs-banner-container">
			<?php echo do_shortcode(uniqmag_different_themes_html_output($code));?>
		</div>
	</div>
</div>

