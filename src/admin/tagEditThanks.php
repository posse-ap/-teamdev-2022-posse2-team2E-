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
            <li class="header-nav-item ">エージェント一覧</li>
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
<body>
<div id="head">
<h1>エージェント編集</h1>
</div>

<div id="content">
<p>編集が完了しました。</p>
<p><a href="tagsEdit.php">タグ一覧画面で確認する</a></p>
<p>絞り込みの種類、タグ両方が設定されていなければユーザー画面には反映されません。片方しかなものは、編集画面で確認できます</p>
</div>

</div>
</body>
</html>