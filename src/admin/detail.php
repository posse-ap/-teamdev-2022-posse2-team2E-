<?php
//タグのチェックが上手くいかない
use LDAP\Result;

require('../db_connect.php');
$id = $_GET['id'];

//タグ情報
// $stmt = $db->query('select * from filter_sorts, filter_tags where filter_tags.filter_sort_id=filter_sorts.id;');
// $filter_sorts_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $stmt = $db->prepare('select * from agents_tags where agent_id=:id');
// $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
// $stmt->execute();
// $agents_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($agents_tags);


// タグの取り出し filter_sortsをベースにしてfilter_tagsを結合するだけ
$stmt = $db->query("
  select
    fs.id, sort_name,
    filter_sort_id,
    tag_name 
  from
    filter_sorts fs
  inner join
    filter_tags ft on fs.id = ft.filter_sort_id;
");
$filter_sorts_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

$t_list = [];
// 絞り込みの種類毎に配列に突っ込む [idが1 => [], idが2 => []];
// $t_list[XX][] = AAA; のやっていることは キーがXXの中身にAAAを追加するって感じです
// var_dump($t_list[XX]); ｰ> [1,2]だとすると
// $t_list[XX][] = AAA; は var_dump($t_list[XX])の結果が[1,2,AAA]になります
foreach ($filter_sorts_tags as $f) {
  $t_list[(int)$f['id']][] = $f;
}

// $t_listの中身はこんな感じ
// [
//   [1] => [
//     [0] => [
//       ["id"]=> 1,
//       ["sort_name"]=> "エージェントのタイプ",
//       ["filter_sort_id"]=> 1,
//       ["tag_name"]=> "特化型",
//     ],
//     [1] => [
//       ["id"]=> 1,
//       ["sort_name"]=> "エージェントのタイプ",
//       ["filter_sort_id"]=> 1,
//       ["tag_name"]=> "総合型",
//     ],
//   ],
//   [2]=> [
//     [0] => [
//       ["id"]=> 2,
//       ["sort_name"]=> "志望会社",
//       ["filter_sort_id"]=> 2,
//       ["tag_name"]=> "大手志望",
//     ],
//     [1] => [
//       ["id"]=> 2,
//       ["sort_name"]=> "志望会社",
//       ["filter_sort_id"]=> 2,
//       ["tag_name"]=> "ベンチャー志望",
//     ],
//   ],
// ]



function set_list_status($list_status)
{
  if ($list_status === 1) {
    return '掲載中';
  } elseif ($list_status === 2) {
    return '掲載停止中';
  } else {
    return 'エラー';
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
            <li class="header-nav-item select">エージェント一覧</li>
          </a>
          <a href="./agentAdd.php">
            <li class="header-nav-item">エージェント追加</li>
          </a>
          <a href="#">
            <li class="header-nav-item">タグ追加</li>
          </a>
        </ul>
      </nav>
    </div>
  </header>
  <a href="./agentList.php">エージェント一覧へ戻る＞</a>
  <main class="main">
    <table class="tags-add">
      <tr>
        <td class="sub-th">絞り込みの種類</td>
        <td class="sub-th">タグ</td>
      </tr>
      <?php foreach ($t_list as $filter_sorts) : ?>
        <tr>
          <!-- 絞り込みの種類は必ず -->
          <!-- currentは配列の要素を1つ抽出してくるメソッド, filter_sort_tags[0]['sort_name'] と同じです -->
          <td><?= current($filter_sorts)['sort_name']; ?></td>
          <td>
            <label class="added-tag">
              <!-- オプションの分だけここのforeachを追加してあげればOK -->
              <?php foreach ($filter_sorts as $index => $filter_sort_tag) : ?>
                <input type="checkbox" name="" disabled <?php if ($filter_sort_tag[$id] === $agents_tags['tag_id']) : ?>checked <?php endif; ?> />
                <span><?= $filter_sort_tag['tag_name']; ?></span>
              <?php endforeach; ?>
            </label>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
    </div>
  </main>
</body>

</html>
