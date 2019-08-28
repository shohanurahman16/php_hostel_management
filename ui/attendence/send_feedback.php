<?php

$base_url="http://localhost/hms/";

require('./../../inc/sessionManager.php');
require('./../../inc/dbPlayer.php');
require('./../../inc/handyCam.php');
require('./../../vendor/autoload.php');

$ses = new \sessionManager\sessionManager();
$ses->start();

if($ses->isExpired())
{
    header( 'Location:'.$base_url.'index.php');

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$db = new \dbPlayer\dbPlayer();
	$msg = $db->open();
	$handyCam = new \handyCam\handyCam();

	$start_date = $handyCam->parseAppDate($_POST['start_date']);
	$end_date = $handyCam->parseAppDate($_POST['end_date']);

	$ts1 = strtotime($_POST['start_date']);
	$ts2 = strtotime($_POST['end_date']);

	$seconds_diff = $ts2 - $ts1;

	$total_date = ($seconds_diff/3600/24)+1;

	$sql = "SELECT * FROM studentinfo";
	$result=$db->getData($sql);

	while($row = mysql_fetch_array($result)){
		$uid =  $row['userId'];

		$sql = "SELECT * FROM attendence WHERE userID='$uid'";
		$result2 = $db->getData($sql);

		$count = 0;

		while ($row2 = mysql_fetch_array($result2)) {
		    if($row2['isAbsence'] == 'Yes'){
		    	$count++;
		    }
		}

		$client = new Nexmo\Client(new Nexmo\Client\Credentials\Basic('abd8fa16', 'fVqUzJ3KhoGLi7oL'));     
		

		$message = $client->message()->send([
		    'to' => '+88'.$row['localGuardianCell'],
		    'from' => "HostelAdmin",
		    'text' => 'Dear Guardian, '.$row['name'].' was absent for '.$count.' day(s) in '.$total_date.' day(s) ('.$start_date.' to '.$end_date.')'
		]);

	}

	header('Location: list.php');
}

?>