<?php
	require_once( dirname(__FILE__)."/model/model.php" );
	$e_id = $_GET['e_id'];
	$proc = $_GET['proc'];

	switch ( $e_id ) {
//(→A(create.php)）e_idが指定されていなければ、日程調整ページ作成画面へ
		case "":
			header( "Location: ./schedule/newEvent/" );
			break;
		default:
//(共通)登録されていれば最新情報を取得
		if( $e_data = getEventData( $e_id ) ) {
			$day_time = getEventDaytime( $e_id );
			$p_sum = countParticipant( $e_id );
			$participant = getParticipant( $e_id );
			$p_tsugo = getTsugo( $e_id );
//日程調整ページトップ画面表示
			switch ( $proc ) {
				case '0':
					header( "Location: ./Cv.php?e_id=$e_id" );
					break;
//都合入力画面表示
				case '1':
					header( "Location: ./Dv.php?e_id=$e_id" );
					break;
//登録してトップ画面へ戻る
				case '2':
				//参加者の入力した都合情報をリネームして配列にまとめる
					for( $i=0; $i<count($day_time); $i++ ) {
						$tsugo[$i] = array(
							's_id' => $day_time[$i]['s_id'],
							'tsugo' => $_POST[ $day_time[$i]['s_id'] ]
						);
					}
					enterParticipantTsugo( $_POST['p_name'], $_POST['p_comment'], $e_id, $tsugo );
					header( "Location: ./Cv.php?e_id=$e_id" );
					break;
//選択した参加者の都合を取得して編集画面へ
				case '3':
					$p_id = $_GET['p_id'];
					//その参加者の登録情報・都合を取得
					session_start();
					if( $_SESSION['p_t_tsugo'] = getTheParticipantTsugo( $e_id, $p_id ) ) {
						header( "Location: ./Ev.php?e_id=$e_id&p_id=$p_id" );
					//p_idをいじって都合取得できなかったらエラーページに飛ばす
					} else {
						header( "Location: ./Hv.php" );
					}
					break;
//その参加者の情報を更新
				case '4':
					$p_id = $_GET['p_id'];
					updateParticipant( $p_id, $_POST['p_name'], $_POST['p_comment'] );
				//複雑に散らばった参加者の都合に関する値をリネームして配列にまとめる
					for( $i=0; $i<count($day_time); $i++ ) {
						$tsugo[$i] = array(
							's_id' => $day_time[$i]['s_id'],
							'p_id' => $p_id,
							'tsugo' => $_POST[ $day_time[$i]['s_id'] ]
						);
					}
				//その参加者の都合を更新
					for( $i=0; $i<count($day_time); $i++ ) {
						updateTsugo(
							$tsugo[$i]['s_id'], $tsugo[$i]['p_id'], $tsugo[$i]['tsugo']
						);
					}
					header( "Location: ./Cv.php?e_id=$e_id" );
					break;
//その参加者の都合を削除
				case '5':
					$p_id = $_GET['p_id'];
					deleteParticipantTsugo( $p_id );
					header( "Location: ./Cv.php?e_id=$e_id&p_id=$p_id" );
					break;
//日程調整ページの編集画面へ遷移
				case '6':
					if( $_COOKIE[$e_id] === $e_data[0]["organizer_id"] ) {
						header( "Location: ./schedule/editEvent/edit.php?e_id=".$e_id."&proc=6" );
					}
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
