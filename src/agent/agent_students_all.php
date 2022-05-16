<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . "/db_connect.php");

$db = new PDO(
    "mysql:host=db; dbname=shukatsu; charset=utf8",
    "$user",
    "$password",
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);

// $id = $_GET['id'];

$id = $_SESSION['id'];

//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["login"])) {
    header("Location: agent_students_all.php");
    exit();
}

// $options_stmt = $db->prepare("SELECT * FROM agents");


//ログインされている場合は表示用メッセージを編集
$corporate_name = $_SESSION['corporate_name'];
// var_dump($_SESSION['corporate_name']);
$message = $corporate_name . "様ようこそ";
// $message = $_SESSION['login'] . "様ようこそ";
$message = htmlspecialchars($message);

// $name = $_SESSION['name'];

// $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $counts = $db->query('select * from memos');
// $options_stmt = $db->prepare("SELECT * FROM students");
// $options_stmt->execute(array($id));
// $options = $options_stmt->fetchAll();

// $id = $result['id'];

var_dump($_SESSION['id']);

try {
    // $db = new PDO($dsn, $user, $password, [
    //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // ]);
    $db = new PDO("mysql:host=db; dbname=shukatsu; charset=utf8", "$user", "$password");


    // $sql = 'SELECT * from `students` where id = :id';
    // $stmt = $db->prepare('SELECT * FROM agents WHERE id = :id  INNER JOIN agents as T2 ON T1.agent_id = $id ');
    $stmt = $db->prepare('SELECT * FROM student_contact AS T1 INNER JOIN agents as T2 ON T1.agent_id = T2.id WHERE T1.agent_id = :agent_id ');
    $stmt->bindValue(':agent_id', $id, PDO::PARAM_INT);
    // $stmt->bindValue(':agent_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
        // $stmt->execute(array($id));

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $id = $result['id'];

        // $result = array();
    var_dump($result);
    if (!$result) {
        exit('データがありません。');
    }

    // var_dump($result['id']);
    // var_dump($id);
    var_dump($_SESSION['id']);
    echo 'wwwwww';

    /////

//     $stmt = $db->prepare('SELECT 
//     students.id AS id,
// 	students.created AS 申込日時, 
// 	students.name AS 氏名, 
// 	students.email AS メールアドレス, 
// 	students.tel AS 電話番号,
//     agents.id AS 問い合わせID
// FROM 
// 	students LEFT OUTER JOIN student_contact ON students.id  = student_contact.student_id 
//              LEFT OUTER JOIN agents ON student_contact.agent_id    = agents.id 
// ORDER BY students.id;
// ');

// // var_dump($stmt);

//     // $stmt = $db->prepare('SELECT * FROM student_contact as T1 INNER JOIN students as T2 On T1.student_id = T2.id ');
//     // $stmt->bindValue(':agent_id', $_SESSION['id'], PDO::PARAM_STR);
//     // $stmt->execute(array($id));
//     $stmt->execute();
//     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // // $result = array();
    // var_dump($result);
    // if (!$result) {
    //     exit('データがありません。');
    // }

    //////

    // $id_stmt = $db->prepare
    // ('SELECT * FROM student_contact as T1
    // INNER JOIN agents as T2
    // ON T1.agent_id = $id 
    // ');

    // $id_stmt = $db->prepare('SELECT * FROM student_contact where agent_id = $id');
    // $id_stmt = $db->prepare('SELECT * FROM `students` where id = :id');
    // $id_stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
    // //SQL実行
    // // $id_stmt->execute(array($id));
    // $id_stmt->execute();
    // //結果を取得
    // $result = $id_stmt->fetchAll(PDO::FETCH_ASSOC);
    // $result = array();
    // if (!$result) {
    //     exit('データがありません。');
    // }


    // $stmt = $db->query($sql);
    // var_dump($result);

    // $dbh->query('SET NAMES sjis');

    // foreach ($db->query($sql) as $row) {
    //     // print($row['id'].'<br>');
    //     // print($row['name'].'<br>');
    //     // print($row['email'].'<br>');
    // }
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
}


// echo $id;

// if (empty($id)) {
//  exit('IDが不正です。');
// }


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

    <!-- <header> -->
    <h1>
        <p><span>CRAFT</span>by boozer</p>
    </h1>
    <p class="welcome_agent"><?php echo $message; ?></p>
    <nav class="nav">
        <ul>
            <li><a href="agent_students_all.php">学生情報一覧</a></li>
            <li><a href="agent_information.php">登録情報</a></li>
            <li><a href="#">ユーザー画面</a></li>
            <li><a href="agent_logout.php">ログアウト</a></li>
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

            <h1 class="students_all_title">学生情報一覧</h1>


            <table cellspacing="0">
                <tr>
                    <th>申込日時</th>
                    <th>氏名</th>
                    <th>メールアドレス</th>
                    <th>電話番号</th>
                    <th>問い合わせID</th>
                    <th></th>
                </tr>

                <?php foreach ($result as $column) : ?>
                    <tr>
                        <td><?php echo ($column['申込日時']); ?></td>
                        <td><?php echo ($column['氏名']); ?></td>
                        <td><?php echo ($column['メールアドレス']); ?></td>
                        <td><?php echo ($column['電話番号']); ?></td>
                        <td><?php echo ($column['問い合わせID']); ?></td>
                        <td><a class="to_students_detail" href="agent_students_detail.php?id=<?php echo ($column['id']); ?>">詳細</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <!-- <tr>
            <td>2022/04/34 05:13</td>
            <td>かしけん</td>
            <td>starbucks@jinjan.com</td>
            <td>080-3424-8035</td>
            <td>210414</td>
            <td><a class="to_students_detail"
                    href="agent_students_detail.php">詳細</a>
            </td>
        </tr>
            <td>2022/04/34 05:13</td>
            <td>かしけん</td>
            <td>starbucks@jinjan.com</td>
            <td>080-3424-8035</td>
            <td>210414</td>
            <td><a class="to_students_detail"
                    href="agent_students_detail.php">詳細</a>
            </td>
        </tr>
            <td>2022/04/34 05:13</td>
            <td>かしけん</td>
            <td>starbucks@jinjan.com</td>
            <td>080-3424-8035</td>
            <td>210414</td>
            <td><a class="to_students_detail"
                    href="agent_students_detail.php">詳細</a>
            </td>
        </tr>
        <tr>
            <td>2022/04/34 05:13</td>
            <td>かしけん</td>
            <td>starbucks@jinjan.com</td>
            <td>080-3424-8035</td>
            <td>210414</td>
            <td><a class="to_students_detail"
                    href="agent_students_detail.php">詳細</a>
            </td>
        </tr>
        <tr>
            <td>2022/04/34 05:13</td>
            <td>かしけん</td>
            <td>starbucks@jinjan.com</td>
            <td>080-3424-8035</td>
            <td>210414</td>
            <td><a class="to_students_detail"
                    href="agent_students_detail.php">詳細</a>
            </td>
        </tr>
        <tr>
            <td>2022/04/34 05:13</td>
            <td>かしけん</td>
            <td>starbucks@jinjan.com</td>
            <td>080-3424-8035</td>
            <td>210414</td>
            <td><a class="to_students_detail"
                    href="agent_students_detail.php">詳細</a>
            </td>
        </tr> -->


            </table>

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