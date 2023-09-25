<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	
	$date = date('Y-m-d');
?>

<style>

	#id_emp_name, #id_emp_dateHired {
		
		background-color: #FFFFFF;;
		
	}
	
	.modal {
	  overflow-y:auto;
	}
	
	.table td{
	  text-align: center;
	  vertical-align: bottom;
	}

	.span-align {
		vertical-align: bottom;
	}
	
	.loader {
		border: 16px solid #f3f3f3; /* Light grey */
		border-top: 16px solid #3498db; /* Blue */
		border-radius: 50%;
		width: 120px;
		height: 120px;
		animation: spin 2s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
	
</style>

<html lang="eng">

	<head>
		<input type="hidden" id="hidden_email" value="<?=$empEmail?>">
	</head>
	
	<body>
		
		<div class="container">
			<ol class="breadcrumb" style="background-color: #00B5EC; border-radius: 0px;">
			  <li><a href="#" style="color: #FFFFFF;">Home</a></li>
			</ol>
		</div>
			
		<header>
		
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<center>
							<h3> REQUEST PANEL </h3>
						</center>
					</div>	
				</div>
				
				<div class="row">
					<div class="col-sm-12 text-right">
						<select class="btn btn-default" name="name_crt_classification" id="id_crt_classification">
							<option value="0">Pricon</option>
							<option value="1">Sub Con</option>
						</select>
						<select class="btn btn-default" name="name_crt_hr_memo_ctrl_no" id="id_crt_hr_memo_ctrl_no">
						</select>
						<button id="btn_create_request" class="btn btn-success">Create a request</button>
					</div>
				</div>
			</div>
			
		</header>

		<br>
		
		<section id="home-slider">
			
			<div class="container">
				<div class="row">	
					<div class="col-sm-12">
						<div id="container_request">
						</div>
					</div>
				</div>
			</div>
			
			
			
		</section>
		
		<br>
		
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-right">
					<button id="display_granted_request" class="btn btn-info"><i class="fa fa-clock-o"></i> Show Request History</button>
				</div>
			</div>
		</div>
		
		<br>
		
		<section id="section_2">
			
		</section>
		
		<footer></footer>
	
	</body>
	
	<div class="modal fade" id="modal_create_request">
	
		<div class="modal-dialog modal-lg" >
			
			<div class="modal-content" >
			  
				<div class="modal-body" >
					
					<form id="form_id_create_request">
					
						<div class="row rowMargin">
							<div class="col-sm-12">
								<label style="margin-bottom:2px;"> TRAINING REQUEST FORM</label>
							</div>
						</div>
												
						<br>
					
						<div class="row rowMargin">
							<div class="col-sm-6" >
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">CONTROL NO :</span>
									<input type	="text" class="form-control" id ="id_add_ctrlno" style="background-color: #FFF; border-color: #FFF;" readonly>
								</div>
							</div>	
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">DATE :</span>
									<input type	="text" class="form-control" id ="id_add_ctrlno" name="name_add_date" style="background-color: #FFF; border-color: #FFF;" value="<?=$date?>" readonly>
								</div>
							</div>
						</div>
						
						
						<div class="row">
							<div class="col-sm-12">
								<hr width="100%" align="center" style="padding-bottom: 1px; margin-bottom: 5px; opacity: 0.4;" noshade="noshade">
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<label  style="margin-bottom:2px;">REQUEST DETAILS</label>
							</div>
						</div>
						
						<div class="row rowMargin">
						
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">DEPARTMENT :</span>
									<select class="form-control" name="name_crt_dept" id="id_crt_dept" onchange="setProductClassification()">
										<option value="CN">CN</option>
										<option value="YF">YF</option>
										<option value="TS">TS</option>
										<option value="PPS">PPS</option>
										<option value="PPS-CN">PPS-CN</option>
										<option value="PPS-YF">PPS-YF</option>
										<option value="PPS-TS">PPS-TS</option>
									</select>
									
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">SECTION :</span>
									
									<select class="form-control" name="name_crt_sec" id="id_crt_sec">
										<option value="PRD">Production</option>
										<option value="ENG">Engineering</option>
										<!--<option value="SSD">SSD</option>-->
										<option value="PPC">PPC</option>
										<option value="LQC">LQC</option>
									</select>
									
								</div>
							</div>
						</div>
						<div class="row rowMargin">
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">JOB FUNCTION :</span>
									
									<select class="form-control" name="name_crt_jobfunc" id="id_crt_jobfunc">
										<option value="1">Operator</option>
										<option value="2">Material Handler</option>
										<option value="3">Inspector</option>
										<option value="4">Technician</option>
										<option value="5">Engineer</option>
										<option value="6">Supervisor</option>
									</select>
									
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">AREA/LINE ALLOCATION :</span>
									
									<select class="form-control" name="name_crt_alloc" id="id_crt_alloc">
										<option value="1">Automotive Line</option>
										<option value="2">Non-Automotive Line</option>
									</select>
									
								</div>
							</div>
							
						</div>
						<div class="row rowMargin">
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">REASON:</span>
									
									<select class="form-control" name="name_crt_reason" id="id_crt_reason">
										<option value="0">--</option>
										<option value="1">Newly Hired</option>
										<option value="2">Promoted Employee</option>
										<option value="3">Transferred from other assembly line</option>
										<option value="4">Transferred from other section/department/division</option>
										<option value="5">ML/SL/VL (whose leave reached at least 1 month)</option>
										<option value="6">New Product/Line</option>
										<option value="7">Flexibility Certification</option>
										<option value="8">Re-certification</option>
									</select>
									
								</div>
							</div>

							<!-- <div class="col-sm-6" id="div_id_crt_classification">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">Classification</span>
									
									<select class="form-control" name="name_crt_classification" id="id_crt_classification">
										<option value="0">Direct</option>
										<option value="1">Sub Con</option>
									</select>
									
								</div>
							</div> -->
							
						</div >
						<div class="row rowMargin">
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">Product Classification</span>
									
									<select class="form-control" name="name_crt_product_classification" id="id_crt_product_classification">
										<option value="Card Connectors">Card Connectors</option>
										<option value="FRS/FUS/FMS Connectors">FRS/FUS/FMS Connectors</option>
										<option value="Flexicon and Connectors">Flexicon and Connectors</option>
										<option value="TC/DC Connectors">TC/DC Connectors</option>
									</select>
									
								</div>
							</div>

							<!-- <div class="col-sm-6" id="div_id_crt_hr_memo_ctrl_no">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">HR Memo(s) Ctrl No.</span>
									
									<select class="form-control" name="name_crt_hr_memo_ctrl_no" id="id_crt_hr_memo_ctrl_no">
									</select>
									
								</div>
							</div> -->
							
						</div >
						
						<div class="row">
							<div class="col-sm-12">
								<hr width="100%" align="center" style="padding-bottom: 1px; margin-bottom: 5px; opacity: 0.4;" noshade="noshade">
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<label  style="margin-bottom:2px;">EMPLOYEE DETAILS</label>
								<button 
								type="button" 
								class="btn btn-info btn-sm pull-right" 
								id="btn_show_from_to_station" >
								ADD FROM & TO IN EMPLOYEE SELECTED
								</button>
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-12" style="height: 300px; overflow: scroll; overflow-x: hidden;">
								<table id="tbl_trainees" class="table table-bordered" style="font-size: 12px;" border="1">
									
									<thead>
										<tr>
											<th><input type="checkbox" id="tbl_trainees_checkbox"></th>
											<th>Date hired</th>
											<th>Employee No</th>
											<th>Name</th>
											<th colspan="2">From Station/Production</th>
											<th colspan="2">To Station/Production</th>
											<!-- <th><center><span class="fa fa-wrench"></span></center></th> -->
										</tr>
									</thead>
									
									<tbody>
									</tbody>
									
								</table>
							</div>
						</div>
						
						
						<!-- <br>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<button 
								type="button" 
								class="btn btn-info btn-sm pull-right" 
								id="btn_id_add_emp_details" >
								<i class="fa fa-plus" style="font-size: 15px;"> ADD EMPLOYEE</i>
								</button>
								<button 
								type="button" 
								class="btn btn-info btn-sm pull-right" 
								id="btn_show_from_to_station" >
								From & To Station
								</button>
							</div>
						</div>
 -->						
						<div class="row">
							<div class="col-sm-12">
								<hr width="100%" align="center" style="padding-bottom: 1px; margin-bottom: 5px; opacity: 0.4;" noshade="noshade">
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<label  style="margin-bottom:2px;">APPROVAL DETAILS</label>
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">REQUESTOR:</span>
									<input type	="text" class="form-control" value="<? echo $empName ?>" readonly>
									<input type	="hidden" class="form-control" name="name_crt_reqby" id="id_crt_reqby" value="<? echo $empEmail ?>" readonly>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;"> APPROVER:</span>
									<input class="form-control" list="id_superior_list" name="name_superior_check" id="id_superior_check" autocomplete=off required>
									<datalist id="id_superior_list"></datalist>
									<input type="hidden" class="form-control" name="name_superior_name" id="id_superior_name" required readonly>
								</div>
							</div>
							<div class="col-sm-6" hidden>
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;"> FINAL APPROVER:</span>
									<input class="form-control" list="id_final_approver_list" name="name_final_approver_check" id="id_final_approver_check" autocomplete=off>
									<datalist id="id_final_approver_list"></datalist>
									<input type="hidden" class="form-control" name="name_final_approver_name" id="id_final_approver_name" readonly>
									<!-- <input type="hidden" class="form-control" name="name_final_approver_name" id="id_final_approver_name" required readonly> -->
								</div>
							</div>
						</div>
						
						<br>
						<br>
						<div class="row">
							<div class="col-sm-12">
								<input type="hidden" name="txt_request_pkid" id="txt_request_pkid">
								<input type="hidden" name="txt_hr_ctrl_no" id="txt_hr_ctrl_no">
							</div>
						</div>
					 
						<div class="modal-footer">
							<div class="form-group">
							
								<button 
								type="submit" 
								class="btn btn-success btn-sm">
								<i class="fa fa-send-o" style="font-size: 15px;"> SUBMIT </i>
								</button>
							
								<button type="button" 
								class="btn btn-default btn-sm"  
								data-dismiss="modal" >
								<i class="fa fa-close" style="font-size: 15px;"> Close</i>
								</button>
								
							</div>
						</div>
						
					</form>
					
					
				
					<div id="misc">
					</div>
					
				</div><!-- Modal Body -->
				
			</div><!-- /.modal-content -->
			
		</div><!-- /.modal-dialog -->

	</div>
	
	<div class="modal fade" id="modal_crt_add_emp">
	
		<div class="modal-dialog" >
			
			<div class="modal-content" >
			  	<div class="modal-header">
			  		<h5 style="font-weight: bold;">ADD EMPLOYEE</h5>
			  	</div>
				<div class="modal-body">
				
					<form id="form_id_add_emp" role="form">
						
						<div class="row rowMargin">

							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">CLASSIFICATION:</span>
									
									<select class="form-control" id="id_crt_type">
										<option value="0">SELECT CLASS</option>
										<option value="SUBCON">SUBCON</option>
										<option value="PMI">PMI</option>
									</select>
									
								</div>
							</div>
							
							<div class="col-sm-12" style="padding-top: 5px;">
							</div>
							
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">EMPLOYEE NO :</span>
									<input class="form-control" list="id_crt_name" name="empno_check" id="id_empno_check">
									<datalist id="id_crt_name"></datalist>
								</div>
							</div>
						</div>
						
						<!--<div class="row rowMargin">
							<div class="col-sm-12">
								<button type="button" class="btn btn-info btn-sm pull-right" id="btn_check_details"> Check Details
								</button>
							</div>
						</div>-->
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">NAME :</span>
									<input type	="text" class="form-control" tabindex="-1" name="name_emp_name" id="id_emp_name" readonly>
								</div>
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">DATE HIRED</span>
									<input type	="text" class="form-control" tabindex="-1" name="name_emp_dateHired" id ="id_emp_dateHired" readonly>
								</div>
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-4">
								<h5 style="text-align: center;font-weight: bold;">FROM</h5>
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">STATION :</span>
									<input type	="text" class="form-control" name="name_emp_fstation" id="id_emp_fstation" required>
								</div>
							</div>
						</div >
						
						<div class="row rowMargin">
						
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">PRODUCT NAME :</span>
									<input type	="text" class="form-control" name="name_emp_fprodname" id="id_emp_fprodname" required>
								</div>
							</div>
							
						</div >
						
						<div class="row rowMargin">
							<div class="col-sm-4">
								<h5 style="text-align: center;font-weight: bold;">TO</h5>
							</div>
						</div>
						
						<div class="row rowMargin">
						
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">STATION :</span>
									<input type	="text" class="form-control" name="name_emp_tstation" id="id_emp_tstation" required>
								</div>
							</div>
							
						</div >
						
						<div class="row rowMargin">
						
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">PRODUCT NAME :</span>
									<input type	="text" class="form-control" name="name_emp_tprodname" id="id_emp_tprodname" required>
								</div>
							</div>
							
						</div >
						
						<br>
					 
						<div class="modal-footer">
							<div class="form-group">
								
								<button 
								type="button"
								class="btn btn-info btn-sm" 
								id="btn_id_add_emp" >
								<i class="fa fa-check" style="font-size: 15px;"> Add</i>
								</button>
							
								<button type="button" 
								class="btn btn-default btn-sm"  
								data-dismiss="modal" >
								<i class="fa fa-close" style="font-size: 15px;"> Close</i>
								</button>
								
							</div>
						</div>
						
					</form>
				
					<div id="misc">
					</div>
					
				</div>
				
			</div>
			
		</div>

	</div>
	
	<div class="modal fade" id="modal_crt_add_from_to_station">
	
		<div class="modal-dialog" >
			
			<div class="modal-content" >
			  	<div class="modal-header">
			  		<h5 style="font-weight: bold;">ADD FROM & TO IN EMPLOYEE SELECTED</h5>
			  	</div>
				<div class="modal-body">
				
					<div>
						
						<div class="row rowMargin">
							<div class="col-sm-4">
								<h5 style="text-align: center;font-weight: bold;">FROM</h5>
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">STATION :</span>
									<!-- <input type	="text" class="form-control" name="name_emp_fstation" id="modal_crt_add_from_to_station_fstation" required> -->
									<select class="form-control" name="name_emp_fstation" id="modal_crt_add_from_to_station_fstation" required onchange="setFromProductName()">
									</select>
								</div>
							</div>
						</div >
						
						<div class="row rowMargin">
						
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">PRODUCT NAME :</span>
									<!-- <input type	="text" class="form-control" name="name_emp_fprodname" id="modal_crt_add_from_to_station_fprodname" required> -->
									<select class="form-control" name="name_emp_fprodname" id="modal_crt_add_from_to_station_fprodname" required>
									</select>
								</div>
							</div>
							
						</div >
						
						<div class="row rowMargin">
							<div class="col-sm-4">
								<h5 style="text-align: center;font-weight: bold;">TO</h5>
							</div>
						</div>
						
						<div class="row rowMargin">
						
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">STATION :</span>
									<!-- <input type	="text" class="form-control" name="name_emp_tstation" id="modal_crt_add_from_to_station_tstation" required> -->
									<select class="form-control" name="name_emp_tstation" id="modal_crt_add_from_to_station_tstation" required onchange="setToProductName()">
									</select>
								</div>
							</div>
							
						</div >
						
						<div class="row rowMargin">
						
							<div class="col-sm-12">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 30%;">PRODUCT NAME :</span>
									<!-- <input type	="text" class="form-control" name="name_emp_tprodname" id="modal_crt_add_from_to_station_tprodname" required> -->
									<select class="form-control" name="name_emp_tprodname" id="modal_crt_add_from_to_station_tprodname" required>
									</select>
								</div>
							</div>
							
						</div >
						
						<br>
					 
						<div class="modal-footer">
							<div class="form-group">
								
								<button 
								type="button"
								class="btn btn-info btn-sm" 
								id="modal_crt_add_from_to_station_btn" >
								<i class="fa fa-check" style="font-size: 15px;">Ok</i>
								</button>
							
								<button type="button" 
								class="btn btn-default btn-sm"
								id="modal_crt_add_from_to_station_btn_close" >
								<i class="fa fa-close" style="font-size: 15px;"> Close</i>
								</button>
								
							</div>
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div>

	</div>
	
	<div class="modal fade" id="modal_id_request">
	
		<div class="modal-dialog modal-lg" >
			
			<div class="modal-content" >
			  
				<div class="modal-body" >
					
						<div class="row rowMargin">
							<div class="col-sm-12">
								<label style="margin: auto;"> TRAINING REQUEST FORM</label>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
								<hr width="100%" align="center" style="padding-bottom: 1px; margin-bottom: 5px; opacity: 0.4;" noshade="noshade">
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<label  style="margin-bottom:2px;">REQUEST DETAILS:</label>
							</div>
						</div>
						
						<div class="row rowMargin">
						
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%";>DEPARTMENT :</span>
									<input class="form-control" type="text" id="id_request_dept" readonly>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%";>SECTION :</span>
									<input class="form-control" type="text" id="id_request_sec" readonly>
								</div>
							</div>						
						</div >
						<div class="row rowMargin">
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">JOB FUNCTION :</span>
									<input class="form-control" type="text" id="id_request_jobfunc" readonly>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%;">AREA/LINE ALLOCATION :</span>
									<input class="form-control" type="text" id="id_request_alloc" readonly>
								</div>
							</div>
						</div>
						<div class="row rowMargin">
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%";>REASON:</span>
									<input class="form-control" type="text" id="id_request_reason" readonly>
								</div>
							</div>
						</div>
						<div class="row rowMargin">
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%";>PRODUCT CLASSIFICATION:</span>
									<input class="form-control" type="text" id="id_product_classification" readonly>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
								<hr width="100%" align="center" style="padding-bottom: 1px; margin-bottom: 5px; opacity: 0.4;" noshade="noshade">
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<label  style="margin-bottom:2px;">REQUEST DETAILS:</label>
							</div>
						</div>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<div id="container_emplist" style="height: 200px; overflow: scroll; overflow-x: hidden;">
								</div>
							</div>
						</div>
						<br>
						<div class="row rowMargin">
							<div class="col-sm-12">
								<label  style="margin-bottom:2px;">APPROVAL DETAILS:</label>
							</div>
						</div>
						<div class="row row_remarks">
							<div class="col-sm-12">
								<div class="alert alert-default">
									<div id="conf_remarks_container">
										<strong>Conformance:</strong>
										<span id="summary_span_conf_email" class="text-info"></span> -
										<span id="summary_span_conf_status" class="label label-success"></span>
										<br>
										<span>Remarks:</span>
										<em id="summary_span_conf_remarks"></em>
									</div>
									<br>
									<div id="rec_remarks_container">
										<strong>Receiving:</strong>
										<span id="summary_span_rec_email" class="text-info"></span> -
										<span id="summary_span_rec_status" class="label label-success"></span>
										<br>
										<span>Remarks:</span>
										<em id="summary_span_rec_remarks"></em>
									</div>
									<br>
									<div id="app_remarks_container">
										<strong>QC Head Approval:</strong>
										<span id="summary_span_app_email" class="text-info"></span> -
										<span id="summary_span_app_status" class="label label-success"></span>
										<br>
										<span>Remarks:</span>
										<em id="summary_span_app_remarks"></em>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<div class="form-group">

								<button 
								type="button" id="btn_edit_request" 
								class="btn btn-warning btn-sm">
								<i class="fa fa-edit" style="font-size: 15px;"> EDIT </i>
								</button>

								<button type="button" 
								class="btn btn-default btn-sm"  
								data-dismiss="modal" id="modal_close">
								<i class="fa fa-close" style="font-size: 15px;"> Close</i>
								</button>
								
							</div>
						</div>
						
					<div id="misc">
					</div>
					
				</div>
				
			</div>
			
		</div>

	</div>
	
	<div class="modal fade" id="modal_previous_request">
	
		<div class="modal-dialog modal-lg" >
			
			<div class="modal-content" >
			  
				<div class="modal-body" >
				
					<div class="container-fluid">
				
						<div class="row">
						
							<div class="col-md-12">
								<center>
									<h3 id="display_label">TRAINING REQUEST HISTORY</h3>
								</center>
							</div>
							
							<br>
							
							<br>
							
							<div class="row">	
								<div class="col-sm-12">
									<div id="container_granted_request">
									</div>
								</div>
							</div>
							
						</div>
					
					</div>
				
				</div>
				
			</div>
			
		</div>

	</div>
	
	<script type="text/javascript" src="./js/request.js?v=1">
	</script>

	
</html>

<script>

	const dataProductClassification = {
		['CN']: ['Card Connectors', 'FRS/FUS/FMS Connectors', 'Flexicon and Connectors', 'TC/DC Connectors'],
		['YF']: ['Adapter Type', 'Connector Type', 'Tape Type'],
		['TS']: ['BGA/LGA/YEU', 'BGA-FP', 'QFP/TSOP', 'Probe Pin'],
		['PPS']: [''],
		['PPS-CN']: ['Card Connectors', 'FRS/FUS/FMS Connectors', 'Flexicon and Connectors', 'TC/DC Connectors', 'Molding Products'], /*['Reworker/Sorter', 'Machine Operator'],*/
		['PPS-YF']: [''],
		['PPS-TS']: ['Burn-in Sockets', 'Grinding'],
	}

	const dataStationFromTo = {
		['CN']: ['N/A', 'Assembly', 'Visual', 'Machine Operator'],
		['YF']: ['N/A', 'Inspection Process', 'Manual Process', 'Machine Operator', 'Assembly Process'],
		['TS']: ['N/A', 'Visual', 'Assembly', 'Machine', 'Parts Preparation'],
		['PPS']: ['N/A'],
		['PPS-CN']: ['N/A'],
		['PPS-YF']: ['N/A'],
		['PPS-TS']: ['N/A', 'Visual', 'Rework / Segregation', 'Machine'],
	}
	// const dataProductNameFromTo = {
	// 	['N/A']: ['N/A'],
	// 	[dataStationFromTo[1]]: ['Visual', 'Assembly', 'Machine', 'Parts Preparation'],
	// 	[dataStationFromTo[2]]: ['Visual', 'Rework / Segregation', 'Machine'],
	// 	[dataStationFromTo[3]]: ['Inspection Process', 'Manual Process', 'Machine Operator', 'Assembly Process'],
	// }
	function setProductClassification() {
		$('#id_crt_product_classification').html("")
		for (var i = 0; i < dataProductClassification[$('#id_crt_dept').val()].length; i++){
			if(i==0)
				$('#id_crt_product_classification').append("<option selected value='" + dataProductClassification[$('#id_crt_dept').val()][i] + "'>" + dataProductClassification[$('#id_crt_dept').val()][i] + "</option>")
			else
				$('#id_crt_product_classification').append("<option value='" + dataProductClassification[$('#id_crt_dept').val()][i] + "'>" + dataProductClassification[$('#id_crt_dept').val()][i] + "</option>")
		}
		getAllProductNames()

		if( $('#id_crt_reason').val() == 1 ){
			$("input:checkbox[name=tbl_trainees_emp_id]").each(function () {
				$('#tbl_trainees_from_station_' + $(this).val()).html('N/A')
				$('#tbl_trainees_from_prodName_' + $(this).val()).html('N/A')
				$('#tbl_trainees_to_station_' + $(this).val()).html('')
				$('#tbl_trainees_to_prodName_' + $(this).val()).html('')
	        })
		}else{
			$("input:checkbox[name=tbl_trainees_emp_id]").each(function () {
				$('#tbl_trainees_from_station_' + $(this).val()).html('')
				$('#tbl_trainees_from_prodName_' + $(this).val()).html('')
				$('#tbl_trainees_to_station_' + $(this).val()).html('')
				$('#tbl_trainees_to_prodName_' + $(this).val()).html('')
	        })
		}
	}
	function setFromToStation(station_id) {
		$('#' + station_id).html("")
		for (var i = 0; i < dataStationFromTo[/*$('#id_crt_dept').val()*/'CN'].length; i++){
			if(i==0)
				$('#' + station_id).append("<option selected value='" + dataStationFromTo[/*$('#id_crt_dept').val()*/'CN'][i] + "'>" + dataStationFromTo[/*$('#id_crt_dept').val()*/'CN'][i] + "</option>")
			else
				$('#' + station_id).append("<option value='" + dataStationFromTo[/*$('#id_crt_dept').val()*/'CN'][i] + "'>" + dataStationFromTo[/*$('#id_crt_dept').val()*/'CN'][i] + "</option>")
		}
	}
	function setFromToProductName(station_id, prod_name_id) {
		// $('#' + prod_name_id).html("")
		// for (var i = 0; i < dataProductNameFromTo[$("#" + station_id).val()].length; i++)
		// 	$('#' + prod_name_id).append("<option value='" + dataProductNameFromTo[$("#" + station_id).val()][i] + "'>" + dataProductNameFromTo[$("#" + station_id).val()][i] + "</option>")
	}
	function setFromProductName() {
		setFromToProductName('modal_crt_add_from_to_station_fstation', 'modal_crt_add_from_to_station_fprodname')
	}
	function setToProductName() {
		setFromToProductName('modal_crt_add_from_to_station_tstation', 'modal_crt_add_from_to_station_tprodname')
	}

	function setClassification() {
		$('#id_crt_hr_memo_ctrl_no').html('')
		setSelectOption(
			"http://192.168.3.31/TrainingRecordDatabaseSystem/rapidGetHRMemos", 
			{ mode: $('#id_crt_classification').val() }, 
			'id', 
			'ctrl_no_added', 
			'id_crt_hr_memo_ctrl_no'
		)
		setTblEmployees()
	}

	function getAllProductNames() {
		setSelectOption(
			"http://192.168.3.31/TrainingRecordDatabaseSystem/getAllProductNames", 
			{ department: $('#id_crt_dept').val() }, 
			'product_name', 
			'product_name', 
			'modal_crt_add_from_to_station_fprodname'
		)
		$('#modal_crt_add_from_to_station_tprodname').html( $('#modal_crt_add_from_to_station_fprodname').html() )
	}

	function tableDataChecker() {
		var empty_field = false
		$('#tbl_trainees tr').each(function(row, tr){
			if(row>0){
				var from_station = $(tr).find('td:eq(4)').text();
				var from_prodName = $(tr).find('td:eq(5)').text();
				var to_station = $(tr).find('td:eq(6)').text();
				var to_prodName = $(tr).find('td:eq(7)').text();
				
				if(from_station==''||from_prodName==''||to_station==''||to_prodName==''||from_station==null||from_prodName==null||to_station==null||to_prodName==null)
					empty_field = true
			}
		})
		return empty_field;
	}

	$(document).ready(function(){

		setClassification()

		setFromToStation("modal_crt_add_from_to_station_fstation")
		setFromProductName()

		setFromToStation("modal_crt_add_from_to_station_tstation")
		setToProductName()

		$('#id_crt_classification').change(function(){
			setClassification()
		})
		$('#id_crt_hr_memo_ctrl_no').change(function(){
			setTblEmployees()
		})

		$('#id_crt_reason').change(function(){
			if( $(this).val() == 1 ){
				$("input:checkbox[name=tbl_trainees_emp_id]").each(function () {
					$('#tbl_trainees_from_station_' + $(this).val()).html('N/A')
					$('#tbl_trainees_from_prodName_' + $(this).val()).html('N/A')
					$('#tbl_trainees_to_station_' + $(this).val()).html('')
					$('#tbl_trainees_to_prodName_' + $(this).val()).html('')
		        })
			}else{
				$("input:checkbox[name=tbl_trainees_emp_id]").each(function () {
					$('#tbl_trainees_from_station_' + $(this).val()).html('')
					$('#tbl_trainees_from_prodName_' + $(this).val()).html('')
					$('#tbl_trainees_to_station_' + $(this).val()).html('')
					$('#tbl_trainees_to_prodName_' + $(this).val()).html('')
		        })
			}
		})

		$('#tbl_trainees_checkbox').change(function(){
			var  have = false;
			$("input:checkbox[name=tbl_trainees_emp_id]").each(function () {
	            have = true
	        })
	        if(have){
				$("input:checkbox[name=tbl_trainees_emp_id]").each(function () {
					if($('#tbl_trainees_checkbox').is(":checked"))
		            	$('#tbl_trainees_chk_' + $(this).val()).prop("checked", true)
		            else
		            	$('#tbl_trainees_chk_' + $(this).val()).prop("checked", false)
		        })
			}else{
				alert('No employee in the list')
				$('#tbl_trainees_checkbox').prop("checked", false)
			}
		})

		$("#tbl_trainees").on("click", ".tbl_trainees_from_to__", function(){
			if( $('#id_crt_reason').val() == 1 ) {
				$('#modal_crt_add_from_to_station_fstation').attr('disabled', true)
				$('#modal_crt_add_from_to_station_fprodname').attr('disabled', true)
			}else{
				$('#modal_crt_add_from_to_station_fstation').attr('disabled', false)
				$('#modal_crt_add_from_to_station_fprodname').attr('disabled', false)
			}


			if( $('#tbl_trainees_from_station_' + $(this).attr('data')).html() == "" )
				setFromToStation("modal_crt_add_from_to_station_fstation")
			else
				$('#modal_crt_add_from_to_station_fstation').val( $('#tbl_trainees_from_station_' + $(this).attr('data')).html() )
			setFromProductName()
			if( $('#tbl_trainees_from_prodName_' + $(this).attr('data')).html() != "" )
				$('#modal_crt_add_from_to_station_fprodname').val( $('#tbl_trainees_from_prodName_' + $(this).attr('data')).html() )
			else
				$("#modal_crt_add_from_to_station_fprodname").val( 'N/A' )


			if( $('#tbl_trainees_to_station_' + $(this).attr('data')).html() == "" )
				setFromToStation("modal_crt_add_from_to_station_tstation")
			else
				$('#modal_crt_add_from_to_station_tstation').val( $('#tbl_trainees_to_station_' + $(this).attr('data')).html() )
			setToProductName()
			if( $('#tbl_trainees_to_prodName_' + $(this).attr('data')).html() != "" )
				$('#modal_crt_add_from_to_station_tprodname').val( $('#tbl_trainees_to_prodName_' + $(this).attr('data')).html() )
			else
				$("#modal_crt_add_from_to_station_tprodname").val( 'N/A' )


			$('#tbl_trainees_chk_' + $(this).attr('data')).prop('checked', true)
			var  have = false;
			$("input:checkbox[name=tbl_trainees_emp_id]:checked").each(function () {
	            have = true
	        })
	        if(have)
				$('#modal_crt_add_from_to_station').modal('show')
			else
				alert('No employee selected')
		})

		$('#btn_create_request').click(function(){

			if( $('#id_crt_classification').val()==null || $('#id_crt_classification').val()=='' || $('#id_crt_hr_memo_ctrl_no').val()==null || $('#id_crt_hr_memo_ctrl_no').val()=='' ){
				alert( 'Please select HR Memo control no.' )
				return true;
			}

			$('#txt_hr_ctrl_no').val( $('#id_crt_hr_memo_ctrl_no :selected').text() )
			// alert( $('#txt_hr_ctrl_no').val() )
			setProductClassification()

			setFromToStation("modal_crt_add_from_to_station_fstation")
			setFromProductName()

			setFromToStation("modal_crt_add_from_to_station_tstation")
			setToProductName()

			$('#id_crt_dept').attr('readonly', false)
			$('#id_crt_sec').attr('readonly', false)
			$('#id_crt_jobfunc').attr('readonly', false)
			$('#id_crt_alloc').attr('readonly', false)
			$('#id_crt_reason').attr('readonly', false)

			$('#div_id_crt_classification').attr('hidden', false)
			$('#div_id_crt_hr_memo_ctrl_no').attr('hidden', false)

			$('#txt_request_pkid').val('');
			// $('#id_crt_classification').val(0);
			
			$('#modal_create_request').modal('show');
		})

		$('#modal_crt_add_from_to_station_btn').click(function(){

			var from_station = $('#modal_crt_add_from_to_station_fstation').val()
			var from_prodName = $('#modal_crt_add_from_to_station_fprodname').val()
			var to_station = $('#modal_crt_add_from_to_station_tstation').val()
			var to_prodName = $('#modal_crt_add_from_to_station_tprodname').val()

			if(from_station==''||from_prodName==''||to_station==''||to_prodName==''||from_station==null||from_prodName==null||to_station==null||to_prodName==null){
				alert('Please fill all the fields to continue.');
				return false;
			} 

			if( $('#id_crt_reason').val() != 1 ) {
				if(from_station=='N/A'||from_prodName=='N/A'){
					alert('Station and Product Name in From are required.');
					return false;
				}
			}

			if(to_station=='N/A'||to_prodName=='N/A'){
				alert('Station and Product Name in To are required.');
				return false;
			}

			$("input:checkbox[name=tbl_trainees_emp_id]:checked").each(function () {
				$('#tbl_trainees_from_station_' + $(this).val()).html(from_station)
				$('#tbl_trainees_from_prodName_' + $(this).val()).html(from_prodName)
				$('#tbl_trainees_to_station_' + $(this).val()).html(to_station)
				$('#tbl_trainees_to_prodName_' + $(this).val()).html(to_prodName)

				$('#tbl_trainees_chk_' + $(this).val()).attr('product_name', $('#id_crt_dept').val() + "<,>" + to_prodName)

				$(this).prop('checked', false)
	        })

			$('#tbl_trainees_checkbox').prop("checked", false)
			$('#modal_crt_add_from_to_station_fstation').val('')
			$('#modal_crt_add_from_to_station_fprodname').val('')
			$('#modal_crt_add_from_to_station_tstation').val('')
			$('#modal_crt_add_from_to_station_tprodname').val('')
			$('#modal_crt_add_from_to_station').modal('hide')
		})

		$('#modal_crt_add_from_to_station_btn_close').click(function(){
			$("input:checkbox[name=tbl_trainees_emp_id]:checked").each(function () {
				$(this).prop('checked', false)
	        })
			$('#tbl_trainees_checkbox').prop("checked", false)
			$('#modal_crt_add_from_to_station_fstation').val('')
			$('#modal_crt_add_from_to_station_fprodname').val('')
			$('#modal_crt_add_from_to_station_tstation').val('')
			$('#modal_crt_add_from_to_station_tprodname').val('')
			$('#modal_crt_add_from_to_station').modal('hide')
		})

		$('#btn_show_from_to_station').click(function(){

			var  have = false;
			$("input:checkbox[name=tbl_trainees_emp_id]:checked").each(function () {
	            have = true
	        })
	        if(have){
				$('#modal_crt_add_from_to_station_fstation').val( '' )
				$('#modal_crt_add_from_to_station_fprodname').val( '' )
				$('#modal_crt_add_from_to_station_tstation').val( '' )
				$('#modal_crt_add_from_to_station_tprodname').val( '' )

		        if( $('#id_crt_reason').val() == 1 ) {
					$('#modal_crt_add_from_to_station_fstation').attr('disabled', true)
					$('#modal_crt_add_from_to_station_fprodname').attr('disabled', true)
					$('#modal_crt_add_from_to_station_fstation').val( 'N/A' )
					$('#modal_crt_add_from_to_station_fprodname').val( 'N/A' )
				}

				setFromToStation("modal_crt_add_from_to_station_fstation")
				setFromProductName()

				setFromToStation("modal_crt_add_from_to_station_tstation")
				setToProductName()

				$('#modal_crt_add_from_to_station').modal('show')
	        }
			else
				alert('No employee selected')
		})

	})

	function rapidSetEmployeeToRFTMemoIncluded(assigned_pkid) {
		var ids = ''
		var array_ids = []
		$("input:checkbox[name=tbl_trainees_emp_id]").each(function () {
			ids += $(this).val() + ','
			array_ids.push([
				$(this).val(), $('#tbl_trainees_chk_' + $(this).val()).attr('product_name'), 
				$('#tbl_trainees_to_station_' + $(this).val()).html(), 
				$('#tbl_trainees_to_prodName_' + $(this).val()).html()
			])
		})
		ids = ids.slice(0, -1)
		
		let reponed
		$.ajax({
	        url: 'http://192.168.3.31/TrainingRecordDatabaseSystem/rapidSetEmployeeToRFTMemoIncluded',
	        method: "post",
	        data: {
	        	_token: '',
	        	ids: ids,
	        	array_ids: array_ids,
	        	rst_id: assigned_pkid,
	        	txt_request_pkid: $('#txt_request_pkid').val()
	        },
	        async: false,
	        dataType: "json",
	        success: function(JsonObject){
	            // if(JsonObject['result'] != undefined){
	            //     alert('saved')
	            // }
	            reponed = 1
	        },
	        error: function(data, xhr, stat){
	        	reponed = 1
	        }
	    })
	    while(!reponed)
	    return reponed
	}

	function _getToken() {
		let reponed
		$.ajax({
	        url: 'http://192.168.3.31/TrainingRecordDatabaseSystem/rapidGetToken',
	        method: "get",
	        data: {},
	        async: false,
	        dataType: "json",
	        success: function(JsonObject){
	            if(JsonObject['data'] != undefined)
	                reponed = JsonObject['data']
	            else
	            	reponed = 1
	        },
	        error: function(data, xhr, stat){
	        	reponed = 1
	        }
	    })
	    while(!reponed)
	    return reponed
	}

	function getTRDSUsers(){
		
		var data = {
			'action' : 'getTRDSUsers',
		}
		
		$.ajax({
			url: "http://192.168.3.31/TrainingRecordDatabaseSystem/rapidGetdata",
			method: 'GET',
			data: data,
			dataType: 'json',
			success	: function(data){
				
			},
			error	: function(data){
				alert("Handler Failed!");
			}
		})

	}

	function setSelectOption(url, json_data, val_col, text_col, tag_id, selected_ids=null){
	    let data
	    $.ajax({
	        url: url,
	        method: "get",
	        data: json_data,
	        async: false,
	        dataType: "json",
	        success: function(JsonObject){
	            if(JsonObject['data'] != undefined){
	                data = JsonObject['data']
	                let html = ""
	                for (var i = 0; i < data.length; i++) {
	                    if( selected_ids == null ){
	                        html += "<option value='" + data[i][val_col] + "'>" + data[i][text_col] + "</option>"
	                    }else{
	                        if( selected_ids.indexOf(data[i][val_col]) >= 0 )
	                            html += "<option selected value='" + data[i][val_col] + "'>" + data[i][text_col] + "</option>"
	                        else
	                            html += "<option value='" + data[i][val_col] + "'>" + data[i][text_col] + "</option>"
	                    }
	                }
	                $('#' + tag_id).html(html)
	            }
	            else{
	                
	                data = 1
	            }
	        },
	        error: function(data, xhr, stat){
	            
	            data = 1
	        }
	    })
	    while(!data)
	    return data
	}

	function setTblEmployees(){
		$('#tbl_trainees tbody').html('')
		$('#tbl_trainees_checkbox').attr('checked', false)
		if( $('#id_crt_hr_memo_ctrl_no').val() != undefined || $('#id_crt_hr_memo_ctrl_no').val() != 0 ) {
		    let data
		    $.ajax({
		        url: "http://192.168.3.31/TrainingRecordDatabaseSystem/rapidGetEmployeesInHRMemo",
		        method: "get",
		        data: { id: $('#id_crt_hr_memo_ctrl_no').val() },
		        async: false,
		        dataType: "json",
		        success: function(JsonObject){
		            if(JsonObject['data'] != undefined){
		                data = JsonObject['data']
		                let html = ""
		                for (var i = 0; i < data.length; i++) {

		                	var from_val = ''
		                	if( $('#id_crt_reason').val() == 1 )
		                		from_val = 'N/A'

		                    $('#tbl_trainees tbody').append('<tr>' + 
		                    	'<td><input type="checkbox" id="tbl_trainees_chk_'+data[i]['id']+'" name="tbl_trainees_emp_id" value="'+data[i]['id']+'" product_name=""></td>' + 
		                    	'<td>'+data[i]['DateHired']+'</td>' + 
		                    	'<td>'+data[i]['EmpNo']+'</td>' + 
		                    	'<td>'+data[i]['LastName']+', '+data[i]['FirstName']+' '+data[i]['MiddleName']+'</td>' + 
		                    	'<td class="tbl_trainees_from_to__" data="'+data[i]['id']+'" id="tbl_trainees_from_station_'+data[i]['id']+'">' + from_val + '</td>' + 
		                    	'<td class="tbl_trainees_from_to__" data="'+data[i]['id']+'" id="tbl_trainees_from_prodName_'+data[i]['id']+'">' + from_val + '</td>' + 
		                    	'<td class="tbl_trainees_from_to__" data="'+data[i]['id']+'" id="tbl_trainees_to_station_'+data[i]['id']+'"></td>' + 
		                    	'<td class="tbl_trainees_from_to__" data="'+data[i]['id']+'" id="tbl_trainees_to_prodName_'+data[i]['id']+'"></td>' + 
		                    	// '<td>' + 
		                    	// 	'<a href="#"</a>Remove' +
		                    	// '</td>' + 
		                    	'</tr>'
		                    );
		                }
		                // $('#' + tag_id).html(html)
		            }
		            else{
		                data = 1
		            }
		        },
		        error: function(data, xhr, stat){
		            data = 1
		        }
		    })
		    while(!data)
		    return data
		}
	}
	function getEmployeeList_for_edit(pkid){
		var data = {
			'action'	: 'getEmployeeList',
			'pkid'		: pkid[0]
		}
		data = $.param(data);
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				var ctr = data['ctr'];
				var html = '';
				$('#tbl_trainees tbody').html('');
				for(i=0;i<ctr;i++){
						// var html = '<tr>';
						// html += '   <td>'+data['date_hired'][i]+'</td>';
						// html += '	<td>'+data['emp_no'][i]+'</td>';
						// html += '	<td>'+data['emp_name'][i]+'</td>';	
						// html += '	<td>'+data['from_station'][i]+'</td>';	
						// html += '	<td>'+data['from_line'][i]+'</td>';
						// html += '	<td>'+data['to_station'][i]+'</td>';
						// html += '	<td>'+data['to_line'][i]+'</td>';
						// html += '	<td>'+'<a href="#"</a>Cancel'+'</td>';
						// html += '</tr>';
					 // $('#tbl_trainees tbody').append(html);

					 $('#tbl_trainees tbody').append('<tr>' + 
                    	'<td><input type="checkbox" id="tbl_trainees_chk_'+data['emp_no'][i]+'" name="tbl_trainees_emp_id" value="'+data['emp_no'][i]+'" product_name=""></td>' + 
                    	'<td>'+data['date_hired'][i]+'</td>' + 
                    	'<td>'+data['emp_no'][i]+'</td>' + 
                    	'<td>'+data['emp_name'][i]+'</td>' + 
                    	'<td class="tbl_trainees_from_to__" data="'+data['emp_no'][i]+'" id="tbl_trainees_from_station_'+data['emp_no'][i]+'">'+data['from_station'][i]+'</td>' + 
                    	'<td class="tbl_trainees_from_to__" data="'+data['emp_no'][i]+'" id="tbl_trainees_from_prodName_'+data['emp_no'][i]+'">'+data['from_line'][i]+'</td>' + 
                    	'<td class="tbl_trainees_from_to__" data="'+data['emp_no'][i]+'" id="tbl_trainees_to_station_'+data['emp_no'][i]+'">'+data['to_station'][i]+'</td>' + 
                    	'<td class="tbl_trainees_from_to__" data="'+data['emp_no'][i]+'" id="tbl_trainees_to_prodName_'+data['emp_no'][i]+'">'+data['to_line'][i]+'</td>' + 
                    	// '<td>' + 
                    	// 	'<a href="#"</a>Remove</td>' + 
                    	'</tr>');
				}
			},
			error	: function(data){
				alert('Error on retrieving employee list');
				console.log(data);
			}
		});
	}

	$("input[name=bla]").each( function () {
       alert( $(this).val() );
   })
</script>
<!-- // url		: "http://192.168.3.31/RFT_request/index.php", -->