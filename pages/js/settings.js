
	var handler = '../handler/handler.php';
	var selected_pkid = '';
	var oTable	= '';
	
	display_user_access_list();
	
	$(document).ready(function(){
		
		$('#id_btn_addtolist').click(function(){
			
			$('#id_modal_add_accesstolist').modal('show');
			
		});
		
		$("input[type=radio]").click(function() {
			
			var previousValue = $(this).data('storedValue');
			
			if (previousValue){
				
			  $(this).prop('checked', !previousValue);
			  $(this).data('storedValue', !previousValue);
			  
			}else{
				
			  $(this).data('storedValue', true);
			  $("input[type=radio]:not(:checked)").data("storedValue", false);
			  
			}
			
		});
		
		$('#id_form_addAccess').submit(function(e){
			e.preventDefault();
			
			var data = {
				'action'	: 'add_user_access'
			}
			
			data = $.param(data) + "&" + $(this).serialize();
			
			$.ajax({
				type	: 'post',
				dataType: 'json',
				data	: data,
				url		: handler,
				success	: function(data){
					oTable.destroy();
					
					console.log(data);
					notif_success(function() {
						alert('Registration Successful!');
						// $('table_user_access_list').empty();
						// display_user_access_list();
						location.reload();
					});
					$('#id_modal_add_accesstolist').modal('hide');
					
					
				},
				error	: function(data){
					console.log(data);
				}
			});
			
		});
		
	});
	
	function display_user_access_list(){
		
		var data = {
			'action'		: 'display_user_access_list'
		}
		
		data = $.param(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
					
				var ctr = data['ctr'];
				$('table_user_access_list').empty();
				
				var html = '<table id="tbl_user_access" align="center" class="table table-bordered overflow-x" style="padding: 20px; margin-right: 20px; font-size: 15px;">';
					html += '	<thead>';
					html += '		<tr>';
					html += '			<th>ID No.</th>';
					html += '			<th>Name</th>';
					html += '			<th>Email Address</th>';
					html += '			<th>Welcome Page</th>';
					html += '			<th>Request Page</th>';
					html += '			<th>Conformance Page</th>';
					html += '			<th>Receiving Page</th>';
					html += '			<th>Approval</th>';
					html += '		</tr>';
					html += '	</thead>';
					html += '	<tbody>';
					html += '	</tbody>';
					html += '</table>';
					
				$('#table_user_access_list').append(html);
				
				var html = '';
				
				for(i=0;i<ctr;i++){
						html += '<tr id="'+data['RequestNo'][i]+'">';
						html += '<td>'+data['RequestNo'][i]+'</td>';
						html += '<td>'+data['Name'][i]+'</td>';
						html += '<td>'+data['Email'][i]+'</td>';
						
						
						if (data['Welcome'][i] == '1'){
							html += '<td><span class="fa fa-check"></span></td>';
						}else{
							html += '<td><span class="fa fa-times"></span></td>';
						}
						
						if (data['Request'][i] == '1'){
							html += '<td><span class="fa fa-check"></span></td>';
						}else{
							html += '<td><span class="fa fa-times"></span></td>';
						}
						
						if (data['Conformance'][i] == '1'){
							html += '<td><span class="fa fa-check"></span></td>';
						}else{
							html += '<td><span class="fa fa-times"></span></td>';
						}
						
						if (data['Receiving'][i] == '1'){
							html += '<td><span class="fa fa-check"></span></td>';
						}else{
							html += '<td><span class="fa fa-times"></span></td>';
						}
						
						if (data['Approval'][i] == '1'){
							html += '<td><span class="fa fa-check"></span></td>';
						}else{
							html += '<td><span class="fa fa-times"></span></td>';
						}
						
						html += '</tr>';
						
				}
				
				$('#tbl_user_access tbody').append(html);
				
				
				oTable = $('#tbl_user_access').DataTable({ paginate: true, aaSorting: []});
				event_tbl_user_access();
			},
			error	: function(data){
				console.log(data);
			}
		});
		
	}
	
	function event_tbl_user_access(){
	
		$('#tbl_user_access tbody').on('click', 'tr', function(){
		
			selected_pkid = '';
			$('tbl_user_access tbody tr').attr('style', '');
			$(this).attr('style', 'background: #7a9d00; color: #ffffff');
			selected_pkid = this.id;
		
		});
		
	}
	
	
	
	function notif_success(callback){
		notif({
		msg: "<strong>System: </strong> Transaction successful!",
		type: "success",
		position: "center",
		timeout: "3000"
		});
		callback();
	}
	
	
	// 
	