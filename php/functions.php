<?php

function logMe() {
	$file = fopen('/storage/logovanje.txt', 'a');
	flock($file, LOCK_EX);
	
	function writeTo ($file, $string) {
		fwrite($file, $string);
		flock($file, LOCK_UN);
		fclose($file);
	}
	
	$dbh = new PDO('mysql:host=10.10.10.50:3306;dbname=dssEngine', 'bogdan', 'Tween#0709', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	function dataEntry(string $msg, $dbh) {
		$sql = "INSERT INTO tblEngineLog(userID, severity, message, logDate)
					VALUES(?, ?, ?, ?)";
		$data[] = $_SESSION['userID'];
		$data[] = $_POST['dugme'];
		$data[] = $msg;
		$data[] = date('Y-m-d H:i:s');
		$stmt = $dbh->prepare($sql);
		$stmt->execute($data);
	}
	
	switch ($_POST['dugme']) {
		case 'Log In' :
			$string = "User " . $_SESSION['fullName'] . " dugme je " . $_POST['dugme'] . ", pristupljeno sa adresom " . $_POST['email'] . " u vreme: " . date('Y-m-d H:i:s') . "\n";
			writeTo($file, $string);
			dataEntry($_SESSION['fullName'] . " has logged in through email " . $_POST['email'] . " from IP address " . $_SERVER['HTTP_X_FORWARDED_FOR'], $dbh);
			break;
						
		case 'Edit' :
			$string = "User " . $_SESSION['fullName'] . ", dugme je " . $_POST['dugme'] . " u vreme: " . date('Y-m-d H:i:s') . "\n";
			writeTo($file, $string);
			dataEntry($_SESSION['fullName'] . " has accessed editUser.php page from IP address " . $_SERVER['HTTP_X_FORWARDED_FOR'], $dbh);
			break;
						
		case 'Save update' :
			$string = "User " . $_SESSION['fullName'] . ", dugme je " . $_POST['dugme'] . " u vreme: " . date('Y-m-d H:i:s') . "\n";
			writeTo($file, $string);
			dataEntry($_SESSION['fullName'] . " has saved changes on editUser.php page from IP address " . $_SERVER['HTTP_X_FORWARDED_FOR'], $dbh);
			break;
			
		case 'Logout' :
			$string = "User " . $_SESSION['fullName'] . " dugme je " . $_POST['dugme'] . " u vreme: " . date('Y-m-d H:i:s') . "\n";
			writeTo($file, $string);
			dataEntry($_SESSION['fullName'] . " has been logged out.", $dbh);
			break;
						
		case 'Change Password' :
			$string = "User " . $_SESSION['fullName'] . ", dugme je " . $_POST['dugme'] . " u vreme: " . date('Y-m-d H:i:s') . "\n";
			writeTo($file, $string);
			dataEntry($_SESSION['fullName'] . " has accessed changePassword.php page.", $dbh);
			break;
						
		case 'Save new password' :
			$string = "User " . $_SESSION['fullName'] . ", dugme je " . $_POST['dugme'] . " u vreme: " . date('Y-m-d H:i:s') . "\n";
			writeTo($file, $string);
			dataEntry($_SESSION['fullName'] . " has changed password.", $dbh);
			break;

		case 'Delete' :
			$string = "User " . $_SESSION['fullName'] . ", dugme je " . $_POST['dugme'] . " u vreme: " . date('Y-m-d H:i:s') . "je obrisao korisnika " . $_POST['fullName'] . "\n";
			writeTo($file, $string);
			dataEntry($_SESSION['fullName'] . " ~ Admin has deleted user " . $_POST['fullName'] . ".", $dbh);
			break;
						
		case 'Insert user' :
			$string = "User " . $_SESSION['fullName'] . ", preko dugmeta " . $_POST['dugme'] . " je dodao korsinika " . $_POST['name'] . " u vreme: " . date('Y-m-d H:i:s') . "\n";
			writeTo($file, $string);
			dataEntry($_SESSION['fullName'] . " as Admin has added new user " . $_POST['name'] . ".", $dbh);
			break;
		
		case 'My Activity' :
			$string = $_SESSION['fullName'] . " je pristupio strani My Activity";
			writeTo($file, $string);
			dataEntry($string, $dbh);
			break;
	}
	
	}
#######################################################################################################################################################################################################

function setMe() {
	ini_set('display_error', 'On');
	error_reporting(-1);
}
########################################################################################################################################################################################################

// Validacija duzine
function validateLength($value, $max, $min = 0) {
	return (strlen($value) > $max || strlen($value) < $min)? false : true;
}
########################################################################################################################################################################################################

// Validacija tipa
function validateType($var, $flag=FILTER_VALIDATE_INT) {
	return filter_var($var, $flag);
}
########################################################################################################################################################################################################

// Random string length duzine
/**
 * Function which returns given length random string. Can be used for password creations.
 * @param int $length Given value for string length
 * @return string Value which must be assigned to variable 
 */
function getPassword($length) {
	$pass = '';
	$char = array_merge(range(0,9), range('a','z'), range('A','Z'));
	for ($i = 0; $i < $length; $i++) {
		$pass .= $char[array_rand($char)];
	}
	return $pass;
}
########################################################################################################################################################################################################

//Vraca vrednost iz stringa izmedju 2 "reci"
function getBetween($var1="",$var2="",$pool){
	$temp1 = strpos($pool,$var1)+strlen($var1);
	$result = substr($pool,$temp1,strlen($pool));
	$dd=strpos($result,$var2);
	if($dd == 0){
		$dd = strlen($result);
	}
	return substr($result,0,$dd);
}
########################################################################################################################################################################################################

//Rekurzivno kroz niz
function recursive($array) {
	static $final = [];
	foreach ($array as $element) {
		if (!is_array($element)) {
			$final[] = $element;
			continue;
		}
		recursive($element);
	}
	return $final;
}
########################################################################################################################################################################################################

/**
 * 
 * @param int $number given number
 * @return int number is factorial of given number using recursive
 */
function getFactorial($number) {
	if ($number == 1) return $number;
	return $number * getFactorial($number - 1);
}
########################################################################################################################################################################################################
function timeAgo($time_ago) {
	$time_ago = strtotime($time_ago);
	$cur_time   = time();
	$time_elapsed   = $cur_time - $time_ago;
	$seconds    = $time_elapsed ;
	$minutes    = round($time_elapsed / 60);
	$hours      = round($time_elapsed / 3600);
	$days       = round($time_elapsed / 86400);
	$weeks      = round($time_elapsed / 604800);
	$months     = round($time_elapsed / 2600640);
	$years      = round($time_elapsed / 31207680);
	// Seconds
	if ($seconds <= 60){
		return "just now";
	}
	//Minutes
	else if ($minutes <= 60) {
		if ($minutes == 1) {
			return "one minute ago";
		} else {
			return "$minutes minutes ago";
		}
	}
	//Hours
	else if ($hours <= 24) {
		if ($hours == 1) {
			return "an hour ago";
		} else {
			return "$hours hours ago";
		}
	}
	//Days
	else if ($days <= 7) {
		if ($days == 1) {
			return "yesterday";
		} else {
			return "$days days ago";
		}
	}
	//Weeks
	else if ($weeks <= 4.3) {
		if ($weeks == 1) {
			return "a week ago";
		} else {
			return "$weeks weeks ago";
		}
	}
	//Months
	else if ($months <= 12) {
		if ($months == 1) {
			return "a month ago";
		} else {
			return "$months months ago";
		}
	}
	//Years
	else {
		if ($years == 1) {
			return "one year ago";
		} else {
			return "$years years ago";
		}
	}
}

