<?php require($_SERVER['DOCUMENT_ROOT'] . "/db_connect.php");

session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["login"])) {
    header("Location: agent_login.php");
    exit();
}


if(!isset($_SESSION['kerberos_flg']) && $_SESSION['kerberos_flg'] !== 1 ){
    // header("Location: agent_login.php");

		echo '
			<div align="center">
				<h1>不正遷移です。</h1>
				<p style="color : red;">
					このページの直接アクセスは禁止されています。
				</p>
				<p>誠にご面倒をおかけしますが、お問い合わせフォームから入力をお願い致します</p>
				<p><strong>Cookieを無効化している場合は、有効化を行って下さい。</strong></p>
				<p>
					<ul style=" list-style-type: none;">
						<li><a href="https://support.google.com/chrome/answer/95647?co=GENIE.Platform%3DDesktop&hl=ja" target="_blank">Google ChromeのCookieの有効化方法</a></li>
						<li><a href="https://support.mozilla.org/ja/kb/enable-and-disable-cookies-website-preferences" target="_blank">FirefoxのCookieの有効化方法</a></li>
						<li><a href="https://support.microsoft.com/ja-jp/help/17442/windows-internet-explorer-delete-manage-cookies" target="_blank">IE, EdgeのCookieの有効化方法</a></li>
					</ul>
				
				
					<a href="/info/お問い合わせフォーム/"><strong>『お問い合わせページ』はこちら</strong></a>
				</p>
			</div><!--div center-->
		';
		exit();
	}



try {
    $db = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    echo '接続失敗: ' . $e->getMessage();
    exit();
}

$id = $_GET['id'];
// echo $id;

if (empty($id)) {
    exit('IDが不正です。');
}

$stmt = $db->prepare('SELECT * FROM students AS S INNER JOIN student_contact AS SC ON S.id = SC.student_id where S.id = :id');
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
//SQL実行
$stmt->execute();
//結果を取得
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    exit('データがありません。');
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生情報詳細</title>
    <script src="agent_students_detail.js"></script>

</head>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<link rel="stylesheet" href="user/reset.css">
<link rel="stylesheet" href="table.css">
<link rel="stylesheet" href="agent_students_detail.css">

<body>

    <header>
        <h1>
            <p><span>CRAFT</span>by boozer</p>
        </h1>
        <p class="welcome_agent">ようこそ　<?php echo ($_SESSION['corporate_name']); ?>様</p>
        <nav class="nav">
        <ul>
            <li><a href="agent_students_all.php">学生情報一覧</a></li>
            <li><a href="agent_information.php">登録情報</a></li>
            <li><a href="#">ユーザー画面へ</a></li>
            <li><a href="agent_logout.php">ログアウト</a></li>
        </ul>
    </nav>
    </header>
    <div class="all_wrapper">
        <div class="left_wrapper">
            <li><a href="agent_students_all.php">学生情報一覧</a></li>
            <li><a href="agent_information.php">登録情報</a></li>
            <li><a href="#">ユーザー画面へ</a></li>
            <li><a href="agent_logout.php">ログアウト</a></li>
        </div>
        <div class="right_wrapper">
            <h1 class="detail_title">学生情報詳細</h1>
            <table class="students_detail" border="1" width="90%">
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">申込日時</th>
                    <td><?php echo $result['created'] ?></td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">氏名</th>
                    <td><?php echo $result['name'] ?></td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">メールアドレス</th>
                    <td><?php echo $result['email'] ?></td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">電話番号</th>
                    <td><?php echo $result['tel'] ?></td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">大学</th>
                    <td><?php echo $result['collage'] ?></td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">学部</th>
                    <td><?php echo $result['faculty'] ?></td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">学科</th>
                    <td><?php echo $result['department'] ?></td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">何年卒</th>
                    <td><?php echo $result['class_of'] ?></td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">住所</th>
                    <td><?php echo $result['address'] ?></td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">悩み</th>
                    <td><?php echo $result['memo'] ?>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">問い合わせID</th>
                    <td><?php echo $result['student_id'] ?></td>
                </tr>
            </table>
            <div class="mukou">
                <a class="back_to_students" href="agent_students_all.php">学生情報一覧に戻る</a>
                <a id="mukou_form" class="mukou_to_form" onclick="display()">通報する</a>
            </div>
            <div class="iframe_wrap">
                <iframe id="view" style="display:none;" src="https://docs.google.com/forms/d/e/1FAIpQLSeDbKnAzAbnHlYaRGkPwyAUU6vZYt97ZxKsdM7J9T6DNQ1fKA/viewform?embedded=true" width="900" height="884" marginwidth="0">読み込んでいます…</iframe>
            </div>


            <?php
            /*******************************
 確認ページから戻ってきた場合のデータの受け取り 
             *******************************/
            if (isset($_POST["backbtn"])) {
                //確認ページ（confirm.php）から戻ってきた場合にはデータを受け取る
                $namae        = $_POST["namae"];        //お名前
                $studentid        = $_POST["studentid"];        //問い合わせID
                $mailaddress    = $_POST["mailaddress"];    //メールアドレス
                $naiyou        = $_POST["naiyou"];        //お問合せ内容

                //危険な文字列を入力された場合にそのまま利用しない対策
                $namae        = htmlspecialchars($namae, ENT_QUOTES);
                $studentid        = htmlspecialchars($studentid, ENT_QUOTES);
                $mailaddress    = htmlspecialchars($mailaddress, ENT_QUOTES);
                $naiyou        = htmlspecialchars($naiyou, ENT_QUOTES);
            } else {
                //確認ページから戻ってきた場合でなければ、変数の値は必ず空となる
                $namae        = '';                //お名前
                $$studentid        = '';                //問い合わせID
                $mailaddress    = '';                //メールアドレス
                $naiyou        = '';                //お問合せ内容
            }
            ?>

            <div class="iframe_wrap">
                <iframe id="view" style="display:none;" src="https://docs.google.com/forms/d/e/1FAIpQLSeDbKnAzAbnHlYaRGkPwyAUU6vZYt97ZxKsdM7J9T6DNQ1fKA/viewform?embedded=true" width="900" height="884" marginwidth="0">読み込んでいます…</iframe>
            </div>

            <form id="view" class="form" method="post" action="comform.php" style="display: none;">
<p><label>御社名：<br>
<input type="text" maxlength="255" name="namae" value="<?= $namae ?>" required>
</label></p>

<p><label>問い合わせID：<br>
<input type="text" inputmode="numeric" maxlength="6" name="studentid" value="<?= $studentid ?>" required>
</label></p>

<p><label>御社のメールアドレス：<br>
<input type="email" size="30" maxlength="255" name="mailaddress" value="<?= $mailaddress ?>" required>
</label></p>

<p><label>通報内容：<br>
<textarea name="naiyou" cols="40" rows="5"><?= $naiyou ?></textarea>
</label></p>

<p>
報告を受けました学生の情報に関しましては、当社が確認の上削除させていただきます。
<br>また、削除されました学生に関しては請求の対象から除きますのでご安心くださいませ。</p>

<p><input type="submit" value="通報する"></p>
</form>
        </div>
    </div>

    <div class="inquiry">
        <p>お問い合わせは下記の連絡先にお願いいたします。
            <br>craft運営 boozer株式会社事務局
            <br>TEL:080-3434-2435
            <br>Email:craft@boozer.com
        </p>
    </div>

    <script src="agent_students_detail.js"></script>
</body>

</html>