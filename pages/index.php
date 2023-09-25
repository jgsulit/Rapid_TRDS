<!-- <h3 class="label-danger" style="text-align: center; color: white;">
	PLEASE CLEAR THE CACHE FIRST BEFORE USING THE SYSTEM
	<div class="h4">
		Some functions may not work.
		See the procedure <a href="media/clearcache.png" target="_blank">here</a> or call 205.
	</div>
</h3> -->
<!-- commented this on 2019-05-27 -->

<?php
	require_once('navmenu.php');
	
	 if(!isset($_GET['page']))
	{
		$page = "dashboard.php";
	}else{
		$page = $_GET['page'];
	} 

	require_once($page);
?>


