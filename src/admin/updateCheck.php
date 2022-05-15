<?php
session_start();
require('../db_connect.php');
?>
<?
if (isset($_SESSION['form'])) {
  $form = $_SESSION['form'];
  var_dump($form);
} else {
  header('location: agentList.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login_pass = password_hash($form['login_pass'], PASSWORD_DEFAULT);
  $stmt = $db->prepare('update agents set corporate_name = :corporate_name, started_at = :started_at, ended_at = :ended_at, login_email = :login_email, login_pass = :login_pass, to_send_email = :to_send_email, client_name = :client_name, client_department = :client_department, client_email = :client_email, client_tel = :client_tel, insert_company_name = :insert_company_name, insert_logo = :insert_logo, insert_recommend_1 = :insert_recommend_1, insert_recommend_2 = :insert_recommend_2, insert_recommend_3 = :insert_recommend_3, insert_handled_number = :insert_handled_number, insert_detail = :insert_detail, list_status = :list_status');
  $stmt->bindValue('corporate_name', $form['corporate_name'], PDO::PARAM_STR);
  $started_at = new DateTime( $form['started_at']);
  $stmt->bindValue('started_at', $started_at->format('Y-m-d'), PDO::PARAM_STR);
  $ended_at = new DateTime( $form['ended_at']);
  $stmt->bindValue('ended_at', $ended_at->format('Y-m-d'), PDO::PARAM_STR);
  $stmt->bindValue('login_email', $form['login_email'], PDO::PARAM_STR);
  $stmt->bindValue('login_pass', $login_pass, PDO::PARAM_STR);
  $stmt->bindValue('to_send_email', $form['to_send_email'], PDO::PARAM_STR);
  $stmt->bindValue('client_name', $form['client_name'], PDO::PARAM_STR);
  $stmt->bindValue('client_department', $form['client_department'], PDO::PARAM_STR);
  $stmt->bindValue('client_email', $form['client_email'], PDO::PARAM_STR);
  $stmt->bindValue('client_tel', $form['client_tel'], PDO::PARAM_STR);
  $stmt->bindValue('insert_company_name', $form['insert_company_name'], PDO::PARAM_STR);
  $stmt->bindValue('insert_logo', $form['insert_logo'], PDO::PARAM_STR);
  $stmt->bindValue('insert_recommend_1', $form['insert_recommend_1'], PDO::PARAM_STR);
  $stmt->bindValue('insert_recommend_2', $form['insert_recommend_2'], PDO::PARAM_STR);
  $stmt->bindValue('insert_recommend_3', $form['insert_recommend_3'], PDO::PARAM_STR);
  $stmt->bindValue('insert_handled_number', $form['insert_handled_number'], PDO::PARAM_STR);
  $stmt->bindValue('insert_detail', $form['insert_detail'], PDO::PARAM_STR);
  $stmt->bindValue('list_status', $form['list_status'], PDO::PARAM_INT);
  if (!$stmt) {
    die($db->error);
  }
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }

  // タグ未解決
  // $stmt = $db->prepare('insert into agents_tags (agent_id, tag_id) VALUES (LAST_INSERT_ID(), :tag_id)');
  // foreach($form['agent_tags'] as $agent_tag):
  // $stmt->bindValue('tag_id', $agent_tag, PDO::PARAM_STR);//いくつかあるから、配列？for文？
  // endforeach;

  // if (!$stmt) {
  //   die($db->error);
  // }
  // $success = $stmt->execute();
  // if (!$success) {
  //   die($db->error);
  // }

  unset($_SESSION['form']);
  header('location: updateThanks.php');
}

