<?php
//変数を取得するファイルの読み込み
$e_id = $_GET['e_id'];
include( dirname(__FILE__)."/model/getValues.php" );
?>

<!doctype HTML>
<HTML lang="ja">
<HEAD>
	<?php readfile( dirname(__FILE__)."/src/header.html" ); ?>
	<LINK href="./src/style.css" rel="stylesheet" type="text/css">
	<TITLE>日程調整ページトップ</TITLE>
</HEAD>
<BODY>
<div class="container">
<div class="row">
<!--イベント名-->
<h1><u><?php echo $e_data[0]["e_name"]; ?></u></h1>
回答者数：<?php echo $ninzu; ?>人

<!--クッキーに保存したイベントページ作成者番号と一致したら表示するボタン-->
<?php if( $_COOKIE[$e_id] === $e_data[0]["organizer_id"] ) { ?>
&emsp;あなたが幹事のイベントです。
<input type="button" onclick='location.href="./s.php?e_id=<?php echo $e_id; ?>&proc=6"' value="イベント編集" >

<?php } ?><br><br>
	<h3>イベントの詳細説明</h3>
		<p><?php echo $e_data[0]["e_comment"]; ?></p><br><br>
	<!--参加者の都合に関する2つの表をインクルード-->
	<h3>日にち候補</h3>

	<?php include( dirname(__FILE__)."/Table_sum.php" ); ?><br>
	<?php if( $ninzu!==0 ){ ?>
		<?php include( dirname(__FILE__)."/Table_p.php" ); ?><br>
	<?php } ?><br>


	<input type="button" onclick="location.href='./s.php?e_id=<?php echo $e_id; ?>&proc=1'" value="出欠を入力する" >
</div>
</div>
</body>
</html>
