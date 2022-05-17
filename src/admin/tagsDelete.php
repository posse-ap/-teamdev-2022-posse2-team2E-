<?php
require('../db_connect.php');
// 絞り込みの種類
$stmt = $db->query('select * from filter_sorts;');
$filter_sorts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// タグ
$stmt = $db->query('select * from filter_tags;');
$filter_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 削除機能
// 絞り込みの種類
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if($_POST['filter_sorts'] != ''){
$stmt = $db->prepare('delete from filter_sorts where id = :id');
foreach($_POST['filter_sorts'] as $filter_sort):
$stmt->bindValue(':id', $filter_sort, PDO::PARAM_INT);
$stmt->execute();
endforeach;
}

// タグ
if($_POST['filter_tags'] != ''){
$stmt = $db->prepare('delete from filter_tags where tag_id = :tag_id');
foreach($_POST['filter_tags'] as $filter_tag):
$stmt->bindValue(':tag_id', $filter_tag, PDO::PARAM_INT);
$stmt->execute();
endforeach;
}

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
        </ul>
      </nav>
    </div>
  </header>
  <p>
  <main class="main">
    <div class="agent-add-table">
    <form action="" method="post" enctype="multipart/form-data">
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
              <label class="filter-sort">
                <input type="checkbox" name="filter_sorts[]" value="<?= $filter_sort['id']; ?>" />
                <span><?= $filter_sort['sort_name']; ?></span></label>
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
              <label class="filter-tag">
                <input type="checkbox" name="filter_tags[]" value="<?= $filter_tag['tag_id']; ?>" />
                <span><?= $filter_tag['tag_name']; ?></span></label>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    
    <div><input type="submit" value="削除する" /></div>
    </form>
    </div>
  </main>
</body>

</html>