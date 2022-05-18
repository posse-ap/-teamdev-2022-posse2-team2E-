<?php
session_start();
require('../db_connect.php');
if (isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])) {
  $form = $_SESSION['form'];
} else {
  $form = [ //エラーで使うものだけで良いかも
    'corporate_name' => '',
    'started_at' => '',
    'ended_at' => '',
    'class_of' => '',
    'login_pass' => '',
    'to_send_email' => '',
    'client_name' => '',
    'client_department' => '',
    'client_email' => '',
    'client_tel' => '',
    'insert_company_name' => '',
    // 'insert_logo' => '',写真は別で
    'insert_recommend_1' => '',
    'insert_recommend_2' => '',
    'insert_recommend_3' => '',
    'insert_handled_number' => '',
    'list_status' => '',
    'insert_detail' => '',
    'agent_tags' => [],
  ];
}

//タグ情報
$stmt = $db->query('select fs.id, sort_name, tag_id, tag_name from filter_sorts fs inner join filter_tags ft on fs.id = ft.sort_id;
');
$filter_sorts_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
$t_list = [];
foreach ($filter_sorts_tags as $f) {
  $t_list[(int)$f['id']][] = $f;
}

$error = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $args = array(
    'corporate_name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'started_at' => FILTER_SANITIZE_NUMBER_INT,
    'ended_at' => FILTER_SANITIZE_NUMBER_INT,
    'login_email' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'login_pass' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'to_send_email' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'client_name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'client_department' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'client_email' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'client_tel' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'insert_company_name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    // 'insert_logo' => '',写真は別で
    'insert_recommend_1' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'insert_recommend_2' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'insert_recommend_3' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'insert_handled_number' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'insert_detail' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'list_status' => FILTER_SANITIZE_NUMBER_INT,
    'agent_tags' => array(
      'filter' => FILTER_SANITIZE_NUMBER_INT,
      'flags'     => FILTER_REQUIRE_ARRAY,
    ),
  ); // タグは配列

  $form = filter_input_array(INPUT_POST, $args);

  // エラー判定
  if ($form['insert_company_name'] === '') {
    $error['insert_company_name'] = 'blank';
  }
  if (!$form['list_status']) {
    $error['list_status'] = 'blank';
  }
  if ($form['started_at'] === '') {
    $error['started_at'] = 'blank';
  }
  if ($form['ended_at'] === '') {
    $error['ended_at'] = 'blank';
  }

  // login_emailの重複チェック
  if ($form['login_email'] != '') {
    $stmt = $db->prepare('select count(*) from agents where login_email=:login_email');
    if (!$stmt) {
        die($db->error);
    }
    $stmt->bindValue('login_email', $form['login_email'], PDO::PARAM_STR);
    $success = $stmt->execute();
    $cnt = (int)$stmt->fetchColumn();
    if ($cnt > 0) {
        $error['login_email'] = 'duplicate';
    }
}

  // 画像のチェック
  $insert_logo = $_FILES['insert_logo'];
  if ($insert_logo['name'] !== '' && $insert_logo['error'] === 0) {
    $type = mime_content_type($insert_logo['tmp_name']);
    if ($type !== 'image/png' && $type !== 'image/jpeg') {
      $error['insert_logo'] = 'type';
    }
  }

  // エラーがなければ送信
  if (empty($error)) {
    $_SESSION['form'] = $form;

    if ($insert_logo['name'] !== '') {
      //画像のアップロード
      $filename = date('YmdHis') . '_' . $insert_logo['name'];
      if (!move_uploaded_file($insert_logo['tmp_name'], '../img/insert_logo/' . $filename)) {
        die('ファイルのアップロードに失敗しました');
      }
      $_SESSION['form']['insert_logo'] = $filename;
    } else {
      $_SESSION['form']['insert_logo'] = '';
    }

    header('location: check.php');
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
            <li class="header-nav-item select">エージェント追加</li>
          </a>
          <a href="./tagsEdit.php">
            <li class="header-nav-item">タグ一覧</li>
          </a>
          <a href="./loginEdit.php">
            <li class="header-nav-item">管理者ログイン情報</li>
          </a>
        </ul>
      </nav>
    </div>
  </header>
  <main class="main">
    <h1 class="main-title">エージェント追加画面</h1>
    <div class="agent-add-table">
      <form action="" method="post" enctype="multipart/form-data">
        <table class="main-info-table">
          <tr>
            <th>法人名</th>
            <td><input type="text" name="corporate_name" value="<?php echo h($form["corporate_name"]); ?>" /></td>
          </tr>
          <tr>
            <th>掲載状態<span class="required">必須</span></th>
            <td>
              <label class="list-status">
                <input type="radio" name="list_status" value=1 <?php if ($form['list_status'] === "1") : ?>checked<?php endif; ?> /><span>掲載する</span>
              </label>
              <label class="list_status">
                <input type="radio" name="list_status" value=2 <?php if ($form['list_status'] === "2") : ?>checked<?php endif; ?> /><span>まだ掲載しない</span><?php if (isset($error['list_status']) && $error['list_status'] === 'blank') : ?>
                  <p class="error">* 掲載状態を選択してください</p>
                <?php endif; ?>
              </label>
            </td>
          </tr>

          <tr>
            <th>掲載期間<span class="required">必須</span></th>
            <td>
              <input type="date" name="started_at" value="<?php echo h($form["started_at"]); ?>" /> ～
              <input type="date" name="ended_at" value="<?php echo h($form["ended_at"]); ?>" <?php if ((isset($error['started_at']) && $error['started_at'] === 'blank') || isset($error['ended_at']) && $error['ended_at'] === 'blank') : ?> />
              <p class="error">* 掲載期間を入力</p>
            <?php endif; ?>
            </td>
          </tr>

          <tr class="login-info">
            <th>ログイン情報</th>
            <td>
              email:<input type="email" name="login_email" value="<?php echo h($form["login_email"]); ?>" />　　　pass:<input type="password" name="login_pass" value="<?php echo h($form["login_pass"]); ?>" />
              <?php if (isset($error['login_email']) && $error['login_email'] === 'duplicate') : ?>
                <p class="error">* 指定されたメールアドレスはすでに登録されています</p><?php endif; ?>
            </td>
          </tr>

          <tr>
            <th>学生情報送信先</th>
            <td><input type="email" name="to_send_email" value="<?php echo h($form["to_send_email"]); ?>" />
          </tr>
        </table>
        <table class="contact-info-table">
          <tr>
            <th>担当者情報</th>
          </tr>
          <tr>
            <td class="sub-th">氏名</td>
            <td><input type="text" name="client_name" value="<?php echo h($form["client_name"]); ?>" /></td>
          </tr>
          <tr>
            <td class="sub-th">部署名</td>
            <td><input type="text" name="client_department" value="<?php echo h($form["client_department"]); ?>" /></td>
          </tr>
          <tr class="contact-number">
            <td class="sub-th">連絡先</td>
            <td>
              email:<input type="email" name="client_email" value="<?php echo h($form["client_email"]); ?>" />　　　tel:<input type="tel" name="client_tel" value="<?php echo h($form["client_tel"]); ?>" />
            </td>
          </tr>
        </table>
        <table class="post-info-table">
          <tr>
            <th>掲載情報</th>
          </tr>
          <tr>
            <td class="sub-th">掲載企業名<span class="required">必須</span></td>
            <td>
              <input type="text" name="insert_company_name" value="<?php echo h($form["insert_company_name"]); ?>" /><?php if (isset($error['insert_company_name']) && $error['insert_company_name'] === 'blank') : ?>
                <p class="error">* 掲載する企業名を入力してください</p>
              <?php endif; ?>
            </td>
          </tr>
          <tr>
            <td class="sub-th">企業ロゴ</td>
            <td><input type="file" name="insert_logo" />
              <?php if (isset($error['insert_logo']) && $error['insert_logo'] === 'type') : ?>
                <p class="error">* 写真などは「.png」または「.jpg」の画像を指定してください</p>
              <?php endif; ?>
            </td>
          </tr>
          <tr>
            <td class="sub-th">オススメポイント</td>
            <td>
              <input type="text" name="insert_recommend_1" placeholder="100文字以内で入力してください" value="<?php echo h($form["insert_recommend_1"]); ?>" /><input type="text" name="insert_recommend_2" value="<?php echo h($form["insert_recommend_2"]); ?>" /><input type="text" name="insert_recommend_3" value="<?php echo h($form["insert_recommend_3"]); ?>" />
            </td>
          </tr>
          <tr>
            <td class="sub-th">取扱い企業数</td>
            <td><input type="text" name="insert_handled_number" value="<?php echo h($form["insert_handled_number"]); ?>" /></td>
          </tr>
          <tr>
            <td class="sub-th">詳細欄</td>
            <!-- textareaの文字数制限解除する↓ -->
            <td> <textarea name="insert_detail" id="" cols="30" rows="10"><?php echo h($form["insert_detail"]); ?></textarea></td>
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
                    <input type="checkbox" name="agent_tags[]" value="<?= $filter_tag['tag_id'] ?>" <?php if ($form['agent_tags']) : foreach ($form['agent_tags'] as $agent_tag) : if (h($filter_tag['tag_id']) === $agent_tag) : ?>checked <?php endif;
                                                                                                                                                                                                                                      endforeach;
                                                                                                                                                                                                                                    endif; ?> />
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