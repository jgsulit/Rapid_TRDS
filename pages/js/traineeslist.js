
	var handler = '../handler/handler.php';
	var selected_pkid = '';
	
	display_list_of_trainees();
	
	$(document).ready(function(){
		
		
	});
	
	function display_list_of_trainees(){
		
		var data = {
			'action'		: 'display_list_of_trainees'
		}
		
		data = $.param(data);
		
		// alert(data);
		
		$.ajax({
			type	: 'post',
			dataType: 'json',
			data	: data,
			url		: handler,
			success	: function(data){
				
				// console.log(data);
				
				var ctr = data['ctr'];
				
				// alert(data['emp_no']);
				
				$('#container_list_of_trainees').empty();
			
				var html  = '<table id="tbl_trainees" class="table table-bordered" style="padding: 20px; margin-right: 20px; font-size: 12px;">';
					html += '	<thead>';
					html += '		<tr>';
					html += '			<th>Employee No.</th>';
					html += '			<th>Employee Name</th>';
					html += '			<th>Control No.</th>';
					html += '			<th>Date Filed</th>';
					html += '			<th>Requestor</th>';
					html += '			<th>Date Hired</th>';
					html += '			<th>Request No</th>';
					html += '		</tr>';
					html += '	</thead>';
					html += '	<tbody>';
					html += '	</tbody>';
					html += '</table>';
					
				$('#container_list_of_trainees').append(html);	
				
				for(i=0;i<ctr;i++){
						var html = '<tr id="'+data['traineeNo'][i]+'">';
							html += '<td>'+data['emp_no'][i]+'</td>';
							html += '<td>'+data['emp_name'][i]+'</td>';
							html += '<td>'+data['control_no'][i]+'</td>';
							html += '<td>'+data['date_filed'][i]+'</td>';
							html += '<td>'+data['requested_by'][i]+'</td>';
							html += '<td>'+data['date_hired'][i]+'</td>';
							html += '<td>'+data['requestNo'][i]+'</td>';
						
						$('#tbl_trainees tbody').append(html);
				}
				
				var oTable = $('#tbl_trainees').DataTable({ paginate: true, aaSorting: []});
				// table_event_receive();
				
				
			},
			error	: function(data){
				console.log(data);
			}
		
		});
	}