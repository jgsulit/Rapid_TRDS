<?php
	
	$reason = '';
	$job_func = '';
	$al_alloc = '';
	$ctrlno = '';
	
	if($return['control_no'][0] == ''){
		$ctrlno = 'To Be Advised';
	}else{
		$ctrlno = $return['control_no'][0];
	}

	if($return['rft'][0] == '1'){
		$reason = 'Newly Hired';
	}else if($return['rft'][0] == '2'){
		$reason = 'Promoted Employee';
	}else if($return['rft'][0] == '3'){
		$reason = 'Transferred from other assembly line';
	}else if($return['rft'][0] == '4'){
		$reason = 'Transferred from on other section/department/division';
	}else if($return['rft'][0] == '5'){
		$reason = 'ML / SL / VL (whose leave reached at least 1 month)';
	}else if($return['rft'][0] == '6'){
		$reason = 'New Product Line';
	}else if($return['rft'][0] == '7'){
		$reason = 'Flexibility Certification';
	}else if($return['rft'][0] == '8'){
		$reason = 'Re-certification';
	}
	
	if($return['job_func'][0] == '1'){
		$job_func = 'Operator';
	}else if($return['job_func'][0] == '2'){
		$job_func = 'Material Handler';
	}else if($return['job_func'][0] == '3'){
		$job_func = 'Inspector';
	}else if($return['job_func'][0] == '4'){
		$job_func = 'Technician';
	}else if($return['job_func'][0] == '5'){
		$job_func = 'Engineer';
	}else if($return['job_func'][0] == '6'){
		$job_func = 'Supervisor';
	}
	
	if($return['al_alloc'][0] == '1'){
		$al_alloc = 'Automotive Line';
	}else if($return['al_alloc'][0] == '2'){
		$al_alloc = 'Non-Automotive Line';
	}
	
	ob_start();

	include('mail_body.php');
	
	$body = ob_get_clean();
	
?>