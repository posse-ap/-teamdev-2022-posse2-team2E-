<?php
if( ! function_exists('h') ) {
  function h($s) {
    echo htmlspecialchars($s, ENT_QUOTES, "UTF-8");
  }
}

$dsn = 'mysql:host=db;dbname=shukatsu;charset=utf8mb4;';
$user = 'posse_user';
$password = 'password';

try {
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo '接続失敗: ' . $e->getMessage();
  exit();
}
?>