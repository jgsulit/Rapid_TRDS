<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

?>

<style>
body {
    background-repeat: no-repeat;
	background-size: cover;
}

</style>

<html>

	<head>
		<input type="hidden" id="id_setAccess" value="<?=$accessKey?>">
		<input type="hidden" id="id_special" value="<?=$specialKey?>">
	</head>

	
	<body background="media\images\wallpaper3.jpg">
	
		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-md-4 col-md-offset-4">
						<div class="account-wall" style="background-color: #FFFFFF;">
							
							<div class="container-fluid">
								<center>
									<p><strong style="background-color: #603cba; color: #FFF;font-size: 25px; padding: 5px;">TRAINING UNIT</strong></p>
								</center>
							</div>
							
							<img class="profile-img" src=".\media\images\student.png" alt="">
							
							<center>
							
								<p>Hi! <?=$empName?>! </p>
								<p>Welcome to Training Request Processing System!</p>
								<p>This system provides data processing for production training request.</p>
								
								<div class="form-signin">
									<button class="btn btn-success btn-lg btn-block" id="btn_id_proceed">Proceed</button>
								</div>
								
								
							</center>
						</div>
					</div>
				</div>
			</div>	
			
		</section>
		
		<footer>
			<center>
			<p>Pricon Microelectronics Inc. ISS - All Rights Reserved &copy; <?php echo date("Y") ?></p>
			</center>
		</footer>
		
	</body>

	<script src="./js/dashboard.js?vx=1" language="javascript"></script>
	
</html>