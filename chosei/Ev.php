<?php
//変数を取得するファイルの読み込み
$e_id = $_GET['e_id'];
include( dirname(__FILE__)."/model/getValues.php" );
session_start();
$p_t_tsugo = $_SESSION['p_t_tsugo'];
$p_id = $_GET['p_id'];
?>

<!doctype HTML>
<HTML lang="ja">
<HEAD>
	<?php readfile( dirname(__FILE__)."/src/header.html" ); ?>
	<LINK href="./src/style.css" rel="stylesheet" type="text/css">
	<TITLE>出欠都合新規入力</TITLE>
</HEAD>
<BODY>
<div class="container">
<!--イベント名-->
<h1><u><?php echo $e_data[0]["e_name"]; ?></u></h1>
回答者数：<?php echo $ninzu; ?>人

<div class="row">
	<div class="col-md-4">
		<h3>イベントの詳細説明</h3>
		<?php echo $e_data[0]["e_comment"]; ?><br><br>
		<!--参加者の都合に関する2つの表をインクルード-->
		<h3>日にち候補</h3>
		<?php include( dirname(__FILE__)."/Table_sum.php" ); ?><br>
		<?php if( $ninzu!==0 ){ ?>
			<?php include( dirname(__FILE__)."/Table_p.php" ); ?><br>
		<?php } ?><br>
	</div>

	<div class="col-md-4">
		<h3><?php echo $p_t_tsugo[0]["p_name"]; ?>さんの出欠を編集</h3>
		<hr>
		<FORM action="./s.php?e_id=<?php echo $e_id."&p_id=".$p_id; ?>&proc=4" method="post">
		<h3>表示名</h3>
		表示に使用する名前を入力してください。<br>
			<input type="text" name="p_name" value="<?php echo $p_t_tsugo[0]["p_name"]; ?>" required><br><br>
		<h3>日にち候補</h3>
		<table class="table table-striped table-borderd">
			<tr>
				<th>都合</th>
				<?php
				for( $i=0; $i<count($day_time); $i++ ){
					echo "<th>".$day_time[$i]["day_time"]."</th>";
				} ?>
			</tr>
			<tr>
				<td class="coltsugo">◯</td>
				<?php for( $i=0; $i<count($day_time); $i++ ){ ?>
					<td><input type="radio" name="<?php echo $day_time[$i]['s_id']; ?>" value=3 ></td>
				<?php } ?>
			</tr>
			<tr>
				<td class="coltsugo">△</td>
				<?php for( $i=0; $i<count($day_time); $i++ ){ ?>
					<td><input type="radio" name="<?php echo $day_time[$i]['s_id']; ?>" value=2 ></td>
				<?php } ?>
			</tr>
			<tr>
				<td class="coltsugo">✕</td>
				<?php for( $i=0; $i<count($day_time); $i++ ){ ?>
					<td><input type="radio" name="<?php echo $day_time[$i]['s_id']; ?>" checked value=1 ></td>
				<?php } ?>
			</tr>
		</table><br>
	</div>
	<div class="col-md-4">
		<h3>コメント</h3>
			<textarea name="p_comment"><?php echo $p_t_tsugo[0]["p_comment"] ; ?></textarea><br><br>
			<input type="submit" value="更新する">&nbsp;
			<input type="button" style="background-color:#f33" onclick='location.href="./s.php?e_id=<?php echo $e_id."&p_id=".$p_id; ?>&proc=5"' value=登録を削除 />
		</FORM>
	</div>
</div>

</BODY>
</HTML>
