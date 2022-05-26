<?php
require('../db_connect.php');
session_start();

//ログインされていない場合は強制的にログインページにリダイレクト
if (!isset($_SESSION["login"])) {
  header("Location: ./login/login.php");
  exit();
}

// try {一時
// 全てのエージェントの掲載ステータスをupdateする。
date_default_timezone_set('Asia/Tokyo');
$today = date("Y-m-d");
// 掲載再開
$stmt = $db->prepare('update agents set list_status=1 where started_at <= :started_at and ended_at >= :ended_at');
$stmt->bindValue(':started_at', $today, PDO::PARAM_STR);
$stmt->bindValue(':ended_at', $today, PDO::PARAM_STR);
$success = $stmt->execute();
if (!$success) {
  die($db->error);
}

// 申し込み上限数到達(今月の申し込み数と比較)
// 全てのエージェントでforeach
// 全てのエージェント
$stmt = $db->query('select id from agents');
$stmt->execute();
$agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 今月の申し込み数
foreach($agents as $agent){
$stmt = $db->prepare('SELECT *
  FROM
  students AS S, students_contacts AS SC, agents AS A
  WHERE 
  S.id = SC.student_id
  AND
  SC.agent_id = A.id
  AND
  SC.agent_id = :agent_id
  AND
  DATE_FORMAT(S.created, "%Y-%m") = :form_month
  ');
$stmt->bindValue(':form_month', Date('Y-m'), PDO::PARAM_STR);
$stmt->bindValue(':agent_id', $agent['id'], PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$cnt = count($result);
// 比較
$stmt = $db->prepare('update agents set list_status=3 where id= :id and application_max <= :application');
$stmt->bindValue(':id', $agent['id'], PDO::PARAM_INT);
$stmt->bindValue(':application', $cnt, PDO::PARAM_INT);
$success = $stmt->execute();
if (!$success) {
  die($db->error);
}
}

// 掲載期間外
$stmt = $db->prepare('update agents set list_status=2 where started_at > :started_at or ended_at < :ended_at');
$stmt->bindValue(':started_at', $today, PDO::PARAM_STR);
$stmt->bindValue(':ended_at', $today, PDO::PARAM_STR);
$stmt->execute();
$success = $stmt->execute();
if (!$success) {
  die($db->error);
}


// 掲載エージェント
$stmt = $db->prepare('select * from agents where list_status=? order by id desc');
$stmt->execute([1]);
$listed_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
// 非掲載エージェント
$stmt = $db->prepare('select * from agents where list_status !=? order by id desc');
$stmt->execute([1]);
$non_listed_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// タグ表示テスト

$stmt = $db->query('select agent_id, at.tag_id, tag_name from agents_tags at, filter_tags ft where at.tag_id = ft.tag_id');
$agents_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
$at_list = [];
foreach ($agents_tags as $a) {
  $at_list[(int)$a['agent_id']][] = $a;
}

// var_dump($at_list);
// $at_listの中身はこんな感じ 
//[1]=> { 
//   [0]=>  { 
//    ["agent_id"]=> int(1) 
//    ["tag_id"]=> int(1) 
//    ["tag_name"]=> string(9) "特化型" 
// }
//    [1]=>  { 
//    ["agent_id"]=> int(1)   
//    ["tag_id"]=> int(2)  
//    ["tag_name"]=> string(9) "総合型" 
// } 
// } 
//[2]=>  { 
//   [0]=>  { 
// ["agent_id"]=> int(2) 
// ["tag_id"]=> int(1) 
// ["tag_name"]=> string(9) "特化型" } 
//} 
//[16]=>  { 
// [0]=>  { 
// ["agent_id"]=> int(16) 
// ["tag_id"]=> int(4) 
// ["tag_name"]=> string(6) "小型" } 
// } 
// [3]=> { 
// [0]=>  {
//  ["agent_id"]=> int(3) 
// ["tag_id"]=> int(4) 
// ["tag_name"]=> string(6) "小型" 
// } 
// } 
// }


// ここまで



// } catch (PDOException $e) {一時
//   echo '接続失敗';
//   $e->getMessage();
//   exit();
// };
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
      <h1 class="header-title">CRAFT管理者画面</h1>
      <nav class="header-nav">
        <ul class="header-nav-list">
          <a href="./index.php">
            <li class="header-nav-item select">エージェント一覧</li>
          </a>
          <a href="./add/agentAdd.php">
            <li class="header-nav-item">エージェント追加</li>
          </a>
          <a href="./tags/tagsEdit.php">
            <li class="header-nav-item">タグ一覧</li>
          </a>
          <a href="./contact/contact.php">
            <li class="header-nav-item">問い合わせ一覧</li>
          </a>
          <a href="./login/loginInfo.php">
            <li class="header-nav-item">ログイン情報</li>
          </a>
          <a href="./login/logout.php">
            <li class="header-nav-item">ログアウト</li>
          </a>
        </ul>
      </nav>
    </div>
  </header>
  <main class="main">
    <section class="agent-list">
      <h2 class="viewing_agent">掲載中の企業</h2>
      <table>
        <!-- 掲載企業、停止企業の条件つける -->
        <tr>
          <th>エージェント名</th>
          <th>掲載期間</th>
          <th colspan="2">操作</th>
          <th>登録タグ</th>
        </tr>
        <?php foreach ($listed_agents as $listed_agent) :
        ?>
          <tr>
            <td><?php echo $listed_agent['insert_company_name'] ?></td>
            <td><?php echo date("Y/m/d", strtotime($listed_agent['started_at'])) . '~' . date("Y/m/d", strtotime($listed_agent['ended_at'])) ?></td>
            <td><a href="detail.php?id=<?php echo $listed_agent['id']; ?>">詳細</a></td>
            <td><a href="contact/contact.php?id=<?php echo $listed_agent['id']; ?>">問い合わせ一覧</a></td>

            <!--  タグ表示テスト↓ -->
            <td>
              <?php foreach ($at_list as $agent_tags) : ?>
                <?php if ($listed_agent['id'] === current($agent_tags)['agent_id']) : ?>
                  <?php foreach ($agent_tags as $agent_tag) : ?>
                    <?= $agent_tag['tag_name']; ?>
                  <?php endforeach; ?></td>
          <?php endif; ?>
        <?php endforeach; ?>
        </td>
        <!-- タグ表示テスト ↑-->
      <?php endforeach; ?>
          </tr>
      </table>
    </section>
    <section class="agent-not-listed">
      <div class="viewing_agent">掲載停止中の企業</div>
      <table>
        <?php foreach ($non_listed_agents as $non_listed_agent) :
        ?>
          <tr>
            <td><?php echo $non_listed_agent['insert_company_name'] ?></td>
            <td><?php echo date("Y/m/d", strtotime($non_listed_agent['started_at'])) . '~' . date("Y/m/d", strtotime($non_listed_agent['ended_at'])) ?></td>
            <td><?php echo set_list_status($non_listed_agent['list_status']); ?></td>
            <td><a href="detail.php?id=<?php echo $non_listed_agent['id']; ?>">詳細</a></td>
            <td><a href="contact/contact.php?id=<?php echo $non_listed_agent['id']; ?> ">問い合わせ一覧</a></td>
            <td><a href="delete.php?id=<?php echo $non_listed_agent['id']; ?>" onclick="return confirm('本当に削除しますか? 一度削除すると復元できません。')">削除</a></td>
          <?php endforeach; ?>
      </table>
    </section>
  </main>
</body>

</html>