<?php


function emailSent ($email, $subject, $message){

	require_once 'PHPMailer/PHPMailerAutoload.php';
	
	$mail = new PHPMailer;
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => true,
			'peer_name' => 'mail.cdclux.com',
			'verify_depth' => 3,
		//	'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);

	//  $mail->SMTPDebug = 2;                               // Enable verbose debug outpu
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'SMTP';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = false;                               // Enable SMTP authentication
	$mail->Username = 'support@cdclux.com';                 // SMTP username
	$mail->SMTPAutoTLS = false;                           // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 25;
	$mail->setLanguage('fr', '/optional/path/to/language/directory/');                                  // TCP port to connect t
	$mail->setFrom('support@cdclux.com', 'CDCL Support Team');

	/*****************************************************FIN PARAMETRAGE EXCHANGE*******************************************************************/
	$mail->addAddress($email);     // Add a recipient
	$mail->Subject = $subject ;
	$mail->Body    = $message;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	$success=true;
	if(!$mail->send()) {
	    $success=false;
	} 
	/*else {
	    echo 'Message has been sent';
	}*/

	return $success;
}
