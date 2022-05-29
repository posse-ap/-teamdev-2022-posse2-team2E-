<?php
require('../../db_connect.php');

session_start();
//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["login"])) {
    header("Location: ../login/login.php");
    exit();
}

// 絞り込みの種類情報
$stmt = $db->query('select * from filter_sorts;');
$filter_sorts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// タグ情報
$stmt = $db->query('select * from filter_tags;');
$filter_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 絞り込みの種類追加
$stmt = $db->prepare('insert into filter_sorts (sort_name) VALUES (:sort_name)');
$stmt->bindValue(':sort_name', $_POST['tag_name'], PDO::PARAM_STR);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt->execute();
  header('location: tagEditThanks.php');
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
            <li class="header-nav-item select">タグ追加/編集</li>
          </a>
          <a href="../login/loginInfo.php">
            <li class="header-nav-item">ログイン情報</li>
          </a>
          <a href="../login/logoutPage.php">
            <li class="header-nav-item">ログアウト</li>
          </a>
        </ul>
      </nav>
    </div>
  </header>
  <p>
  <main class="main">
  <h1 class="main-title">絞り込みの種類追加画面</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="agent-add-table">

        <table class="tags-add">
          <p>※絞り込みの種類を追加した後、タグ追加を行ってください。</br>
          　タグ追加後、[エージェント一覧]→[(各エージェントの)詳細]→[編集]から、追加した絞り込みの種類の「タグ」を必ず選んでください。</br>
            　(掲載中の全てのエージェントに対して行ってください)</br></br>
          　<span class="error">注意</span>：追加した絞り込みの種類の「タグ」が選択されていない場合、掲載画面にエージェントは表示されません。
          </p>
          <tr>
            <th>絞り込みの種類</th>
          </tr>
          <tr>
            <td class="sub-th">番号</td>
            <td class="sub-th">名前</td>
          </tr>
          <?php foreach ($filter_sorts as $filter_sort) : ?>
            <tr>
              <td>
                <?php echo $filter_sort['id'] ?>
              </td>
              <td>
                <?= $filter_sort['sort_name']; ?>
              </td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <td>
              【自動割当】
            </td>
            <td>
              <input type="text" name="tag_name" value="" placeholder="追加する絞り込みの種類を記入" required />
            </td>
          </tr>
        </table>
        <div><a href="tagsEdit.php">&laquo;&nbsp;タグ一覧に戻る</a> | <input type="submit" value="追加する" /></div>
      </div>
    </form>
  </main>
</body>

</html>