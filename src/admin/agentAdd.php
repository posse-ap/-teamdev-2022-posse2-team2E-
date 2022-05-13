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
          <a href="#">
            <li class="header-nav-item select">エージェント追加</li>
          </a>
          <a href="#">
            <li class="header-nav-item">タグ追加</li>
          </a>
        </ul>
      </nav>
    </div>
  </header>
  <main class="main">
    <h1 class="main-title">エージェント追加画面</h1>
    <div class="agent-add-table">
      <form action="agentAdd.php" method="post" enctype="multipart/form-data">
        <table class="main-info-table">
          <tr>
            <th>法人名</th>
            <td><input type="text" name="corporate_name" value="<?php echo h($form["corporate_name"]); ?>"/></td>
          </tr>
          <tr>
            <th>掲載状態</th>
            <td><label class="list-status">
                <input type="radio" name="list-status" value="1" /><span>掲載する</span>
              </label>
              <label class="list-status">
                <input type="radio" name="list-status" value="2" /><span>まだ掲載しない</span>
              </label>
            </td>
          </tr>

          <tr>
            <th>掲載期間</th>
            <td>
              <input type="date" name="started_at" /> ～
              <input type="date" name="ended_at" />
            </td>
          </tr>

          <tr class="login-info">
            <th>ログイン情報</th>
            <td>
              email:<input type="email" name="login_email" />　　　pass:<input type="password" name="login_pass" />
            </td>
          </tr>

          <tr>
            <th>学生情報送信先</th>
            <td><input type="email" name="to_send_email">
          </tr>
        </table>
        <table class="contact-info-talbe">
          <tr>
            <th>担当者情報</th>
          </tr>
          <tr>
            <td class="sub-th">氏名</td>
            <td><input type="text" name="client_name" /></td>
          </tr>
          <tr>
            <td class="sub-th">部署名</td>
            <td><input type="text" name="client_department" /></td>
          </tr>
          <tr class="contact-number">
            <td class="sub-th">連絡先</td>
            <td>
              email:<input type="email" name="client_email" />　　　tel:<input type="tel" name="client_tel" />
            </td>
          </tr>
        </table>
        <table class="post-info-talbe">
          <tr>
            <th>掲載情報</th>
          </tr>
          <tr>
            <td class="sub-th">掲載企業名</td>
            <td><input type="text" name="insert_company_name" /></td>
          </tr>
          <tr>
            <td class="sub-th">企業ロゴ</td>
            <td><input type="file" name="insert_logo" /></td>
          </tr>
          <tr>
            <td class="sub-th">オススメポイント</td>
            <td>
              <input type="text" name="insert_recommend_1" placeholder="100文字以内で入力してください"/><input type="text" name="insert_recommend_2" /><input type="text" name="insert_recommend_3" />
            </td>
          </tr>
          <tr>
            <td class="sub-th">取扱い企業数</td>
            <td><input type="text" name="insert_handled_number" /></td>
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
                  <input type="checkbox" name="filter_tag" value="<?= $filter_tag['tag_id']?>"/>
                  <span><?= $filter_tag['tag_name']; ?></span> </label>
              <?php endforeach; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>

        <div><input type="submit" value="入力内容を確認する" /></div>
      </form>
    </div>
  </main>
</body>

</html>