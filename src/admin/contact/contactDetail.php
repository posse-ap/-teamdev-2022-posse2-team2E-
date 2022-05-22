<?php
require('../db_connect.php');
session_start();

// //ログインされていない場合は強制的にログインページにリダイレクト
// if (!isset($_SESSION["login"])) {
//     header("Location: agent_login.php");
//     exit();
// }

// 問い合わせid (!=student_id)
$id = $_GET['id'];

if (empty($id)) {
    exit('IDが不正です。');
}

$stmt = $db->prepare('SELECT * FROM students AS S INNER JOIN students_contacts AS SC ON S.id = SC.student_id where SC.id = :id');
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
//SQL実行
$stmt->execute();
//結果を取得
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    exit('データがありません。');
}

// 通報内容
$stmt = $db->prepare('SELECT * FROM invalid_requests  where contact_id = :contact_id');
$stmt->bindValue(':contact_id', (int)$id, PDO::PARAM_INT);
//SQL実行
$stmt->execute();
//結果を取得
$invalid_requests = $stmt->fetch(PDO::FETCH_ASSOC);

// 通報機能
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naiyou = filter_input(INPUT_POST, 'naiyou', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $stmt = $db->prepare('insert into invalid_requests (contact_id, invalid_request_memo) VALUES (:contact_id, :invalid_request_memo)');
    $stmt->bindValue(':contact_id', (int)$id, PDO::PARAM_INT);
    $stmt->bindValue(':invalid_request_memo', $naiyou, PDO::PARAM_STR); //filterする
    $stmt->execute();

    // students_contacts.valid_status_idを　1→2へ
    $stmt = $db->prepare('update students_contacts set valid_status_id=2 where id=:id');
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    header("location: agent_students_detail.php?id=$id");
}

// 無効化申請中/無効化承認済みをタイトルに表示
function set_valid_status($valid_status)
{
    if ($valid_status === 1) {
        return '';
    } elseif ($valid_status === 2) {
        return '無効化申請中';
    } elseif ($valid_status === 3) {
        return '無効化承認済み';
    } else {
        return 'エラー';
    }
}

// 重複検査
//email重複
$stmt = $db->prepare(
    'SELECT SC.id FROM students AS S, students_contacts AS SC WHERE S.email = :email AND S.id = SC.student_id AND SC.agent_id = :agent_id ORDER BY S.created desc'
);
if (!$stmt) {
    die($db->error);
}
$stmt->bindValue(':email', $result['email'], PDO::PARAM_STR);
$stmt->bindValue(':agent_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$duplicated_emails = $stmt->fetchAll(PDO::FETCH_ASSOC);
//tel重複
$stmt = $db->prepare(
    'SELECT SC.id FROM students AS S, students_contacts AS SC WHERE S.tel = :tel AND S.id = SC.student_id AND SC.agent_id = :agent_id ORDER BY S.created desc'
);
if (!$stmt) {
    die($db->error);
}
$stmt->bindValue(':tel', $result['tel'], PDO::PARAM_STR);
$stmt->bindValue(':agent_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$duplicated_tels = $stmt->fetchAll(PDO::FETCH_ASSOC);
//name重複
$stmt = $db->prepare(
    'SELECT SC.id FROM students AS S, students_contacts AS SC WHERE S.name = :name AND S.id = SC.student_id AND SC.agent_id = :agent_id ORDER BY S.created desc'
);
if (!$stmt) {
    die($db->error);
}
$stmt->bindValue(':name', $result['name'], PDO::PARAM_STR);
$stmt->bindValue(':agent_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$duplicated_names = $stmt->fetchAll(PDO::FETCH_ASSOC);


// foreach($duplicated_emails as $d_email){
//     if($d_email['id'] !=  $id){
//         echo $d_email['id'];
//     }
// }
// echo "<pre>";
// var_dump($duplicated_emails);
// echo "</pre>";
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
            <h1 class="detail_title">学生情報詳細　　　　<?= set_valid_status($result['valid_status_id']) ?></h1>
            <table class="students_detail" border="1" width="90%">
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">申込日時</th>
                    <td><?php echo $result['created'] ?></td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">氏名</th>
                    <td><?php echo $result['name'] ?>
                    <?php foreach ($duplicated_names as $d_name) : if ($d_name['id'] !=  $id) : ?>
                                <span style="background-color:red;">id<?= $d_name['id']; ?>と重複</span>
                        <?php endif;
                        endforeach ?>
                </td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">メールアドレス</th>
                    <td><?php echo $result['email'] ?>
                        <?php foreach ($duplicated_emails as $d_email) : if ($d_email['id'] !=  $id) : ?>
                                <span style="background-color:red;">id<?= $d_email['id']; ?>と重複</span>
                        <?php endif;
                        endforeach ?>
                    </td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">電話番号</th>
                    <td><?php echo $result['tel'] ?>
                    <?php foreach ($duplicated_tels as $d_tel) : if ($d_tel['id'] !=  $id) : ?>
                                <span style="background-color:red;">id<?= $d_tel['id']; ?>と重複</span>
                        <?php endif;
                        endforeach ?>
                </td>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">大学</th>
                    <td><?php echo $result['collage'] ?></td>
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
                    <th bgcolor="#4FA49A">備考欄</th>
                    <td><?php echo $result['memo'] ?>
                </tr>
                <tr bgcolor="white">
                    <th bgcolor="#4FA49A">問い合わせID</th>
                    <td><?php echo $id ?></td>
                </tr>
            </table>
            <div class="mukou">
                <a class="back_to_students" href="agent_students_all.php">学生情報一覧に戻る</a>
                <?php if ($result['valid_status_id'] === 1) : ?>
                    <a id="mukou_form" class="mukou_to_form" onclick="display()">通報する</a>
                <?php endif; ?>
            </div>
            <?php if ($result['valid_status_id'] === 1) : ?>
                <form id="view" action="" method="post" enctype="multipart/form-data" style="display: none">
                    <p><label>通報内容：<br>
                            <textarea name="naiyou" cols="40" rows="5" required></textarea>
                        </label></p>
                    <p>
                        報告を受けました学生の情報に関しましては、当社が確認の上、請求の対象外といたします。
                        <br>確認いたしましたら、学生情報に「無効」と記載いたしますのでご確認くださいませ。
                    </p>

                    <p><input type="submit" value="通報する"></p>
                </form>
            <?php endif; ?>
            <?php if ($result['valid_status_id'] != 1) : ?>
                <table>
                    <tr bgcolor="white">
                        <th bgcolor="red">通報内容</th>
                        <td><?php echo h($invalid_requests['invalid_request_memo']) ?></td>
                    </tr>
                </table>
            <?php endif; ?>
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