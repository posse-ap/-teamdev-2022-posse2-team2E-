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
  <title>問い合わせ完了</title>
</head>

<body>
  <!-- ヘッダー -->
  <header>
    <img src="logo.png" alt="">
    <nav>
      <ul>
        <li><a href="">就活サイト</a></li>
        <li><a href="">就活支援サービス</a></li>
        <li><a href="">自己分析診断ツール</a></li>
        <li><a href="">ES添削サービス</a></li>
        <li><a href="">就活エージェント</a></li>
        <li><a href="">就活の教科書とは</a></li>
        <li><a href="">お問い合わせ</a></li>
      </ul>
    </nav>
  </header>
  <div id="content">
    <p>問い合わせ完了</p>
    <a href="index.php"> トップページに戻る </a>
  </div>
</body>

</html>