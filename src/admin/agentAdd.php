<?php 
require('../db_connect.php');
// try{

// }catch(){

// }
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
            <a href="./agentList.php"
              ><li class="header-nav-item">エージェント一覧</li></a
            >
            <a href="#"
              ><li class="header-nav-item select">エージェント追加</li></a
            >
            <a href="#"><li class="header-nav-item">タグ追加</li></a>
          </ul>
        </nav>
      </div>
    </header>
    <main class="main">
      <h1 class="main-title">エージェント追加画面</h1>
      <div class="operations">
        <button>編集する</button>
        <button>ユーザー画面を確認</button>
      </div>
      <div class="agent-add-table">
        <table class="main-info-talbe">
          <tr>
            <th>法人名</th>
            <td><input type="text" name="法人名" /></td>
          </tr>

          <tr>
            <th>掲載期間</th>
            <td>
              <input type="date" name="掲載開始日時" /> ～
              <input type="date" name="掲載終了日時" />
            </td>
          </tr>

          <tr class="login-info">
            <th>ログイン情報</th>
            <td>
              email:<input
                type="email"
                name="ログイン用メールアドレス"
              />　　　pass:<input type="text" name="ログイン用パスワード" />
            </td>
          </tr>

          <tr>
            <th>学生情報送信先</th>
            <td><input type="email" name="学生情報送信先" /></td>
          </tr>
        </table>
        <table class="contact-info-talbe">
          <tr>
            <th>担当者情報</th>
          </tr>
          <tr>
            <td class="sub-th">氏名</td>
            <td><input type="text" name="担当者氏名" /></td>
          </tr>
          <tr>
            <td class="sub-th">部署名</td>
            <td><input type="text" name="担当者部署名" /></td>
          </tr>
          <tr class="contact-number">
            <td class="sub-th">連絡先</td>
            <td>
              email:<input
                type="email"
                name="担当者メールアドレス"
              />　　　tel:<input type="tel" name="担当者電話番号" />
            </td>
          </tr>
        </table>
        <table class="post-info-talbe">
          <tr>
            <th>掲載情報</th>
          </tr>
          <tr>
            <td class="sub-th">掲載企業名</td>
            <td><input type="text" name="掲載企業名" /></td>
          </tr>
          <tr>
            <td class="sub-th">企業ロゴ</td>
            <td><input type="file" name="企業ロゴ" /></td>
          </tr>
          <tr>
            <td class="sub-th">オススメポイント</td>
            <td>
              <input type="text" name="オススメポイント" /><input
                type="text"
                name="オススメポイント"
              /><input type="text" name="オススメポイント" />
            </td>
          </tr>
          <tr>
            <td class="sub-th">取扱い企業数</td>
            <td><input type="text" name="取扱い企業数" /></td>
          </tr>
        </table>
        <table class="tags-add">
          <tr>
            <td class="sub-th">絞り込みの種類</td>
            <td class="sub-th">タグ</td>
          </tr>
          <tr>
            <td>エージェントのタイプ</td>
            <td>
              <label class="added-tag">
                <input type="checkbox" name="" /><span>特化型</span>
              </label>
              <label class="added-tag">
                <input type="checkbox" name="" /><span>総合型</span>
              </label>
            </td>
          </tr>
          <tr>
            <td>志望会社の規模</td>
            <td>
              <label class="added-tag">
                <input type="checkbox" name="" /><span>大手志望</span>
              </label>
              <label class="added-tag">
                <input type="checkbox" name="" /><span>ベンチャー志望</span>
              </label>
            </td>
          </tr>
        </table>
      </div>
    </main>
  </body>
</html>
