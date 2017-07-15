<?php
//直接アクセスさせない
if( array_shift( get_included_files() ) === __FILE__ ) {
	die( 'エラー：　正しいURLを指定してください。' );
}

require_once( dirname(__FILE__)."/model.php" );
if( $e_data = getEventData( $e_id ) ) {
	$day_time = getEventDaytime( $e_id );
	$p_sum = countParticipant( $e_id );
	$participant = getParticipant( $e_id );
	$p_tsugo = getTsugo( $e_id );

	$ninzu = count( $participant );
//出欠都合を 3 →◯, 2 →△, 1 →✕, 0 →""に変換
	if( $ninzu!==0 ){
		for( $i=0; $i<count($p_tsugo); $i++ ) {
			if( (int)$p_tsugo[$i]["tsugo"] === 3 ) {
				$p_tsugo[$i]["tsugo"] = "◯";
			} else if( (int)$p_tsugo[$i]["tsugo"] === 2 ) {
				$p_tsugo[$i]["tsugo"] = "△";
			} else if( (int)$p_tsugo[$i]["tsugo"] === 1 ) {
				$p_tsugo[$i]["tsugo"] = "✕";
			} else if( $p_tsugo[$i]["tsugo"] == null ) {
				$p_tsugo[$i]["tsugo"] = "";
			}
		}
	}
} else {
	header( "Location: ./Hv.php" );
}

?>
