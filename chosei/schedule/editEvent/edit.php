<?php
require_once( dirname(__FILE__)."/../../model/model.php" );
$e_id = $_GET['e_id'];
$proc = $_GET['proc'];
$e_data = getEventData( $e_id );
//ページ作成者だけにこのディレクトリの操作を許可する
if( $_COOKIE[$e_id] === $e_data[0]["organizer_id"] ) {
	switch ( $proc ) {
		case '6':
			header( "Location: ./Fv.php?e_id=$e_id" );
			break;
		case '7':
			$new_e_name = $_POST['new_e_name'];
			$new_e_comment = $_POST['new_e_comment'];
			$delete_s_id = $_POST['delete_s_id'];
			$new_day_time = textToArray( $_POST['new_dates'] );
		//イベント情報更新
			updateEvent( $e_id, $new_e_name, $new_e_comment );
		//候補日程の追加があれば追加
			if( !empty($new_day_time) ) {
				$result1 = addDayTime( $e_id, $new_day_time );
			}
		//候補日程の削除があれば削除
			if( !empty($delete_s_id) ) {
				$result2 = deleteDayTime( $delete_s_id );
			}
			header( "Location: ../../Cv.php?e_id=$e_id" );
			break;
		case '8':
			if( $result = deleteEvent( $e_id ) ) {
				header( "Location: ./deletecomplete.php");
			} else {
				header( "Location: ../error.html");
			}
			break;
	}
} else {
	header( "Location: ../../Hv.php" );
}

exit();
?>
