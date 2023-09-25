<?php

	// class YPICS	
	// {
		
	// 	/* Establish Server Connection */
	// 	private function connect_DBM(){
			
	// 		$username = 'builder';
	// 		$password = '';
	// 		$db_name  = 'tpics_iscd2';
	// 		$server   = '192.168.3.251\MSSQLSERVER';
			
	// 		$this->db_handleM = mssql_connect($server,$username,$password);
	// 		return mssql_select_db($db_name,$this->db_handleM);
		
	// 	}
		
	// 	/* Disconnect from Server */
	// 	private function close_DBM(){
	// 		if(isset($this->db_handleM)){
	// 			mssql_close($this->db_handleM);
	// 		}
	// 	}
		
	// 	public function select_query($array_fields,$table,$joins,$sql_where,$sql_order){
			
	// 		$db_found = $this->connect_DBM();
		
	// 		if($db_found){
				
	// 			$array_fields = implode(",",$array_fields);
	// 			$SQL = "SELECT {$array_fields} FROM {$table} {$joins} {$sql_where} {$sql_order};";
	// 			$result = mssql_query($SQL);
	// 			return $result;
	// 			mssql_free_result($result);
	// 			// echo 'gg';
				
				
	// 		}else{
				
	// 			$errorMsg = "Database not found, Please contact your administrator";
	// 			return $errorMsg;
	// 		}
			
	// 		$this->close_DBM();
			
	// 	}
		
	// 	public function select_query_test($array_fields,$table,$joins,$sql_where,$sql_order){
			
	// 		$db_found = $this->connect_DBM();
		
	// 		if($db_found){
				
	// 			$array_fields = implode(",",$array_fields);
	// 			$SQL = "SELECT {$array_fields} FROM {$table} {$joins} {$sql_where} {$sql_order};";
	// 			return $SQL;
				
	// 		}else{
				
	// 			$errorMsg = "Database not found, Please contact your administrator";
	// 			return $errorMsg;
	// 		}
			
	// 		$this->close_DBM();
			
	// 	}
		
		
	// }
	
	class RAPID extends mysqli 
	{
		
		private static $instance = null;
	
		private $user = "root";	
		private $pass = ""; 
		private $dbName = "db_rft_v2"; 
		// private $dbName = "db_rft_test"; 
		private $dbHost = "localhost";
		
		//NO NEED TO CHANGE HERE 
		public static function getInstance() {
			if(!self::$instance instanceof self) 
			{
				self::$instance = new self;
			}
			return self::$instance;
		}

		public function __clone()
		{
			trigger_error('Clone is not allowed.',E_USER_ERROR);
		}
		
		public function __wakeup()
		{
			trigger_error('Deserializing is not allowed.',E_USER_ERROR);
		}
		
		private function __construct() {
			parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
			if(mysqli_connect_error())
			{
				exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
			}
			parent::set_charset('utf-8');
		}
		
		////////////////////////////////////UP TO HERE////////////////////////////////////////
	
		////////////////////////////////////PUBLIC FUNCTIONS STARTS HERE//////////////////////////////////////////////
		
		public function request_info($pkid){
			$query = "SELECT * FROM tbl_request WHERE pkid_request = '{$pkid}' LIMIT 0,1;";
			return $this->query($query);
			// return $query;
		}
		
		public function collectQC(){
			$query = "SELECT * FROM tbl_email_receive_module";
			return $this->query($query);
		}
		
		public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
			$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
			return $this->query($query);
		}
		
		public function select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $query;
		}
		
		public function insert_query($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$this->query($query);
		$this->save_logs('1',$query);
		}
		
		public function insert_query_id($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$result = $this->query($query);
		$new_pkid = $this->insert_id;
		return $new_pkid;
		}
		
		public function insert_query_test($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		return $query;
		}
		
		public function update_query($table,$array_fields,$array_values,$pkid,$where){
			$update_array =  $this->create_update_param($array_fields,$array_values);
			$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE {$where}='{$pkid}';";
			$this->query($query);
			$this->save_logs('2',$query);
		}
		
		public function update_query_test($table,$array_fields,$array_values,$pkid,$where){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE {$where}='{$pkid}';";
		return $query;
		}
		
		public function getEmails() {
			$query = 'SELECT * FROM tbl_mailReceipients WHERE logdel=0';
			return $this->query($query);
		}
		
		public function getAdmin($username){
			$query = "SELECT * FROM tbl_adminList WHERE userCode = '{$username}'";
			return $this->query($query);
		}
		
		public function getPath($ptisCode){
			$query = "SELECT * FROM vw_uploadList WHERE ptisNo = '$ptisCode'";
			return $this->query($query);
		}
		
		public function delete_query($table,$pkid){
		$query = "DELETE FROM {$table} WHERE `pkid` = '{$pkid}';";
		$this->query($query);
		$this->save_logs('3',$query);
		return "Record has been deleted";
		}
		
		public function delete_query_test($table,$pkid){
		$query = "DELETE FROM {$table} WHERE `pkid` = '{$pkid}';";
		return $query;
		}
		
		public function create_update_param($array_fields,$array_values){
		$array_update = array();
		for($i=0;$i<count($array_fields);$i++){
			$array_update[$i] = "`".$array_fields[$i]."` = "."'".$array_values[$i]."' ";
		}
		return $array_update;
		}
		
		public function save_logs($type,$query){
		$date_today = date('Y-m-d H:i:s');
		$new_query = str_replace("'",'"',$query);
		$logs = "INSERT INTO `tbl_logs` (`type_of_query`,`query`,`date`) VALUES('".$type."','".$new_query."','".$date_today."');";
		$this->query($logs);
		}
		
		public function add_quotations($array_values){
		$array_values_r = array();
		for($i=0;$i<count($array_values);$i++){
			$array_values_r[$i] = "'".$array_values[$i]."'";
		}
		return $array_values_r;
		}
		
		public function checkAccess($empEmail){
			$query = "SELECT * FROM tbl_access WHERE email_add = '{$empEmail}';";
			return $this->query($query);
		}
		
		public function getEmpNo($username) {
			$query = "SELECT * FROM db_rapid.vw_user_accounts WHERE username ='".$username."' ";
			return $this->query($query);
		}
		
		public function getEmailLink($empNo) {
			$query = "SELECT * FROM db_rapid.vw_user_accounts WHERE empno='".$empNo."';";
			return $this->query($query);	
		}
		
		public function getRequestorInfo($empNo) {
			$query = "SELECT * FROM db_rapid.vw_user_accounts WHERE empno='".$empNo."';";
			return $this->query($query);	
		}
		
		public function checklog(){
			echo "<script>alert('Your session has expired. Please log in again!');</script>";
			echo "<script>location.href = 'http://rapid/';</script>";
		}
		
		
	}
	
	class TRDS extends mysqli 
	{
		
		private static $instance = null;
	
		private $user = "rapidx";	
		private $pass = ""; 
		private $dbName = "db_training_record_ds"; 
		// private $dbName = "db_rft_test"; 
		private $dbHost = "";
		
		//NO NEED TO CHANGE HERE 
		public static function getInstance() {
			if(!self::$instance instanceof self) 
			{
				self::$instance = new self;
			}
			return self::$instance;
		}

		public function __clone()
		{
			trigger_error('Clone is not allowed.',E_USER_ERROR);
		}
		
		public function __wakeup()
		{
			trigger_error('Deserializing is not allowed.',E_USER_ERROR);
		}
		
		private function __construct() {
			parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
			if(mysqli_connect_error())
			{
				exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
			}
			parent::set_charset('utf-8');
		}
		
		////////////////////////////////////UP TO HERE////////////////////////////////////////
	
		////////////////////////////////////PUBLIC FUNCTIONS STARTS HERE//////////////////////////////////////////////
		
		public function getTRDSUsers(){
			$query = "SELECT * FROM users";
			return $this->query($query);
			// return $query;
		}
		
		public function collectQC(){
			$query = "SELECT * FROM tbl_email_receive_module";
			return $this->query($query);
		}
		
		public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
			$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
			return $this->query($query);
		}
		
		public function select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $query;
		}
		
		public function insert_query($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$this->query($query);
		$this->save_logs('1',$query);
		}
		
		public function insert_query_id($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$result = $this->query($query);
		$new_pkid = $this->insert_id;
		return $new_pkid;
		}
		
		public function insert_query_test($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		return $query;
		}
		
		public function update_query($table,$array_fields,$array_values,$pkid,$where){
			$update_array =  $this->create_update_param($array_fields,$array_values);
			$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE {$where}='{$pkid}';";
			$this->query($query);
			$this->save_logs('2',$query);
		}
		
		public function update_query_test($table,$array_fields,$array_values,$pkid,$where){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE {$where}='{$pkid}';";
		return $query;
		}
		
		public function getEmails() {
			$query = 'SELECT * FROM tbl_mailReceipients WHERE logdel=0';
			return $this->query($query);
		}
		
		public function getAdmin($username){
			$query = "SELECT * FROM tbl_adminList WHERE userCode = '{$username}'";
			return $this->query($query);
		}
		
		public function getPath($ptisCode){
			$query = "SELECT * FROM vw_uploadList WHERE ptisNo = '$ptisCode'";
			return $this->query($query);
		}
		
		public function delete_query($table,$pkid){
		$query = "DELETE FROM {$table} WHERE `pkid` = '{$pkid}';";
		$this->query($query);
		$this->save_logs('3',$query);
		return "Record has been deleted";
		}
		
		public function delete_query_test($table,$pkid){
		$query = "DELETE FROM {$table} WHERE `pkid` = '{$pkid}';";
		return $query;
		}
		
		public function create_update_param($array_fields,$array_values){
		$array_update = array();
		for($i=0;$i<count($array_fields);$i++){
			$array_update[$i] = "`".$array_fields[$i]."` = "."'".$array_values[$i]."' ";
		}
		return $array_update;
		}
		
		public function save_logs($type,$query){
		$date_today = date('Y-m-d H:i:s');
		$new_query = str_replace("'",'"',$query);
		$logs = "INSERT INTO `tbl_logs` (`type_of_query`,`query`,`date`) VALUES('".$type."','".$new_query."','".$date_today."');";
		$this->query($logs);
		}
		
		public function add_quotations($array_values){
		$array_values_r = array();
		for($i=0;$i<count($array_values);$i++){
			$array_values_r[$i] = "'".$array_values[$i]."'";
		}
		return $array_values_r;
		}
		
		public function checkAccess($empEmail){
			$query = "SELECT * FROM tbl_access WHERE email_add = '{$empEmail}';";
			return $this->query($query);
		}
		
		public function getEmpNo($username) {
			$query = "SELECT * FROM db_rapid.vw_user_accounts WHERE username ='".$username."' ";
			return $this->query($query);
		}
		
		public function getEmailLink($empNo) {
			$query = "SELECT * FROM db_rapid.vw_user_accounts WHERE empno='".$empNo."';";
			return $this->query($query);	
		}
		
		public function getRequestorInfo($empNo) {
			$query = "SELECT * FROM db_rapid.vw_user_accounts WHERE empno='".$empNo."';";
			return $this->query($query);	
		}
		
		public function checklog(){
			echo "<script>alert('Your session has expired. Please log in again!');</script>";
			echo "<script>location.href = 'http://rapid/';</script>";
		}
		
		
	}

	class SENDMAILxx //novs edit
	{
		
		//function emailMultipleRecipients($from,$fromName,$recipient,$CCrecipient,$subject,$message,$attachment){ //reserved if there are attachments
		function emailMultipleRecipientsxx($from,$fromName,$recipient,$CCrecipient,$subject,$message){ //without attachement  //novs edit
			$recipientArray = explode(",",$recipient);
			$ccArray = explode(',',$CCrecipient);
			//$attachmentArray = explode(',',$attachment);
			$mail = new PHPMailer();
			$mail->From = $from;
			$mail->FromName = $fromName; //from name name that will displayed when sending mail
			
			//loop to all recipients
			$ctr = 0;
			while($ctr<count($recipientArray)){
				$mail->AddAddress($recipientArray[$ctr]);
				$ctr++;
			}
			//loop for all CC
			$ctr = 0;
			while($ctr<count($ccArray)){
				$mail->AddCC($ccArray[$ctr]);
				$ctr++;
			}
			//$mail->AddBCC("marlope@pricon.ph");
			//$mail->AddReplyTo("marlope@pricon.com", "Information"); //reply goes thru here
			$mail->WordWrap = 50;                             // set word wrap to 50 characters
			/*
			$ctr = 0;
			while($ctr<count($attachment)){	//reserved for attachments;
				$mail->AddAttachment($attachment[$ctr]);
				$ctr++;
			}
			*/
			//$mail->AddAttachment("./testAttach2.txt");        // add attachments
			$mail->IsHTML(true);    // set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $message;

			//validation if mail has been sent
			if(!$mail->Send())
			{
			   echo "Message could not be sent. <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			   exit;
			}else{
				echo "Message Sent!. <p>";
			}
		}
	}
	
?>