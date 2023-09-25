
	var handler = '../handler/handler.php';
	var selected_pkid ='';
	var email = $('#hidden_email').val();
	// var email = email1+'@pricon.ph';
	
	disable_input();
	get_empno('');
	display_my_request(email);
	
	$('#id_crt_type').change(function(){
		
		var selected_type = $('#id_crt_type').val();
		
		if(selected_type == 'SUBCON'){
		
			// datalist to check employee number
			enable_input();
			clear_fields();
			$('#id_empno_check').keyup(function(e){
				var key_pressed = e.which;
				if(key_pressed != 38 && key_pressed != 40){
				var pattern = $(this).val();
				get_empno(pattern);
				}
				empno_check_db();
			});
			
		}else{
		
			enable_input();
			clear_fields();
			$('#id_empno_check').keyup(function(e){
				var key_pressed = e.which;
				if(key_pressed != 38 && key_pressed != 40){
				var pattern = $(this).val();
				get_empno(pattern);
				}
				
				// alert(pattern);
				empno_check_db2();
			});
			
		}
		
	});
	
	
	$(document).ready(function(){
	
		// $('#btn_create_request').click(function(){
		// 	$('#txt_request_pkid').val('');
		// 	$('#modal_create_request').modal('show');
		// });
		
		$('#btn_id_add_emp_details').click(function(){
			$('#modal_crt_add_emp').modal('show');
		}); 
		
		$('#btn_check_details').click(function(){
			var empno = $('#id_empno_check').val();
			
			var data = {
				'action'		: 'check_empno_details',
				'empno'			: empno
			}
			
			data = $.param(data);
			
			$.ajax({
				type	: 'post',
				dataType: 'json',
				data	: data,
				url		: handler,
				success	: function(data){
					
					var fullName = data['LastName']+', '+data['FirstName']+' '+data['MiddleName'];
					$('#id_emp_name').val(fullName);
					$('#id_emp_dateHired').val(data['DateHired']);
				
				},
				error	: function(data){
					alert('check details failed!');
					console.log(data);
				}
			});
			
		});
		
		$('#btn_id_add_emp').click(function(e){
			
			var EmpNo = $('#id_empno_check').val();
			var name = $('#id_emp_name').val();
			var dateHired = $('#id_emp_dateHired').val();
			var from_station = $('#id_emp_fstation').val();
			var from_prodName = $('#id_emp_fprodname').val();
			var to_station = $('#id_emp_tstation').val();
			var to_prodName = $('#id_emp_tprodname').val();
			
			if(name==''||EmpNo==''||from_station==''||from_prodName==''||to_station==''||to_prodName==''){
				alert('Please fill all the fields to continue.');
				return false;
			}
			if( $('#tbl_trainees tbody tr > td:contains('+EmpNo+')').length > 0 ){
				alert('Employee already exist.');
				return false;
			}

			$('#tbl_trainees tbody').append('<tr><td>'+dateHired+'</td><td>'+EmpNo+'</td><td>'+name+'</td><td>'+from_station+'</td><td>'+from_prodName+'</td><td>'+to_station+'</td><td>'+to_prodName+'</td><td><a href="#"</a>Cancel</td></tr>');
			
			clear_query();
		});
		
		$('#modal_close').click(function(){
			
			// $('#modal_previous_request').modal('show');
		});
		
		$('#form_id_create_request').submit(function(e){
			e.preventDefault();

			if ( !tableDataChecker() ) {
			
				if($("[name='name_superior_name']").val() == ''){
					alert('Please indicate Approver');
				}else{
					
					var table_validity = $("#tbl_trainees tbody");
					
					if (table_validity.children().length == 0) {
						
						alert('Table is empty. Please add an employee.');//novs edit
						
					} else {
						
						var data = {
							'action'	: 'send_new_request'
						}
						
						data = $.param(data) + "&" + $(this).serialize();
						
						$.ajax({
						
							type	: 'post',
							dataType: 'json',
							data	: data,
							url		: handler,
							success	: function(data){
							
								var assigned_pkid = data['result'];
								// send_request_email(assigned_pkid);//novs edit
								
								// $.when(send_request_email).done(function() {//novs edit
									add_new_employees(assigned_pkid);//novs edit
								// });//novs edit
								rapidSetEmployeeToRFTMemoIncluded(assigned_pkid)
								location.reload()
								
							},
							error	: function(data){
								alert('Error on submitting new request. Please contact ISS Administrator');
								console.log(data);
							}
						});
						
					}
				}

			}else{
				alert('Please complete the all employee information.');
			}
			
		});
		
		$('#tbl_trainees tbody').on('click','tr a', function(){
			var selected_row = $(this).closest('tr').remove();
		});
		
		$('#container_request').on('click', '#tbl_request_list #id_btn_cancel_request', function(){
			var confirm_cancel = confirm('Are you sure you want to cancel the request?');
			if(confirm_cancel){
				var data = {
	        		_token: '',
					'action'	: 'cancel_request',
					'pkid'		: selected_pkid
				}
				
				data = $.param(data);
				
				cancel_request(data);
			}
		})
		$('#container_request').on('click', '#tbl_request_list #id_btn_view_request', function(){
			getRequestDetails(selected_pkid);
			
			$.when(getRequestDetails).done(function(){
				$('#modal_id_request').modal('show');
			});
		})

	
	});
	

	// datalist to check requestors immediate superior
	$('#id_superior_check').on('keyup',function(e){
		var key_pressed = e.which;
		if(key_pressed !=38 && key_pressed !=40){
		var pattern_superior = $(this).val();
		get_immediate_superior(pattern_superior);
		}
	});

	$('#id_final_approver_check').on('keyup',function(e){
		var key_pressed = e.which;
		if(key_pressed !=38 && key_pressed !=40){
		var pattern_superior = $(this).val();
		get_final_approver(pattern_superior);
		}
	});
	
	// datalist passes value to check email setup
	$('#id_superior_check').on('change hover',function(e){
		get_superior_email( $(this).val() );
	});

	$('#id_final_approver_check').on('change hover',function(e){
		$('#id_final_approver_name').val( '' );
		var thiss = $(this).val();
		$('#id_final_approver_list option').each(function(index) {
		    var id = $(this).attr('id');
		    var val = $(this).val();
		    var name = $(this).text();
		    if(thiss == name){
				$('#id_final_approver_name').val( id );
		    }
		});
	});

	
	$('#display_granted_request').click(function(){
		display_granted_request(email);
		$('#modal_previous_request').modal('show');
	});


	function get_request_td_value(indx,td_con,td_rec,td_app, log_del){
		var td_text_arr = ['CONFORMED','RECEIVED','APPROVED']
		var tds = [td_con,td_rec,td_app];
		var current_td = tds[indx];

		var td_text 		= '';
		var td_bg 			= '';

		if( current_td == '0'){
			td_text 		= 'QUEUED';
			td_bg 			= 'label label-default';
			if( indx == 0 || (indx == 1 && td_con == 1) || (indx == 2 && td_rec == 1) ){
				td_text 		= 'ON-GOING';
				td_bg 			= 'label label-info';
			}
			if(log_del == 1){
				td_text 		= '---';
				td_bg 			= '';
			}
		}
		else if( current_td == '1'){
			td_text 		= td_text_arr[indx];
			td_bg 			= 'label label-success';
		}
		else if( current_td == '3'){
			td_text 		= 'DISAPPROVED';
			td_bg 			= 'label label-danger';
		}
		else if( current_td == '4'){
			td_text 		= 'FOR REVISION';
			td_bg 			= 'label label-warning';
		}


		if(indx == 1){//rec
			if( td_con == '3' || td_con == '4' ){
				td_text 		= '---';
				td_bg 			= '';
			}
		}
		if(indx == 2){//app
			if( td_con == '3' || td_rec == '3' || td_con == '4' || td_rec == '4' ){
				td_text 		= '---';
				td_bg 			= '';
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

	function display_my_request(email){
	
		var data = {
			'action'	: 'display_my_request',
			'email'		: email
		}
		
		data = $.param(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
			
				var ctr = data['ctr'];
			
				$('#container_request').empty();
			
				var html  = '<table id="tbl_request_list" class="table table-bordered " style="padding: 20px; margin-right: 20px; font-size: 15px;">';
					html += '	<thead>';
					html += '		<tr>';
					html += '			<th>HR Memo Ctrl No.</th>';
					html += '			<th>Control No.</th>';
					html += '			<th>Date Filed</th>';
					html += '			<th>Conformance</th>';
					html += '			<th>Receiving</th>';	
					html += '			<th>QC Head Approval</th>';
					html += '			<th>Actions</th>';
					html += '		</tr>';
					html += '	</thead>';
					html += '	<tbody>';
					html += '	</tbody>';
					html += '</table>';
					
				$('#container_request').append(html);	
			
				for(i=0;i<ctr;i++){
						var html = '<tr id="'+data['pkid_request'][i]+'">';

						html += '<td style="vertical-align: middle;">'+data['hr_ctrl_no'][i]+'</span></td>';

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

						var td_val_arr 	= get_request_td_value(0,td_con,td_rec,td_app,0);
						html += '<td style="vertical-align: middle;"><span class="'+td_val_arr[0]+' small">'+td_val_arr[1]+'</span></td>';
						td_val_arr 	= get_request_td_value(1,td_con,td_rec,td_app,0);
						html += '<td style="vertical-align: middle;"><span class="'+td_val_arr[0]+' small">'+td_val_arr[1]+'</span></td>';
						td_val_arr 	= get_request_td_value(2,td_con,td_rec,td_app,0);
						html += '<td style="vertical-align: middle;"><span class="'+td_val_arr[0]+' small">'+td_val_arr[1]+'</span></td>';
						//-----
						html +='<td>';
						html +='	<button id="id_btn_view_request" class="btn btn-sm btn-success">View</button>';
						html +='	<button id="id_btn_cancel_request" class="btn btn-sm btn-danger">Cancel</button>';//novs add
						html +='</td>';
						
						html += '</tr>';
						$('#tbl_request_list tbody').append(html);
				}
				
			
			
			var oTable = $('#tbl_request_list').DataTable({ paginate: true, aaSorting: []});
			table_events_tbl_request_list();
			
			// $('#id_btn_view_request').click(function(){
				// alert(selected_pkid+'xx');//novs edit //should be removed this block of comments
			// });	
			},
			error	: function(data){
				alert('Error on loading your requests');
				console.log(data);
			}
		});
		
	}
	
	function display_granted_request(email){
	
		var data = {
			'action'	: 'display_my_granted_request',
			'email'		: email
		}
		
		data = $.param(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				
				console.log(data);
			
				var ctr = data['ctr'];
			
				$('#container_granted_request').empty();
			
				var html  = '<table id="tbl_request_list2" class="table table-bordered " style="margin-right: 20px; font-size: 15px;">';
					html += '	<thead>';
					html += '		<tr>';
					html += '			<th>HR Memo Ctrl No.</th>';
					html += '			<th>Control No.</th>';
					html += '			<th>Date Filed</th>';
					html += '			<th>Conformance</th>';
					html += '			<th>Receiving</th>';	
					html += '			<th>QC Head Approval</th>';
					html += '			<th>Status</th>';
					// html += '			<th>View Details</th>';
					html += '		</tr>';
					html += '	</thead>';
					html += '	<tbody>';
					html += '	</tbody>';
					html += '</table>';
					
				$('#container_granted_request').append(html);	
			
				for(i=0;i<ctr;i++){
					
						var html = '<tr id="'+data['pkid_request'][i]+'">';

						html += '<td style="vertical-align: middle;">'+data['hr_ctrl_no'][i]+'</span></td>';
						
						if(data['control_no'][i]==''){
							html += '   <td style="vertical-align: middle;"><span class="label label-success">TBA</span></td>';
						}else{
							html += '   <td style="vertical-align: middle;">'+data['control_no'][i]+'</td>';
						}
						
						html += '	<td style="vertical-align: middle;">'+data['date_filed'][i]+'</td>';
						


						var td_con 		= data['conf_status'][i];
						var td_rec 		= data['rec_status'][i];
						var td_app 		= data['app_status'][i];
						var log_del 	= data['log_del'][i];
						//-----
						var td_val_arr 	= get_request_td_value(0,td_con,td_rec,td_app,log_del);
						html += '<td style="vertical-align: middle;"><span class="'+td_val_arr[0]+' small">'+td_val_arr[1]+'</span></td>';
						td_val_arr 	= get_request_td_value(1,td_con,td_rec,td_app,log_del);
						html += '<td style="vertical-align: middle;"><span class="'+td_val_arr[0]+' small">'+td_val_arr[1]+'</span></td>';
						td_val_arr 	= get_request_td_value(2,td_con,td_rec,td_app,log_del);
						html += '<td style="vertical-align: middle;"><span class="'+td_val_arr[0]+' small">'+td_val_arr[1]+'</span></td>';
						//-----
						var td_status_text = ['DONE','CANCELLED','DISAPPROVED','?'];
						var td_status_bg = ['label label-success','label label-default','label label-danger',''];
						var indx = 3;

						if(log_del == '1'){
							indx = 1;//cancelled
						}else{
							if(td_app == 1){
								indx = 0;//done
							}
							else{
								indx = 2;//disapproved
							}
						}
						html += '<td style="vertical-align: middle;"><span class="'+td_status_bg[indx]+' small">'+td_status_text[indx]+'</span></td>';
						



						// html += '   <td style="vertical-align: middle;"><button class="btn btn-default"><span class="fa fa-cloud-download" style="border-radius: 0px;"> Download</span></button></td>';
												
						html += '</tr>';
						$('#tbl_request_list2 tbody').append(html);
				}
			
			var oTable = $('#tbl_request_list2').DataTable({ paginate: true, aaSorting: []});
			table_events_tbl_request_list2();
			},
			error	: function(data){
				alert('Error on loading your requests');
				console.log(data);
			}
		});
		
	}
	
	function get_immediate_superior(pattern_superior){
		var data = {
			'action'			: 'get_immediate_superior',
			'pattern_superior'	: pattern_superior
		} 
		data = $.param(data) + "&" + $(this).serialize();
		
		// alert(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				console.log(data);
				var ctr = data['ctr'];
				$('#id_superior_list').empty();
				for(i=0;i<ctr;i++){
					var html = '<option id="'+data['pkid'][i]+'">'+data['lastname'][i]+', '+data['firstname'][i]+'</option>';
					$('#id_superior_list').append(html);
				}
			},
			error	: function(data){
				alert('Error found in Superior Listing.');
				console.log(data);
			}
			
		});
	}

	function get_final_approver(pattern_superior){
		var data = {
			'action'			: 'get_final_approver',
			'pattern_superior'	: pattern_superior
		} 
		data = $.param(data) + "&" + $(this).serialize();
		
		// alert(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				console.log(data);
				var ctr = data['ctr'];
				$('#id_final_approver_list').empty();
				for(i=0;i<ctr;i++){
					var html = '<option id="'+data['Email'][i]+'">'+data['Name'][i]+'</option>';
					$('#id_final_approver_list').append(html);
				}
			},
			error	: function(data){
				alert('Error found in Final Approver Listing.');
				console.log(data);
			}
			
		});
	}
	
	function get_superior_email(superior_name){
		var data = {
			'action'			: 'get_superior_email',
			'superior_name'		: superior_name
		} 
		data = $.param(data);
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				$('#id_superior_name').val(data['email_add']);
			},
			error	: function(data){
				alert('Error found in Superior Listing.');
				console.log(data);
			}
			
		});
	}
	
	function get_empno(pattern){
		
		var data = {
			'action'		: 'action_get_empno',
			'pattern'		: pattern
		}
	
		data = $.param(data) + "&" + $(this).serialize();
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				
				var ctr = data['ctr'];
				
				$('#id_crt_name').empty();
				
				for(i=0;i<ctr;i++){
					var html = '<option>'+data['EmpNo'][i]+'</option>';
					$('#id_crt_name').append(html);
				}
				
			},
			error	: function(data){
				alert("Handler Failed!");
				console.log(data);
			}
		});
	}
	
	function empno_check_db(){
			var empno = $('#id_empno_check').val();
			
			var data = {
				'action'		: 'check_empno_details',
				'empno'			: empno
			}
			
			data = $.param(data) + "&" + $(this).serialize();
			
			$.ajax({
				type	: 'post',
				dataType: 'json',
				data	: data,
				url		: handler,
				success	: function(data){
					
					if(typeof data['LastName'] === "undefined"){
						$('#id_emp_name').val('Not Found!');
						$('#id_emp_dateHired').val('Not Found!');
					}else{
						var fullName = data['LastName']+', '+data['FirstName']+' '+data['MiddleName'];
						$('#id_emp_name').val(fullName);
						$('#id_hidden_firstname').val(data['FirstName']);
						$('#id_hidden_lastname').val(data['LastName']);
						$('#id_hidden_middlename').val(data['MiddleName']);
						$('#id_emp_dateHired').val(data['DateHired']);
					}
				},
				error	: function(data){
					alert('check details failed!');
					console.log(data);
				}
			});
		}
		
	function empno_check_db2(){
			var empno = $('#id_empno_check').val();
			
			var data = {
				'action'		: 'check_empno_details2',
				'empno'			: empno
			}
			
			data = $.param(data) + "&" + $(this).serialize();
			
			$.ajax({
				type	: 'post',
				dataType: 'json',
				data	: data,
				url		: handler,
				success	: function(data){
					
					if(typeof data['LastName'] === "undefined"){
						$('#id_emp_name').val('Not Found!');
						$('#id_emp_dateHired').val('Not Found!');
					}else{
						var fullName = data['LastName']+', '+data['FirstName']+' '+data['MiddleName'];
						$('#id_emp_name').val(fullName);
						$('#id_hidden_firstname').val(data['FirstName']);
						$('#id_hidden_lastname').val(data['LastName']);
						$('#id_hidden_middlename').val(data['MiddleName']);
						$('#id_emp_dateHired').val(data['DateHired']);
					}
				},
				error	: function(data){
					alert('check details failed!');
					console.log(data);
				}
			});
		}
		
	function clear_query(){
		$('#id_empno_check').val('');
		$('#id_emp_name').val('');
		$('#id_emp_dateHired').val('');
	}
	
	function add_new_employees(assigned_pkid){
	
		$('#tbl_trainees tr').each(function(row, tr){
			
			if(row>0){
			
				// var dateHired = $(tr).find('td:eq(0)').text();
				// var empNo = $(tr).find('td:eq(1)').text();
				// var name = $(tr).find('td:eq(2)').text();
				// var fstation = $(tr).find('td:eq(3)').text();
				// var fprod = $(tr).find('td:eq(4)').text();
				// var tstation = $(tr).find('td:eq(5)').text();
				// var tprod = $(tr).find('td:eq(6)').text();

				var dateHired = $(tr).find('td:eq(1)').text();
				var empNo = $(tr).find('td:eq(2)').text();
				var name = $(tr).find('td:eq(3)').text();
				var fstation = $(tr).find('td:eq(4)').text();
				var fprod = $(tr).find('td:eq(5)').text();
				var tstation = $(tr).find('td:eq(6)').text();
				var tprod = $(tr).find('td:eq(7)').text();
			
				var data = {
					'action'		: 'add_new_employees',
					'pkid'			: assigned_pkid,
					'empNo'			: empNo,
					'name'			: name,
					'fstation'		: fstation,
					'fprod'			: fprod,
					'tstation'		: tstation,
					'tprod'			: tprod,
					'dateHired'		: dateHired
				}
				
				data = $.param(data);
				
				$.ajax({
				
					type	: 'post',
					dataType: 'json',
					data	: data,
					url		: handler,
					success	: function(data){
						//notif_success();
						$('#modal_create_request').modal('hide');
					},
					error	: function(data){
						alert("Error found in saving employees. Please contact ISS Administrator.")
						console.log(data);
					}
					
				});
				
			}
			
		});
		
	}
	
	function table_events_tbl_request_list2(){
		
		$('#tbl_request_list2 tbody').on('click','tr', function(){
			selected_pkid = '';
			$('#tbl_request_list tbody tr').attr('style','');
			$(this).attr('style','background:#7a9d00 ;color:white;');
			selected_pkid = this.id;
		});
		
		$('#tbl_request_list2 tbody').on('dblclick', 'tr', function(){
			$('#modal_id_request').modal('show');
			getRequestDetails(selected_pkid);
			$('#modal_previous_request').modal('hide');
			
		});
		
	}
	
	function table_events_tbl_request_list(){
		
		$('#tbl_request_list tbody').on('click','tr', function(){
			selected_pkid = '';
			$('#tbl_request_list tbody tr').attr('style','');
			$(this).attr('style','background:#7a9d00 ;color:white;');
			selected_pkid = this.id;
		});
		
		$('#tbl_request_list tbody').on('dblclick', 'tr', function(){
			
			getRequestDetails(selected_pkid);
			
			$.when(getRequestDetails).done(function(){
				$('#modal_id_request').modal('show');
			});
		});

		$('#btn_edit_request').on('click', function(){
			$('#modal_id_request').modal('hide');

			setProductClassification()

			$('#id_crt_dept').attr('readonly', true)
			$('#id_crt_sec').attr('readonly', true)
			$('#id_crt_jobfunc').attr('readonly', true)
			$('#id_crt_alloc').attr('readonly', true)
			$('#id_crt_reason').attr('readonly', true)
			$('#id_crt_product_classification').attr('readonly', true)

			$('#div_id_crt_classification').attr('hidden', true)
			$('#div_id_crt_hr_memo_ctrl_no').attr('hidden', true)

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
					$('#txt_request_pkid').val(pkid);
					
					$('#id_crt_dept').val(data['dept']);
					$('#id_crt_sec').val(data['sec']);
					
					var reason = data['rft'];
					var job_function = data['job_func'];
					var allocation = data['al_alloc'];
					

					$('#id_crt_product_classification').val(data['product_class']);
					$('#txt_hr_ctrl_no').val(data['hr_ctrl_no']);
					
					$('#id_crt_reason').val(reason);

					// if(reason == '1'){
					// 	$('#id_crt_reason').val('Newly Hired');
					// }else if(reason == '2'){
					// 	$('#id_crt_reason').val('Promoted Employee');
					// }else if(reason == '3'){
					// 	$('#id_crt_reason').val('Transferred from other assembly line');
					// }else if(reason == '4'){
					// 	$('#id_crt_reason').val('Transferred from on other section/department/division');
					// }else if(reason == '5'){
					// 	$('#id_crt_reason').val('ML / SL / VL (whose leave reached at least 1 month)');
					// }else if(reason == '6'){
					// 	$('#id_crt_reason').val('New Product Line');
					// }else if(reason == '7'){
					// 	$('#id_crt_reason').val('Flexibility Certification');
					// }else if(reason == '8'){
					// 	$('#id_crt_reason').val('Re-certification');
					// }
					
					$('#id_crt_jobfunc').val(job_function);
					// if(job_function == '1'){
					// 	$('#id_crt_jobfunc').val('Operator');
					// }else if(job_function == '2'){
					// 	$('#id_crt_jobfunc').val('Material Handler');
					// }else if(job_function == '3'){
					// 	$('#id_crt_jobfunc').val('Inspector');
					// }else if(job_function == '4'){
					// 	$('#id_crt_jobfunc').val('Technician');
					// }else if(job_function == '5'){
					// 	$('#id_crt_jobfunc').val('Engineer');
					// }else if(job_function == '6'){
					// 	$('#id_crt_jobfunc').val('Supervisor');
					// }
					
					$('#id_crt_alloc').val(allocation);
					// if(allocation == '1'){
					// 	$('#id_crt_alloc').val('Automotive Line');
					// }else{
					// 	$('#id_crt_alloc').val('Non-Automotive Line');
					// }

					$('#id_superior_name').val(data['conformed_by']);

					//here
					getEmployeeList_for_edit(pkid);
					
					//new
					$('.row_remarks').hide();
					$('#conf_remarks_container').hide();
					$('#rec_remarks_container').hide();
					$('#app_remarks_container').hide();

					$('#div_conf_remarks').text('');
					$('#div_rec_remarks').text('');
					$('#div_app_remarks').text('');

					var conf_remarks 	= data['conf_remarks'];
					var rec_remarks 	= data['rec_remarks'];
					var app_remarks 	= data['app_remarks'];
					if(conf_remarks != ''){
						$('.row_remarks').show();
						$('#conf_remarks_container').show();
						$('#div_conf_remarks').text(conf_remarks);
					}
					if(rec_remarks != ''){
						$('.row_remarks').show();
						$('#rec_remarks_container').show();
						$('#div_rec_remarks').text(rec_remarks);
					}
					if(app_remarks != ''){
						$('.row_remarks').show();
						$('#app_remarks_container').show();
						$('#div_app_remarks').text(app_remarks);
					}

					$('#modal_create_request').modal('show');
				},
				error	: function(data){
					alert('Error on retrieving request details.');
					console.log(data);
				}
			});
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
				$('#id_request_dept').val(data['dept']);
				$('#id_request_sec').val(data['sec']);
				
				var reason = data['rft'];
				var job_function = data['job_func'];
				var allocation = data['al_alloc'];
				
				if(reason == '1'){
					$('#id_request_reason').val('Newly Hired');
				}else if(reason == '2'){
					$('#id_request_reason').val('Promoted Employee');
				}else if(reason == '3'){
					$('#id_request_reason').val('Transferred from other assembly line');
				}else if(reason == '4'){
					$('#id_request_reason').val('Transferred from on other section/department/division');
				}else if(reason == '5'){
					$('#id_request_reason').val('ML / SL / VL (whose leave reached at least 1 month)');
				}else if(reason == '6'){
					$('#id_request_reason').val('New Product Line');
				}else if(reason == '7'){
					$('#id_request_reason').val('Flexibility Certification');
				}else if(reason == '8'){
					$('#id_request_reason').val('Re-certification');
				}
				
				if(job_function == '1'){
					$('#id_request_jobfunc').val('Operator');
				}else if(job_function == '2'){
					$('#id_request_jobfunc').val('Material Handler');
				}else if(job_function == '3'){
					$('#id_request_jobfunc').val('Inspector');
				}else if(job_function == '4'){
					$('#id_request_jobfunc').val('Technician');
				}else if(job_function == '5'){
					$('#id_request_jobfunc').val('Engineer');
				}else if(job_function == '6'){
					$('#id_request_jobfunc').val('Supervisor');
				}
				
				if(allocation == '1'){
					$('#id_request_alloc').val('Automotive Line');
				}else{
					$('#id_request_alloc').val('Non-Automotive Line');
				}
				
				getEmployeeList(pkid);
				
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
				$('#btn_edit_request').hide();
				if(data['conf_status']==4||data['rec_status']==4||data['app_status']==4){
					$('#btn_edit_request').show();
				}

				$('#modal_id_request').modal('show');
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

	// function getEmployeeList_for_edit(pkid){
		
	// 	var data = {
	// 		'action'	: 'getEmployeeList',
	// 		'pkid'		: pkid[0]
	// 	}
		
	// 	data = $.param(data);
		
	// 	$.ajax({
	// 		type	: 'post',
	// 		dataType: 'json',
	// 		data	: data,
	// 		url		: handler,
	// 		success	: function(data){
				
	// 			var ctr = data['ctr'];
			
	// 			// $('#tbl_trainees').empty();
				
	// 			// var html  = '<table id="tbl_emplist" class="table table-bordered" style="padding: 20px; margin-right: 20px; font-size: 12px;">';
	// 			// 	html += '	<thead>';
	// 			// 	html += '		<tr>';
	// 			// 	html += '			<th>Date Hired</th>';
	// 			// 	html += '			<th>Employee No.</th>';
	// 			// 	html += '			<th>Name</th>';
	// 			// 	html += '			<th colspan="2">From (Station/Product Name)</th>';	
	// 			// 	html += '			<th colspan="2">To (Station/Product Name)</th>';
	// 			// 	html += '		</tr>';
	// 			// 	html += '	</thead>';
	// 			// 	html += '	<tbody>';
	// 			// 	html += '	</tbody>';
	// 			// 	html += '</table>';
					
	// 			// $('#tbl_trainees').append(html);	
	// 			var html = '';

	// 			$('#tbl_trainees tbody').html('');

	// 			for(i=0;i<ctr;i++){
	// 					var html = '<tr>';
	// 					html += '   <td>'+data['date_hired'][i]+'</td>';
	// 					html += '	<td>'+data['emp_no'][i]+'</td>';
	// 					html += '	<td>'+data['emp_name'][i]+'</td>';	
	// 					html += '	<td>'+data['from_station'][i]+'</td>';	
	// 					html += '	<td>'+data['from_line'][i]+'</td>';
	// 					html += '	<td>'+data['to_station'][i]+'</td>';
	// 					html += '	<td>'+data['to_line'][i]+'</td>';
	// 					html += '	<td>'+'<a href="#"</a>Cancel'+'</td>';
	// 					html += '</tr>';
	// 				 $('#tbl_trainees tbody').append(html);
	// 			}
	// 		// $('#tbl_trainees tbody').append('<tr><td>'+dateHired+'</td><td>'+EmpNo+'</td><td>'+name+'</td><td>'+from_station+'</td><td>'+from_prodName+'</td><td>'+to_station+'</td><td>'+to_prodName+'</td><td><a href="#"</a>Cancel</td></tr>');
	// 			// var oTable = $('#tbl_emplist').DataTable({ paginate: true, aaSorting: [] });
	// 		},
	// 		error	: function(data){
	// 			alert('Error on retrieving employee list');
	// 			console.log(data);
	// 		}
	// 	});
	// }


	function cancel_request(data){
		
		$.ajax({
			
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				$.ajax({
					method	: 'post',
					dataType: 'json',
					data	: data,
					url		: "http://192.168.3.31/TrainingRecordDatabaseSystem/rapidCancelHRMemoInRequest",
				});
				notif_success();
				display_my_request(email);
				setClassification()
			},
			error	: function(data){
				alert('Error found on cancellation of request');
				console.log(data);
			}
			
		});
		
	}
	
	function send_request_email(assigned_pkid){//novs edit
		
		var data = {
			'action'	: 'send_email_request',
			'email'		: email,
			'pkid'		: assigned_pkid
		}

		data = $.param(data);
		
		$.ajax({
		
			type 	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				notif_email_success();
				display_my_request(email);
			},
			error	: function(data){
				alert('Error found in sending email');
				console.log(data);
			}
		});
		
	}
	
	function disable_input(){
		$('#id_empno_check').prop('disabled', true);
		$('#id_emp_name').prop('disabled', true);
		$('#id_emp_dateHired').prop('disabled', true);
	}
	
	function enable_input(){
		$('#id_empno_check').prop('disabled', false);
		$('#id_emp_name').prop('disabled', false);
		$('#id_emp_dateHired').prop('disabled', false);
	}
	
	function clear_fields(){
		$('#id_empno_check').val('');
		$('#id_emp_name').val('');
		$('#id_emp_dateHired').val('');
		
	}
	
	function notif_success(){
		notif({
		msg: "<strong>System: </strong> Transaction successful!",
		type: "success",
		position: "center",
		timeout: "3000"
		});
	}
	
	function notif_email_success(){
		notif({
		msg: "<strong>System: </strong> Email sent!",
		type: "success",
		position: "center",
		timeout: "3000"
		});
	}
	
	function notif_email_ok(){
		notif({
		msg: "<strong>System: </strong> Email was sent!",
		type: "success",
		position: "center",
		timeout: "3000"
		});
	}
	
	function notif_email_fail(){
		notif({
		msg: "<strong>System: </strong> Email problem!",
		type: "danger",
		position: "center",
		timeout: "3000"
		});
	}
	
	
	