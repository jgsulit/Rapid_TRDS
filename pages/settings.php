<?php


?>

<html lang="eng">

	<head>
	
		<style>
			
			td, tr {
				 text-align:center; 
				 vertical-align:middle;
			}
		
		</style>
		
	</head>
	
	<body>
	
		<header>
		
			<div class="container">
				
				<div class="row">
				
					<div class="col-sm-12">
					
						<br>
						
						<h3>USER ACCESS LIST</h3>
						
					</div>
					
				</div>
				
			</div>
			
		</header>
		
		<section>
			
			<div class="container">
				
				<div class="row">
					
					<br>
					<br>
					<br>
				
					<div class="col-sm-12 text-right">
					
						<button class="btn btn-success" id="id_btn_addtolist"><span class="fa fa-plus"></span> Add Employee</button>
					
					</div>
					
				</div>
			
			</div>
		
		</section>
		
		<br>-
		
		<section>
			
			<div class="container">
			
				<div class="row">
					
					<div id="table_user_access_list">
					</div>
					
				</div>
				
			</div>
		
		</section>
		
		<footer>
		</footer>
		
	</body>
	
	<div class="modal fade" id="id_modal_add_accesstolist">
	
		<div class="modal-dialog modal-sm">
			
			<div class="modal-content">
			
				<div class="modal-header">
					<center>
						<h4>Add to Access List</h4>
					</center>
				</div>
				
				<div class="modal-body">
					
					<form id="id_form_addAccess">
						
						<div class="row">
					
							<div class="col-sm-12">
							
								<div class="input-group input-group-sm">
								
									<span class="input-group-addon" style="background-color: #119CFC; color: #fff; border-color: #fff;" id="sizing-addon3">NAME:</span>
									
									<input class="form-control" list="id_list_lastname" name="name_access_lastname" id="id_access_lastname" required>
									<datalist id="id_list_lastname"></datalist>
									
								</div>
							
							</div>
							
							<br>
							<br>
							
							<div class="col-sm-12">
								
								<div class="input-group input-group-sm">
								
									<span class="input-group-addon" style="background-color: #119CFC; color: #fff; border-color: #fff;" id="sizing-addon3">EMAIL:</span>
									<input  type="email" class="form-control" name="name_access_email" id="id_access_email" required>
									
								</div>
								
							</div>
							
							<br>
							<br>
							
							<input type="hidden" id="id_lastname" name="name_lastname">
							<input type="hidden" id="id_firstname" name="name_firstname">
							
							<div class="col-sm-12">
								
							<span class="input-group-addon" style="background-color: #119CFC; font-size: 10px; color: #fff; border-color: #fff; margin: 10px;" id="sizing-addon3">ACCESS POINTS
							</div>
							
							<br>
							<br>
							
							<div style="margin-left: 20px;">
							
								<div class="col-sm-12">
									<label style="font-size: 10px; padding-right: 5px;"><b><input type="radio" id="id_rad_welcome" name="name_rad_welcome" value="1"> WELCOME PAGE</b></label>
								</div>
							
								<div class="col-sm-12">
									<label style="font-size: 10px; padding-right: 5px;"><b><input type="radio" id="id_rad_request" name="name_rad_request" value="1" /> REQUEST PAGE</b></label>
								
								</div>
							
								<div class="col-sm-12">
									<label style="font-size: 10px; padding-right: 5px;"><b><input type="radio" id="id_rad_conformance" name="name_rad_conformance" value="1" /> CONFORMANCE PAGE</b></label>	
								</div>
								
								<div class="col-sm-12">
									<label style="font-size: 10px; padding-right: 5px;"><b><input type="radio" id="id_rad_receiving" name="name_rad_receiving" value="1" /> RECEIVING PAGE</b></label>	
								</div>
								
								<div class="col-sm-12">
									<label style="font-size: 10px; padding-right: 5px;"><b><input type="radio" id="id_rad_approval" name="name_rad_approval" value="1" /> APPROVAL PAGE</b></label>	
								</div>
						
							</div>
														
						</div>
						
					
					
				</div>
				
				<div class="modal-footer">
				
					<button type="submit" class="btn btn-sm btn-success">APPLY</button>
					<button class="btn btn-sm btn-default" data-dismiss="modal">CLOSE</button>
					
				</div>
				
				</form>
				
			</div>
			
		</div>
	
	</div>
	
	<script src="./js/settings.js?vx=1"></script>
	
</html>