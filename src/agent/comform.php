<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>入力内容の確認｜メール送信フォーム</title>
</head>

<body>

    <?php
    /*******************************
 データの受け取り
     *******************************/
    $namae        = $_POST["namae"];        //お名前
    $studentid        = $_POST["studentid"];        //問い合わせID
    $mailaddress    = $_POST["mailaddress"];    //メールアドレス
    $naiyou        = $_POST["naiyou"];        //お問合せ内容

    //危険な文字列を入力された場合にそのまま利用しない対策
    $namae        = htmlspecialchars($namae, ENT_QUOTES);
    $studentid        = htmlspecialchars($studentid, ENT_QUOTES);
    $mailaddress    = htmlspecialchars($mailaddress, ENT_QUOTES);
    $naiyou        = htmlspecialchars($naiyou, ENT_QUOTES);

    /*******************************
 未入力チェック
     *******************************/
    $errmsg = '';    //エラーメッセージを空にしておく
    if ($namae == '') {
        $errmsg = $errmsg . '<p>お名前が入力されていません。</p>';
    }
    if ($studentid == '') {
        $errmsg = $errmsg . '<p>問い合わせIDが入力されていません。</p>';
    }
    if ($mailaddress == '') {
        $errmsg = $errmsg . '<p>メールアドレスが入力されていません。</p>';
    }
    if ($naiyou == '') {
        $errmsg = $errmsg . '<p>お問合せ内容が入力されていません。</p>';
    }

    /*******************************
 入力内容の確認
     *******************************/
    if ($errmsg != '') {
        //エラーメッセージが空ではない場合には、エラーメッセージを表示する
        echo $errmsg;

        //[前のページへ戻る]ボタンを表示する
        echo '<form method="post" action="agent_students_detail.php">';
        echo '<input type="hidden" name="namae" value="' . $namae . '">';
        echo '<input type="hidden" name="studentid" value="' . $studentid . '">';
        echo '<input type="hidden" name="mailaddress" value="' . $mailaddress . '">';
        echo '<input type="hidden" name="naiyou" value="' . $naiyou . '">';
        echo '<input type="submit" name="backbtn" value="前のページへ戻る">';
        echo '</form>';
    } else {
        //エラーメッセージが空の場合には、入力された内容を画面表示する
        echo '<h3>入力内容を確認します</h3>';
        echo '<dl>';
        echo '<dt>【お名前】</dt><dd>' . $namae . '</dd>';
        echo '<dt>【問い合わせID】</dt><dd>' . $studentid . '</dd>';
        echo '<dt>【メールアドレス】</dt><dd>' . $mailaddress . '</dd>';
        echo '<dt>【お問合せ内容】</dt><dd>' . nl2br($naiyou) . '</dd>';
        echo '</dl>';

        //[上記内容で送信する]ボタンを表示する
        echo '<form method="post" action="mailpost.php">';
        echo '<input type="hidden" name="namae" value="' . $namae . '">';
        echo '<input type="hidden" name="studentid" value="' . $studentid . '">';
        echo '<input type="hidden" name="mailaddress" value="' . $mailaddress . '">';
        echo '<input type="hidden" name="naiyou" value="' . $naiyou . '">';
        echo '<input type="submit" name="okbtn" value="上記内容で送信する">';
        echo '</form>';
    }
    ?>

</body>

</html>