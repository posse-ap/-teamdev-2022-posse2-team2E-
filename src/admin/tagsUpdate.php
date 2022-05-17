<?php
require('../db_connect.php');
// 絞り込みの種類情報
$stmt = $db->query('select * from filter_sorts;');
$filter_sorts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->query('select * from filter_tags;');
$filter_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

$form = [ //英数字が入力されているか、判定
  'selected_sorts_id' => [],
];
$error = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $args = array(
    'sorts_name' => array(
      'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
      'flags'     => FILTER_REQUIRE_ARRAY,
    ),
    'tags_name' => array(
      'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
      'flags'     => FILTER_REQUIRE_ARRAY,
    ),
  );

  $form = filter_input_array(INPUT_POST, $args);
  // echo "<pre>";
  // var_dump($form);
  // echo "</pre>";
  // formの中身
  // ["sorts_name"]=>
  // array(3) {
  //   [1]=>
  //   array(2) {
  //     ["id"]=>
  //     string(1) "1"
  //     ["name"]=>
  //     string(9) "テスト"
  //   }
  //   [3]=>
  //   array(2) {
  //     ["id"]=>
  //     string(1) "3"
  //     ["name"]=>
  //     string(45) "もう一個志望会社の規模（復元）"
  //   }
  //   [4]=>
  //   array(2) {
  //     ["id"]=>
  //     string(1) "4"
  //     ["name"]=>
  //     string(15) "テストだよ"
  //   }
  // }



// エラー判定
// foreach ($form['selected_sorts_id'] as $selected_sort_id) :
//   if ($selected_sort_id === '') {
//     $error['selected_sorts_id'][] = 'blank';
//   }
// endforeach;

// エラーがなければ送信
if (empty($error)) {

  // update構文記入
  // 絞り込みの種類

  $stmt = $db->prepare('update filter_sorts set sort_name=:sort_name where id=:id');
  foreach ($form['sorts_name'] as $sort_name) :
    $stmt->bindValue('sort_name', $sort_name['name'], PDO::PARAM_STR);
    $stmt->bindValue('id', $sort_name['id'], PDO::PARAM_INT);
    if (!$stmt) {
      die($db->error);
    }
    $success = $stmt->execute();
    if (!$success) {
      die($db->error);
    }
  endforeach;

  header('location: tagEditThanks.php');
  exit();
}
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
                <input type="hidden" name="sorts_name[<?= $filter_sort['id'] ; ?>][id]" value="<?= $filter_sort['id']; ?>" />
              </td>
              <td>
                <span>
                  <input type="text" name="sorts_name[<?= $filter_sort['id'] ; ?>][name]" value="<?= $filter_sort['sort_name']; ?>" />
                </span>
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
                <input type="text" name="selected_sorts_id[<?php echo $filter_tag['sort_id'] ?>][id]" value="<?php echo $filter_tag['sort_id'] ?>" />
                <p class="error">* 半角英数字で入力してください</p>
              </td>
              <td>
                <input type="text" name="tag_names[<?php echo $filter_tag['sort_id'] ?>][name]" value="<?= $filter_tag['tag_name']; ?>" />
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
        <p>※入力した番号にあう絞り込みの種類がなければ、ユーザー画面に表示されません。</p>

        <input type="submit" value="編集を完了する" />
      </div>
    </form>
  </main>
</body>

</html>