//タグ情報
$stmt = $db->query('select fs.id, sort_name, tag_id, tag_name from filter_sorts fs inner join filter_tags ft on fs.id = ft.sort_id;
');
$filter_sorts_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
$t_list = [];
foreach ($filter_sorts_tags as $f) {
  $t_list[(int)$f['id']][] = $f;
}

// エージェントタグ
$stmt = $db->prepare('select * from agents_tags where agent_id=:id');
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
$stmt->execute();
$agent_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
var_dump($agent_tags);
function set_list_status($list_status)
{
  if ($list_status === "1") {
    return '掲載';
  } elseif ($list_status === "2") {
    return '非掲載';
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
  <main class="main">
    <h1 class="main-title"><?php echo h($form['insert_company_name']); ?>詳細 (<?php echo set_list_status($form['list_status']); ?>)</h1>
    <div class="agent-add-table">
      <form action="" method="post" enctype="multipart/form-data">
        <table class="main-info-table">
          <tr>
            <th>法人名</th>
            <td><?php echo h($form['corporate_name']) ?></td>
          </tr>
          <tr>
            <th>掲載状態</th>
            <td><label class="list-status">
                <input type="radio" name="list-status" value="1" <?php if ($form['list_status'] === "1") : ?>checked <?php endif; ?> disabled /><span>掲載する</span>
              </label>
              <label class="list-status">
                <input type="radio" name="list-status" value="2" <?php if ($form['list_status'] === "2") : ?>checked <?php endif; ?> disabled /><span>まだ掲載しない</span>
              </label>
            </td>
          </tr>

          <tr>
            <th>掲載期間</th>
            <td>
              <?php echo h($form['started_at']) ?> ～
              <?php echo h($form['ended_at']) ?>
            </td>
          </tr>

          <tr class="login-info">
            <th>ログイン情報</th>
            <td>
              email:<?php echo h($form['login_email']) ?>　　　pass: 【表示されません】
            </td>
          </tr>

          <tr>
            <th>学生情報送信先</th>
            <td><?php echo h($form['to_send_email']) ?></td>
          </tr>
        </table>
        <table class="contact-info-table">
          <tr>
            <th>担当者情報</th>
          </tr>
          <tr>
            <td class="sub-th">氏名</td>
            <td><?php echo h($form['client_name']) ?></td>
          </tr>
          <tr>
            <td class="sub-th">部署名</td>
            <td><?php echo h($form['client_department']) ?></td>
          </tr>
          <tr class="contact-number">
            <td class="sub-th">連絡先</td>
            <td>
              email:<?php echo h($form['client_email']) ?>　　　tel:<?php echo h($form['client_tel']) ?>
            </td>
          </tr>
        </table>
        <table class="post-info-table">
          <tr>
            <th>掲載情報</th>
          </tr>
          <tr>
            <td class="sub-th">掲載企業名</td>
            <td><?php echo h($form['insert_company_name']) ?></td>
          </tr>
          <tr>
            <td class="sub-th">企業ロゴ</td>
            <td><img src="../img/insert_logo/<?php echo h($form['insert_logo']); ?>" width="300" alt="" /></td>
          </tr>
          <tr>
            <td class="sub-th">オススメポイント</td>
            <td>
              <ul>
                <li>・<?php echo h($form['insert_recommend_1']) ?></li>
                <li>・<?php echo h($form['insert_recommend_2']) ?></li>
                <li>・<?php echo h($form['insert_recommend_3']) ?></li>
              </ul>
            </td>
          </tr>
          <tr>
            <td class="sub-th">取扱い企業数</td>
            <td><?php echo h($form['insert_handled_number']) ?></td>
          </tr>
          <tr>
            <td class="sub-th">詳細欄</td>
            <td><?php echo h($form['insert_detail']) ?></td>
          </tr>
        </table>
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
                    <input type="checkbox" name="agent_tags[]" value="<?= $filter_tag['tag_id'] ?>" disabled <?php if($form['agent_tags']):foreach ($form['agent_tags'] as $agent_tag) : if (h($filter_tag['tag_id']) === $agent_tag) : ?>checked <?php endif;
                                                                                                                                                                              endforeach;endif;?> />
                    <span><?= $filter_tag['tag_name']; ?></span> </label>
                <?php endforeach; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
        <div><a href="agentAdd.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>
      </form>
    </div>
  </main>
</body>

</html>