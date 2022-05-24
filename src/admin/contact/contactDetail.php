<?php
require('../../db_connect.php');
session_start();

// //ログインされていない場合は強制的にログインページにリダイレクト
// if (!isset($_SESSION["login"])) {
//     header("Location: agent_login.php");
//     exit();
// }

// 問い合わせid (!=student_id)
$id = $_GET['id'];
$agent_id = $_GET['agent'];

if (empty($id) || empty($agent_id)) {
    exit('IDが不正です。');
}
// agent_id 取得
// $stmt = $db->prepare('SELECT agent_id FROM students_contacts where id = :id');
// $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
// $stmt->execute();
// $agent_id = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $db->prepare('SELECT * FROM students AS S INNER JOIN students_contacts AS SC ON S.id = SC.student_id where SC.id = :id');
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
//SQL実行
$stmt->execute();
//結果を取得
$result = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($result);

if (!$result) {
    exit('データがありません。');
}

// エージェント名取得
$stmt = $db->prepare('SELECT insert_company_name FROM agents WHERE id=:id');
$stmt->bindValue(':id', (int)$agent_id, PDO::PARAM_INT);
$stmt->execute();
$agent = $stmt->fetch(PDO::FETCH_ASSOC);



// 通報内容
$stmt = $db->prepare('SELECT * FROM invalid_requests  where contact_id = :contact_id');
$stmt->bindValue(':contact_id', (int)$id, PDO::PARAM_INT);
//SQL実行
$stmt->execute();
//結果を取得
$invalid_requests = $stmt->fetch(PDO::FETCH_ASSOC);

// 通報機能
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // students_contacts.valid_status_idを　3へ
    $stmt = $db->prepare('update students_contacts set valid_status_id=3 where id=:id');
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    header("location: contactDetail.php?agent=$agent_id&id=$id");
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
$stmt->bindValue(':agent_id', (int)$agent_id, PDO::PARAM_INT);
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
$stmt->bindValue(':agent_id', (int)$agent_id, PDO::PARAM_INT);
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
$stmt->bindValue(':agent_id', (int)$agent_id, PDO::PARAM_INT);
$stmt->execute();
$duplicated_names = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<link rel="stylesheet" href="../css/reset.css" />
  <link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" href="../../agent/table.css">
<link rel="stylesheet" href="../../agent/agent_students_detail.css">


<body>

    <header>
        <div class="header-inner">
            <h1 class="header-title">CRAFT管理者画面</h1>
            <nav class="header-nav">
                <ul class="header-nav-list">
                    <a href="../index.php">
                        <li class="header-nav-item select">エージェント一覧</li>
                    </a>
                    <a href="../add/agentAdd.php">
                        <li class="header-nav-item">エージェント追加</li>
                    </a>
                    <a href="../tags/tagsEdit.php">
                        <li class="header-nav-item">タグ一覧</li>
                    </a>
                    <a href="../contact/contact.php">
                        <li class="header-nav-item">問い合わせ一覧</li>
                    </a>
                    <a href="../login/loginInfo.php">
                        <li class="header-nav-item">管理者ログイン情報</li>
                    </a>
                    <a href="../login/logout.php">
                        <li class="header-nav-item">ログアウト</li>
                    </a>
                </ul>
            </nav>
        </div>
    </header>
    <div class="back">
    <a href="contact.php?id=<?= $agent_id ?>">&laquo;&nbsp;<?= $agent['insert_company_name'] ?>問い合わせ一覧に戻る</a></div>
    <main class="main">
        
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
                <form action="" method="post" enctype="multipart/form-data">
                    <p><input type="submit" value="無効化"></p>
                </form>
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
    <script src="agent_students_detail.js"></script>
    </main>
</body>

</html>