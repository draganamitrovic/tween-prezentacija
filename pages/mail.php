<?php 
date_default_timezone_set('Europe/Belgrade');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	include '../php/functions.php';
	include '../php/PHPMailer-master/PHPMailerAutoload.php';
	print_r($_POST);
	if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) exit("Morate popuniti formu! \n"); 
	if (!validateLength(trim($_POST['name']), 50, 2)) exit("Ime mora biti manje od 50 karaktera! \n");
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) exit("Neispravan format Email naloga! \n");
	if (!validateLength(trim($_POST['email']), 60, 1)) exit("Email mora biti manji od 60 karaktera! \n");
	if (!validateLength(trim($_POST['subject']), 40, 1)) exit("Email mora biti manji od 60 karaktera! \n");
	
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPOptions = array(
		'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
		)
	);
	$mail->Debugoutput = 'html';
	$mail->Host = 'mail.tween-art.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Username = "admin@tween-art.com";
	$mail->Password = "Sumadija!3";
	$mail->setFrom('admin@tween-art.com', 'Tween Art Webform');
	$mail->addAddress('hanshi.tween@gmail.com', 'Boban Tween Mandic');
	$mail->WordWrap = 50;
	$mail->Subject = 'Tween Art Webforma - Kontakt';
	$mail->Body = "Ime posetioca: " . trim($_POST['name']) . "\n" . "Email posetioca: " . $_POST['email'] . "\n" . "Poruka: " . trim($_POST['comment']);
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
		header('Location: thankyou.html');
	}
}
	
?>