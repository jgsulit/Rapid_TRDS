<?php
	/* This email must send everyday, 12:00AM */
	echo send_for_retrieval_list();

	function send_for_retrieval_list() {
		require_once('../../oop/oop.php'); 
		require_once('../../oop/email_oop.php');
		
		/* Load all for retrieval documents */
		$result 	= "";
		$array_fields = array('doc_no', 'doc_title', 'rev_no', 'no_of_copy', 'requested_by', 'issued_dept_section', 'retrieval_number', 'retrieval_duedate', 'retrieval_remarks' , 'fkrequest');
		$table 	   	= 'vw_retrieval_details';
		$joins 	   	= '';
		$sql_where 	= 'WHERE retrieval_status != 2 AND retrieval_number != ""';
		$sql_order 	= 'ORDER BY retrieval_duedate ';
		$sql_limit 	= '';
		$tr_body 	= '';
		$to_array 	= array();
		$cc_array 	= array();
		$date_today = date('M d, Y');
		$result = DIRS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		// $script = DIRS::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		
		if($result->num_rows != 0) {
			while($row = mysqli_fetch_array($result)){
				$doc_no 			= $row['doc_no'];
				$doc_title 			= $row['doc_title'];
				$rev_no 			= $row['rev_no'];
				$no_of_copy 		= $row['no_of_copy'];
				$requested_by 		= $row['requested_by'];
				$issued_dept_section = $row['issued_dept_section'];
				$retrieval_number 	= $row['retrieval_number'];
				$retrieval_duedate 	= date('M d, Y',strtotime($row['retrieval_duedate']));
				$retrieval_remarks 	= $row['retrieval_remarks'];
				$fkrequest 			= $row['fkrequest'];
				
				$tr_body 	.= 		strtotime($retrieval_duedate) > strtotime($date_today) ? '<tr>' : '<tr bgcolor="red">';
				$tr_body 	.= '			<td>'.$doc_no.'</td>';
				$tr_body 	.= '			<td>'.$doc_title.'</td>';
				$tr_body 	.= '			<td><center>'.$rev_no.'</center></td>';
				$tr_body 	.= '			<td><center>'.$no_of_copy.'</center></td>';
				$tr_body 	.= '			<td>'.return_emp_name_by_username($requested_by).'</td>';
				$tr_body 	.= '			<td>'.$issued_dept_section.'</td>';
				$tr_body 	.= '			<td><center>'.$retrieval_number.'</center></td>';
				$tr_body 	.= '			<td><center>'.$retrieval_duedate.'</center></td>';
				$tr_body 	.= '			<td>'.$retrieval_remarks.'</td>';
				$tr_body 	.= '		</tr>';
				
				$requestor_email	= return_emp_email_add_by_username($requested_by);
				array_push($to_array,$requestor_email);
				
				$array_fields2 = array('superior');
				$table2 	   	= 'tbl_doc_request_main';
				$joins2 	   	= '';
				$sql_where2 	= 'WHERE pkid='.$fkrequest;
				$sql_order2 	= '';
				$sql_limit2 	= 'LIMIT 0,1';
				$result2 = DIRS::getInstance()->select_query($array_fields2,$table2,$joins2,$sql_where2,$sql_order2,$sql_limit2);
				if($row2 = mysqli_fetch_array($result2)) {
					$superior 			= $row2['superior'];
					$superior_email		= return_emp_email_add_by_username($superior);
					array_push($cc_array,$superior_email);
				}
			}
			
			/* Populate DCC emails and add on email recipients */
			$cc_recipients = array();
			$table_dcc_email 		= 'tbl_dcc_names';	
			$array_fields_dcc_email = array('dcc_email');
			$joins_dcc_email 	   	= '';
			$sql_where_dcc_email 	= 'WHERE logdel=0';
			$sql_order_dcc_email 	= '';
			$sql_limit_dcc_email 	= '';
			$result_dcc_email = DIRS::getInstance()->select_query($array_fields_dcc_email,$table_dcc_email,$joins_dcc_email,$sql_where_dcc_email,$sql_order_dcc_email,$sql_limit_dcc_email);
			while($row_dcc_email = mysqli_fetch_array($result_dcc_email)){
				array_push($cc_array,$row_dcc_email['dcc_email']);				
			}
			
			$to = implode(',',$to_array);
			$from 	= 'issinfoservice@pricon.ph';
			$cc = implode(',',$cc_array);
			
			$subject = 'For Retrieval Documents';
			$body 	 = 'Good day!<br>';
			$body 	.= 'Kindly submit the following documents to DCC on or before the deadline. <br><br>';
			$body 	.= '<table border=1>';
			$body 	.= '	<thead>';
			$body 	.= '		<th>Document Number</th>';
			$body 	.= '		<th>Document Title</th>';
			$body 	.= '		<th>Rev No</th>';
			$body 	.= '		<th>No. of Copy</th>';
			$body 	.= '		<th>Issued To</th>';
			$body 	.= '		<th>Department - Section</th>';
			$body 	.= '		<th>Retrieval Number</th>';
			$body 	.= '		<th>Due until</th>';
			$body 	.= '		<th>Remarks</th>';
			$body 	.= '	</thead>';
			$body 	.= '	<tbody>';		
			$body 	.= $tr_body;		
			$body 	.= '	</tbody>';
			$body 	.= '</table><br>';
			$body 	.= '*Documents highlighted in red are already overdue.';
			
			$php_mailer = new email();
			$msg = $php_mailer-> send_email($to, $from, $cc, $subject, $body,'');
			return ($msg == 'Message has been sent!' ? 'tru2e' : 'false');
			// return 'true';
		} else {
			return 'true';
		}
		
	}	

	function return_emp_name_by_username($username) {
		require_once('../class/oop.php'); //OOP Path
		$emp_info = array();
		$result = "";
		$array_fields = array('CONCAT(lastname,", ",firstname) as empname');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username="'.$username.'"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = SYS1_HRIS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$empname 	= $row['empname'];
		}
		return $empname;
	}

	function return_emp_email_add_by_username($username) {
		require_once('../class/oop.php'); //OOP Path
		$emp_info = array();
		$result = "";
		$array_fields = array('email_add');
		$table 	   	= 'db_hris.vw_EmpInfo_Rapid';
		$joins 	   	= '';
		$sql_where 	= 'WHERE username="'.$username.'"';
		$sql_order 	= '';
		$sql_limit 	= 'LIMIT 0,1';
		$result = SYS1_HRIS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		if($row = mysqli_fetch_array($result)){
			$email_add 	= $row['email_add'];
		}
		return $email_add;
	}
?>