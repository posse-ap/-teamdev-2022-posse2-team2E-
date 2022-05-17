<?php require($_SERVER['DOCUMENT_ROOT'] . "/db_connect.php");
session_start();

// // ログイン済みかを確認
// if (isset($_SESSION['login'])) {
//     session_regenerate_id(TRUE);
//     header('Location: agent_students_all.php'); // ログインしていればresult-index.phpへリダイレクトする
//     exit; // 処理終了
// }

if (isset($_POST["submit"])) {

    try {
        $db = new PDO("mysql:host=db; dbname=shukatsu; charset=utf8", "$user", "$password");

        $stmt = $db->prepare('SELECT id, corporate_name, login_pass FROM agents WHERE login_email = :login_email');
        // $stmt = $db->prepare('SELECT * FROM agents WHERE login_email = :email limit 1');
        // $stmt->execute(array(':email' => $_POST['email']));
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $login_email = $_POST['email'];
        $stmt->bindValue(':login_email', $login_email, PDO::PARAM_STR);
        // $stmt->bindParam(1, $_POST['email'], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($_POST['pass'], $result['login_pass'])) {

            // }
            session_regenerate_id(TRUE); //セッションidを再発行
            $_SESSION['id'] = $result['id'];
            $_SESSION['corporate_name'] = $result['corporate_name'];
            $_SESSION["login"] = $_POST['email']; //セッションにログイン情報を登録
                //         $redirect[1] = "agent_students_all.php?id=1";
                //         $redirect[2] = "agent_students_all.php?id=2";
                //         $redirect[3] = "agent_students_all.php?id=3";
                // // $id = ($_GET['id']);
                // $id = ($_SESSION['id']);
                // header("Location:$redirect[$id]");
            header('Location: agent_students_all.php');
        } else {
            $msg = 'メールアドレスもしくはパスワードが間違っています。';
            var_dump($result['corporate_name']);

            echo "わあああああああああああ";

            // var_dump(password_hash("miyuki", PASSWORD_DEFAULT));

            echo "わあああああああああああ";

            var_dump($_POST['pass']);

            echo "わあああああああああああ";

            var_dump($result['login_pass']);

            echo "わあああああああああああ";

            var_dump($_POST['email']);

            echo "わあああああああああああ";

            var_dump($result['login_email']);
        }
    } catch (PDOException $e) {
        echo "もう一回";
        $msg = $e->getMessage();
        exit;
    }
}

// $id = $_GET['id'];
// echo $id;

// if (empty($id)) {
//  exit('IDが不正です。');
// }

// $error = [];
// $email = '';
// $password = '';
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
//   $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
// if ($email === '' || $password === '') {
//   $error['login'] = 'blank';
// } else {
//   // ログインチェック
//   $db = dbconnect();
//   $stmt = $db->prepare('select id, name, password from members where email=? limit 1');
//   if (!$stmt) {
//     die($db->error);
//   }

// $stmt->bind_param('s', $email);
// $success = $stmt->execute();
// if (!$success) {
//   die($db->error);
// }

// $stmt->bind_result($id, $name, $hash);
// $stmt->fetch();

//     if (password_verify($password, $hash)) {
//       // ログイン成功
//       session_regenerate_id();
//       $_SESSION['id'] = $id;
//       $_SESSION['name'] = $name;
//       header('Location: index.php');
//       exit();
//     } else {
//       $error['login'] = 'failed';
//     }
//   // }
// }

// $id_stmt = $db->prepare('SELECT * FROM users where id = :id');
// $id_stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
// //SQL実行
// $id_stmt->execute();
// //結果を取得
// $result = $id_stmt->fetch(PDO::FETCH_ASSOC);

// if(!$result) {
//     exit('データがありません。');
// }

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="agent_students_all.css">
    <link rel="stylesheet" href="agent_information.css">
    <link rel="stylesheet" href="agent_login.css">
</head>

<body>
    <!-- <header> -->
    <h1>
        <p><span>CRAFT</span>by boozer</p>
    </h1>
    <p class="agent_login">エージェント企業ログイン画面</p>
    </header>
    <div class="agent_login_info">
        <h2 class="agent_login_title">エージェント企業用画面</h2>
        <form action="" method="post">
            <h3 class="pass_wrong"><?php echo $msg; ?></h3>
            <p>
            <p class="agent_login_label">メールアドレス</p>
            <input type="text" name="email" value="<?php echo h($email); ?>" required>
            </p>
            <p>
            <p class="agent_login_label">パスワード</p>
            <input type="text" name="pass" value="<?php echo h($password); ?>" required>
            </p>
            <input type="submit" name="submit" value="ログイン">
        </form>
        <!-- <a href="inquiry.php" class="pass_forget">パスワードをお忘れの方はこちら</a> -->
    </div>
    <!-- <div class="inquiry"> -->
    <p>お問い合わせは下記の連絡先にお願いいたします。
        <br>craft運営 boozer株式会社事務局
        <br>TEL:080-3434-2435
        <br>Email:craft@boozer.com
    </p>
    </div>
</body>

</html>