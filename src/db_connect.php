<?php
// if( ! function_exists('h') ) {
//   function h($s) {
//     echo htmlspecialchars($s, ENT_QUOTES, "UTF-8");
//   }
// }

function h($value) {
	return htmlspecialchars($value, ENT_QUOTES);
}
function set_list_status($list_status)
{
  if ($list_status === 1) {
    return '掲載';
  } elseif ($list_status === 2) {
    return '掲載期間外';
  } elseif ($list_status === 3) {
    return '申込上限到達';
  } else {
    return 'エラー';
  }
}

$dsn = 'mysql:host=db;dbname=shukatsu;charset=utf8mb4;';
$user = 'posse_user';
$password = 'password';


try {
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//追加した！
} catch (PDOException $e) {
  echo '接続失敗: ' . $e->getMessage();
  exit();
}
// try {
//   $db = new PDO($dsn, $user, $password);
//   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//   echo '接続失敗: ' . $e->getMessage();
//   exit();
// }

?>