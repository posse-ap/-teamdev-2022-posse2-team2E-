$(function () {
  $('.js-btn').on('click', function () {        // js-btnクラスをクリックすると、
    $('.menu , .btn-line').toggleClass('open'); // メニューとバーガーの線にopenクラスをつけ外しする
    $('.filter-cond').toggleClass('opa_it');
    $('.btn-line span').toggleClass('open'); // メニューとバーガーの線にopenクラスをつけ外しする
  })
});

$(function(){
var state = false;
var pos;
$('#menu-btn-check').click(function(){
    if (state == false) {
        pos = $(window).scrollTop();
        $('body').addClass('fixed').css({'top': -pos});
        state = true;
    } else {
        $('body').removeClass('fixed').css({'top': 0});
        window.scrollTo(0, pos);
        state = false;
    }
});
});

// スクロールしたらアニメーション
$(function(){
    $(window).scroll(function (){
        $('.process').each(function (){
            var elementTop = $(this).offset().top;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll > elementTop - windowHeight + 100) {
                $(this).addClass('scrollin');
            }
        });
    });
});

//全選択ボタンを取得する
const checkBtn = document.getElementById("check-btn");
//全解除ボタンを取得する
const uncheckBtn = document.getElementById("uncheck-btn");
//チェックボックスを取得する
const el = document.getElementsByClassName("checks");

$(function () {
    var btn = $('.btn');
    var btn2 = $('.trigger_keep_btn2');
    btn.hide();
    btn2.hide();
    $(window).scroll(function () {
        //1700pxスクロールしたらtopBtnをフェードイン表示させる 
        if ($(this).scrollTop() > 1600) {
            btn.fadeIn();
            btn2.fadeIn();
        } else {
            //もし上にスクロールして1700px未満になったらフェードアウトさせる 
            btn.fadeOut();
            btn2.fadeOut();
        }
    });
});


function check(id) {
    let keep_agent_box = document.getElementById("keep_agent_box_" + id);
    if (keep_agent_box.style.display = "none") {
        keep_agent_box.style.display = "flex";
    } else {
        keep_agent_box.style.display = "none";
    }
    // キープのcheckboxを全取得 (idは重複しない性質のため、class名等で取得したいですがnameが今回識別しやすそうだったのでnameで)
    const checkBoxElements = document.getElementsByName('student_contacts[]');
    // チェックした項目のみを数える
    let count = 0;
    checkBoxElements.forEach((element) => {
        // チェックされてたらカウント追加
        if (element.checked) {
            count++;
        }
    });
    $('div.tohokuret').text(count);

    if (count == 0) {
        $('.trigger_keep_btn').removeClass('btn_orange');
        $('.trigger_keep_btn').addClass('btn_gray');
        $('.trigger_keep_btn2').removeClass('btn_orange');
        $('.trigger_keep_btn2').addClass('btn_gray');
        $('.tohokuret').addClass('btn_gray');
        $('.tohokuret').removeClass('int_white');
        $('.keep_inquiry_btn').addClass('btn_gray');

    }
    else {
        $('.keep_inquiry_btn').removeClass('btn_gray');
        $('.trigger_keep_btn').removeClass('btn_gray');
        $('.trigger_keep_btn').addClass('btn_orange');
        $('.trigger_keep_btn2').removeClass('btn_gray');
        $('.trigger_keep_btn2').addClass('btn_orange');
        $('.tohokuret').removeClass('btn_gray');
        $('.tohokuret').addClass('int_white');
    }
}


// キープしたやつを取り消す
function buttonDelete(id) {
    let keep = document.getElementById("keep_" + id);
    let keep_agent_box = document.getElementById("keep_agent_box_" + id);
    let tohokuret = document.getElementById('tohokuret');
    let trigger_keep_btn = document.getElementById('trigger_keep_btn');
    let trigger_keep_btn2 = document.getElementById('trigger_keep_btn2');
    let tohokuret2 = document.getElementById('tohokuret2');
    let tohokuret3 = document.getElementById('tohokuret3');
    let keep_inquiry_btn = document.getElementById('keep_inquiry_btn');
    keep_agent_box.style.display = "none";
    keep.checked = false;

    let count = tohokuret.innerHTML;
    count--;
    tohokuret.innerHTML = count;
    tohokuret2.innerHTML = count;
    tohokuret3.innerHTML = count;

    if (count === 0) {
        keep_inquiry_btn.classList.add('btn_gray');
        trigger_keep_btn.classList.add('btn_gray');
        trigger_keep_btn2.classList.add('btn_gray');

    } else {
        keep_inquiry_btn.classList.remove('btn_gray');
    }
}


