<?php

session_start();
require('db_connect.php');

// //ログインされていない場合は強制的にログインページにリダイレクト
// if (!isset($_SESSION["login"])) {
//     header("Location: ../login/login.php");
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thanks</title>
</head>
<body>
  <div id="content">
  <p>問い合わせ完了</p>
  <a href="index.php">  トップページに戻る  </a>
  </div>
</body>
</html>