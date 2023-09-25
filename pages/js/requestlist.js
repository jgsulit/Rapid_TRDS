
	var handler = '../handler/handler.php';
	var selected_pkid = '';
	
	
	$(document).ready(function(){
		
		display_list_of_received();
		
	});
	
	function display_list_of_received(){
		
		var data = {
			'action'		: 'display_list_of_received'
		}
		
		data = $.param(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				
				var ctr = data['ctr'];
				
				$('#container_list_of_received').empty();
			
				var html  = '<table id="tbl_received" class="table table-bordered" style="padding: 20px; margin-right: 20px; font-size: 12px;">';
					html += '	<thead>';
					html += '		<tr>';
					html += '			<th>HR Memo Ctrl No.</th>';
					html += '			<th>Control No.</th>';
					html += '			<th>Date Filed</th>';
					html += '			<th>Requested By</th>';
					html += '			<th>Remarks</th>';
					html += '			<th width="10%"></th>';
					html += '		</tr>';
					html += '	</thead>';
					html += '	<tbody>';
					html += '	</tbody>';
					html += '</table>';
					
				$('#container_list_of_received').append(html);	
				
				for(i=0;i<ctr;i++){
						var html = '<tr id="'+data['pkid_request'][i]+'">';
							html += '<td>'+data['hr_ctrl_no'][i]+'</td>';
							html += '<td>'+data['control_no'][i]+'</td>';
							html += '<td>'+data['date_filed'][i]+'</td>';
							html += '<td>'+data['requested_by'][i]+'</td>';
							if(data['remarks'] == ''){
								html += '<td>No Identified Remarks</td>';
							}else{
								html += '<td>'+data['remarks'][i]+'</td>';
							}
							html += '<td><center><button type="button" class="btn btn-info btn-sm" onclick="btnView('+data['pkid_request'][i]+')"> <i class="fa fa-file" style="font-size: 15px;"> View</i> </button></center></td>';
							html += '</tr>';
						
						$('#tbl_received tbody').append(html);
				}
				
				var oTable = $('#tbl_received').DataTable({ paginate: true, aaSorting: []});
				// table_event_receive();
				
				
			},
			error	: function(data){
				console.log(data);
			}
		
		});
	}