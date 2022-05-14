<?php
require('../db_connect.php');
try {
  $stmt = $db->prepare('select * from agents where list_status=?');
  $stmt->execute([1]);
  $listed_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->execute([2]);
  $non_listed_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo '接続失敗';
  $e->getMessage();
  exit();
};

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
    <section class="agent-list">
      <table>
        <!-- 掲載企業、停止企業の条件つける -->
        <tr>
          <th>エージェント名</th>
          <th>契約期間</th>
          <th colspan="3">操作</th>
        </tr>
        <?php foreach ($listed_agents as $listed_agent) :
        ?>
          <tr>
            <td><?php echo $listed_agent['corporate_name'] ?></td>
            <td><?php echo $listed_agent['started_at'] ?> ~ <?php echo $listed_agent['ended_at'] ?></td>
            <td><a href="detail.php?id=<?php echo $listed_agent['id']; ?>">詳細</a></td>
            <td><a href="contact.php?id=<?php echo $listed_agent['id']; ?>">問い合わせ一覧</a></td>
            <td><a href="stop.php?id=<?php echo $listed_agent['id']; ?>"  onclick="return confirm('本当に掲載停止しますか? 掲載停止しても詳細情報は保持されます。')">掲載停止</a></td>
          <?php endforeach; ?>
          </tr>

      </table>
    </section>
    <section class="agent-not-listed">
      <div id="js-open" onclick="js-open">掲載停止中の企業▼</div>
      <table>
        <?php foreach ($non_listed_agents as $non_listed_agent) :
        ?>
          <tr>
            <td><?php echo $non_listed_agent['corporate_name'] ?></td>
            <td><?php echo $non_listed_agent['started_at'] ?> ~ <?php echo $non_listed_agent['ended_at'] ?></td>
            <td><a href="detail.php?id=<?php echo $non_listed_agent['id']; ?>">詳細</a></td>
            <td><a href="contact.php?id=<?php echo $non_listed_agent['id']; ?> " >問い合わせ一覧</a></td>
            <td><a href="restart.php?id=<?php echo $non_listed_agent['id']; ?>" onclick="return confirm('本当に掲載再開しますか?')">再開</a></td>
            <td><a href="delete.php?id=<?php echo $non_listed_agent['id']; ?>" onclick="return confirm('本当に削除しますか? 一度削除すると復元できません。')">削除</a></td>
          <?php endforeach; ?>
      </table>
    </section>
  </main>
</body>

</html>