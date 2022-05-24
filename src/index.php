
<?php 
require('db_connect.php');

$to = 'user@gmail.com';
$subject = '本登録をお願いします。';
$message = 'URLから本登録をお願いします。';
$from = 'test@gmail.com';
$header = "From: ".$from."\r\n";
mb_language('Japanese');
mb_internal_encoding("UTF-8");
$result = mb_send_mail($to,$subject,$message,$header);
var_dump($result);
exit;


try {
  $stmt = $db->prepare('select * from agents where list_status=?');
  $stmt->execute([1]);
  $listed_agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo '接続失敗';
  $e->getMessage();
  exit();
};


//タグ情報
$stmt = $db->query('select fs.id, sort_name, tag_id, tag_name from filter_sorts fs inner join filter_tags ft on fs.id = ft.sort_id;
');
$filter_sorts_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
$t_list = [];
foreach ($filter_sorts_tags as $f) {
  $t_list[(int)$f['id']][] = $f;
}


// タグ表示テスト　htmlの上に各部分
$stmt = $db->query('select agent_id, at.tag_id, tag_name from agents_tags at, filter_tags ft where at.tag_id = ft.tag_id');
$agents_tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
$at_list = [];
foreach ($agents_tags as $a) {
  $at_list[(int)$a['agent_id']][] = $a;
}

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

    <wrapper>
        <div class="first_message fade-in-bottom">
            <h1>CRAFT</h1>
            <h2>失敗しないエージェント選びを</h2>
            <p>就活ドットコムだからこそできる、フラットな視点から比較、一括問い合わせまで</p>
        </div>

        <div class="process">
            <p class="slide_in_1">絞り込む</p>
            <div class="arrow slide_in_2"></div>
            <p class="slide_in_3">比較する</p>
            <div class="arrow slide_in_4"></div>
            <p class="slide_in_5">キープする</p>
            <div class="arrow slide_in_6"></div>
            <p class="slide_in_7">問い合わせる</p>
        </div>
        
        <div class="q_and_a">
            <p>Q.いくつのエージェントを問い合わせればいいの？</p>
            <br>
            <p>A. <span class="multiples">複数</span>のエージェントに問い合わせることをおすすめします。</p>
            <p>理由としては、以下のようなものが挙げられます。</p>
            <br>
            <br>
            <div class="reason">
            <p>・<span>目的</span>に合わせてエージェントを使い分けられる</p>
            <p>・様々な<span>視点</span>からアドバイスをもらえる</p>
            <p>・応募できる<span>求人の幅</span>を広げることができる</p>
            </div>
        </div>
        <img src="agent_person.png" alt="" class="agent_person">

            <container class="filter" id="js-filter">


                <ul class="filter-items" >
                    <!-- <a href=""><button class="all_keep">全てをキープ</button></a> -->
                    <form action="entry.php" method="post" id="inquiry_submit" >  
                    <?php foreach($listed_agents as $listed_agent): ?>
                    <li class="agent_box" data-filter-key="総合型" id="tohoku_<?php echo $listed_agent['id'] ?>">
                        <img class="agent_img" src="logo.png" alt="">
                        <div class="agent_article">
                            <div class="agent_article_header">
                                <h1 class="agent_name"><?php echo $listed_agent['insert_company_name'] ?></h1>
                                <p class="num_company">取扱企業数：<?php echo $listed_agent['insert_handled_number'] ?></p>        
                            </div>
                            <div class="agent_article_main">
                            
                            <div class="agent_type">
                                    <!--  タグ表示↓ -->
                                    <?php foreach ($at_list as $agent_tags) : ?>
                                        <?php if ($listed_agent['id'] === current($agent_tags)['agent_id']) : ?>
                                            <?php foreach ($agent_tags as $agent_tag) : ?>
                                            <p class="agent_tag">#<?= $agent_tag['tag_name']; ?></p>
                                            <?php endforeach; ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <!--  タグ表示↑ -->
                            </div>
                                <p class="recommend_points">特徴</p>
                                    <div class="recommend_points_box">
                                        <p><?php echo $listed_agent['insert_recommend_1'] ?></p>
                                    </div>
                                    <div class="recommend_points_box">
                                        <p><?php echo $listed_agent['insert_recommend_2'] ?></p>
                                    </div>
                                    <div class="recommend_points_box">
                                        <p><?php echo $listed_agent['insert_recommend_3'] ?></p>
                                    </div>
                                
                            </div>
                            <div class="agent_article_footer">
                            <p class="span_published">掲載期間：<?php echo date("Y/m/d",strtotime($listed_agent['started_at'])); ?>〜<?php echo date("Y/m/d",strtotime($listed_agent['ended_at'])); ?></p>
                                <!-- <div > -->
                                <label id="tohoku_<?php echo $listed_agent['id'] ?>">
                                    <input 
                                    id="keep_<?php echo $listed_agent['id'] ?>"
                                    class="bn632-hover bn19 "  onclick="check(<?php echo $listed_agent['id'] ?>)"
                                    type=checkbox name=student_contacts[] value="<?php echo $listed_agent['id']; ?>" ><span></span>
                                </label>
                                <!-- </div> -->
                            </div>
                        </div>       
                    </li>
                    
                    <?php endforeach; ?>
                </ul>
                </form>


                <div class="filter_left_wrapper">
                    <!-- 白色の擬似要素div -->
                    <!-- <div class="white_div"></div> -->
                    <div class="filter-cond" id="filter_side">
                        <!-- <div class="agents_type"> -->
                        <!-- 実際に表示されてるエージェント数をいれる -->
                            <p class="filter_num"><span>5</span>件</p> 

                                <?php foreach ($t_list as $filter_sort) : ?>
                                    <div class="filter_sort_name"><?= current($filter_sort)['sort_name']; ?></div>
                                        <?php foreach ($filter_sort as $filter_tag) : ?>
                                            <label class="added-tag">
                                                <input type="checkbox" name="agent_tags[]" value="<?= $filter_tag['tag_id'] ?>" class="checks" id="form" />
                                                <?= $filter_tag['tag_name']; ?> 
                                            </label>
                                        <?php endforeach; ?>
                                <?php endforeach; ?>
                    
                        <div class="filter_btn">
                        <div class="flex_btn">
                            <button class="reset_btn" id="uncheck-btn" type="reset" >リセット</button>
                            <button class="reset_btn to_filter_btn" id="uncheck-btn" type="reset" >絞りこむ</button>
                        </div>
                            <!-- <div class="all_btn" id="check-btn" type="button"></div> -->
                            <!-- <button class="trigger_keep_btn"><label for="trigger_keep">キープ：<span id="counter_dis" ><div class="tohokuret">0</div></span>件<br>確認する</label></button> -->
                            <button class="trigger_keep_btn"><label for="trigger_keep"><span id="counter_dis" ><div class="tohokuret">0</div></span>件キープ中<br>確認する</label></button>
                            <!-- <button ><label for="trigger_keep">キープ：<span id="counter_dis" ><div class="tohokuret">0</div></span>件<br>確認する</label></button> -->
                            <!-- <button class="bn632-hover bn19 open_button" ><label for="trigger_keep">キープ：<span id="counter_dis" ><div class="tohokuret">0</div></span>件<br>確認する</label></button> -->
                        </div>

                    </div>

                    <!-- <btn class="keep_btn" id="keep_btn"> -->
                        <!-- <div class="button05"> -->
                            <!-- <button  class="bn632-hover bn19 open_button" ><label for="trigger_keep">キープ：<span id="counter_dis" ><div class="tohokuret">0</div></span>件<br>確認する</label></button> -->

                        <!-- </div> -->
                    <!-- </btn> -->
                </div>

                

                <!-- キープ一覧のモーダル -->
                <div class="modal_keep">
                    <div class="modal_wrap">
                        <input id="trigger_keep" type="checkbox">
                        <div class="modal_overlay">
                            <label for="trigger_keep" class="modal_trigger"></label>
                            <div class="modal_content">
                                <label for="trigger_keep" class="close_button">✖️</label>

                        <!-- モーダルの中身 -->
                                <div class="modal_keep_header">
                                    <h1 class="keep_view">キープ一覧</h1>
                                    <btn class="keep_btn" >
                                                <div class="button05">
                                                    
                                                <button class="bn632-hover bn19 keep_inquiry_btn "  type="submit" form="inquiry_submit" value="問い合わせる" >
                                                    キープ：<span id="count_dis"><div class="tohokuret">0</div></span>件<br>問い合わせる
                                                    <!-- <button type="submit" form="inquiry_submit" value="問い合わせる">ああ</button> -->
                
                                                    <!-- <form action="/src/usercontact/entry.php"><input type="submit" form="inquiry_submit" value="問い合わせる"></form> -->
                                                </button>
                                                    
                                                </div>
                                    </btn>
                                </div>
                                <container class="filter keep_container" id="js-filter">
                                    <div class="modal-filter-items">
                                        <ul class="filter-items">
                                        <?php foreach($listed_agents as $listed_agent): ?>
                                            <li class="agent_box keep_agent_box" id="keep_agent_box_<?php echo $listed_agent['id'] ?>" data-filter-key="総合型">
                                                <img class="agent_img" src="logo.png" alt="">
                                                <div class="agent_article">
                                                    <div class="agent_article_header">   
                                                        <div class="agent_type">     
                                                            <!--  タグ表示↓ -->
                                                            <?php foreach ($at_list as $agent_tags) : ?>
                                                                <?php if ($listed_agent['id'] === current($agent_tags)['agent_id']) : ?>
                                                                    <?php foreach ($agent_tags as $agent_tag) : ?>
                                                                    <p class="agent_tag">#<?= $agent_tag['tag_name']; ?></p>
                                                                    <?php endforeach; ?></td>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                            <!--  タグ表示↑ -->
                                                        </div>
                                                        <p class="num_company">取扱企業数：<?php echo $listed_agent['insert_handled_number'] ?></p>
                                                    </div>
                                                    <div class="agent_article_main">
                                                    <h1 class="agent_name"><?php echo $listed_agent['insert_company_name'] ?></h1>
                                                        <p class="recommend_points">特徴</p>
                                                            <div class="recommend_points_box modal_recommend_points_box">
                                                                <p><?php echo $listed_agent['insert_recommend_1'] ?></p>
                                                            </div>
                                                            <div class="recommend_points_box modal_recommend_points_box">
                                                                <p><?php echo $listed_agent['insert_recommend_2'] ?></p>
                                                            </div>
                                                            <div class="recommend_points_box modal_recommend_points_box">
                                                                <p><?php echo $listed_agent['insert_recommend_3'] ?></p>
                                                            </div>
                                                    </div>
                                                    <div class="agent_article_footer modal_agent_article_footer">
                                                        <p class="span_published">掲載期間：<?php echo date("Y/m/d",strtotime($listed_agent['started_at'])); ?>〜<?php echo date("Y/m/d",strtotime($listed_agent['ended_at'])); ?></p>
                                                        <label onclick="buttonDelete(<?php echo $listed_agent['id'] ?>)" class="delete_btn">取り消す</label>
                                                        
                                                    </div>
                                                </div>
                                            
                                            </li>
                                            
                                            
                                        <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </container>
                        <!-- ここまでモーダルの中身 -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ここまでキープ一覧のモーダル -->
            </container>

    </wrapper>


    <footer></footer>

    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <script src="main.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    
</body>
</html>