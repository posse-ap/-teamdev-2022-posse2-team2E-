<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>メール送信完了｜メール送信フォーム</title>
</head>
<body>

<?php
/*******************************
 データの受け取り 
*******************************/
$namae		= $_POST["namae"];		//お名前
$studentid		= $_POST["studentid"];		//問い合わせID
$mailaddress	= $_POST["mailaddress"];	//メールアドレス
$naiyou		= $_POST["naiyou"];		//お問合せ内容

//危険な文字列を入力された場合にそのまま利用しない対策
$namae		= htmlspecialchars($namae, ENT_QUOTES);
$studentid		= htmlspecialchars($studentid, ENT_QUOTES);
$mailaddress	= htmlspecialchars($mailaddress, ENT_QUOTES);
$naiyou		= htmlspecialchars($naiyou, ENT_QUOTES);

/*******************************
 未入力チェック 
*******************************/
$errmsg = '';	//エラーメッセージを空にしておく
if ($namae == '') {
	$errmsg = $errmsg.'<p>お名前が入力されていません。</p>';
}
if ($studentid == '') {
	$errmsg = $errmsg.'<p>問い合わせIDが入力されていません。</p>';
}
if ($mailaddress == '') {
	$errmsg = $errmsg.'<p>メールアドレスが入力されていません。</p>';
}
if ($naiyou == '') {
	$errmsg = $errmsg.'<p>お問合せ内容が入力されていません。</p>';
}

/*******************************
 メール送信の実行
*******************************/
if ($errmsg != '') {
	//エラーメッセージが空ではない場合には、[前のページへ戻る]ボタンを表示する
	echo $errmsg;
	
	//[前のページへ戻る]ボタンを表示する
	echo '<form method="post" action="index.php">';
	echo '<input type="hidden" name="namae" value="'.$namae.'">';
	echo '<input type="hidden" name="studentid" value="'.$studentid.'">';
	echo '<input type="hidden" name="mailaddress" value="'.$mailaddress.'">';
	echo '<input type="hidden" name="naiyou" value="'.$naiyou.'">';
	echo '<input type="submit" name="backbtn" value="前のページへ戻る">';
	echo '</form>';
} else {
	//エラーメッセージが空の場合には、メール送信処理を実行する
	//メール本文の作成
	$honbun = '';
	$honbun .= "メールフォームよりお問い合わせがありました。\n\n";
	$honbun .= "【お名前】\n";
	$honbun .= $namae."\n\n";
	$honbun .= "【問い合わせID】\n";
	$honbun .= $studentid."\n\n";
	$honbun .= "【メールアドレス】\n";
	$honbun .= $mailaddress."\n\n";
	$honbun .= "【お問い合わせ内容】\n";
	$honbun .= $naiyou."\n\n";
	
	//エンコード処理
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");

	//メールの作成
	$mail_to	= "kashiken4646@gmail.com";			//送信先メールアドレス
	$mail_subject	= "メールフォームよりお問い合わせ";	//メールの件名
	$mail_body	= $honbun;				//メールの本文
	$mail_header	= "from:".$mailaddress;			//送信元として表示されるメールアドレス
    $header = "MIME-Version: 1.0\r\n"
. "Content-Transfer-Encoding: 7bit\r\n"
. "Content-Type: text/plain; charset=ISO-2022-JP\r\n"
. "Message-Id: <" . md5(uniqid(microtime())) . "@ドメイン>\r\n"
. "From: サイト名 <送信元メールアドレス>\r\n";
	
	//メール送信処理
	$mailsousin	= mb_send_mail($mail_to, $mail_subject, $mail_body, $mail_header);
	
	//メール送信結果
	if($mailsousin == true) {
		echo '<p>お問い合わせメールを送信しました。</p>';
	} else {
		echo '<p>メール送信でエラーが発生しました。</p>';
	}
}
?>

</body>
</html>