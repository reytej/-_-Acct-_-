<?php
function makeLoginBox(){
	$CI =& get_instance();
		$CI->make->sDiv(array('class'=>'center'));
			$CI->make->sDiv(array('class'=>'form-box login-shadow-box'));
				$CI->make->sDiv(array('class'=>'header'));
					$CI->make->span('PointOne');
				$CI->make->eDiv();				
				$CI->make->sForm('site/go_login',array('id'=>'login-form'));
					$CI->make->sDiv(array('class'=>'body bg-white'));
						$CI->make->input(null,'username',null,'username',array('class'=>'rOkay'),null,fa('fa-user'));
						$CI->make->pwd(null,'password',null,'password',array('class'=>'rOkay'),null,fa('fa-lock'));
						$CI->make->sDivRow();
							$CI->make->sDivCol(4,'right',8);
								$CI->make->button('Sign In',array('id'=>'login-btn','class'=>'btn-block btn-flat bg-olive','style'=>'padding:6px;'),'success');
							$CI->make->eDivCol();
						$CI->make->eDivRow();
					$CI->make->eDiv();
				$CI->make->eForm();
				$CI->make->sDiv(array('class'=>'footer'));
				$CI->make->eDiv();			
			$CI->make->eDiv();				
		$CI->make->eDiv();
	return $CI->make->code();
}
?>