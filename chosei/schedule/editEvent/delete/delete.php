<?php
	require_once( './model.php' );
	$e_id = $_GET['e_id'];
	$proc = $_GET['proc'];

	switch ( $e_id ) {
//e_idが指定されていなければ、日程調整ページ作成画面へ
		case "":
			header( "Location: ./schedule/newEvent/" );
			break;
		default:
//登録されていれば最新情報を取得
		if( $e_data = getEventData( $e_id ) ) {
			$day_time = getEventDaytime( $e_id );
			$p_sum = countParticipant( $e_id );
			$p_tsugo = getParticipantTsugo( $e_id );
//日程調整ページトップ画面表示
			switch ( $proc ) {
				case '7':
					$new_e_name = $_POST['new_e_name'];
					$new_e_comment = $_POST['new_e_comment'];
					$delete_s_id = $_POST['delete_s_id'];
					$new_day_time = textToArray( $_POST['new_dates'] );
				//イベント情報更新
					updateEvent( $e_id, $new_e_name, $new_e_comment );
				//候補日程の削除
					for( $i=0; $i<count($delete_s_id); $i++ ) {
						deleteDayTime( $delete_s_id[$i] );
					}
				//候補日程の追加があれば追加
					if( !empty($new_day_time) ) {
						for( $i=0; $i<count($new_day_time); $i++ ) {
							organizeDayTime( $e_id, $new_day_time[$i] );
						}
					}
				//更新後のイベントに関するデータを取得してCに移動
					$e_data = getEventData( $e_id );
					$day_time = getEventDaytime( $e_id );
					$p_sum = countParticipant( $e_id );
					$p_tsugo = getParticipantTsugo( $e_id );
					include( "./Cv.php" );
					break;
//procが指定されたもの以外ならばエラーページへ
				default:
					header( "Location: ./Hv.php" );
					break;
			}
//登録されてなければエラーページ表示
		} else {
			header( "Location: ./Hv.php" );
		}
		break;
	}
	exit();
?>
