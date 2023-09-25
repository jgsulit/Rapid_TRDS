<?php
include_once('media/includes.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Notification Mailer</title>
<script>

//an interval function that loops every 5 seconds and run a specific function called send mail
window.onload=function(){setInterval(function(){document.getElementById("sending").click();},5000);}
var lastsent="";

//this functions is run for every 5sec this check if the the mailer has sent today or not if the mailer has not yet sent an email it will go to the first if and send all the email that is either on-going or overdue(it runs the alertmailer.php) else it will keep checking if the day has ended if it has ended then it will send again an email for that day. this will keep continue to check if the this php file is open in a browser
function sendMail(){
	if(document.getElementById("Checker").value==""||document.getElementById("Checker").value=="false"){
		$.ajax({url:"mail/daily_notif.php",
			success:function(result){
				document.getElementById("Checker").value=result;
				lastsent=dateToday();
			}
		});
	}
	else{
		if(lastsent<dateToday()){
			document.getElementById("Checker").value="false";
		}
	}
}

//just getting the date today
function dateToday(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; 
	var yyyy = today.getFullYear();

	if(dd<10) {
		dd='0'+dd
	} 

	if(mm<10) {
		mm='0'+mm
	} 

	today = mm+'/'+dd+'/'+yyyy;
	return today;
}

 </script>

  </head>
  
<body>
<!-- do not change this is what the function checks if is false/blank("") the mailer will sent for today and if is true/ has a value on it this will start to go to the "else part" of the sendmail function -->
<div class="container"><center>
<h1>DO NOT CLOSE</h1>
<p>This is the Auto mailer of the <strong>Request For Training</strong>. This sends the notifications everyday if has document for retrieval.</p>
<input type="text" id="Checker"/>
<button type="button" id="sending" onclick="sendMail()">Send Mail</button>
</center>


</div>
</body>
</html>