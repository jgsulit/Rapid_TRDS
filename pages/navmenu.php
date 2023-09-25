<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include_once('media/includes.php');
	include_once('../dbcon/hris_oop.php');
	include_once('../oop/rapid_oop.php');
	
	session_start();
	
	$accountType = $_SESSION['rapidUserAccountType'];
	
	if (array_key_exists('username',$_SESSION))
	{
	
		$username = $_SESSION['username'];
		// $username = 'jcfeliciano';
		// $username = 'marlope';
		 // $username = 'mylsiba';
		// $username = 'marmala';
		// $username = 'cnpoblete';
		 // $username = 'rdmorallos';
		 // $username = 'vcrelativo';
		 // $username = 'acelcag';
		
		// $getEmpNo 	= HRIS::getInstance()->getEmpNo($username); 
		// $rowEmpNo 	= mysqli_fetch_array($getEmpNo);
		// $empNo 		= $rowEmpNo['empno'];

		// $getEmail 	= HRIS2::getInstance()->getEmailLink($empNo);
		// $rowEmail	= mysqli_fetch_array($getEmail);
		// $empEmail 	= $rowEmail['email_add'];
		
		// $getEmpInfo = HRIS::getInstance()->getRequestorInfo($empNo);
		// $rowEmpInfo = mysqli_fetch_array($getEmpInfo); 
		// $empName 	= $rowEmpInfo['FirstName'] . " " . substr($rowEmpInfo['MiddleName'], 0, 1) . ". " .$rowEmpInfo['LastName'];
		// $empName2 	= substr($rowEmpInfo['FirstName'], 0, 1) .". ".$rowEmpInfo['LastName'];
		// $empName3 	= $rowEmpInfo['FirstName'];
		
		$getEmpNo 	= RAPID::getInstance()->getEmpNo($username); 
		$rowEmpNo 	= mysqli_fetch_array($getEmpNo);
		$empNo 		= $rowEmpNo['empno'];

		$getEmail 	= RAPID::getInstance()->getEmailLink($empNo);
		$rowEmail	= mysqli_fetch_array($getEmail);
		$empEmail 	= $rowEmail['email_add'];
		
		if($empEmail == '') {
			$getEmail 	= HRIS2::getInstance()->getEmailLink($empNo);
			$rowEmail	= mysqli_fetch_array($getEmail);
			$empEmail 	= $rowEmail['email_add'];
		}
		
		$getEmpInfo = RAPID::getInstance()->getRequestorInfo($empNo);
		$rowEmpInfo = mysqli_fetch_array($getEmpInfo); 
		$empName 	= $rowEmpInfo['name'];
		
	}else{
	
		RAPID::getInstance()->checklog();
	
	}
	
	require_once('../oop/rapid_oop.php');
							
	$getAccess 	= RAPID::getInstance()->checkAccess($empEmail);
	$accessRow 	= mysqli_fetch_array($getAccess);
	$accessKey 	= $accessRow['request'];
	$specialKey = $accessRow['special'];

?>

<style>

	.btn {
		border-radius: 0px;
	}
	
	.whiteBG {
		background-color: #fff;
	}
	
</style>

<html>

	<head>
		
		<? require_once('header.php'); ?>
		
	</head>

	<body>
	
		<header>
		
			<div class="navbar navbar-default navbar-static-top whiteBG">
			
				<div class="container-fluid">
				
					<div class="navbar-header">
					
						<button type="button" class="navbar-toggle whiteBG" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						
						<a class="navbar-brand" href="#">
							<img alt="Brand" width="30" height="30" style="max-width:100px; margin-top: -7px;" src="./media/images/laptop.png"> <p style="margin-top: -22px; padding-left: 40px; font-size: 20px; color: #9f00a7;">REQUEST FOR TRAINING (on maintenance mode)</p>
						</a>
						
					</div>
					
					<div class="collapse navbar-collapse">
					
						<ul class="nav navbar-nav pull-right" style="margin-top: 0px;">
						
							<?php
								
								if($accessRow['welcome'] == '1'){echo '<li><a href="index.php?page=dashboard.php" style="color: #9f00a7;"><span class="fa fa-skyatlas" style="font-size: 20px; width: 22px; padding-right: 5px;"></span>  WELCOME</a></li>';}else{}
								if($accessRow['request'] == '1'){echo '<li><a href="index.php?page=request.php" style="color: #9f00a7;"><span class="fa fa-plus" style="font-size: 20px; width: 22px;"></span>  REQUEST</a></li>';}else{}
								if($accessRow['conformance'] == '1'){echo '<li><a href="index.php?page=conformance.php" style="color: #9f00a7;"><span class="fa fa-user-plus" style="font-size: 20px; width: 22px;"></span>  CONFORMANCE</a></li>';}else{}
								if($accessRow['receiving'] == '1'){echo '<li><a href="index.php?page=receiving.php" style="color: #9f00a7;"><span class="fa fa-hand-o-right" style="font-size: 20px; width: 22px;"></span>  RECEIVING</a></li>';}else{}
								if($accessRow['receiving'] == '1'){echo '<li><a href="index.php?page=requestlist.php" style="color: #9f00a7;"><span class="fa fa-list" style="font-size: 20px; width: 22px;"></span>  LIST OF REQUESTS</a></li>';}else{}
								if($accessRow['receiving'] == '1'){echo '<li><a href="index.php?page=traineeslist.php" style="color: #9f00a7;"><span class="fa fa-list" style="font-size: 20px; width: 22px;"></span>  LIST OF TRAINEES</a></li>';}else{}
								if($accessRow['receiving'] == '1'){echo '<li><a href="index.php?page=settings.php" style="color: #9f00a7;"><span class="fa fa-cogs" style="font-size: 20px; width: 22px;"></span>  SETTINGS</a></li>';}else{}
								if($accessRow['approval'] == '1'){echo '<li><a href="index.php?page=approval.php" style="color: #9f00a7;"><span class="fa fa-thumbs-o-up" style="font-size: 20px; width: 22px;"></span>  APPROVALS</a></li>';}else{}
								
							?>
							
							<li >
								<a href="#" style="color: #9f00a7; font-size: 18px;">Hi  <?php echo $empName; ?>!</a>
							</li>
													
						</ul>
						
					</div>
				
				</div>
			
			</div>
		
		</header>

	</body>
	
</html>