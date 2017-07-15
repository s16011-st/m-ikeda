$( function() {
	$( "#datepicker" ).datepicker({
		dateFormat: 'm/dd(DD) 19:00～',  //入力される日付フォーマット
		monthNames: [ "1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月" ],
		weekHeader: "週",
		yearSuffix: "年",
		dayNames: ['日','月','火','水','木','金','土'],  //曜日フォーマットを漢字に変更
		minDate: '0y', //当日より前は選択できない
// date_val（日付）が選択されたら引数としてメソッドに渡す。
//再びイベント発生待ちとなり、 this にイベント要素 data_val の値を渡して改行する
		onSelect: function() {
			$("#date_val").val( $("#date_val").val()+$(this).val()+'\n' );
		}
	});
});
