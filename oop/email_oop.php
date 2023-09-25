<?php

class email {
	function send_email($to, $from, $cc, $subject, $body,$attachment) {
		$body = str_replace("\n","<br>",$body);
		require_once("../handler/PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		if($to != '') {
			$to = explode(",",$to);
			for($i=0; $i<sizeof($to);$i++) {
				$mail->AddAddress($to[$i]);	
			}
		}
		if($cc != '') {
			$cc = explode(",",$cc);
			for($i=0; $i<sizeof($cc);$i++) {
				$mail->AddCC($cc[$i]);	
			}
		}
        $body .= "<br><br><i>For more info, please log-in to your Rapid account. Go to http://rapid/ <br>";
		$body .= "This E-mail is automatically generated by Document Issuance and Retrieval System (DIRS). <br>";
		$body .= "Don't reply to this e-mail, this is only a notification created by the system, Thank you!</i>";
        $body .= "<br><br>Notice of Disclaimer:<br>
                    This message (including any attachments) contains confidential information intended for a specific individual and purpose, and is protected by law. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.
";
		// $body .= "TO: ".$to."<br>";
		// $body .= "FROM: ".$from."<br>";
		// $body .= "CC: ".$cc."<br>";
		// $mail->AddAddress('ronfern@pricon.ph');	
		// $mail->AddCC('ronfern@pricon.ph');	
		
		$mail->From = $from;
		// $mail->FromName = "Document Issuance and Retrieval System";
		$mail->FromName = $from;
		$mail->AddBCC("jeadiam@pricon.ph");
		$mail->Subject = $subject;
		$mail->Body= $body;
		
        if($attachment != '') {
            $mail->AddAttachment($attachment);
        }
        
		if(!$mail->Send())
		{
		   $msg = "Message could not be sent.";
		   $msg .= "Mailer Error: " . $mail->ErrorInfo ."\n";
		   exit;
		} else {
			$msg = "Message has been sent!";
		}
		return $msg; 
	}
}
?>