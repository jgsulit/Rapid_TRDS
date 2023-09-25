
	var handler = '../handler/handler.php';
	var selected_pkid ='';
	var email = $('#id_email').val();
	
	$(document).ready(function(){
		
		$('#btn_id_receive').click(function(){
			
			if (confirm('Please select ok to confirm approval')) {
				
				var data = {
					'action'	: 'process_controlno',
					'pkid'		: selected_pkid
				}
				
				data = $.param(data);

				$.ajax({
					type	: 'post',
					dataType: 'json',
					data	: data,
					url		: handler,
					success	: function(data){
						var ctrl_no = data['ctrlno'];
						var counter = data['counter'];
						// alert(ctrl_no);
						generate_code(ctrl_no,counter);
					},
					error	: function(data){
						alert('Error found on code generation.');
						console.log(data);
					}
				});
				
			} else {
				return false;
			}
		});

		$('#btn_id_disapprove').click(function(){
			if (confirm('Are you sure you want to disapprove this request?')) {
				if($('#txt_remarks').val() == ''){
					alert('Please state the reason first on the remarks box.')
					return false;
				}
				var data = {
					'action'		: 'receive_request_disapprove',
					'pkid'			: selected_pkid,
					'txt_remarks'	: $('#txt_remarks').val()

				}
		
				data = $.param(data);
				$.ajax({
					type	: 'post',
					dataType: 'json',
					data	: data,
					url		: handler,
					success : function(data){
						var pkid_ = data['pkid'];
						send_email_receive_disapprove(pkid_); //novs enable this
						// rapidSetEmployeeToRFTMemoIncluded(selected_pkid)
						disapprovedMemo(pkid_)
					},
					error	: function(data){
						alert('Error found on conforming request.');
						console.log(data);
					}
				});
			} else {
				return false;
			}
		});

		$('#btn_id_for_revision').click(function(){
			if (confirm('Are you sure you want to return this request to the requestor?')) {
				if($('#txt_remarks').val() == ''){
					alert('Please state the reason first on the remarks box.')
					return false;
				}
				var data = {
					'action'		: 'receive_request_return',
					'pkid'			: selected_pkid,
					'txt_remarks'	: $('#txt_remarks').val()
				}
		
				data = $.param(data);
				$.ajax({
					type	: 'post',
					dataType: 'json',
					data	: data,
					url		: handler,
					success : function(data){
						var pkid_ = data['pkid'];
						send_email_receive_return(pkid_); //novs enable this
					},
					error	: function(data){
						alert('Error found on conforming request.');
						console.log(data);
					}
				});
			} else {
				return false;
			}
		});

		
	});
	


	function get_receiving_td_value(indx,td_con,td_rec,td_app, log_del){

		var td_text_arr = ['CONFORMED','RECEIVED','APPROVED']
		var tds = [td_con,td_rec,td_app];
		var current_td = tds[indx];

		var td_text 		= '';
		var td_bg 			= '';

		if( current_td == '1'){
			td_text 		= td_text_arr[indx];
			td_bg 			= 'label label-success';
		}
		else{
			td_text 		= 'QUEUED';
			td_bg 			= 'label label-default';
			if((indx == 0 && td_con == 0) || (indx == 2 && td_rec == 1)){
				td_text 		= 'ON-GOING';
				td_bg 			= 'label label-info';
			}
			if( indx == 1 && td_con == 1 ){
				td_text 		= 'FOR CONFORMANCE';
				td_bg 			= 'label label-warning';
			}
		}
		var td_val_arr = [td_bg,td_text];
		return td_val_arr;
	}

	function set_summary_status_value(element, phase, status){
		if(status == 1){
			if(phase == 1){
				$(element).text('Conformed');
			}
			else if(phase == 2){
				$(element).text('Received');
			}
			else if(phase == 3){
				$(element).text('Approved');
			}
			$(element).addClass('label-success');
		}
		else if(status == 3){
			$(element).text('Disapproved');
			$(element).addClass('label-danger');
		}
		else if(status == 4){
			$(element).text('For Revision');
			$(element).addClass('label-warning');
		}
	}

	display_receiving();
	
	function display_receiving(){
		
		var data = {
			'action'	: 'display_receiving'
		}
		
		data = $.param(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				
				// alert(data['ctr']);
				var ctr = data['ctr'];
			
				$('#container_receive').empty();
			
				var html  = '<table id="tbl_receive" class="table table-bordered" style="padding: 20px; margin-right: 20px; font-size: 15px;">';
					html += '	<thead>';
					html += '		<tr>';
					html += '			<th>HR Memo Ctrl No.</th>';
					html += '			<th>Control No.</th>';
					html += '			<th>Date Filed</th>';
					html += '			<th>Conformance</th>';
					html += '			<th>Receiving</th>';	
					html += '			<th>QC Head Approval</th>';
					html += '		</tr>';
					html += '	</thead>';
					html += '	<tbody>';
					html += '	</tbody>';
					html += '</table>';
					
				$('#container_receive').append(html);	
			
				for(i=0;i<ctr;i++){
						var html = '<tr id="'+data['pkid_request'][i]+'">';

						html += '	<td style="vertical-align: middle;">'+data['hr_ctrl_no'][i]+'</td>';
						
						if(data['control_no'][i]==''){										
							html += '   <td style="vertical-align: middle;"><span class="label label-success">TBA</span></td>';
						}else{
							html += '   <td style="vertical-align: middle;">'+data['control_no'][i]+'</td>';
						}
						
						html += '	<td style="vertical-align: middle;">'+data['date_filed'][i]+'</td>';

						//-----
						var td_con 		= data['conf_status'][i];
						var td_rec 		= data['rec_status'][i];
						var td_app 		= data['app_status'][i];

						var td_val_arr 	= get_receiving_td_value(0,td_con,td_rec,td_app,0);
						html += '<td style="vertical-align: middle;"><span class="'+td_val_arr[0]+' small">'+td_val_arr[1]+'</span></td>';
						td_val_arr 	= get_receiving_td_value(1,td_con,td_rec,td_app,0);
						html += '<td style="vertical-align: middle;"><span class="'+td_val_arr[0]+' small">'+td_val_arr[1]+'</span></td>';
						td_val_arr 	= get_receiving_td_value(2,td_con,td_rec,td_app,0);
						html += '<td style="vertical-align: middle;"><span class="'+td_val_arr[0]+' small">'+td_val_arr[1]+'</span></td>';
						//-----

						
						// if(data['conf_status'][i] == '0'){
						// 	html += '   <td style="vertical-align: middle;"><h5><span class="label label-info" style="background-color: #34CCFF; border-radius: 0px;">ON-GOING</span></h5></td>';
						// }else if(data['conf_status'][i] == '1'){
						// 	html += '   <td style="vertical-align: middle;"><h5><span class="label label-success">CONFORMED</span></h5></td>';
						// }else{
						// 	html += '   <td style="vertical-align: middle;"><h5><span class="label label-success" style="background-color: #5416B4; border-radius: 0px;">QUEUED</span></h5></td>';
						// }
						
						// if(data['rec_status'][i] == '0'){
						// 	html += '   <td style="vertical-align: middle;"><h5><span class="label label-info" style="background-color: #FF9F00; border-radius: 0px;">FOR CONFORMANCE</span></h5></td>';
						// }else if(data['rec_status'][i] == '1'){
						// 	html += '   <td style="vertical-align: middle;"><h5><span class="label label-success">RECEIVED</span></h5></td>';
						// }else{
						// 	html += '   <td style="vertical-align: middle;"><h5><span class="label label-success" style="background-color: #5416B4; border-radius: 0px;">QUEUED</span></h5></td>';
						// }
						
						// if(data['app_status'][i] == '0'){
						// 	html += '   <td style="vertical-align: middle;"><h5><span class="label label-info" style="background-color: #34CCFF; border-radius: 0px;">ON-GOING</span></h5></td>';
						// }else if(data['app_status'][i] == '1'){
						// 	html += '   <td style="vertical-align: middle;"><h5><span class="label label-success">APPROVED</span></h5></td>';
						// }else{
						// 	html += '   <td style="vertical-align: middle;"><h5><span class="label label-success" style="background-color: #5416B4; border-radius: 0px;">QUEUED</span></h5></td>';
						// }
												
						html += '</tr>';
						
						$('#tbl_receive tbody').append(html);
				}
			
				var oTable = $('#tbl_receive').DataTable({ paginate: true, aaSorting: []});
				table_event_receive();
				
			},
			error	: function(data){
				alert('Error loading conformance table.');
				console.log(data);
			}
		});
		
	}
	
	function table_event_receive(){
		
		$('#tbl_receive tbody').on('click','tr', function(){
			selected_pkid = '';
			$('#tbl_receive tbody tr').attr('style','');
			$(this).attr('style','background:#7a9d00 ;color:white;');
			selected_pkid = this.id;
		});
		
		$('#tbl_receive tbody').on('dblclick', 'tr', function(){
			
			getRequestDetails(selected_pkid);
			$('#btn_id_receive').prop('disabled',false);
			$('#btn_id_disapprove').prop('disabled', false);
			$('#btn_id_for_revision').prop('disabled', false);
		});
		
	}
	
	function getRequestDetails(selected_pkid){
		
		var data = {
			'action'	: 'getRequestDetails',
			'pkid'		: selected_pkid
		}
		
		data = $.param(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				
				var pkid = data['pkid_request'];
				
				$('#id_product_classification').val(data['product_class']);
				$('#id_receive_dept').val(data['dept']);
				$('#id_receive_sec').val(data['sec']);
				
				
				var reason = data['rft'];
				var job_function = data['job_func'];
				var allocation = data['al_alloc'];
				var requestor = data['requested_by'];
				var conformer = data['conformed_by'];
				
				if(reason == '1'){
					$('#id_receive_reason').val('Newly Hired');
				}else if(reason == '2'){
					$('#id_receive_reason').val('Promoted Employee');
				}else if(reason == '3'){
					$('#id_receive_reason').val('Transferred from other assembly line');
				}else if(reason == '4'){
					$('#id_receive_reason').val('Transferred from on other section/department/division');
				}else if(reason == '5'){
					$('#id_receive_reason').val('ML / SL / VL (whose leave reached at least 1 month)');
				}else if(reason == '6'){
					$('#id_receive_reason').val('New Product Line');
				}else if(reason == '7'){
					$('#id_receive_reason').val('Flexibility Certification');
				}else if(reason == '8'){
					$('#id_receive_reason').val('Re-certification');
				}
				
				if(job_function == '1'){
					$('#id_receive_jobfunc').val('Operator');
				}else if(job_function == '2'){
					$('#id_receive_jobfunc').val('Material Handler');
				}else if(job_function == '3'){
					$('#id_receive_jobfunc').val('Inspector');
				}else if(job_function == '4'){
					$('#id_receive_jobfunc').val('`Technician');
				}else if(job_function == '5'){
					$('#id_receive_jobfunc').val('Engineer');
				}else if(job_function == '6'){
					$('#id_receive_jobfunc').val('Supervisor');
				}
				
				if(allocation == '1'){
					$('#id_receive_alloc').val('Automotive Line');
				}else{
					$('#id_receive_alloc').val('Non-Automotive Line');
				}
				
				if(data['rec_status'] == '1' || data['conf_status'] == '0'){
					$('#btn_id_receive').prop('disabled',true);
					$('#btn_id_disapprove').prop('disabled', true);
					$('#btn_id_for_revision').prop('disabled', true);
				}
				
				getEmployeeList(pkid);
				getRequestorDetails(requestor);
				getConformerDetails(conformer);
				
				//new
				$('#summary_span_conf_email').text('---');
				$('#summary_span_conf_status').text('no status').removeClass('label-default label-primary label-info label-warning label-danger label-success').addClass('label-default');
				$('#summary_span_conf_remarks').text('none');

				$('#summary_span_rec_email').text('---');
				$('#summary_span_rec_status').text('no status').removeClass('label-default label-primary label-info label-warning label-danger label-success').addClass('label-default');
				$('#summary_span_rec_remarks').text('none');

				$('#summary_span_app_email').text('---');
				$('#summary_span_app_status').text('no status').removeClass('label-default label-primary label-info label-warning label-danger label-success').addClass('label-default');
				$('#summary_span_app_remarks').text('none');


				if( data['conformed_by'] != ''){
					$('#summary_span_conf_email').text( data['conformed_by'] );
				}
				if( data['received_by'] != ''){
					$('#summary_span_rec_email').text( data['received_by'] );
				}
				if( data['approved_by'] != ''){
					$('#summary_span_app_email').text( data['approved_by'] );
				}

				if( data['conf_remarks'] != ''){
					$('#summary_span_conf_remarks').text( data['conf_remarks'] );
				}
				if( data['rec_remarks'] != ''){
					$('#summary_span_rec_remarks').text( data['rec_remarks'] );
				}
				if( data['app_remarks'] != ''){
					$('#summary_span_app_remarks').text( data['app_remarks'] );
				}

				set_summary_status_value('#summary_span_conf_status', 1, data['conf_status']);
				set_summary_status_value('#summary_span_rec_status', 2, data['rec_status']);
				set_summary_status_value('#summary_span_app_status', 3, data['app_status']);
				//---


				$('#modal_id_receive').modal('show');
			},
			error	: function(data){
				alert('Error on retrieving request details.');
				console.log(data);
			}
		});
		
	}
	
	function getEmployeeList(pkid){
		
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
			
				$('#container_emplist').empty();
				
				var html  = '<table id="tbl_emplist" class="table table-bordered" style="margin-right: 20px; font-size: 12px;">';
					html += '	<thead>';
					html += '		<tr>';
					html += '			<th>Date Hired</th>';
					html += '			<th>Employee No.</th>';
					html += '			<th>Name</th>';
					html += '			<th colspan="2">From (Station/Product Name)</th>';	
					html += '			<th colspan="2">To (Station/Product Name)</th>';
					html += '		</tr>';
					html += '	</thead>';
					html += '	<tbody>';
					html += '	</tbody>';
					html += '</table>';
					
				$('#container_emplist').append(html);	
				
				for(i=0;i<ctr;i++){
						var html = '<tr id="'+data['pkid_trainees'][i]+'">';
						html += '   <td>'+data['date_hired'][i]+'</td>';
						html += '	<td>'+data['emp_no'][i]+'</td>';
						html += '	<td>'+data['emp_name'][i]+'</td>';	
						html += '	<td>'+data['from_station'][i]+'</td>';	
						html += '	<td>'+data['from_line'][i]+'</td>';
						html += '	<td>'+data['to_station'][i]+'</td>';
						html += '	<td>'+data['to_line'][i]+'</td>';
						html += '</tr>';
					 $('#tbl_emplist tbody').append(html);
				}
				
				var oTable = $('#tbl_emplist').DataTable({ paginate: true, aaSorting: [] });
			},
			error	: function(data){
				alert('Error on retrieving employee list');
				console.log(data);
			}
		});
	}
	
	function getRequestorDetails(requestor){
		
		var data = {
			'action'	: 'getRequestorDetails',
			'email'		: requestor[0]
		}
		
		data = $.param(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				var ln = data['lastname'];
				var fn = data['firstname'];
				
				var fullname = fn+" "+ln;
				
				$('#id_receive_requestor').val(fullname);
			},
			error	: function(data){
				alert('Error found in retrieving requestor');
				console.log(data);
			}
		});
		
	}
	
	function getConformerDetails(conformer){
		
		var data = {
			'action'	: 'getRequestorDetails',
			'email'		: conformer[0]
		}
		
		data = $.param(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				var ln = data['lastname'];
				var fn = data['firstname'];
				
				var fullname = fn+" "+ln;
				
				$('#id_receive_conformer').val(fullname);
			},
			error	: function(data){
				alert('Error found in retrieving requestor');
				console.log(data);
			}
		});
	}
	
	function generate_code(ctrl_no,counter){
		var data = {
					'action'		: 'receive_request',
					'pkid'			: selected_pkid,
					'receiver'		: email,
					'ctrl_no'		: ctrl_no,
					'counter'		: counter,
					'txt_remarks'	: $('#txt_remarks').val()
				}
		
				data = $.param(data);
				// alert(data);
				receive_request(data);
	}
	
	function receive_request(data){
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success : function(data){
				var pkid_receiving = data['pkid'];
				send_email_receive(pkid_receiving);
				
			},
			error	: function(data){
				alert('Error found on conforming request.');
				console.log(data);
			}
		});
		
	}
	
	function send_email_receive(pkid_receiving){
		var data = {
			'action'	: 'send_email_receive',
			'pkid'		: pkid_receiving,
			'email'		: email
		}
		
		data = $.param(data);
		
		// alert(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				$('#modal_id_receive').modal('hide');
				notif_success();
				display_receiving();
			},
			error	: function(data){
				alert('Error found in sending email receive');
				console.log(data);
			}
		});
	}


	function send_email_receive_disapprove(pkid_receiving){//novs remove the xx
		
		var data = {
			'action'	: 'send_email_conformance_disapprove',
			'pkid'		: pkid_receiving,
			'email'		: email
		}
		
		data = $.param(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				$('#modal_id_receive').modal('hide');
				notif_success();
				display_receiving();
			},
			error	: function(data){
				alert('Error found in sending email conformance');
				console.log(data);
			}
		});
	}

	function send_email_receive_return(pkid_receiving){//novs remove the xx
		
		var data = {
			'action'	: 'send_email_conformance_return',
			'pkid'		: pkid_receiving,
			'email'		: email
		}
		
		data = $.param(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				$('#modal_id_receive').modal('hide');
				notif_success();
				display_receiving();
			},
			error	: function(data){
				alert('Error found in sending email conformance');
				console.log(data);
			}
		});
	}
	
	function notif_success(){
		notif({
		msg: "<strong>System: </strong> Transaction successful!",
		type: "success",
		position: "center",
		timeout: "3000"
		});
	}
	