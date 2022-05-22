<?php
require('../../db_connect.php');

session_start();

session_start();
//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}

//タグ情報
$stmt = $db->query('select * from admin_login;');
$admin_login = $stmt->fetch(PDO::FETCH_ASSOC);
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
            <li class="header-nav-item">タグ一覧</li>
          </a>
          <a href="#">
            <li class="header-nav-item">問い合わせ一覧</li>
          </a>
          <a href="../login/loginInfo.php">
            <li class="header-nav-item select">管理者ログイン情報</li>
          </a>
          <a href="../login/logout.php">
            <li class="header-nav-item">ログアウト</li>
          </a>
        </ul>
      </nav>
    </div>
  </header>
  <main class="main">
    <div class="agent-add-table">
      <table class="tags-add">
        <tr>
          <td class="sub-th">email</td>
          <td class="sub-th">pass</td>
        </tr>
        <tr>
          <td>
            <!-- email -->
            <?= $admin_login['email'] ?>
          </td>
          </td>
          <td>
            <!-- ここにパスワード -->
            【表示されません】
          </td>
        </tr>
      </table>
    </div>
  </main>
</body>

</html>