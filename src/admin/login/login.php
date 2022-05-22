<?php require($_SERVER['DOCUMENT_ROOT'] . "/db_connect.php");
session_start();

// ログイン済みかを確認
// if (isset($_SESSION['login'])) {
//     header('Location: agent_students_all.php'); // ログインしていればagent_students_all.phpへリダイレクトする
//     exit; // 処理終了
// }

if (isset($_POST["submit"])) {
    try {
        $db = new PDO("mysql:host=db; dbname=shukatsu; charset=utf8", "$user", "$password");
        $stmt = $db->prepare('SELECT id, email, login_password FROM admin_login WHERE email = :email limit 1');
        $email = $_POST['email'];
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($_POST['pass'], $result['login_password'])) {
            session_regenerate_id(TRUE); //セッションidを再発行
            $_SESSION['id'] = $result['id'];
            $_SESSION["login"] = $_POST['email']; //セッションにログイン情報を登録
            header('Location: ../../admin/index.php');
        } else {
            $msg = 'メールアドレスもしくはパスワードが間違っています。';

            // echo "<pre>";
            // var_dump($_POST['pass']);
            // echo "</pre>";

            // echo "<pre>";
            // var_dump(password_hash("pass", PASSWORD_DEFAULT));
            // echo "</pre>";

            // echo "<pre>";
            // var_dump($result['login_password']);
            // echo "</pre>";

            // echo "<pre>";
            // var_dump($_POST['email']);
            // echo "</pre>";

            // echo "<pre>";
            // var_dump($result['email']);
            // echo "</pre>";
        }
    } catch (PDOException $e) {
        echo "もう一回";
        $msg = $e->getMessage();
        exit;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン画面</title>
    <link rel="stylesheet" href="../../reset.css">
    <link rel="stylesheet" href="../../agent/table.css">
    <link rel="stylesheet" href="../../agent/agent_login.css">
</head>

<body>
    <!-- <header> -->
    <h1>
        <p><span>CRAFT</span>by boozer</p>
    </h1>
    <p class="agent_login">CRAFT管理者ログイン画面</p>
    </header>
    <div class="agent_login_info">
        <h2 class="agent_login_title">CRAFT管理者ログイン画面</h2>
        <form action="" method="post">
            <h3 class="pass_wrong"><?php echo $msg; ?></h3>
            <p class="agent_login_label">メールアドレス</p>
            <input type="text" name="email" value="<?php echo h($email); ?>" required>
            <p class="agent_login_label">パスワード</p>
            <input type="password" name="pass" value="<?php echo h($pass); ?>" required>
            <input type="submit" name="submit" value="ログイン">
        </form>
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