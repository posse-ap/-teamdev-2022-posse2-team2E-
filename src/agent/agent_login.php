<?php require($_SERVER['DOCUMENT_ROOT'] . "/db_connect.php");


// ログイン済みかを確認
if (isset($_SESSION['USER'])) {
    header('Location: agent_students_all.php'); // ログインしていればresult-index.phpへリダイレクトする
    exit; // 処理終了
}

if (isset($_POST["submit"])) {

try {
    $dbh = new PDO("mysql:host=db; dbname=shukatsu; charset=utf8", "$user", "$password");

    $stmt = $dbh->prepare('SELECT * FROM users WHERE email = :email');

    $stmt->execute(array(':email' => $_POST['email']));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($_POST['pass'], $result['password'])) {
        header('Location: agent_students_all.php');
    } else {
        $msg = 'メールアドレスもしくはパスワードが間違っています。';
        // var_dump(password_hash("password", PASSWORD_DEFAULT));
        // var_dump($result['password']);
        // var_dump($_POST['pass']);
        // var_dump($_POST['email']);
        // var_dump($result['email']);
        

    }
} catch (PDOException $e) {
    echo "もう一回";
    $msg = $e->getMessage();
    // die();
}
}
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
    <header>
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
                <input type="text" name="email" required>
            </p>
            <p>
                <p class="agent_login_label">パスワード</p>
                <input type="password" name="pass">
            </p>
            <input type="submit" name="submit" value="ログイン" required>
        </form>
        <!-- <a href="inquiry.php" class="pass_forget">パスワードをお忘れの方はこちら</a> -->
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