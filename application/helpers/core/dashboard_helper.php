<?php
function dashboardMain($lastGT=0,$todaySales=0,$todayTransNo=0){
	$CI =& get_instance();
	// $CI->make->sDiv(array('style'=>'width:100%;background-color:#fff;padding-top:15px;padding-left:10px;padding-right:10px;'));
	// 	$opts = array('Today'=>'today','This Month'=>'monthly','This Year'=>'yearly');
	// 	$CI->make->sDivRow();
	// 		$CI->make->sDivCol(3,'right',9);
	// 			$CI->make->select(null,'show-drop',$opts);
	// 		$CI->make->eDivCol();
	// 	$CI->make->eDivRow();
	// $CI->make->eDiv();
	$CI->make->sDiv(array('style'=>'width:100%;background-color:#f1f1f1'));
		$CI->make->sDiv(array('style'=>'padding:10px;'));
			################################################
			########## BOXES
			################################################
				$CI->make->sDivRow();
					$CI->make->sDivCol(3);
				    	$CI->make->sDiv(array('class'=>'info-box'));
				        	$CI->make->span(fa('fa-desktop'),array('class'=>'info-box-icon  bg-blue'));
				        	$CI->make->sDiv(array('class'=>'info-box-content','id'=>'last-gt-box'));
				        		$CI->make->span('Last Grand Total',array('class'=>'info-box-text'));
				        		$CI->make->span('PHP '.num($lastGT),array('class'=>'info-box-number','id'=>"last-gt"));
				        	$CI->make->eDiv();
				        $CI->make->eDiv();
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						$CI->make->sDiv(array('class'=>'info-box '));
					    	$CI->make->span(fa('fa-money'),array('class'=>'info-box-icon  bg-green'));
					    	$CI->make->sDiv(array('class'=>'info-box-content'));
					    		$CI->make->span('Today Sales',array('class'=>'info-box-text'));
					    		$CI->make->span('PHP '.num($todaySales),array('class'=>'info-box-number'));
					    	$CI->make->eDiv();
					    $CI->make->eDiv();
					$CI->make->eDivCol();
					$CI->make->sDivCol(3);
						$CI->make->sDiv(array('class'=>'info-box  '));
							$CI->make->span(fa('fa-users'),array('class'=>'info-box-icon bg-yellow'));
							$CI->make->sDiv(array('class'=>'info-box-content'));
								$CI->make->span('Today Transactions',array('class'=>'info-box-text'));
								$CI->make->span(num($todayTransNo),array('class'=>'info-box-number'));
							$CI->make->eDiv();
						$CI->make->eDiv();
					$CI->make->eDivCol();
					// $CI->make->sDivCol(3);
				 //    	$CI->make->sDiv(array('class'=>'info-box'));
				 //        	$CI->make->span(fa('fa-cutlery'),array('class'=>'info-box-icon  bg-blue'));
				 //        	$CI->make->sDiv(array('class'=>'info-box-content'));
				 //        		$CI->make->span('Today\'s Top Menu',array('class'=>'info-box-text'));
				 //        		$CI->make->span('Congee',array('class'=>'info-box-number'));
				 //        	$CI->make->eDiv();
				 //        $CI->make->eDiv();
					// $CI->make->eDivCol();
					$CI->make->sDivCol(3);
						$CI->make->sDiv(array('class'=>'info-box'));
							$CI->make->span(fa('fa-calendar'),array('class'=>'info-box-icon bg-aqua'));
							$CI->make->sDiv(array('class'=>'info-box-content'));
								$CI->make->span(null,array('class'=>'info-box-text','id'=>'box-day'));
								$CI->make->span('9:00 PM',array('class'=>'info-box-number','id'=>'box-time'));
								$CI->make->sDiv(array('class'=>'progress'));
									$CI->make->sDiv(array('class'=>'progress-bar','style'=>'width:100%'));
									$CI->make->eDiv();
								$CI->make->eDiv();
								$CI->make->span(null,array('class'=>'progress-description','id'=>'box-date'));
							$CI->make->eDiv();
						$CI->make->eDiv();
					$CI->make->eDivCol();

				$CI->make->eDivRow();
			################################################
			########## GRAPHS
			################################################
				$CI->make->sDivRow();
					$CI->make->sDivCol(9);
							$CI->make->sBox('solid');
								// $CI->make->sBoxHead();
								// 	$CI->make->boxTitle(fa('fa-money fa-fw').' Transactions Sales');
								// $CI->make->eBoxHead();
								$CI->make->sBoxHead(array('class'=>'bg-blue'));
									$CI->make->h(3,fa('fa-money').' Today\'s Sales',array('class'=>'box-title'));
								$CI->make->eBoxHead();
								$CI->make->sBoxBody();
									$CI->make->sDivRow(array('class'=>'chart-responsive'));
										// $CI->make->sDivCol(8);
										// 	$CI->make->sDiv(array('class'=>'chart','id'=>'bar-chart','style'=>'height:300px;'));
										// 	$CI->make->eDiv();
										// $CI->make->eDivCol();
										$CI->make->sDivCol(6);
											$CI->make->sDiv(array('id'=>'sales-chart','class'=>'chart','style'=>'height: 300px; position: relative;'));
											$CI->make->eDiv();
										$CI->make->eDivCol();
										$CI->make->sDivCol(6);
											$CI->make->sDiv(array('id'=>'bars-div'));
											$CI->make->eDiv();
										$CI->make->eDivCol();
									$CI->make->eDivRow();
								$CI->make->eBoxBody();
							$CI->make->eBox();
					$CI->make->eDivCol();		
					$CI->make->sDivCol(3);
						$CI->make->sBox('default',array('class'=>'box-solid'));
							$CI->make->sBoxHead(array('class'=>'bg-teal'));
								$CI->make->h(3,fa('fa-cutlery').' Today\'s Top Menu',array('class'=>'box-title'));
							$CI->make->eBoxHead();
// 									$CI->make->append('<div class="overlay">
//   <i class="fa fa-refresh fa-spin"></i>
// </div>');
							$CI->make->sBoxBody(array('class'=>'chart-responsive no-padding'));
								$CI->make->sDiv(array('id'=>'top-menu-box','style'=>'min-height:218px;'));
								$CI->make->eDiv();
							$CI->make->eBoxBody();
						$CI->make->eBox();
					$CI->make->eDivCol();		
				$CI->make->eDivRow();
		$CI->make->sDiv();
	$CI->make->eDiv();

	return $CI->make->code();
}
?>