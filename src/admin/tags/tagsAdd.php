<?php
require('../../db_connect.php');
// 絞り込みの種類情報
$stmt = $db->query('select * from filter_sorts;');
$filter_sorts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->query('select * from filter_tags;');
$filter_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 絞り込みの種類追加
$stmt = $db->prepare('insert into filter_tags (sort_id, tag_name) VALUES (:sort_id, :tag_name)');
$stmt->bindValue(':sort_id', $_POST['sort_id'], PDO::PARAM_STR);
$stmt->bindValue(':tag_name', $_POST['tag_name'], PDO::PARAM_STR);
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
  <p>
  <main class="main">
  <form action="" method="post" enctype="multipart/form-data">
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
            <input type="number" name="sort_id" value="" required/>
          </td>
          <td>
            <input type="text" name="tag_name" value="" required/>
          </td>
        </tr>
      </table>
      <input type="submit" value="追加する" />
    </div>
    </form>

  </main>
</body>

</html>