
<?php 
require('db_connect.php');
try {
  $stmt = $db->prepare('select * from agents where list_status=?');
  $stmt->execute([1]);
  $listed_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo '接続失敗';
  $e->getMessage();
  exit();
};
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>CRAFT</title>
    <script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
</head>
<body>
    <!-- ヘッダー -->
    <header>
        <img src="logo.png" alt="">
        <nav>
            <ul>
                <li><a href="">就活サイト</a></li>
                <li><a href="">就活支援サービス</a></li>
                <li><a href="">自己分析診断ツール</a></li>
                <li><a href="">ES添削サービス</a></li>
                <li><a href="">就活エージェント</a></li>
                <li><a href="">就活の教科書とは</a></li>
                <li><a href="">お問い合わせ</a></li>
            </ul>
        </nav>
    </header>

    <!-- 問い合わせフォーム -->
    <wrapper>

    </wrapper>


    <footer></footer>

    <script src="main.js"></script>
</body>
</html>