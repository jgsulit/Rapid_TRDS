<?php
	class HRIS extends mysqli
	{
		private static $instance = null;
		
		//db connection config variables
		private $user = "root";
		private $pass = "";
		private $dbName = "db_subcon";
		// private $dbHost = "";
		private $dbHost = "";

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

		// METHOD SECTION
		
		
		
		public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
			$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
			return $this->query($query);
		}
		
		public function select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
			$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
			echo $query;
		}
		
		public function checklog(){
			echo "<script>alert('Your session has expired. Please log in again!');</script>";
			echo "<script>location.href = 'http://rapid/';</script>";
		}
		
		public function getEmpNo($username) {
			$query = "SELECT * FROM db_rapid.vw_user_accounts WHERE username ='".$username."' ";
			return $this->query($query);
		}
		
		public function getRequestorInfo($empNo) {
			$query = "SELECT tbl_EmployeeInfo.fkDepartment, tbl_EmployeeInfo.fkSection, tbl_EmployeeInfo.LastName, tbl_EmployeeInfo.FirstName, tbl_EmployeeInfo.MiddleName, tbl_Department.Department, tbl_Division.Division FROM db_hris.tbl_EmployeeInfo 
				INNER JOIN db_hris.tbl_Department ON tbl_Department.pkid = tbl_EmployeeInfo.fkDepartment INNER JOIN db_hris.tbl_Division ON tbl_Division.pkid = tbl_EmployeeInfo.fkDivision 
				WHERE tbl_EmployeeInfo.EmpNo='".$empNo."';";
			return $this->query($query);
		} 
		
		//sendEmail
		public function getEmailAdd($key, $cont1, $cont2) {
			if($key == "EN") {
				$query = "SELECT tbl_useraccnt.email_add FROM db_hris.tbl_EmployeeInfo INNER JOIN db_acl.tbl_useraccnt ON tbl_useraccnt.fkEmployee = tbl_EmployeeInfo.pkid WHERE tbl_EmployeeInfo.EmpNo='".$cont1."';";
				return $this->query($query);
			} else if($key == "NAME") {
				$query = "SELECT tbl_useraccnt.email_add FROM db_hris.tbl_EmployeeInfo INNER JOIN db_acl.tbl_useraccnt ON tbl_useraccnt.fkEmployee = tbl_EmployeeInfo.pkid WHERE tbl_EmployeeInfo.FirstName LIKE '%".$cont1."%' AND tbl_EmployeeInfo.LastName LIKE '%".$cont2."%'";
				return $this->query($query);
			}
			
		}
		
		public function getEmailLink($empNo) {
			
			$query = "SELECT * FROM db_rapid.vw_user_accounts WHERE empno='".$empNo."';";
			return $this->query($query);
			// return $query;
		
		}
		
	}
	
	class HRIS2 extends mysqli
	{
		private static $instance = null;
		
		//db connection config variables
		private $user = "root";
		private $pass = "";
		private $dbName = "db_acl";
		// private $dbHost = "";
		private $dbHost = "";

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

		// METHOD SECTION
		
		
		public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
			$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
			return $this->query($query);
		}
		
		
		public function select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
			$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
			// return $this->query($query);
			return $query;
		}
		
		
		public function getEmailLink($empNo) {
			
			// $query = "SELECT tbl_useraccnt.* FROM db_hris.tbl_EmployeeInfo INNER JOIN db_acl.tbl_useraccnt ON tbl_useraccnt.fkEmployee = tbl_EmployeeInfo.pkid WHERE tbl_EmployeeInfo.EmpNo='".$empNo."';";
			// $query = "SELECT tbl_useraccnt.* FROM db_hris.tbl_EmployeeInfo INNER JOIN db_acl.tbl_useraccnt ON tbl_useraccnt.fkEmployee = tbl_EmployeeInfo.pkid WHERE tbl_EmployeeInfo.EmpNo='".$empNo."';";
			$query = "SELECT * FROM db_rapid.vw_user_accounts WHERE empno ='".$empNo."';";
			return $this->query($query);
			// return $query;
		
		}
		
	}
	
	class HRIS3 extends mysqli
	{
		private static $instance = null;
		
		//db connection config variables
		private $user = "root";
		private $pass = "";
		private $dbName = "db_hris";
		// private $dbHost = "";
		private $dbHost = "";

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

		// METHOD SECTION
		
		public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
			$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
			return $this->query($query);
		}
		
		public function select_query_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
			$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
			return $query;
		}
		
		
	}
	
	class HRIS_SECHEADS extends mysqli
	{
		private static $instance = null;
		
		//db connection config variables
		private $user = "root";
		private $pass = "";
		private $dbName = "db_hris";
		// private $dbHost = "";
		private $dbHost = "";

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

		// METHOD SECTION
		
		public function checkLogin($username){
			$query = "SELECT SQL_CALC_FOUND_ROWS * FROM vw_secheads WHERE username = '{$username}';";
			return $this->query($query);
			
		}
		
	}

?>
