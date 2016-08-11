<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	//ratings
	$ratings = get_post_meta( get_the_ID() , "_".THEME_NAME."_ratings", true );
	$summary = get_post_meta( get_the_ID() , "_".THEME_NAME."_overall", true );
	
	$avarage_rating = Different_Themes()->ratings->avarage_rating();
	$rate_text = Different_Themes()->ratings->rate_text();
	$max_val = Different_Themes::$rating_max_val;
?>
	<?php if($ratings || $summary) { ?>
	   <!-- Review -->
	   <h4 class="cs-heading-subtitle"><?php esc_html_e("Review", 'uniqmag');?></h4>
	   <div class="cs-single-post-review" itemscope itemtype="http://data-vocabulary.org/Review">
	        <meta itemprop="itemreviewed" content="<?php echo esc_attr(get_the_title()); ?>"/>
	        <meta itemprop="reviewer" content="<?php echo esc_attr(get_the_author());?>"/>
	        <meta itemprop="dtreviewed" content="<?php echo esc_attr(get_the_time("F d, Y")); ?>"/>
	                           
  
			<div class="cs-final-score" title="<?php printf ( esc_attr__('Rated %1$s out of %2$s','uniqmag'), floatval($avarage_rating[1]), intval($max_val));?>">
                <div itemprop="rating"><?php echo floatval($avarage_rating[1]);?></div>
                <span><?php echo esc_html($rate_text);?></span>
            </div>

            <div class="cs-review-summary">
                <h5><?php esc_html_e("Summary", 'uniqmag');?></h5>
				<?php if($summary) { ?>
	        		<p><?php echo esc_html($summary);?></p>
				<?php } ?>
            </div>
            <div class="cs-review-scores">
                <ul>
					<?php 
						if($ratings) { 
				            $rating = explode(";", $ratings);

				            foreach($rating as $rate) { 
				                $ratingValues = explode(":", $rate);
				                if(isset($ratingValues[1])){
				                    $rating = str_replace(",",".",$ratingValues[1]);
				                    $precentage =  floatval(round(($rating/$max_val)*100,2));
				                }
				              
				                if($ratingValues[0]) {
					?>	
	                    <li>
	                        <div class="cs-review-score-title"><?php echo esc_html($ratingValues[0]);?></div>
	                        <div class="cs-review-score-score"><?php echo floatval($rating);?>/<?php echo intval($max_val);?></div>
	                        <div class="cs-review-score-line">
	                            <div class="cs-review-score-line-active" style="width: <?php echo floatval($precentage);?>%"></div>
	                        </div>
	                    </li>
					<?php 
								}
							}
						}
				 	?>
                </ul>
            </div>
        </div>
	<?php } ?>