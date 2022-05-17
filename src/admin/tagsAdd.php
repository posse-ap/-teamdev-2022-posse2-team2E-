<?php
require('../db_connect.php');
// 絞り込みの種類情報
$stmt = $db->query('select * from filter_sorts;');
$filter_sorts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->query('select * from filter_tags;');
$filter_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <li class="header-nav-item select">エージェント追加</li>
          </a>
          <a href="./tagsEdit.php">
            <li class="header-nav-item ">タグ一覧</li>
          </a>
        </ul>
      </nav>
    </div>
  </header>
  <p>
  <main class="main">
    <div class="agent-add-table">

      <table class="tags-add">
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
      </table>
      <table class="tags-add">
        <tr>
          <th>タグ</th>
        </tr>
        <tr>
          <td class="sub-th">絞り込みの種類の番号</td>
          <td class="sub-th">名前</td>
        </tr>
        <?php foreach ($filter_tags as $filter_tag) : ?>
          <tr>
            <td>
              <?php echo $filter_tag['sort_id'] ?>
            </td>
            <td>
              <?= $filter_tag['tag_name']; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td>
          <input type="text" name="tag_name" value="" />※絞り込みの種類の番号を英数字で入力してください。
          </td>
          <td>
            <input type="text" name="tag_name" value="" />
          </td>
        </tr>
      </table>
    </div>
    <input type="submit" value="タグを追加する" />
  </main>
</body>

</html>