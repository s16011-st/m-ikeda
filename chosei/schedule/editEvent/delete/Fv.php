<?php
//旧Fv.phpです
	include './model.php';
	$e_id = $_GET['e_id'];
	if( $result = deleteEvent( $e_id ) ) {
		header( "Location: ./complete.php");
	} else {
		header( "Location: ./error.php");
	}
	exit();
?>
