<?php

	header("Content-Type: application/json");
	header("Access-Control-Allow-Origin: *");

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				
				case "action_display_data"			: display_data(); break;
				case "action_edit_data"				: edit_data(); break;
				case "action_add_data"				: add_data(); break;
				// case "action_delete_data"			: send_email(); break; //novs edit, enable this, it does not affect any process tho
				case "action_send_email"			: delete_data(); break;
				
				case "get_superior_email"			: get_superior_email(); break;
			
				case "display_my_request"			: display_my_request(); break;
				case "display_my_granted_request"	: display_my_granted_request(); break;
				case "action_get_empno"				: get_empno(); break;
				case "check_empno_details"			: check_empno_details(); break;
				case "check_empno_details2"			: check_empno_details2(); break;
				case "get_immediate_superior"		: get_immediate_superior(); break;
				case "get_final_approver"			: get_final_approver(); break;
				
				// request.php ajax requests
				case "send_new_request"				: send_new_request(); break;
				
				case "add_new_employees"			: add_new_employees(); break;
				case "cancel_request"				: cancel_request(); break;
				
				// emails
				case "send_email_request"			: send_email_request(); break; //novs edit

				case "send_email_conformance"					: send_email_conformance(); break; //novs edit
				case "send_email_conformance_disapprove"		: send_email_conformance_disapprove(); break; //novs edit
				case "send_email_conformance_return"			: send_email_conformance_return(); break; //novs edit

				case "send_email_receive"			: send_email_receive(); break; //novs edit

				case "send_email_approval"			: send_email_approval(); break; //novs edit
				
				case "display_conformance"			: display_conformance(); break;
				case "getRequestDetails"			: getRequestDetails(); break;
				case "getEmployeeList"				: getEmployeeList(); break;
				case "getRequestorDetails"			: getRequestorDetails(); break;
				case "conform_request"				: conform_request(); break;
				case "conform_request_disapprove"	: conform_request_disapprove(); break;
				case "conform_request_return"		: conform_request_return(); break;
				
				case "display_receiving"			: display_receiving(); break;
				case "process_controlno"			: process_controlno(); break;
				case "receive_request"				: receive_request(); break;
				case "receive_request_disapprove"	: receive_request_disapprove(); break;
				case "receive_request_return"		: receive_request_return(); break;

				case "display_list_of_received"		: display_list_of_received(); break;
				case "display_list_of_trainees"		: display_list_of_trainees(); break;
				
				case "display_approval"				: display_approval(); break;
				case "approve_request"				: approve_request(); break;
				case "approve_request_disapprove"	: approve_request_disapprove(); break;
				case "approve_request_return"		: approve_request_return(); break;
				case "display_approved"				: display_approved(); break;
				
				case "display_user_access_list"		: display_user_access_list(); break;
				case "add_user_access"				: add_user_access(); break;
				case "get_lastname"					: get_lastname(); break;
				case "get_email_ln"					: get_email_ln(); break;

				// new added start --------------------------------------------------
				case "getTRDSUsers"					: getTRDSUsers(); break;
				// new added end --------------------------------------------------
			}
		}
	}

	// new added start --------------------------------------------------
	function getTRDSUsers()
	{
		require_once('../oop/rapid_oop.php');
		$result = TRDS::getInstance()->getTRDSUsers();
		echo json_encode($return);
	}
	// new added end --------------------------------------------------

	
	function display_data(){
	
		require_once('../oop/hris-oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_sample';
		$joins 	   		= '';	
		$sql_where 		= '';
		$sql_order 		= '';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mssql_fetch_array($result)){
			$return['db_column'][$ctr] 			= $row['db_column'];
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		
	}
	
	function add_data(){
		
		require_once('../oop/hris-oop.php');
		
		$return			= $_POST;
		$result			= '';
		$table			= 'tbl_sample';
		$array_fields 	= array('column1', 'column2', 'column3');
		$array_values 	= array($return['column_1'],$return['column_2'],$return['column_3']); 
		$result 		= RAPID::getInstance()->insert_query($table,$array_fields,$array_values);
		
		echo json_encode($return);
		
	}
	
	function edit_data(){
	
		require_once('../oop/hris-oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_sample';
		$sql_where 		= '';
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		$ctr = 0;
		
		while($row = mssql_fetch_array($result)){
			$return['db_column'][$ctr] 			= $row['db_column'];
		}
		echo json_encode($return);
		
	}
	
	function delete_data(){
	
		require_once('../oop/hris-oop.php');
	
		$return 	= $_POST; 
		$result 	= '';
		$table   	= 'tbl_sample';
		$pkid 		= $return['pkid'];
		$result 	= RAPID::getInstance()->delete_query($table,$pkid);
		$return["result"] = json_encode($result); 
		echo json_encode($return); 
		
	}
	
	function send_emailxx(){//novs edit
		
		require('./PHPMailer/class.phpmailer.php');
		require_once('../oop/hris-oop.php');
		$mail = new PHPMailer();
		
		$return = $_POST;
		$from = $return['email'].'@pricon.ph';
		$ptisCode = $return['ptisCode'];
		
		$body = "
			<table>
			
				<tr>
					<td colspan='3' align='left'>Good Morning Sir/Ma'am,</td>
				</tr>
				<br>
				<tr>
					<td colspan='3' align='center'>SYSTEM TITLE</td>
				</tr>
				<br>
				<tr>
					<td style='width:30px;'></td>
					<td>Column1: </td>
					<td>".$return['column_1']."</td>
				</tr>
				<tr>
					<td></td>
					<td>Column2: </td>
					<td>".$return['column_2']."</td>
				</tr>
				<tr>
					<td></td>
					<td>Column3: </td>
					<td>".$return['column_3']."</td>
				</tr>
				";
					
					
		
		$body .= "
			</table>
			<br>
			Notice of Disclaimer:
			This message (including any attachments) contains confidential information intended for a specific individual and purpose, and is protected by law. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.";

		$getPath = RAPID::getInstance()->getPath($pkid);
		while ($getRow = mysqli_fetch_array($getPath)){
			$mail->AddAttachment($getRow['path']);
			$body .= '['.$getRow['path'].']<br>';
		}
		
		$mail->AddAttachment('FolderName/'.$return['column_1'].' '.$return['column_2'].'.xls');
		
		$mail->From = $from;	//from
		$mail->FromName = $from;
		$recipients = RAPID::getInstance()->getEmails();
		while($row = mysqli_fetch_array($recipients)){
			$mail->AddAddress($row['email']);
		}
		
		$mail->AddCC($from);
		$mail->AddBCC('sample@pricon.ph');	
		$mail->ConfirmReadingTo = $from;
		
		$mail->IsHTML(true); 

		$mail->Subject = "Sample Subject";
		$mail->Body= $body;
		

		
		
		if(!$mail->Send())
		{
		   $msg = "Error Sending. <p>";
		   $msg .= "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$msg = "Email sent!";
		}
		$json_array['msg'] = $msg;
		echo json_encode($json_array);
		
	}
	
	
	#Functions
	function display_my_request(){
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_request';
		$joins 	   		= '';	
		$sql_where 		= "WHERE requested_by = '".$return['email']."' AND log_del = '0' AND conf_status != 3 AND rec_status != 3 AND app_status != 3 AND app_status != 1";
		$sql_order 		= 'ORDER by pkid_request DESC';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['hr_ctrl_no'][$ctr] 			= $row['hr_ctrl_no'];
			$return['pkid_request'][$ctr] 			= $row['pkid_request'];
			$return['control_no'][$ctr] 			= $row['control_no'];
			$return['date_filed'][$ctr]				= date('F d, Y', strtotime($row['date_filed']));
			$return['conf_status'][$ctr] 			= $row['conf_status'];
			$return['rec_status'][$ctr] 			= $row['rec_status'];
			$return['app_status'][$ctr] 			= $row['app_status'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function display_my_granted_request(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_request';
		$joins 	   		= '';	
		$sql_where 		= "WHERE requested_by = '".$return['email']."' AND  (log_del = '1' OR conf_status = 3 OR rec_status = 3 OR app_status = 3 OR app_status = 1 )";
		$sql_order 		= 'ORDER by pkid_request DESC';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['pkid_request'][$ctr] 			= $row['pkid_request'];
			$return['hr_ctrl_no'][$ctr] 			= $row['hr_ctrl_no'];
			$return['control_no'][$ctr] 			= $row['control_no'];
			$return['date_filed'][$ctr]				= date('F d, Y', strtotime($row['date_filed']));
			$return['conf_status'][$ctr] 			= $row['conf_status'];
			$return['rec_status'][$ctr] 			= $row['rec_status'];
			$return['app_status'][$ctr] 			= $row['app_status'];
			$return['log_del'][$ctr] 				= $row['log_del'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function get_empno(){
	
		require_once('../oop/hris_oop.php');
		
		$return 		= $_POST;
		$pattern 		= $_POST['pattern'];
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'vw_subcon_all_employees';
		$joins 	   		= '';	
		$sql_where 		= 'WHERE EmpNo LIKE "%'.$pattern.'%"';
		$sql_order 		= '';
		$sql_limit 		= 'LIMIT 0,10';
		$result 		= HRIS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		if (!$result) {
			echo mysql_error();
		}
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['tblPKID'][$ctr] 			= $row['tblPKID'];
			$return['EmpNo'][$ctr] 				= $row['EmpNo'];
			$return['LastName'][$ctr] 			= $row['LastName'];
			$return['FirstName'][$ctr] 			= $row['FirstName'];
			$return['MiddleName'][$ctr] 		= $row['MiddleName'];
			$return['DateHired'][$ctr] 			= $row['DateHired'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	
	}
	
	function check_empno_details(){
	
		require_once('../oop/hris_oop.php');
		
		$result 		= '';
		$return 		= $_POST;
		$array_fields	= array('LastName','FirstName','MiddleName','DateHired');
		$table			= 'vw_subcon_all_employees';
		$sql_where		= "WHERE replace( replace(EmpNo,' ',''), '\t', '' ) = '".$return['empno']."'";
		$joins			= '';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 1';
		$result			= HRIS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		if(!$result){
			echo mysql_error();
		}
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
		$return['LastName'][$ctr]			= $row['LastName'];
		$return['FirstName'][$ctr]			= $row['FirstName'];
		$return['MiddleName'][$ctr]			= $row['MiddleName'];
		$return['DateHired'][$ctr]			= $row['DateHired'];
		
		$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo $result;
		
	}
	
	function check_empno_details2(){
	
		require_once('../oop/hris_oop.php');
		
		$result 		= '';
		$return 		= $_POST;
		$array_fields	= array('LastName','FirstName','MiddleName','DateHired');
		$table			= 'tbl_EmployeeInfo';
		$sql_where		= "WHERE EmpNo = '".$return['empno']."'";
		$joins			= '';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 1';
		$result			= HRIS3::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		if(!$result){
			echo mysql_error();
		}
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
		$return['LastName'][$ctr]			= $row['LastName'];
		$return['FirstName'][$ctr]			= $row['FirstName'];
		$return['MiddleName'][$ctr]			= $row['MiddleName'];
		$return['DateHired'][$ctr]			= $row['DateHired'];
		
		$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo $result;
		
	}
	
	#Requestor
	function get_immediate_superior(){
		
		require_once('../oop/hris_oop.php');
		
		$return 		= $_POST;
		$pattern 		= $_POST['pattern_superior'];
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'vw_secheads_new';
		$joins 	   		= '';	
		$sql_where 		= 'WHERE fullname LIKE "%'.$pattern.'%"';
		$sql_order 		= '';
		$sql_limit 		= 'LIMIT 0,10';
		$result 		= HRIS3::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= HRIS3::getInstance()->select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		if (!$result) {
			echo mysql_error();
		}
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 				= $row['pkid'];
			$return['firstname'][$ctr] 			= $row['firstname'];
			$return['lastname'][$ctr] 			= $row['lastname'];
			$return['email_add'][$ctr] 			= $row['email_add'];
			$return['EmpNo'][$ctr] 				= $row['EmpNo'];
			$return['username'][$ctr] 			= $row['username'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['script'] = json_encode($script);
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo $result;
		
	}
	
	function get_superior_email(){
		require_once('../oop/hris_oop.php');
		$return 		= $_POST;
		$superior_name 	= $_POST['superior_name'];
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'vw_secheads_new';
		$joins 	   		= '';	
		$sql_where 		= 'WHERE fullname = "'.$superior_name.'"';
		$sql_order 		= '';
		$sql_limit 		= 'LIMIT 0,1';
		$result 		= HRIS3::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$script 		= HRIS3::getInstance()->select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		if (!$result) {
			echo mysql_error();
		}
		$row = mysqli_fetch_array($result);
		$return['pkid']					= $row['pkid'];
		$return['firstname'] 			= $row['firstname'];
		$return['lastname'] 			= $row['lastname'];
		$return['email_add'] 			= $row['email_add'];
		$return['EmpNo'] 				= $row['EmpNo'];
		$return['username'] 			= $row['username'];
		
		$return['script'] 				= $script;
		
		echo json_encode($return);
	}

	function get_final_approver(){
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$pattern 		= $return['pattern_superior'];
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_access';
		$joins 	   		= '';	
		$sql_where 		= 'WHERE approval = "1" AND name LIKE "%'.$pattern.'%"';
		// $sql_where 		= 'WHERE approval = "1" AND name LIKE "%morallos%"';
		$sql_order 		= '';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['Name'][$ctr] 					= $row['name'];
			$return['Email'][$ctr] 					= $row['email_add'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	function send_new_request(){
		
		require_once('../oop/rapid_oop.php');
		$return			= $_POST;
		$result			= '';
		$table			= 'tbl_request';

		$array_fields 	= array('hr_ctrl_no', 'product_class', 'dept', 'sec', 'rft', 'job_func', 'al_alloc', 'requested_by', 'conformed_by', 'approved_by', 'conf_status', 'rec_status', 'app_status', 'overallStatus', 'date_filed', 'log_del');
		$array_values 	= array($return['txt_hr_ctrl_no'],$return['name_crt_product_classification'],$return['name_crt_dept'],$return['name_crt_sec'],$return['name_crt_reason'],$return['name_crt_jobfunc'],$return['name_crt_alloc'],$return['name_crt_reqby'], $return['name_superior_name'], 'rdmorallos@pricon.ph', '0', '0', '0', '0', $return['name_add_date'],'0'); //novs edit
		// $array_values 	= array($return['name_crt_dept'],$return['name_crt_sec'],$return['name_crt_reason'],$return['name_crt_jobfunc'],$return['name_crt_alloc'],$return['name_crt_reqby'], $return['name_superior_name'], $return['name_final_approver_name'], '0', '0', '0', '0', $return['name_add_date'],'0'); //novs edit - 5/15/2019
		// $array_values 	= array($return['name_crt_dept'],$return['name_crt_sec'],$return['name_crt_reason'],$return['name_crt_jobfunc'],$return['name_crt_alloc'],$return['name_crt_reqby'], $return['name_crt_reqby'], $return['name_crt_reqby'], '0', '0', '0', '0', $return['name_add_date'],'0'); //novs edit remove this
		
		if( $return['txt_request_pkid'] == '' ){
			$result 		= RAPID::getInstance()->insert_query_id($table,$array_fields,$array_values); //novs edit
			
			$return['result'] = json_encode($result);
			$return['new_id'] = json_encode($result);
		}
		else{
			$sql_where 		= "pkid_request";
			$pkid			= $return['txt_request_pkid'];
			$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);

			$return['result'] = $return['txt_request_pkid'];
			$return['new_id'] = $return['txt_request_pkid'];

			//logdel the employees of the current request
			$result 		= '';
			$array_fields 	= array('log_del');
			$table 	   		= 'tbl_trainees';
			$sql_where 		= "fkid_pkid_request";
			$array_values	= array('1');
			$pkid			= $pkid;
			$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		}
		echo json_encode($return);
	}
	
	function add_new_employees(){
		require_once('../oop/rapid_oop.php');
		
		$return			= $_POST;
		$result			= '';
		$table			= 'tbl_trainees';
		$array_fields 	= array('fkid_pkid_request', 'emp_no', 'emp_name', 'from_station', 'from_line', 'to_station', 'to_line', 'date_hired', 'log_del');
		$array_values 	= array($return['pkid'],$return['empNo'],$return['name'],$return['fstation'],$return['fprod'],$return['tstation'],$return['tprod'],$return['dateHired'],'0'); 
		$result 		= RAPID::getInstance()->insert_query_id($table,$array_fields,$array_values);
		
		$return['new_id'] = json_encode($result);
		echo json_encode($return);
	}
	
	function cancel_request(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('log_del');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		$array_values	= array('1');
		$pkid			= $return['pkid'];
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);
		
	}
	
	function send_email_request(){//novs edit
		
		require('./PHPMailer/class.phpmailer.php');
		require_once('../oop/rapid_oop.php');
		
		// $mail = new PHPMailer();//no longer needed
		$result = RAPID::getInstance()->request_info($_POST['pkid']);
		
		$return = $_POST;
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['date_filed'][$ctr]		= date('F d, Y', strtotime($row['date_filed']));
			$return['control_no'][$ctr] 	= $row['control_no'];
			$return['dept'][$ctr] 			= $row['dept'];
			$return['sec'][$ctr] 			= $row['sec'];
			$return['rft'][$ctr] 			= $row['rft'];
			$return['job_func'][$ctr] 		= $row['job_func'];
			$return['al_alloc'][$ctr] 		= $row['al_alloc'];
			$return['requested_by'][$ctr] 	= $row['requested_by'];
			$return['conformed_by'][$ctr] 	= $row['conformed_by'];

			$return['conf_remarks'][$ctr] 	= $row['conf_remarks'];//novs add - for revised checking, process - approver must enter remarks when disapproving or returning the req for revision, so, only for rev (4) can be edited in req table of the user
			$return['rec_remarks'][$ctr] 	= $row['rec_remarks'];//novs add - for revised checking
			$return['app_remarks'][$ctr] 	= $row['app_remarks'];//novs add - for revised checking

			$ctr++;
		}
		
		require_once('../pages/email_setup/email_request.php');

		$revised_str = '';
		if( $return['conf_remarks'][0] != '' || $return['rec_remarks'][0] != '' || $return['app_remarks'][0] != '' ){
			$revised_str = ' (Revised) ';
		}

        require_once('./email_config.php');                      	// TCP port to connect to		
		// $mail->From = 'naayes@pricon.ph';
		// $mail->FromName = 'RFT System';
		// $mail->AddAddress('naayes@pricon.ph');
		
		// $mail->AddBCC('naayes@pricon.ph');	
		// $mail->AddCC('naayes@pricon.ph');	
		// $mail->ConfirmReadingTo = 'naayes@pricon.ph';

		$mail->From = $return['email'];
		$mail->FromName = 'RFT System';
		$mail->AddAddress($return['conformed_by'][0]);
		
		$mail->AddBCC('naayes@pricon.ph');	
		$mail->AddCC($return['requested_by'][0]);	
		$mail->ConfirmReadingTo = $return['email'];

		$mail->IsHTML(true); 
		$mail->Subject = "RFT System: New Training Request ".date('Y-m-d').$revised_str;//novs added revised
		$mail->Body= $body;
		
		if(!$mail->Send())
		{
		   $msg = "Error Sending. <p>";
		   $msg .= "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$msg = "Email sent!";
		}
		
		$json_array['msg'] = $msg;
		echo json_encode($json_array);
	}
	
	#conformance
	function display_conformance(){
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_request';
		$joins 	   		= '';	
		$sql_where 		= "WHERE conformed_by = '".$return['credentials']."' AND log_del = '0' AND 
			( conf_status != 3 AND rec_status != 3 AND app_status != 3 AND conf_status != 4 AND rec_status != 4 AND app_status != 4 AND app_status != 1 )";
		$sql_order 		= 'ORDER BY pkid_request DESC';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['pkid_request'][$ctr] 			= $row['pkid_request'];
			$return['hr_ctrl_no'][$ctr] 			= $row['hr_ctrl_no'];
			$return['control_no'][$ctr] 			= $row['control_no'];
			$return['date_filed'][$ctr] 			= $row['date_filed'];
			$return['conf_status'][$ctr] 			= $row['conf_status'];
			$return['rec_status'][$ctr] 			= $row['rec_status'];
			$return['app_status'][$ctr] 			= $row['app_status'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		
	}

	function getRequestDetails(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_request';
		$joins 	   		= '';	
		$sql_where 		= "WHERE pkid_request = '".$return['pkid']."'";
		$sql_order 		= '';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['pkid_request'][$ctr] 			= $row['pkid_request'];
			$return['hr_ctrl_no'][$ctr] 			= $row['hr_ctrl_no'];
			$return['product_class'][$ctr] 			= $row['product_class'];
			$return['control_no'][$ctr] 			= $row['control_no'];
			$return['dept'][$ctr] 					= $row['dept'];
			$return['sec'][$ctr] 					= $row['sec'];
			$return['rft'][$ctr] 					= $row['rft'];
			$return['job_func'][$ctr] 				= $row['job_func'];
			$return['al_alloc'][$ctr] 				= $row['al_alloc'];
			$return['requested_by'][$ctr] 			= $row['requested_by'];
			$return['conformed_by'][$ctr] 			= $row['conformed_by'];
			$return['received_by'][$ctr] 			= $row['received_by'];
			$return['date_filed'][$ctr] 			= $row['date_filed'];
			$return['conf_status'][$ctr] 			= $row['conf_status'];
			$return['rec_status'][$ctr] 			= $row['rec_status'];
			$return['app_status'][$ctr] 			= $row['app_status'];
			$return['conformed_by'][$ctr] 			= $row['conformed_by'];
			$return['received_by'][$ctr] 			= $row['received_by'];
			$return['approved_by'][$ctr] 			= $row['approved_by'];
			$return['conf_remarks'][$ctr] 			= $row['conf_remarks'];
			$return['rec_remarks'][$ctr] 			= $row['rec_remarks'];
			$return['app_remarks'][$ctr] 			= $row['app_remarks'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo $result;
	}
	
	function getEmployeeList(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_trainees';
		$joins 	   		= '';	
		$sql_where 		= "WHERE fkid_pkid_request = '".$return['pkid']."' AND log_del = 0";
		$sql_order 		= '';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['pkid_trainees'][$ctr] 			= $row['pkid_trainees'];
			$return['date_hired'][$ctr] 			= $row['date_hired'];
			$return['emp_no'][$ctr] 				= $row['emp_no'];
			$return['emp_name'][$ctr] 				= $row['emp_name'];
			$return['from_station'][$ctr] 			= $row['from_station'];
			$return['from_line'][$ctr] 				= $row['from_line'];
			$return['to_station'][$ctr] 			= $row['to_station'];
			$return['to_line'][$ctr] 				= $row['to_line'];
			$return['dsfdsfsdfs'][$ctr] 				= $row['to_line'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo $result;
	}
	
	function getRequestorDetails(){
		
		require_once('../dbcon/hris_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_useraccnt';
		$joins 	   		= '';	
		$sql_where 		= "WHERE email_add = '".$return['email']."'";
		$sql_order 		= '';
		$sql_limit 		= 'LIMIT 0,1';
		$result 		= HRIS2::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['lastname'][$ctr] 			= $row['LN'];
			$return['firstname'][$ctr] 			= $row['FN'];
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo $result;
	}
	
	function conform_request(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('conf_status','conf_remarks');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		$array_values	= array('1',$return['txt_remarks']);
		$pkid			= $return['pkid'];
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);
		
	}

	function conform_request_disapprove(){		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('conf_status','conf_remarks');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		$array_values	= array('3',$return['txt_remarks']);
		$pkid			= $return['pkid'];
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);
		
	}

	function conform_request_return(){		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('conf_status','conf_remarks');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		$array_values	= array('4',$return['txt_remarks']);
		$pkid			= $return['pkid'];
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);
		
	}

	function send_email_conformance(){//novs edit
		
		require('./PHPMailer/class.phpmailer.php');
		require_once('../oop/rapid_oop.php');
		
		// $mail = new PHPMailer();//novs 
		$pkid = $_POST['pkid'];
		// $result = RAPID::getInstance()->request_info($pkid);
		$result = RAPID::getInstance()->request_info($pkid);
		
		$return = $_POST;
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['date_filed'][$ctr]		= date('F d, Y', strtotime($row['date_filed']));
			$return['control_no'][$ctr] 	= $row['control_no'];
			$return['dept'][$ctr] 			= $row['dept'];
			$return['sec'][$ctr] 			= $row['sec'];
			$return['rft'][$ctr] 			= $row['rft'];
			$return['job_func'][$ctr] 		= $row['job_func'];
			$return['al_alloc'][$ctr] 		= $row['al_alloc'];
			$return['requested_by'][$ctr] 	= $row['requested_by'];
			$return['conformed_by'][$ctr] 	= $row['conformed_by'];
			$ctr++;
		}
		
		require_once('../pages/email_setup/email_request.php');
		
		$getQcReciever = RAPID::getInstance()->collectQC();
		$ctr2 = 0;
		while($rowQC = mysqli_fetch_array($getQcReciever)){
			$qc['email'][$ctr2]		= $rowQC['email'];
			$ctr2++;
		}
		
        require_once('./email_config.php');                      	// TCP port to connect to	
		$mail->From = $return['email'];
		$mail->FromName = 'RFT System';
		
		$count = 0;
		for($x = 0; $x < $ctr2 ; $x++){
			$mail->AddAddress($qc['email'][$count]);//novs, add this if requested, notify some receiver
			$count++;
		}
		$mail->AddBCC('naayes@pricon.ph');
		$mail->AddCC($return['requested_by'][0]);
		$mail->AddCC($return['email']);
		$mail->ConfirmReadingTo = $return['email'];

		// $mail->From = 'naayes@pricon.ph';
		// $mail->FromName = 'RFT System';
		
		// $count = 0;
		// for($x = 0; $x < $ctr2 ; $x++){
		// 	$mail->AddAddress('naayes@pricon.ph');
		// 	$count++;
		// }
		
		// $mail->AddBCC('naayes@pricon.ph');
		// $mail->AddCC('naayes@pricon.ph');		
		// $mail->ConfirmReadingTo = 'naayes@pricon.ph';

		$mail->IsHTML(true); 
		$mail->Subject = "RFT System: Request Conformed ".date('Y-m-d');
		$mail->Body= $body;
		
		if(!$mail->Send())
		{
		   $msg = "Error Sending. <p>";
		   $msg .= "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$msg = "Email sent!";
		}
		
		$json_array['msg'] = $msg;
		echo json_encode($json_array);
		
	}

	function send_email_conformance_disapprove(){
		require('./PHPMailer/class.phpmailer.php');
		require_once('../oop/rapid_oop.php');
		
		// $mail = new PHPMailer();//novs 
		$pkid = $_POST['pkid'];
		// $result = RAPID::getInstance()->request_info($pkid);
		$result = RAPID::getInstance()->request_info($pkid);
		
		$return = $_POST;
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['date_filed'][$ctr]		= date('F d, Y', strtotime($row['date_filed']));
			$return['control_no'][$ctr] 	= $row['control_no'];
			$return['dept'][$ctr] 			= $row['dept'];
			$return['sec'][$ctr] 			= $row['sec'];
			$return['rft'][$ctr] 			= $row['rft'];
			$return['job_func'][$ctr] 		= $row['job_func'];
			$return['al_alloc'][$ctr] 		= $row['al_alloc'];
			$return['requested_by'][$ctr] 	= $row['requested_by'];
			$return['conformed_by'][$ctr] 	= $row['conformed_by'];

			$return['conf_remarks'][$ctr] 	= $row['conf_remarks'];//novs add
			$return['rec_remarks'][$ctr] 	= $row['rec_remarks'];//novs add
			$return['app_remarks'][$ctr] 	= $row['app_remarks'];//novs add
			$ctr++;
		}
		
		require_once('../pages/email_setup/email_request_disapprove.php');
		
		$getQcReciever = RAPID::getInstance()->collectQC();
		$ctr2 = 0;
		while($rowQC = mysqli_fetch_array($getQcReciever)){
			$qc['email'][$ctr2]		= $rowQC['email'];
			$ctr2++;
		}
		
        require_once('./email_config.php');                      	// TCP port to connect to	
		$mail->From = $return['email'];
		$mail->FromName = 'RFT System';
		
		$count = 0;
		for($x = 0; $x < $ctr2 ; $x++){
			$mail->AddAddress($qc['email'][$count]);
			$count++;
		}
		
		$mail->AddBCC('naayes@pricon.ph');
		$mail->AddAddress($return['requested_by'][0]);		
		$mail->AddCC($return['email']);
		$mail->ConfirmReadingTo = $return['email'];

		// $mail->From = 'naayes@pricon.ph';
		// $mail->FromName = 'RFT System';
		
		// $count = 0;
		// for($x = 0; $x < $ctr2 ; $x++){
		// 	$mail->AddAddress('naayes@pricon.ph');
		// 	$count++;
		// }
		
		// $mail->AddBCC('naayes@pricon.ph');
		// $mail->AddAddress('naayes@pricon.ph');		
		// $mail->AddCC('naayes@pricon.ph');		
		// $mail->ConfirmReadingTo = 'naayes@pricon.ph';

		$mail->IsHTML(true); 
		$mail->Subject = "RFT System: Request Disapproved ".date('Y-m-d');
		$mail->Body= $body;
		
		if(!$mail->Send())
		{
		   $msg = "Error Sending. <p>";
		   $msg .= "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$msg = "Email sent!";
		}
		
		$json_array['msg'] = $msg;
		echo json_encode($json_array);
	}

	function send_email_conformance_return(){
		require('./PHPMailer/class.phpmailer.php');
		require_once('../oop/rapid_oop.php');
		
		// $mail = new PHPMailer();//novs 
		$pkid = $_POST['pkid'];
		// $result = RAPID::getInstance()->request_info($pkid);
		$result = RAPID::getInstance()->request_info($pkid);
		
		$return = $_POST;
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['date_filed'][$ctr]		= date('F d, Y', strtotime($row['date_filed']));
			$return['control_no'][$ctr] 	= $row['control_no'];
			$return['dept'][$ctr] 			= $row['dept'];
			$return['sec'][$ctr] 			= $row['sec'];
			$return['rft'][$ctr] 			= $row['rft'];
			$return['job_func'][$ctr] 		= $row['job_func'];
			$return['al_alloc'][$ctr] 		= $row['al_alloc'];
			$return['requested_by'][$ctr] 	= $row['requested_by'];
			$return['conformed_by'][$ctr] 	= $row['conformed_by'];

			$return['conf_remarks'][$ctr] 	= $row['conf_remarks'];//novs add
			$return['rec_remarks'][$ctr] 	= $row['rec_remarks'];//novs add
			$return['app_remarks'][$ctr] 	= $row['app_remarks'];//novs add
			$ctr++;
		}
		
		require_once('../pages/email_setup/email_request_return.php');
		
		$getQcReciever = RAPID::getInstance()->collectQC();
		$ctr2 = 0;
		while($rowQC = mysqli_fetch_array($getQcReciever)){
			$qc['email'][$ctr2]		= $rowQC['email'];
			$ctr2++;
		}
		
        require_once('./email_config.php');                      	// TCP port to connect to	
		$mail->From = $return['email'];
		$mail->FromName = 'RFT System';
		
		$count = 0;
		for($x = 0; $x < $ctr2 ; $x++){
			// $mail->AddAddress($qc['email'][$count]);//include this if requested by ma'am cnpoblete, etc. form the table qc
			$count++;
		}
		
		$mail->AddBCC('naayes@pricon.ph');
		$mail->AddAddress($return['requested_by'][0]);		
		// $mail->AddCC($return['email']);		
		$mail->ConfirmReadingTo = $return['email'];

		// $mail->From = 'naayes@pricon.ph';
		// $mail->FromName = 'RFT System';
		
		// $count = 0;
		// for($x = 0; $x < $ctr2 ; $x++){
		// 	$mail->AddAddress('naayes@pricon.ph');
		// 	$count++;
		// }
		
		// $mail->AddBCC('naayes@pricon.ph');
		// $mail->AddAddress('naayes@pricon.ph');		
		// $mail->AddCC('naayes@pricon.ph');		
		// $mail->ConfirmReadingTo = 'naayes@pricon.ph';

		$mail->IsHTML(true); 
		$mail->Subject = "RFT System: Request Returned For Revision ".date('Y-m-d');
		$mail->Body= $body;
		
		if(!$mail->Send())
		{
		   $msg = "Error Sending. <p>";
		   $msg .= "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$msg = "Email sent!";
		}
		
		$json_array['msg'] = $msg;
		echo json_encode($json_array);
	}
	
	#receiving
	function display_receiving(){
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_request';
		$joins 	   		= '';	
		// $sql_where 		= "WHERE (rec_status = '0' OR app_status = '0') AND log_del = '0'";
		$sql_where 		= "WHERE log_del = '0' AND conf_status = 1 AND
			( conf_status != 3 AND rec_status != 3 AND app_status != 3 AND conf_status != 4 AND rec_status != 4 AND app_status != 4 AND app_status != 1 )";
		$sql_order 		= 'ORDER BY pkid_request DESC';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['pkid_request'][$ctr] 			= $row['pkid_request'];
			$return['hr_ctrl_no'][$ctr] 			= $row['hr_ctrl_no'];
			$return['control_no'][$ctr] 			= $row['control_no'];
			$return['date_filed'][$ctr] 			= $row['date_filed'];
			$return['conf_status'][$ctr] 			= $row['conf_status'];
			$return['rec_status'][$ctr] 			= $row['rec_status'];
			$return['app_status'][$ctr] 			= $row['app_status'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo $result;
	}
	
	function process_controlno(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('pkid_request','ctrlno_counter');
		$table 	   		= 'tbl_request';
		$joins 	   		= '';
		$sql_where 		= '';
		$sql_order 		= 'ORDER BY ctrlno_counter DESC';
		$sql_limit 		= 'LIMIT 0,1';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['pkid_request'][$ctr] 			= $row['pkid_request'];
			$counter						 		= $row['ctrlno_counter'];
			$ctr++;
		}
		
		$counter++;
		
		// $save_increment = $return['pkid_request'][0]+1;
		
		$currentDate = date("ym");
		
		// save_increment($save_increment);
		
		$ctrlno = "TU-".$currentDate."-".$counter."";
		
		$return['ctrlno'] = $ctrlno;
		$return['counter'] = $counter;
		$return['ctr']	   = $ctr;
		$return['result']  = json_encode($result);
		echo json_encode($return);
		
	}
	
	function save_increment($save_increment){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('ctrlno_counter');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		$array_values	= array($return['ctrl_no']);
		$pkid			= $save_increment;
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);
		
	}
	
	function display_list_of_received(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_request ';
		$joins 	   		= '';	
		$sql_where 		= "WHERE log_del = '0' AND rec_status = 1 AND
			( conf_status != 3 AND rec_status != 3 AND app_status != 3 AND conf_status != 4 AND rec_status != 4 AND app_status != 4 )";
		$sql_order 		= 'ORDER BY pkid_request DESC';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['pkid_request'][$ctr] 			= $row['pkid_request'];
			$return['hr_ctrl_no'][$ctr] 			= $row['hr_ctrl_no'];
			$return['control_no'][$ctr] 			= $row['control_no'];
			$return['date_filed'][$ctr] 			= $row['date_filed'];
			$return['requested_by'][$ctr] 			= $row['requested_by'];
			$return['remarks'][$ctr] 				= $row['remarks'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		
	}
	
	// edited funtion
	function display_list_of_trainees(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_trainees';
		$joins 	   		= 'LEFT JOIN  tbl_request ON tbl_trainees.fkid_pkid_request = tbl_request.pkid_request ';
		$sql_where 		= "WHERE tbl_trainees.log_del = '0' AND tbl_request.log_del = '0' AND rec_status = 1 AND ( conf_status != 3 AND rec_status != 3 AND app_status != 3 AND conf_status != 4 AND rec_status != 4 AND app_status != 4 )";
		if(isset($_POST["id"])){
			$sql_where 		= "WHERE tbl_trainees.log_del = '0' AND tbl_request.log_del = '0' AND rec_status = 1 AND tbl_request.pkid_request = " . $_POST["id"] . " AND ( conf_status != 3 AND rec_status != 3 AND app_status != 3 AND conf_status != 4 AND rec_status != 4 AND app_status != 4 )";
		}
		$sql_order 		= 'ORDER BY pkid_trainees DESC';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['traineeNo'][$ctr] 				= $row['pkid_trainees'];
			$return['emp_no'][$ctr] 				= $row['emp_no'];
			$return['emp_name'][$ctr] 				= $row['emp_name'];
			$return['control_no'][$ctr] 			= $row['control_no'];
			$return['date_filed'][$ctr] 			= $row['date_filed'];
			$return['requested_by'][$ctr] 			= $row['requested_by'];
			$return['date_hired'][$ctr] 			= $row['date_hired'];
			$return['requestNo'][$ctr] 				= $row['pkid_request'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo $result;
		
	}
	
	function receive_request(){
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		// $array_fields 	= array('ctrlno_counter','control_no','received_by','rec_status','rec_remarks','approved_by');
		$array_fields 	= array('ctrlno_counter','control_no','received_by','rec_status','rec_remarks');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		// $array_values	= array($return['counter'],$return['ctrl_no'],$return['receiver'],'1',$return['txt_remarks'],'rdmorallos@pricon.ph'); //novs
		// $array_values	= array($return['counter'],$return['ctrl_no'],$return['receiver'],'1',$return['txt_remarks']); //enable this
		$array_values	= array($return['counter'],$return['ctrl_no'],$return['receiver'],'1',$return['txt_remarks']);//remove this
		$pkid			= $return['pkid'];
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);
		
	}
	
	function receive_request_disapprove(){
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('rec_status','rec_remarks');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		$array_values	= array('3',$return['txt_remarks']);
		$pkid			= $return['pkid'];
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);		
	}

	function receive_request_return(){
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('conf_status','rec_status','rec_remarks');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		$array_values	= array('4','4',$return['txt_remarks']);
		$pkid			= $return['pkid'];
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);		
	}

	function display_approval(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_request';
		$joins 	   		= '';	
		// $sql_where 		= "WHERE app_status = '0' AND approved_by = '".$return['credential']."' AND log_del = '0'";
		$sql_where 		= "WHERE log_del = '0' AND approved_by = '".$return['credential']."'  AND rec_status = 1 AND 
			( conf_status != 3 AND rec_status != 3 AND app_status != 3 AND conf_status != 4 AND rec_status != 4 AND app_status != 4 AND app_status != 1 )";
		$sql_order 		= 'ORDER BY pkid_request DESC';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['pkid_request'][$ctr] 			= $row['pkid_request'];
			$return['hr_ctrl_no'][$ctr] 			= $row['hr_ctrl_no'];
			$return['control_no'][$ctr] 			= $row['control_no'];
			$return['date_filed'][$ctr] 			= $row['date_filed'];
			$return['conf_status'][$ctr] 			= $row['conf_status'];
			$return['rec_status'][$ctr] 			= $row['rec_status'];
			$return['app_status'][$ctr] 			= $row['app_status'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo $result;
		
	}
	
	function send_email_receive(){//novs edit
		
		require('./PHPMailer/class.phpmailer.php');
		require_once('../oop/rapid_oop.php');
		
		// $mail = new PHPMailer(); //novs 
		$pkid = $_POST['pkid'];
		$result = RAPID::getInstance()->request_info($pkid);
		
		$return = $_POST;
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['date_filed'][$ctr]		= date('F d, Y', strtotime($row['date_filed']));
			$return['control_no'][$ctr] 	= $row['control_no'];
			$return['dept'][$ctr] 			= $row['dept'];
			$return['sec'][$ctr] 			= $row['sec'];
			$return['rft'][$ctr] 			= $row['rft'];
			$return['job_func'][$ctr] 		= $row['job_func'];
			$return['al_alloc'][$ctr] 		= $row['al_alloc'];
			$return['requested_by'][$ctr] 	= $row['requested_by'];
			$return['conformed_by'][$ctr] 	= $row['conformed_by'];
			$return['approved_by'][$ctr] 	= $row['approved_by'];
			$ctr++;
		}
		
		require_once('../pages/email_setup/email_request.php');
		
        require_once('./email_config.php');                      	// TCP port to connect to
		$mail->From = $return['email'];
		$mail->FromName = 'RFT System';
		$mail->AddAddress($return['approved_by'][0]);//novs edit
		// $mail->AddAddress('rdmorallos@pricon.ph');
		$mail->AddCC($return['requested_by'][0]);
		// $mail->AddCC('cnpoblete@pricon.ph');//novs edit
		$mail->AddCC($return['email']);//novs edit
		$mail->AddBCC('naayes@pricon.ph');	
		$mail->ConfirmReadingTo = $return['email'];

		// $mail->From = 'naayes@pricon.ph';
		// $mail->FromName = 'RFT System';
		// $mail->AddAddress('naayes@pricon.ph');
		// $mail->AddCC('naayes@pricon.ph');
		// $mail->AddCC('naayes@pricon.ph');
		// $mail->AddBCC('naayes@pricon.ph');	
		// $mail->ConfirmReadingTo = 'naayes@pricon.ph';

		$mail->IsHTML(true); 
		$mail->Subject = "RFT System: Request Received / To Final Approver ".date('Y-m-d');
		$mail->Body= $body;
		
		if(!$mail->Send())
		{
		   $msg = "Error Sending. <p>";
		   $msg .= "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$msg = "Email sent!";
		}
		
		$json_array['msg'] = $msg;
		echo json_encode($json_array);
		
	}
	
	#approval
	function approve_request(){
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('app_status','app_remarks');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		$array_values	= array('1',$return['txt_remarks']);
		$pkid			= $return['pkid'];
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);
		
	}

	function approve_request_disapprove(){
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('app_status','app_remarks');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		$array_values	= array('3',$return['txt_remarks']);
		$pkid			= $return['pkid'];
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);		
	}

	function approve_request_return(){
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('conf_status','rec_status','app_status','app_remarks');
		$table 	   		= 'tbl_request';
		$sql_where 		= "pkid_request";
		$array_values	= array('4','4','4',$return['txt_remarks']);
		$pkid			= $return['pkid']; 
		$result 		= RAPID::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$sql_where);
		
		echo json_encode($return);		
	}

	function display_approved(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_request';
		$joins 	   		= '';	
		$sql_where 		= "WHERE log_del = '0' AND app_status = 1 AND
			( conf_status != 3 AND rec_status != 3 AND app_status != 3 AND conf_status != 4 AND rec_status != 4 AND app_status != 4 )";
		$sql_order 		= 'ORDER BY pkid_request DESC';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['pkid_request'][$ctr] 			= $row['pkid_request'];
			$return['hr_ctrl_no'][$ctr] 			= $row['hr_ctrl_no'];
			$return['control_no'][$ctr] 			= $row['control_no'];
			$return['date_filed'][$ctr] 			= $row['date_filed'];
			$return['requested_by'][$ctr] 			= $row['requested_by'];
			$return['remarks'][$ctr] 				= $row['remarks'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo $result;
	}
	
	function display_user_access_list(){
		
		require_once('../oop/rapid_oop.php');
		
		$return 		= $_POST;
		$result 		= '';
		$array_fields 	= array('*');
		$table 	   		= 'tbl_access';
		$joins 	   		= '';	
		$sql_where 		= '';
		$sql_order 		= '';
		$sql_limit 		= '';
		$result 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['RequestNo'][$ctr] 				= $row['pkid_access'];
			$return['Name'][$ctr] 					= $row['name'];
			$return['Email'][$ctr] 					= $row['email_add'];
			$return['Welcome'][$ctr] 				= $row['welcome'];
			$return['Request'][$ctr] 				= $row['request'];
			$return['Conformance'][$ctr] 			= $row['conformance'];
			$return['Receiving'][$ctr] 				= $row['receiving'];
			$return['Approval'][$ctr] 				= $row['approval'];
			$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		
	}
	
	function add_user_access(){
	
		require_once('../oop/rapid_oop.php');
		
		// $fullname = $_POST['name_access_firstname'].', '.$_POST['name_access_lastname'];
		$name_rad_welcome = isset($_POST['name_rad_welcome']) ? $_POST['name_rad_welcome'] : 0;
		$name_rad_request = isset($_POST['name_rad_request']) ? $_POST['name_rad_request'] : 0;
		$name_rad_conformance = isset($_POST['name_rad_conformance']) ? $_POST['name_rad_conformance'] : 0;
		$name_rad_receiving = isset($_POST['name_rad_receiving']) ? $_POST['name_rad_receiving'] : 0;
		$name_rad_approval = isset($_POST['name_rad_approval']) ? $_POST['name_rad_approval'] : 0;
		
		$return			= $_POST;
		$result			= '';
		$table			= 'tbl_access';
		$array_fields 	= array('name', 'email_add', 'welcome', 'request', 'conformance', 'receiving', 'approval');
		$array_values 	= array($return['name_access_lastname'],$return['name_access_email'],$name_rad_welcome,$name_rad_request,$name_rad_conformance,$name_rad_receiving,$name_rad_approval); 
		$result 		= RAPID::getInstance()->insert_query_id($table,$array_fields,$array_values);
		
		$return['new_id'] = json_encode($result);
		echo json_encode($return);
		
	}
	
	function get_lastname(){
		
		require_once('../oop/hris_oop.php');
		
		$result 		= '';
		$return 		= $_POST;
		$array_fields	= array('pkid','LN','FN','email_add');
		$table			= 'tbl_useraccnt';
		$sql_where		= "WHERE LN like '%".$return['pattern']."%'";
		$joins			= '';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 1';
		$result			= HRIS2::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		if(!$result){
			echo mysql_error();
		}
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
		$return['pkid'][$ctr]				= $row['pkid'];
		$return['LastName'][$ctr]			= $row['LN'];
		$return['FirstName'][$ctr]			= $row['FN'];
		$return['email_add'][$ctr]			= $row['email_add'];
		
		$ctr++;
		}
		
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
		// echo  $result;
	
	}
	
	function get_email_ln(){
	
		require_once('../oop/hris_oop.php');
		
		$result 		= '';
		$return 		= $_POST;
		$array_fields	= array('email_add');
		$table			= 'tbl_useraccnt';
		$sql_where		= "WHERE LN = '".$return['name']."'";
		$joins			= '';
		$sql_order		= '';
		$sql_limit		= 'LIMIT 1';
		$result			= HRIS2::getInstance()->select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		
		echo $result;
	}
	
	function send_email_approval(){//novs edit
		
		require('./PHPMailer/class.phpmailer.php');
		require_once('../oop/rapid_oop.php');
		
		// $mail = new PHPMailer();//novs
		$pkid = $_POST['pkid'];
		$result = RAPID::getInstance()->request_info($pkid);
		
		$return = $_POST;
		
		$ctr = 0;
		
		while($row = mysqli_fetch_array($result)){
			$return['date_filed'][$ctr]		= date('F d, Y', strtotime($row['date_filed']));
			$return['control_no'][$ctr] 	= $row['control_no'];
			$return['dept'][$ctr] 			= $row['dept'];
			$return['sec'][$ctr] 			= $row['sec'];
			$return['rft'][$ctr] 			= $row['rft'];
			$return['job_func'][$ctr] 		= $row['job_func'];
			$return['al_alloc'][$ctr] 		= $row['al_alloc'];
			$return['requested_by'][$ctr] 	= $row['requested_by'];
			$return['conformed_by'][$ctr] 	= $row['conformed_by'];
			$ctr++;
		}
		
		require_once('../pages/email_setup/email_request.php');
		
        require_once('./email_config.php');                      	// TCP port to connect to
		$mail->From = $return['email'];
		$mail->FromName = 'RFT System';
		$mail->AddAddress($return['requested_by'][0]);
		$mail->AddCC($return['email']);//novs edit
		// $mail->AddCC($return['conformed_by'][0]);
		// $mail->AddCC('cnpoblete@pricon.ph');
		$mail->AddBCC('naayes@pricon.ph');	
		$mail->ConfirmReadingTo = $return['email'];

		// $mail->From = 'naayes@pricon.ph';
		// $mail->FromName = 'RFT System';
		// $mail->AddAddress('naayes@pricon.ph');
		// $mail->AddCC('naayes@pricon.ph');
		// $mail->AddCC('naayes@pricon.ph');
		// $mail->AddBCC('naayes@pricon.ph');	
		// $mail->ConfirmReadingTo = 'naayes@pricon.ph';

		$mail->IsHTML(true); 
		$mail->Subject = "RFT System: Request Approved ".date('Y-m-d');
		$mail->Body= $body;
		
		if(!$mail->Send())
		{
		   $msg = "Error Sending. <p>";
		   $msg .= "Mailer Error: " . $mail->ErrorInfo;
		} else {
			$msg = "Email sent!";
		}
		
		$json_array['msg'] = $msg;
		echo json_encode($json_array);
		
	}
	
	
	
	
?>