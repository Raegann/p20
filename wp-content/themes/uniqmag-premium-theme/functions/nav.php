<?php

/* -------------------------------------------------------------------------*
 * 								BLOG PAGE BUTTONS							*
 * -------------------------------------------------------------------------*/
 
 
function uniqmag_different_themes_customized_nav_btns($page_num,$max_num_pages,$search=0) {
		global $wp_query;
		$big = 999999999; // need an unlikely integer
		$args = array(
			'base' 			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'       	=> '?page=%#%',
			'total'       	=> $max_num_pages,
			'current'      	=> max( 1, $page_num ),
			'show_all'     	=> false,
			'end_size'    	=> 1,
			'mid_size'     	=> 2,
			'prev_next'    	=> true,
			'prev_text'    	=> '<i class="fa fa-caret-left"></i>',
			'next_text'    	=> '<i class="fa fa-caret-right"></i>',
			'type'         	=> 'list',
			'add_args'     	=> false,
			'add_fragment' 	=> ''
		);
?>

		<?php echo paginate_links($args); ?>

<?php
}






?>
