<?php require($_SERVER['DOCUMENT_ROOT'] . "/db_connect.php");
session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["login"])) {
    header("Location: agent_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['month'] = filter_input(INPUT_POST, 'month', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $form['month'] = Date('Y-m');
}

$id = $_SESSION['id'];

$message = $_SESSION['corporate_name'] . "様ようこそ";

try {
    $db = new PDO("mysql:host=db; dbname=shukatsu; charset=utf8", "$user", "$password");

    if (isset($_POST["months"])) {
        $month = $_POST["months"];
        // セレクトボックスで選択された値を受け取る
    } else {
        $month = Date('n');
    }

    $sum_stmt = $db->prepare('SELECT 
    DATE_FORMAT(S.created, "%Y-%m") AS 年月,
    DATE_FORMAT(S.created, "%Y") AS 年,
    DATE_FORMAT(S.created, "%m") AS 月,
    (SELECT COUNT(S.created) from students AS S WHERE DATE_FORMAT(S.created, "%Y-%m") = :form_month) AS counts
    FROM
    students AS S, students_contacts AS SC, agents AS A
    WHERE 
    S.id = SC.student_id    
    AND
    SC.agent_id = A.id
    AND
    SC.agent_id = :agent_id
    ');
    $sum_stmt->bindValue(':agent_id', $id, PDO::PARAM_INT);
    $sum_stmt->bindValue(':form_month', $form['month'], PDO::PARAM_STR);
    $sum_stmt->execute();
    $sum_result = $sum_stmt->fetchAll(PDO::FETCH_ASSOC);
    $example = $sum_result[$month - 4]['年月'];


    $stmt = $db->prepare('SELECT 
    DATE_FORMAT(S.created, "%Y-%m") AS prepare_month,
    DATE_FORMAT(S.created, "%m") AS 月,
    (SELECT COUNT(SC.created) from students_contacts AS SC, agents AS A WHERE DATE_FORMAT(SC.created, "%Y-%m") = :form_month AND SC.agent_id = A.id AND SC.agent_id = :agent_id) AS counts,
    -- COUNT(S.created) AS counts,
	S.created AS 問い合わせ日時, 
	S.name AS 氏名, 
	S.email AS メールアドレス, 
	S.tel AS 電話番号, 
	S.collage AS 大学,
	-- S.faculty AS 学部,
	S.department AS 学科,
	S.class_of AS 何年卒,
    SC.id AS 問い合わせID,
    SC.valid_status_id AS 無効判定
    FROM
    students AS S, students_contacts AS SC, agents AS A
    WHERE 
    S.id = SC.student_id
    AND
    SC.agent_id = A.id
    AND
    -- A.id = :agent_id
    SC.agent_id = :agent_id
    AND
    DATE_FORMAT(S.created, "%Y-%m") = :form_month
    AND
    DATE_FORMAT(S.created, "%Y-%m") = :form_month
    ORDER BY 問い合わせ日時 desc
    ');

    $stmt->bindValue(':form_month', $form['month'], PDO::PARAM_STR);
    $stmt->bindValue(':agent_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if ($result[0]['counts'] === NULL) {
        $result[0]['counts'] = 0;
    }
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
}

if (empty($id)) {
    exit('IDが不正です。');
}

// 無効化申請中/無効化承認済みをタイトルに表示
function set_valid_status($valid_status)
{
    if ($valid_status === "1") {
        return '';
    } elseif ($valid_status === "2") {
        return '申請中';
    } elseif ($valid_status === "3") {
        return '承認済み';
    } else {
        return 'エラー';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生情報一覧</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="agent_students_all.css">
</head>

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
            <h1 class="students_all_title">学生情報一覧</h1>
            <div class="sum_inquiry_wrapper">
                <p class="sum_inquiry"><span><?php echo ($form['month']); ?>月</span>の問い合わせ件数: <span><?php echo ($result[0]['counts']); ?></span>件</p>
            </div>
            <form action="agent_students_all.php" method="POST">
                <input type="month" name="month" value="<?php echo $form['month']; ?>">
                <input type="submit" name="submit" value="月を変更" />
            </form>
            <?php if ($result[0]['counts'] === 0) : ?>
                <p class="error">ヒットしませんでした。違う月を改めて指定してください</p>
            <?php endif; ?>
            <?php if (!($result[0]['counts'] === 0)) : ?>
                <table cellspacing="0">
                    <tr>
                        <th>問い合わせ日時</th>
                        <th>氏名</th>
                        <th>大学</th>
                        <th>学部</th>
                        <th>学科</th>
                        <th>何年卒</th>
                        <th>問い合わせID</th>
                        <th>詳細</th>
                        <th>無効申請</th>
                    </tr>
                    <?php foreach ($result as $column) : ?>
                        <tr>
                            <td><?php echo ($column['問い合わせ日時']); ?></td>
                            <td><?php echo ($column['氏名']); ?></td>
                            <td><?php echo ($column['大学']); ?></td>
                            <td><?php echo ($column['学部']); ?></td>
                            <td><?php echo ($column['学科']); ?></td>
                            <td><?php echo ($column['何年卒']); ?></td>
                            <td><?php echo ($column['問い合わせID']); ?></td>
                            <td><a class="to_students_detail" href="agent_students_detail.php?id=<?php echo ($column['問い合わせID']); ?>">詳細</a>
                            </td>
                            <td><?php echo set_valid_status($column['無効判定']); ?></td>
                        </tr>
                    <?php endforeach; ?>
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
</body>

</html>