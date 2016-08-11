<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	$DF_builder = new different_themes_home_builder; 

	//get block data
	$dataArray = $DF_builder->get_data(); 
	$sliderSet = $DF_builder->sliderSet(); 

	$main_content_class = "cs-main-content";

	if(isset($dataArray[0]->columns)) {
		$col = $dataArray[0]->columns;
	} elseif(isset($dataArray[0]->layoutColumns)) {
		$col = $dataArray[0]->layoutColumns;
	}
	if(isset($dataArray[0]->row)) {
		$row = $dataArray[0]->row;
	} else {
		$row = false;
	}

	if ((strpos($row,'homepageLayout') !== false)) { 
		$layout = true; 
		$layoutArray = $DF_builder->layout("layout"); 
	} else {
		$layout = false; 
		$layoutArray = $DF_builder->layout("column"); 
	}


	//extract the block variables
	if(isset($col[0]->contentBlocksSettings)) {
		$values = array("background_color");
		extract($DF_builder->block_values($col[0]->contentBlocksSettings,$values, "column settings"));	
	}


 	//get sidebars and sidebar align
	$sidebar_array = array();
	$column_size = 1;
	if( $layout == true ) {
		for ( $i = 0; $i <= 2 ; $i++) { 
			if( isset( $dataArray[0]->columns[$i]->columnID ) ) {
				$columnID = $dataArray[0]->columns[$i]->columnID;
			} else {
				$columnID =  false;
			}

			$columnID = filter_var($columnID, FILTER_SANITIZE_NUMBER_INT);

			if( $columnID && ( $columnID == "4" || $columnID == "3" || $columnID == "2" ) ) {
				$sidebar_array[$i] = $columnID;
				$column_size++;
			}
		}


		$sidebar_position = array();
		if( !empty($sidebar_array) ) {
			foreach ( $sidebar_array as $key => $sidebar ) {
				if( $column_size == "2" ) {				//if there is one sidebar
					if ( isset( $sidebar ) ) {
						if( $key == "0" ) {
							$sidebar_position[] = "left";
						} else {
							$sidebar_position[] = "right";
						}
					}
				} else if( $column_size == "3" ) { 		//if there are two sidebars
					if ( isset( $sidebar ) ) {
						if( $key == "0" ) {
							$sidebar_position[] = "left";
						}else if ( $key == "1" ) {
							$sidebar_position[] = "middle";
						} else {
							$sidebar_position[] = "right";
						}
					}
				}
			}
		}

		$sidebar_count = count($sidebar_position);

		if( $sidebar_count == "1" ) {
			$sidebar_class =  "cs-sidebar-on-the-".$sidebar_position[0];
		} else {
			$sidebar_class = "double";
		}
		
		if (isset($dataArray[0]->row_class) && strpos($dataArray[0]->row_class,'has-sidebar') !== false) {
			$main_content_class.= " ".$sidebar_class; 
			$sidebarSet = true;
		} else {
			$sidebarSet = false;
		}
	
		Different_Themes()->sidebars->set_sidebar();
	}

?>
<?php 
	//column settings
	if(isset($background_color) && $background_color == '111' && !in_array("layout", $layoutArray)){ 
?>
	<div class="wild_container">
<?php
		}

?>

<?php if ($layout==true || (!in_array("layout", $layoutArray) && $layout==false)) { ?>

	<div class="cs-container">

<?php } else { ?>
		<!-- BEGIN .row -->
		<div class="cs-row <?php if(isset($dataArray[0]->row_class)) { echo esc_attr($dataArray[0]->row_class) ; }?>">
<?php } ?>
		<?php
			$counter = 1;

			//foreach row columns
			foreach ($col as $columns) {
				if(isset($columns->columnID)) { 
					$colID = $columns->columnID; 
				} elseif(isset($columns->layoutID)) { 
					$colID = $columns->layoutID;
				}

				$colID = filter_var($colID, FILTER_SANITIZE_NUMBER_INT);
				if($layout == true && ($colID == "4" ||$colID == "3" || $colID == "2")) {
					if($colID == "3" || $colID == "4") {
						$class = "cs-main-sidebar cs-sticky-sidebar";
					} elseif($colID == "2") {
						$class = "sidebar-small sidebar_area";
					}
				} elseif($layout == true) {
					if(isset($double) && $double==true) {
						$class = "main-content-double";
					} else {
						$class = $main_content_class;
					}
				} else {
					$class = "cs-col";
					$class.= " cs-col-".esc_attr($colID)."-of-12";
				}

					if(isset($columns->layoutID)) { 
						$class.= " ".esc_attr($columns->layoutID);
					}
			?>
				<div class="<?php echo esc_attr($class); ?>">
					<?php 
						if($sliderSet==false && ($class == "main_content" || $class == "main-content-double") && get_post_meta ( Different_Themes()->page_id(), "_".THEME_NAME."_sliderStyle", true ) == "1") { 
							//get_template_part(UNIQMAG_DIFFERENT_THEME_SLIDERS."main-slider");
							$DF_builder->sliderSet(true);
						}
					?>
					<?php
						if(!empty($columns->contentBlocks)) { 
							
							//foreach column blocks
							foreach ($columns->contentBlocks as $blocks) {

								if(isset($blocks->blocksContentName)) {
									$block = $blocks->blocksContentName;
									$DF_builder->$block($blocks,$columns->columnID);
								} else {
									$sidebar = $blocks->SidebarName;
									if(!$sidebar) { $sidebar = "default"; }
								?>
								<div class="theiaStickySidebar">
									<?php
										if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar) ) :
										endif;
									?>
								</div>
								<?php
									//echo "&nbsp;";
								}

							} 
						} else if(isset($columns->layoutRows)) {

							foreach ($columns->layoutRows as $layoutRows) {
								$DF_builder->columRows($layoutRows);
							}
						} else {
							echo "&nbsp;";
						}
					?>
				</div>
			<?php $counter++; ?>
			<?php } ?>
			<?php if ($layout==true || (!in_array("layout", $layoutArray) && $layout==false)) { ?>
				
			<?php } else { ?>
				</div>
			<?php } ?>
		<?php if ($layout==true || (!in_array("layout", $layoutArray) && $layout==false)) { ?>
			</div>
		<?php } ?>
		<?php 
			//column settings
			if(isset($background_color) && $background_color == '111' && !in_array("layout", $layoutArray)){  	
		?>
			</div>
		<?php
			}
		?>
