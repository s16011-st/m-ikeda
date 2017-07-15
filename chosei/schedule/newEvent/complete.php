<?php
//旧Bvです
//変数を取得するファイルの読み込み
$e_id = $_GET['e_id'];
include( dirname(__FILE__)."/../../model/getValues.php" );
?>

<!doctype HTML>
<HTML lang="ja">
<head>
	<?php readfile( dirname(__FILE__)."/../../src/header.html" ); ?>
	<LINK href="../../src/style.css" rel="stylesheet" type="text/css">
	<TITLE>イベント作成完了</TITLE>
</head>
<body>

<div class="container">
<div class="text-center">
<h1>日程調整ページ作成結果</h1>

<p>日程調整ページ作成完了！　URLは ⇩</p><br>

<!--
<p>http://<?php echo $_SERVER["SERVER_ADDR"]; ?>/chosei/Cv.php?e_id=<?php echo $e_id; ?></p><br>
-->

<p><input type="text" value="http://<?php echo $_SERVER["SERVER_ADDR"]; ?>/chosei/Cv.php?e_id=<?php echo $e_id; ?>" style="width:80%;" onclick="this.select()"> </p><br>

<input type="button" onclick='location.href="../../Cv.php?e_id=<?php echo $e_id; ?>"' value=イベントページを表示 />
<br><br><br><br>

<a href = "../../index.php">日程調整ページ作成画面に戻る</a>

</div>
</div>

</body>
</html>
