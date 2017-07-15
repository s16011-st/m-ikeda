<?php
//includeで見せるだけで、直接アクセスさせない
if( array_shift( get_included_files() ) === __FILE__ ) {
	die( 'エラー：　正しいURLを指定してください。' );
}

?>
<html>
<head>
	<TITLE>イベント作成完了</TITLE>
	<meta name="viewport" content="width=device-width,maximum-scale=1"/>
	<LINK href="../../src/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>日程調整ページ作成結果</h1>
<?php
	echo $message."<br><br>";
	echo $url."<br>";
	if( !empty( $url ) ) {
?>
<br>
<input type="button" onclick='location.href="../../s.php?e_id=<?php echo $e_id; ?>&proc=0"' value=イベントページを表示 />
<?php } ?>
<br><br><br><br>

<a href = "./Av.php">日程調整ページ作成画面に戻る</a>
</body>
</html>
