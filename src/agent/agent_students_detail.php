<?php require($_SERVER['DOCUMENT_ROOT'] . "/db_connect.php");

// $dbh = new PDO("mysql:host=db; dbname=shukatsu; charset=utf8", "$user", "$password",
//     array(
//             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

try{
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

$stmt = $db->prepare('SELECT * FROM students where id = :id');
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
//SQL実行
$stmt->execute();
//結果を取得
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$result) {
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
</head>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<link rel="stylesheet" href="user/reset.css">
<link rel="stylesheet" href="table.css">

<body>

    <header>
        <h1>
            <p><span>CRAFT</span>by boozer</p>
        </h1>
        <p class="welcome_agent">ようこそ　リクナビ様</p>
        <nav class="nav">
            <ul>
                <li><a href="agent_students_all.php">学生情報一覧</a></li>
                <li><a href="#">登録情報</a></li>
                <li><a href="#">ユーザー画面</a></li>
                <li><a href="#">ログアウト</a></li>
            </ul>
        </nav>
    </header>

    <div class="all_wrapper">

        <div class="left_wrapper">
            <li><a href="agent_students_all.php">学生情報一覧</a></li>
            <li><a href="agent_information.php">登録情報</a></li>
            <li>ユーザー画面</li>
            <li>ログアウト</li>
        </div>

        <div class="right_wrapper">

            <h1 class="detail_title">学生情報詳細</h1>

            <table class="students_detail" border="1" width="90%">
                　<tr bgcolor="white">
                    　　<th bgcolor="#4FA49A">問い合わせID</th>
                    <td><?php echo $result['id'] ?></td>
                    　
                </tr>
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
                    　　<th bgcolor="#4FA49A">住所</th>
                    <td><?php echo $result['address'] ?></td>
                    　
                </tr>
                　<tr bgcolor="white">
                    　　<th bgcolor="#4FA49A">悩み</th>
                    <td><?php echo $result['memo'] ?>
                    　
                </tr>
            </table>
            <div class="mukou">
                <a class="back_to_students" href="agent_students_all.php">学生情報一覧に戻る</a>
                <a id="mukou_form" class="mukou_to_form" onclick="display()">通報する</a>
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

            <!-- <form id="view" class="form" method="post" action="comform.php" style="display: none;">
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
</form> -->
        </div>
    </div>

    <div class="inquiry">
        <p>お問い合わせは下記の連絡先にお願いいたします。
            <br>craft運営 boozer株式会社事務局
            <br>TEL:080-3434-2435
            <br>Email:craft@boozer.com
        </p>
    </div>

    <script src="js/agent_students_detail.js"></script>
</body>

</html>