window.addEventListener("load", function() {
    let count = 0;
    const checkBoxElements = document.getElementsByName('student_contacts[]');

    checkBoxElements.forEach((element) => {
        // チェックされてたらカウント追加
        if (element.checked) {
            count++;
        }
    });
        $('div.tohokuret').text(count);


    if (count === 0) {
        $('.trigger_keep_btn').removeClass('btn_orange');
        $('.trigger_keep_btn').addClass('btn_gray');
        $('.trigger_keep_btn2').removeClass('btn_orange');
        $('.trigger_keep_btn2').addClass('btn_gray');
        $('.tohokuret').addClass('btn_gray');
        $('.tohokuret').removeClass('int_white');
        $('.keep_inquiry_btn').addClass('btn_gray');

    }
    else {
        $('.keep_inquiry_btn').removeClass('btn_gray');
        $('.trigger_keep_btn').removeClass('btn_gray');
        $('.trigger_keep_btn').addClass('btn_orange');
        $('.trigger_keep_btn2').removeClass('btn_gray');
        $('.trigger_keep_btn2').addClass('btn_orange');
        $('.tohokuret').removeClass('btn_gray');
        $('.tohokuret').addClass('int_white');
    }
    });

// 絞り込み機能

$(function () {
    var box = $('.js_target');//検索対象のDOMを格納する
    var conditions = $('.js_conditions');//現在の条件の選択状況を保持するオブジェクト
    var findConditions;//各data-typeの子要素(input)を格納する
    var currentType;//現在のdata-typeを示す
    var count = 0;//検索ヒット数
    var checkcount = 0;//各data-typeのチェックボックス選択数
    var data_check = 0;//対象項目のデータがどれだけチェック状態と一致しているか
    var condition = {};//チェックボックスの入力状態を保持するオブジェクト

    $('.js_denominator').text(box.length);//件数表示の分母をセット

    for (var i = 0; i < conditions.length; i++) {//ターゲットのdata-typeを参照し、メソッドとしてconditionに個別に代入する
        currentType = conditions[i].getAttribute('data-type');
        condition[currentType] = [];
    }


    function setConditions() {//条件設定

        count = 0;
        box.removeClass('js_selected');

        for (var i = 0; i < conditions.length; i++) {//data-typeごとの処理

            currentType = conditions[i].getAttribute('data-type');
            findConditions = conditions[i].querySelectorAll('input');

            for (var n = 0; n < findConditions.length; n++) {//inputごとの処理
                if (findConditions[n].checked){//現在選択中のインプットが選択されている場合
                    condition[currentType][findConditions[n].value] = true;
                    checkcount++
                } else {
                    condition[currentType][findConditions[n].value] = false;
                }
                if (findConditions.length === n+1){//ループが最後の場合
                    if (checkcount === 0) {
                        for (var t = 0; t < findConditions.length; t++) {
                            condition[currentType][findConditions[t].value] = true;
                        }
                    }
                    checkcount = 0;
                }
            }
        }


        for (var m = 0, len = box.length; m < len; ++m) {//最初に取得したターゲットの情報と、現在のinputの選択状態を比較して処理を行う

            for (var i = 0; i < conditions.length; i++) {//ターゲットのdata-typeを参照し、メソッドとしてconditionに個別に代入する
                currentType = conditions[i].getAttribute('data-type');
                //現在のターゲットのtype情報をカンマ区切りで分割し、配列に代入
                var currentBoxTypes = $(box[m]).data(currentType).split(',');

                for (var j = 0; j < currentBoxTypes.length; j++) {
                    if (condition[currentType][currentBoxTypes[j]]) {
                        data_check++;//選択した条件のうちひとつでもマッチしてたらdata_checkを加算してループを抜ける
                        break;
                    } else {
                    }
                }
            }

            if (data_check === conditions.length) {
                count++;
                $(box[m]).addClass('js_selected');
            } else {
            }
            data_check = 0;
        }

        $('.js_numerator').text(count);//件数表示の分子をセット
    }

    setConditions();

    $(document).on('click', 'input', function () {

        setConditions();

    });


    $(document).on('click', '.js_release', function () {
        $('.bl_selectBlock_check input').each(function () {
            $(this).prop('checked', false);
        });
        setConditions();

    });

});

const scrollBlue = function () {
    window.scrollTo({
        top: 1700,         
        behavior: 'smooth'
    });
};