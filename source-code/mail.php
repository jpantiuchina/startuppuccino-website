<?php 

	require './app/vendor/PHPMailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mailsubmit.unibz.it;mailsubmit.scientificnet.org';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = false;                               // Enable SMTP authentication
	//$mail->Username = '';                 // SMTP username
	//$mail->Password = '';                           // SMTP password
	$mail->SMTPSecure = false;                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 25; //587;                                    // TCP port to connect to

	$mail->setFrom('startuppuccino@unibz.it', 'Startuppuccino - Lean Startup');
	$mail->addAddress('mondial95@gmail.com', 'Marco Mondini');     // Add a recipient
	//$mail->addAddress('ellen@example.com');               // Name is optional
	//$mail->addReplyTo('info@example.com', 'Information');
	//$mail->addCC('cc@example.com');
	$mail->addBCC('mondino7@gmail.com');

	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Here is the subject';
	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    echo 'Message has been sent';
	}

?>