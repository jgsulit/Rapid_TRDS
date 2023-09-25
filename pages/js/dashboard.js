	
	var accessKey = $('#id_setAccess').val(),
		specialKey = $('#id_special').val();
	
	$(document).ready(function(){
		
		$('#btn_id_proceed').click(function(){
			if( accessKey == '1'){
				window.location = "index.php?page=request.php";
			}else{
				
				if(specialKey == '1'){
					window.location = "index.php?page=approval.php";
				}else{
					alert('Sorry. You do not have any access on the system. Thank you!');
					return false;
				}
			}
		});
	});