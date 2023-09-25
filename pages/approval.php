<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

?>

<style>
	.table td, th{
	  text-align: center;
	  vertical-align: bottom;
	}
</style>

<html>

	<head>
		<input type="hidden" id="id_email" value="<?=$empEmail ?>">
	</head>
	
	<body>
	
		<header>
			<div class="container">
				<ol class="breadcrumb" style="background-color: #603cba; border-radius: 0px;">
					<li><a href="#" style="color: #FFFFFF;">APPROVAL PAGE</a></li>
				</ol>
			</div>

			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
							<h3> FOR APPROVAL</h3>
					</div>	
				</div>
			</div>
			
			<br>
			
		</header>
		
		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div id="container_approval">
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<br>
		<br>
		
		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div id="container_list_of_approved">
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<footer></footer>
	
	</body>
	
	<div class="modal fade" id="modal_id_approval">
	
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
								<div class="input-group input-group-sm" style="width: 100%">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%">DEPARTMENT :</span>
									<input class="form-control" type="text" id="id_approval_dept" readonly>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%">SECTION :</span>
									<input class="form-control" type="text" id="id_approval_sec" readonly>
								</div>
							</div>
						</div>
							
						<div class="row rowMargin">
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%">JOB FUNCTION :</span>
									<input class="form-control" type="text" id="id_approval_jobfunc" readonly>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%">AREA/LINE ALLOCATION :</span>
									<input class="form-control" type="text" id="id_approval_alloc" readonly>
								</div>
							</div>
						</div>
						<div class="row rowMargin">
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%">REASON:</span>
									<input class="form-control" type="text" id="id_approval_reason" readonly>
								</div>
							</div>
						</div >
						<div class="row rowMargin">
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%;">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%";>PRODUCT CLASSIFICATION:</span>
									<input class="form-control" type="text" id="id_product_classification" readonly>
								</div>
							</div>
						</div>
						
						<br>
						
						<div class="row rowMargin">
							<div class="col-sm-12">
								<div id="container_emplist" style="height: 200px; overflow: scroll; overflow-x: hidden;">
								</div>
							</div>
						</div>
						
						<br>
						
						<div class="row rowMargin" hidden>
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%">REQUESTED BY:</span>
									<input class="form-control" type="text" id="id_approval_requestor" readonly>
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%">CONFORMED BY:</span>
									<input class="form-control" type="text" id="id_approval_conformer" readonly>
								</div>
							</div>
						</div>
						
						<div class="row rowMargin" hidden>
							<div class="col-sm-6">
								<div class="input-group input-group-sm" style="width: 100%">
									<span class="input-group-addon set_span_color" id="sizing-addon3" style="width: 50%">RECEIVED BY:</span>
									<input class="form-control" type="text" id="id_approval_receiver" readonly>
								</div>
							</div>
						</div>
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
						<div class="row bg-info row_remarks_input">
							<div class="form-group col-sm-12">
								<label>Approval Remarks</label>
								<textarea class="form-control" name="txt_remarks" id="txt_remarks" style="resize: none;" maxlength="500" placeholder="Type here..."></textarea>
							</div>
						</div>					 
						<div class="modal-footer">
							<div class="form-group">

								<button 
								type="button" id="btn_id_for_revision"
								class="btn btn-warning btn-sm">
									<i class="fa fa-undo" style="font-size: 15px;"> FOR REVISION </i>
								</button>
							
								<button 
								type="button" id="btn_id_disapprove"
								class="btn btn-danger btn-sm">
									<i class="fa fa-times" style="font-size: 15px;"> DISAPPROVE </i>
								</button>
							
								<button 
								type="button" id="btn_id_approval"
								class="btn btn-success btn-sm">
								<i class="fa fa-check" style="font-size: 15px;"> APPROVE </i>
								</button>
								
								<button type="button" 
								class="btn btn-default btn-sm"  
								data-dismiss="modal">
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
	
	<script src="./js/approval.js?vx=1"></script>
	<script src="./js/common.js"></script>

</html>

<script>
	function rapidSetEmployeeToRFTMemoIncluded(assigned_pkid) {
		var ids = ''
		$("input:checkbox[name=tbl_trainees_emp_id]").each(function () {
			ids += $(this).val() + ','
		})
		ids = ids.slice(0, -1)

		let reponed
		$.ajax({
	        url: 'http://192.168.3.31/TrainingRecordDatabaseSystem/rapidSetEmployeeToRFTMemoIncluded',
	        method: "post",
	        data: {
	        	_token: '',
	        	disapproved: 1,
	        	rst_id: assigned_pkid,
	        },
	        async: false,
	        dataType: "json",
	        success: function(JsonObject){
	            reponed = 1
	        },
	        error: function(data, xhr, stat){
	        	reponed = 1
	        }
	    })
	    while(!reponed)
	    return reponed
	}

	function rapidSetEmployeeToRFTMemoIncludedApproved(assigned_pkid) {
		var ids = ''
		$("input:checkbox[name=tbl_trainees_emp_id]").each(function () {
			ids += $(this).val() + ','
		})
		ids = ids.slice(0, -1)

		let reponed
		$.ajax({
	        url: 'http://192.168.3.31/TrainingRecordDatabaseSystem/rapidSetEmployeeToRFTMemoIncluded',
	        method: "post",
	        data: {
	        	_token: '',
	        	approved: 1,
	        	rst_id: assigned_pkid,
	        },
	        async: false,
	        dataType: "json",
	        success: function(JsonObject){
	            reponed = 1
	        },
	        error: function(data, xhr, stat){
	        	reponed = 1
	        }
	    })
	    while(!reponed)
	    return reponed
	}
</script>