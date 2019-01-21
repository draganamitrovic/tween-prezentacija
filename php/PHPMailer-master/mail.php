<?php 
ini_set('display_errors', 'On');
error_reporting(-1);
require 'PHPMailerAutoload.php';
/*
require '../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST['name'], $_POST['email'], $_POST['comment'])) exit("Morate da popunite sva polja oznacena sa * \n");
	if (!validateLength($_POST['name'], 100, 2)) exit("Ime mora biti 2 karaktera minimum! \n");
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) exit("Neispravan format Email-a! \n");
	if (!validateLength($_POST['email'], 50)) exit("Email adresa ne sme biti veca od 50 karaktera! \n");
	if (!validateLength($_POST['comment'], 500)) exit("Maksimalna dužina komentara je 500 karaktera \n");
	*/
	$mail = new PHPMailer();
	$mail->IsSMTP(); // set mailer to use SMTP
	$mail->SMTPDebug  = 2;
	$mail->From = "bogdan.tween@gmail.com";
	$mail->FromName = "Bogdan Mandic";
	$mail->Host = "smtp.gmail.com"; // specif smtp server
	$mail->SMTPSecure= "ssl"; // Used instead of TLS when only POP mail is selected
	$mail->Port = 25; // Used instead of 587 when only POP mail is selected
	$mail->SMTPAuth = true;
	$mail->Username = "bogdan.tween@gmail.com"; // SMTP username
	$mail->Password = "tadaima333"; // SMTP password
	$mail->AddAddress("bbmandic@gmail.com", "Bogdan Mandic"); //replace myname and mypassword to yours
	$mail->AddReplyTo("bbmandic@gmail.com", "Bogdan Mandic");
	$mail->WordWrap = 50; // set word wrap
	//$mail->AddAttachment("c:\\temp\\js-bak.sql"); // add attachments
	//$mail->AddAttachment("c:/temp/11-10-00.zip");
	
	$mail->IsHTML(true); // set email format to HTML
	$mail->Subject = 'Ovo je naslov';
	$mail->Body = 'Ovo je neki body!';
	
	if($mail->Send()) {
		echo "Send mail successfully";
	} else {
		echo "Send mail fail";
	}
}
print_r($_POST);


?>
