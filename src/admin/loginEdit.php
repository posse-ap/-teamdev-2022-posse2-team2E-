<?php
require('../db_connect.php');
//タグ情報
$stmt = $db->query('select fs.id, sort_name, tag_id, tag_name from filter_sorts fs inner join filter_tags ft on fs.id = ft.sort_id;
');
$filter_sorts_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
$t_list = [];
foreach ($filter_sorts_tags as $f) {
  $t_list[(int)$f['id']][] = $f;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AgentList</title>
  <link rel="stylesheet" href="./css/reset.css" />
  <link rel="stylesheet" href="./css/style.css" />
  <script src="./js/jquery-3.6.0.min.js"></script>
  <script src="./js/script.js" defer></script>
</head>

<body>
  <header>
    <div class="header-inner">
      <div class="header-title">クラフト管理者画面</div>
      <nav class="header-nav">
        <ul class="header-nav-list">
          <a href="./index.php">
            <li class="header-nav-item">エージェント一覧</li>
          </a>
          <a href="./agentAdd.php">
            <li class="header-nav-item">エージェント追加</li>
          </a>
          <a href="./tagsEdit.php">
            <li class="header-nav-item">タグ一覧</li>
          </a>
          <a href="./loginEdit.php">
            <li class="header-nav-item select">管理者ログイン情報</li>
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
          </td>
          </td>
          <td>
            <!-- ここにパスワード -->
          </td>
        </tr>
      </table>
    </div>
    <button><a href="tagsUpdate.php">編集する</a></button>
  </main>
</body>

</html>