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
          <a href="./agentList.php">
            <li class="header-nav-item">エージェント一覧</li>
          </a>
          <a href="./agentAdd.php">
            <li class="header-nav-item">エージェント追加</li>
          </a>
          <a href="./tagsEdit.php">
            <li class="header-nav-item select">タグ一覧</li>
          </a>
          <a href="./loginEdit.php">
            <li class="header-nav-item">管理者ログイン情報</li>
          </a>
        </ul>
      </nav>
    </div>
  </header>
  <main class="main">
      <div class="agent-add-table">
        <table class="tags-add">
          <tr>
            <td class="sub-th">絞り込みの種類</td>
            <td class="sub-th">タグ</td>
          </tr>
          <?php foreach ($t_list as $filter_sort) : ?>
            <tr>
              <td><?= current($filter_sort)['sort_name']; ?></td>
              <td>
                <?php foreach ($filter_sort as $filter_tag) : ?>
                  <label class="added-tag">
                    <span><?= $filter_tag['tag_name']; ?></span> </label>
                <?php endforeach; ?>

              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
      <button><a href="tagsUpdate.php">編集</a></button>
      <button><a href="sortsAdd.php">絞り込みの種類追加</a></button>
      <button><a href="tagsAdd.php">タグ追加</a></button>
      <button><a href="tagsDelete.php">選択して削除</a></button>
  </main>
</body>

</html>