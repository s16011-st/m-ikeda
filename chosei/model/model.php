<?php

//直接アクセスさせない
if( array_shift( get_included_files() ) === __FILE__ ) {
	die( 'エラー：　正しいURLを指定してください。' );
}

//（A）ランダムな変数を生成する2通りの方法
function randomId(){
	$bytes = openssl_random_pseudo_bytes( 8, $cstrong );
	$hex = bin2hex( $bytes );	//ランダムなバイナリコードを16進数に変換
	return $hex;
}
function randomId2(){
	$md5 = md5( date( "YmdD His" ) );	//日時からハッシュ値を生成
	$str = substr( $md5, 0, 10 );
	echo $str;
}

//（A）テキストを配列に変える
function textToArray( $text ) {
// 2つ以上の3種類の改行を1つ1種類の改行に置換後、文頭文末の空白を削除
	$text = trim( preg_replace( "/(\r\n){2,}|\r{2,}|\n{2,}/", "\n", $text ) );
//改行区切りで配列に格納し、「なにもない配列」が入ってる（改行だけの入力）場合をNULLにする
	$array = array_filter( explode("\n", $text) );
	return $array;
}

//(A)新規日程調整ページ作成
function organizeEvent( $e_id, $organizer_id, $e_name, $e_comment ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'INSERT INTO t_event VALUES( ?, ?, ?, ? )';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'ssss', $e_id, $organizer_id, $e_name, $e_comment );
	if( $stmt->execute() ) {
		$result = "OK!";
	} else {
		$result = "ERROR！";
	}
	return $result;
	$stmt->close();
	$mysqli->close();
}
//(A→B)新規日にち候補登録
function organizeDayTime( $e_id, $day_time ){
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'INSERT INTO t_schedule( e_id, day_time ) VALUES( ?, ? )';
	for( $i=0; $i<count($day_time); $i++ ){
		$stmt = $mysqli->prepare( $sql );
		$stmt->bind_param( 'ss', $e_id, $day_time[$i] );
		if( $stmt->execute() ) {
			$result = "日程調整ページ作成完了";
		} else {
			$result = "ERROR";
		}
	}
	return $result;
	$stmt->close();
	$mysqli->close();
}

