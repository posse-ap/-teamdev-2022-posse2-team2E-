<?php
require('../../db_connect.php');
session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["login"])) {
    header("Location: ../login/login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AgentList</title>
  <link rel="stylesheet" href="../css/reset.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <script src="./js/jquery-3.6.0.min.js"></script>
  <script src="./js/script.js" defer></script>
</head>

<body>
  <header>
    <div class="header-inner">
      <h1 class="header-title">CRAFT管理者画面</h1>
      <nav class="header-nav">
        <ul class="header-nav-list">
        <a href="../index.php">
            <li class="header-nav-item">エージェント一覧</li>
          </a>
          <a href="../add/agentAdd.php">
            <li class="header-nav-item">エージェント追加</li>
          </a>
          <a href="../tags/tagsEdit.php">
            <li class="header-nav-item select">タグ一覧</li>
          </a>
          <a href="#">
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
<body>
<div id="head">
<h1>新規登録</h1>
</div>

<div class="done">
<p>新規登録が完了しました。</p>
<p><a href="../index.php">エージェント一覧画面で確認する</a></p>
</div>

</div>
</body>
</html>