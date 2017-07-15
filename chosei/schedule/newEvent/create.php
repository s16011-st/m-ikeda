<?php
//旧ABc.phpです
require_once( dirname(__FILE__)."/../../model/model.php" );
$e_id = randomId();
$organizer_id = randomId();
$e_name = $_POST['e_name'];
$e_comment = $_POST['e_comment'];
$day_time = textToArray( $_POST['dates'] );
setcookie( $e_id, $organizer_id, time()+10800, "/chosei/", FALSE );

if( $e_name && !empty($day_time) ) {
	organizeEvent( $e_id, $organizer_id, $e_name, $e_comment );
	organizeDayTime( $e_id, $day_time );
} else {
	header( "Location: ../error.html" );
	exit;
}

header( "Location: ./complete.php?e_id=$e_id" );
exit();
?>