//(C→D,CDE→F)登録されているイベント情報を渡す
function getEventData( $e_id ) {
 	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'SELECT * FROM t_event WHERE e_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 's', $e_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}
//(C→D,CDE→F)登録されているイベントの日にち情報を渡す
function getEventDaytime( $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'SELECT * FROM t_schedule WHERE e_id = ? ORDER BY s_id';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 's', $e_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}
//(C,D)出欠都合の集計
function countParticipant( $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = '
	SELECT x.day_time,
		count( y.tsugo=3 or null ) as "◯",
		count( y.tsugo=2 or null ) as "△",
		count( y.tsugo=1 or null ) as "✕"
	FROM t_schedule x LEFT OUTER JOIN t_tsugo y
	ON x.s_id = y.s_id
	WHERE x.e_id = ?
	GROUP BY x.s_id ORDER BY x.s_id';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 's', $e_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}

//(C,D)参加者の都合を取得
function getParticipantTsugo( $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = '
	SELECT
	z.p_id, z.p_name, x.day_time, y.tsugo, z.p_comment
	FROM
	( t_schedule x LEFT OUTER JOIN t_tsugo y USING(s_id))
	INNER JOIN t_participant z USING(p_id)
	WHERE x.e_id = ?
	ORDER BY z.p_id, x.s_id';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 's', $e_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}
//★★★　内部仕様書変更！　★★★
//★★★　上の関数を2つに分離　★★★
//(C,D)参加者を取得
function getParticipant( $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = '
	SELECT * FROM t_participant WHERE e_id = ? ORDER BY p_id';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 's', $e_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}
//(C,D)参加者の都合を取得
function getTsugo( $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = '
	SELECT * FROM t_tsugo WHERE p_id IN(
		SELECT p_id FROM t_participant WHERE e_id = ?
		) ORDER BY p_id, s_id';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 's', $e_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}










//★★★　内部仕様書変更！　★★★
//(D→C)参加者の情報と都合を登録
//pRegistration, getLastPid, entryLastPidConvenienceを一つにまとめた
function enterParticipantTsugo( $p_name, $p_comment, $e_id, $tsugo ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql1 = ' INSERT INTO t_participant( p_name, p_comment, e_id ) VALUES( ?, ?, ? )';
	$sql2 = ' SELECT p_id FROM t_participant ORDER BY p_id DESC LIMIT 1';
	$sql3 = ' INSERT INTO t_tsugo( s_id, p_id, tsugo ) VALUES( ?, ?, ? )';
	$stmt = $mysqli->prepare( $sql1 );
	$stmt->bind_param( 'sss', $p_name, $p_comment, $e_id );
	if( $stmt->execute() ) {
		$stmt = $mysqli->prepare( $sql2 );
		if( $stmt->execute() ) {
//★★★　ここ下3行、メソッドチェーン的にまとまらんかな。
			$stmt->store_result();
			$stmt->bind_result( $p_id );
			$stmt->fetch();
			$stmt = $mysqli->prepare( $sql3 );
			for( $i=0; $i<count($tsugo); $i++ ){
				$stmt->bind_param( 'iii', $tsugo[$i]['s_id'], $p_id, $tsugo[$i]['tsugo'] );
				$stmt->execute();
			}
			$result = "登録OK!";
		} else {
			$result = "登録NG";
		}
	}
	return $result;
	$stmt->close();
	$mysqli->close();
}


//(D→E)その参加者の都合を取得
function getTheParticipantTsugo( $e_id, $p_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = '
	SELECT
	z.p_id, z.p_name, x.day_time, y.tsugo, z.p_comment
	FROM
	( t_schedule x LEFT OUTER JOIN t_tsugo y USING(s_id))
	INNER JOIN t_participant z USING(p_id)
	WHERE x.e_id = ? and y.p_id = ?
	ORDER BY y.p_id, y.s_id';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'si', $e_id, $p_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}


//(E→C)参加者都合→参加者情報の順に削除
function deleteParticipantTsugo( $p_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql1 = 'DELETE FROM t_tsugo WHERE p_id = ?';
	$sql2 = 'DELETE FROM t_participant WHERE p_id = ?';
	$stmt = $mysqli->prepare( $sql1 );
	$stmt->bind_param( 'i', $p_id );
	if( $stmt->execute() ) {
		$stmt = $mysqli->prepare( $sql2 );
		$stmt->bind_param( 'i', $p_id );
		if( $stmt->execute() ) {
			$result = "削除完了";
		} else {
			$result = "削除エラー！！！";
		}
	}
	return $result;
	$stmt->close();
	$mysqli->close();
}

//(E→C)その参加者の情報更新
function updateParticipant( $p_id, $p_name, $p_comment ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'UPDATE t_participant SET p_name = ?, p_comment = ? WHERE p_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'ssi', $p_name, $p_comment, $p_id );
	if( $stmt->execute() ) {
		$result = "更新完了";
	} else {
		$result = "更新エラー！！！";
	}	return $result;
	$stmt->close();
	$mysqli->close();
}
//(E→C)その参加者の都合更新
function updateTsugo( $s_id, $p_id, $tsugo ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'UPDATE t_tsugo SET tsugo = ? WHERE s_id = ? and p_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'iii', $tsugo, $s_id, $p_id );
	if( $stmt->execute() ) {
		$result = "都合更新完了";
	} else {
		$result = "都合更新エラー！！！";
	}	return $result;
	$stmt->close();
	$mysqli->close();
}

//(F→C)イベント情報の更新
function updateEvent( $e_id, $new_e_name, $new_e_comment ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'UPDATE t_event SET e_name = ?, e_comment = ? WHERE e_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'sss', $new_e_name, $new_e_comment, $e_id );
	if( $stmt->execute() ) {
		$result = "更新完了";
	} else {
		$result = "更新エラー！！！";
	}	return $result;
	$stmt->close();
	$mysqli->close();
}


//(F→C)日にち候補の削除
function deleteDayTime( $s_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql1 = 'DELETE FROM t_tsugo WHERE s_id = ?';
	$sql2 = 'DELETE FROM t_schedule WHERE s_id = ? ';

	for( $i=0; $i<count($s_id); $i++ ){
		$stmt = $mysqli->prepare( $sql1 );
		$stmt->bind_param( 'i', $s_id[$i] );
		if( $stmt->execute() ) {
			$stmt = $mysqli->prepare( $sql2 );
			$stmt->bind_param( 'i', $s_id[$i] );
			if( $stmt->execute() ) {
				$result = "削除完了";
			} else {
				$result = "削除エラー！！！";
			}
		}
	}
	return $result;
	$stmt->close();
	$mysqli->close();
}


//★★★内部仕様書変更（追加した関数）★★★
//(F→C)日にち候補の追加
function addDayTime( $e_id, $new_day_time ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql1 = ' INSERT INTO t_schedule( e_id, day_time ) VALUES( ?, ? ) ';
	$sql2 = ' SELECT s_id FROM ( SELECT * FROM t_schedule WHERE e_id = ? ORDER BY s_id DESC LIMIT ? ) x ORDER BY x.s_id ';
	$sql3 = ' SELECT p_id FROM t_participant WHERE e_id = ? ';
	$sql4 = ' INSERT INTO t_tsugo( s_id, p_id, tsugo ) VALUES( ?, ?, "" )';

	for( $i=0; $i<count($new_day_time); $i++ ){
		$stmt = $mysqli->prepare( $sql1 );
		$stmt->bind_param( 'ss', $e_id, $new_day_time[$i] );
		$stmt->execute();
	}
	$stmt = $mysqli->prepare( $sql2 );
	$stmt->bind_param( 'si', $e_id, count($new_day_time) );
	if( $stmt->execute() ) {
		$s_id = fetch_all( $stmt );
		$stmt = $mysqli->prepare( $sql3 );
		$stmt->bind_param( 's', $e_id );
		if( $stmt->execute() ) {
			$p_id = fetch_all( $stmt );
			for( $i=0; $i<count($p_id); $i++ ){
				for( $j=0; $j<count($s_id); $j++ ){
					$stmt = $mysqli->prepare( $sql4 );
					$stmt->bind_param( 'ii', $s_id[$j]['s_id'], $p_id[$i]['p_id'] );
					$stmt->execute();
				}
			}
		}
		$result = "都合登録完了";
	} else {
		$result = "都合登録エラー！！！";
	}
	return $result;
	$stmt->close();
	$mysqli->close();
}


//(F→G)イベントの削除
function deleteEvent( $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql1 = 'DELETE FROM t_tsugo WHERE s_id IN
	( SELECT s_id FROM t_participant WHERE e_id = ? ) ';
	$sql2 = 'DELETE FROM t_participant WHERE e_id = ? ';
	$sql3 = 'DELETE FROM t_schedule WHERE e_id = ? ';
	$sql4 = 'DELETE FROM t_event WHERE e_id = ? ';
	$stmt = $mysqli->prepare( $sql1 );
	$stmt->bind_param( 's', $e_id );
	if( $stmt->execute() ) {
		$stmt = $mysqli->prepare( $sql2 );
		$stmt->bind_param( 's', $e_id );
		if( $stmt->execute() ) {
			$stmt = $mysqli->prepare( $sql3 );
			$stmt->bind_param( 's', $e_id );
			if( $stmt->execute() ) {
				$stmt = $mysqli->prepare( $sql4 );
				$stmt->bind_param( 's', $e_id );
				if( $stmt->execute() ) {
					$result = "削除完了";
				} else {
					$result = "削除エラー！！！";
				}
			}
		}
	}
	return $result;
	$stmt->close();
	$mysqli->close();
}

//(allFunction)ステートメントオブジェクトから連想配列で値を取り出す
function fetch_all(& $stmt) {
	$hits = array();
	$params = array();
	$meta = $stmt->result_metadata();
	while( $field = $meta->fetch_field() ) {
		$params[] = &$row[ $field->name ];
	}
	call_user_func_array( array( $stmt, 'bind_result' ), $params );
	while( $stmt->fetch() ) {
		$c = array();
		foreach( $row as $key => $val ) {
			$c[ $key ] = $val;
		}
		$hits[] = $c;
	}
	return $hits;
}
