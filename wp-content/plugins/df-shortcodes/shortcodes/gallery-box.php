<?php
add_shortcode('df-gallery', 'gallery_handler');
function gallery_handler($atts, $content=null, $code="") {
	if(isset($atts['url'])) {
		if(substr($atts['url'],-1) == '/') {
			$atts['url'] = substr($atts['url'],0,-1);
		}
		$vars = explode('/',$atts['url']);
		$slug = $vars[count($vars)-1];
		$page = get_page_by_path($slug,'OBJECT',DF_POST_GALLERY);
		if(is_object($page)) {
			$id = $page->ID;
			if(is_numeric($id)) {

				$galleryImages = get_post_meta ( $id, "different_themes_gallery_gallery_images", true ); 
				$imageIDs = explode(",",$galleryImages);
				$count = count($imageIDs);


				$content.=	'<div class="cs-gallery-preview-short">';
					$content.=	'<div class="cs-gallery-preview-short-text">';
						$content.=	'<h4><a href="'.esc_url($atts['url']).'">'.$page->post_title.'</a></h4>';
						if($page->post_excerpt || !class_exists('Different_Themes')) { 
							$content.=	'<p>'.$page->post_excerpt.'</p>'; 
						} else {
							$content.=	'<p>'.Different_Themes()->other->get_the_excerpt($page->post_content, 30).'</p>'; 
						}
					$content.=	'</div>';
					$content.=	'<div class="cs-gallery-preview-short-thumbs">';
						$counter = 1;
	            		foreach($imageIDs as $imgID) { 
	            			if ($counter==7) break;
	            			if($imgID) {
		            			$file = wp_get_attachment_url($imgID);
		            			if( class_exists('Different_Themes') ) { 
		            				$image = different_themes_get_post_thumb(false, 147, 98, false, $file);
		            				$src = $image['src'];
		            			} else {
		            				$image = wp_get_attachment_image_src($imgID,array(147,98));
		            				$src = $image['0'];
		            			}
								if($counter==1) { $class='featured-photo '; } else { $class=false; }	


								$content.=	'<a href="'.esc_url($atts['url']).'?page='.$counter.'"><img src="'.$src.'" alt="'.esc_attr($page->post_title).'" data-id="'.$counter.'" class="'.$class.'"/></a>';
								$counter++;
							}
						} 
					$content.=	'</div>';

			$content.=	'</div>';
			} else {
				$content.= "Incorrect URL attribute defined";
			}
		} else {
			$content.= "Incorrect URL attribute defined";
		}
		
	} else {
		$content.= "No url attribute defined!";
	
	}
	return $content;
}


?>