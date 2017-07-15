<!doctype HTML>
<HTML lang="ja">
<head>
	<?php readfile( dirname(__FILE__)."/src/header.html" ); ?>
	<LINK href="./src/style.css" rel="stylesheet" type="text/css">
	<!-- 旧Av.phpです -->
	<TITLE>イベント作成</TITLE>
</head>

<body>
<div class="container">

	<!--jQueryのインストール-->
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!--カレンダーのデザイン設定-->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css" >
	<!--datepickerの設定-->
	<script src="./src/datepicker.js"></script>
	<script src="./src/datepicker-ja.js"></script>

	<h1>イベントを作る</h1>

	<div class="row">
	<FORM action="./schedule/newEvent/create.php" method="post">

		<div class="col-md-4">
		<div id="datepicker" >
			<h3>[step1]&nbsp;日にち候補</h3>
			<textarea id="date_val" name="dates" required></textarea>
		</div>
		</div>

		<div class="col-md-4">
			<h3>[step2]&nbsp;イベント名</h3>
			<input type="text" name="e_name" required ><br><br>
		</div>

		<div class="col-md-4">
			<h3>[step3]&nbsp;メモ</h3>
			<textarea name="e_comment"></textarea><br><br>
		<INPUT type="submit" value="イベントを作る">
		</div>

	</FORM>
	</div>

</div>
</body>
</html>
