<?php
session_start();
$output = '';
if (!isset($_SESSION["login"])) {
  header("Location: agent_login.php");
}
//セッション変数のクリア
$_SESSION = array();
//セッションクッキーも削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
//セッションクリア
@session_destroy();

echo $output;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログアウトページ</title>
<link href="/agent_logout.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>ログアウトページ</h1>
<div class="message">ログアウトしました</div>
<a href="agent_login.php">ログインページへ</a>
</body>
</html>