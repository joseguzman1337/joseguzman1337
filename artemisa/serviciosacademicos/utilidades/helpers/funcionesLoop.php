<?php 

$helper_contadorParImpar = function($variable, Mustache_LambdaHelper $helper) {
			global $$variable;
			$class="odd";
			if(intval($$variable) % 2 == 0){
				$class="even";
			}
			$$variable++;
		return $class;
	 };
	 
	 $helper_contadorParImpar = function($rowNumber, Mustache_LambdaHelper $helper) {
			$class="odd";
			if(intval($helper->render($rowNumber)) % 2 == 0){
				$class="even";
			}
		return $class;
	 };


 ?>