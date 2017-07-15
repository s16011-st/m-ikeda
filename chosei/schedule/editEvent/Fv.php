<?php
//変数を取得するファイルの読み込み
$e_id = $_GET['e_id'];
require_once( dirname(__FILE__)."/../../model/getValues.php" );
?>

<!doctype HTML>
<HTML lang="ja">
<head>
	<?php readfile( dirname(__FILE__)."/../../src/header.html" ); ?>
	<LINK href="../../src/style.css" rel="stylesheet" type="text/css">
	<TITLE>日程調整ページ編集画面</TITLE>
</head>


<body>
	<!--jQueryのインストール-->
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!--カレンダーのデザイン設定-->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css" >
	<!--datepickerの設定-->
	<script src="../../src/datepicker.js"></script>
	<script src="../../src/datepicker-ja.js"></script>

<div class="container">
<h1>イベント編集・削除</h1>

<div class="row">
<FORM action="./edit.php?e_id=<?php echo $e_id; ?>&proc=7" method="post">
	<div class="col-md-4">
		<h3>イベント名</h3>
		<input type="text" name="new_e_name" value="<?php echo $e_data[0]['e_name']; ?>" required ><br><br>
		<h3>詳細説明文</h3>
		<textarea name="new_e_comment" ><?php echo $e_data[0]["e_comment"] ; ?></textarea><br><br>
	</div>
	<div class="col-md-4">
		<h3>候補日程の追加と削除</h3>
		<h4>削除する候補</h4>
		削除したい候補にチェックを付けてください。<br>
		&emsp;削除&emsp;現在の日程<br>
		<div  class="delete_day_time">
			<p><?php for( $i=0; $i<count($day_time); $i++ ) { ?>
			&emsp;<input type="checkbox" name="delete_s_id[]" value="<?php echo $day_time[$i]['s_id']; ?>" >
			&emsp;&emsp;<?php echo $day_time[$i]['day_time']."<br>"; ?></p>
			<?php } ?>
		</div>
		<h4>追加する候補</h4>
		追加したい候補を入力してください。<br>
		<div id="datepicker">
			<textarea id="date_val" name="new_dates"></textarea>
		</div><br>
		<input type="button" onclick="location.href='../../Cv.php?e_id=<?php echo $e_id; ?>'" value=" 戻る " >&emsp;
		<input type="submit" style="color:#fff;background-color:#f33" value="  編集内容を保存  " ><br>
		<p>※すでに都合を登録した参加者がいる場合は、管理者が参加者に変更を通知してください。</font></p>
	</div>

	<div class="col-md-4">
		<h3>イベントの削除<h3>
		<h4 class="delete">イベントを削除する</h4>
		<input type="button" onclick="location.href='./edit.php?e_id=<?php echo $e_id; ?>&proc=8'" value="イベント削除" ><br>
		<p>※一度削除すると復旧はできません。ご注意ください。</p>
	</div>
</div>
</FORM>

</div>
</body>
</div>
</html>
