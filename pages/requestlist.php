<?php

?>

<html lang="eng">

	<head>
	
	</head>
	
	<body>
	
		<header>
		
			<div class="container">
			
				<div class="row">
					
					<div class="col-sm-4">
						
						<h3>LIST OF RECEIVED REQUEST</h3>
						
					</div>
					
				</div>
			
			</div>
		
		</header>
		
		<section id="section_list_of_received">
			
			<div class="container">
				
				<div class="row">
				
					<div class="col-sm-12">
						
						<div id="container_list_of_received">
						</div>
						
					</div>
					
				</div>
				
			</div>
		
		</section>
	
	<div class="modal fade" id="modal_crt_add_from_to_station">
	
		<div class="modal-dialog modal-lg" >
			
			<div class="modal-content" >
			  	<div class="modal-header">
			  		<h5 style="text-transform: uppercase; font-size: 20px;">List of Trainees</h5>
			  	</div>
				<div class="modal-body">
				
					<div>
						
						<div class="row rowMargin">
							<div class="col-sm-12">

								<div id="container_list_of_trainees">
								</div>

							</div>
						</div >
						
						<br>
					 
						<div class="modal-footer">
							<div class="form-group">
							
								<button type="button" 
								class="btn btn-default btn-sm"
								data-dismiss="modal" >
								<i class="fa fa-close" style="font-size: 15px;"> Close</i>
								</button>
								
							</div>
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div>

	</div>
		
		<footer>
		
		</footer>
	
	</body>
	
	<script src="./js/requestlist.js?vx=1"></script>

</html>

<script>

	function btnView(id) {
		display_list_of_trainees(id)
		$('#modal_crt_add_from_to_station').modal('show')
	}

	function display_list_of_trainees(id){
		
		var data = {
			'action' : 'display_list_of_trainees',
			'id' : id,
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
			
				var html  = '<table id="tbl_trainees" class="table table-bordered" style="margin-right: 20px; font-size: 12px;">';
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

</script>