


// // 絞り込み
// var widget = document.getElementById('js-filter');
// var checkboxes = widget.querySelectorAll('.filter-cond input[type="checkbox"]');
// var checkedList = [];
// var filter = function () {
//     checkedList = [];

//     Array.prototype.forEach.call(checkboxes, function (input) {
//         if (input.checked) {
//             checkedList.push(input.value);
//         }
//     });

//     widget.setAttribute('data-filter-view', checkedList.join(' '));
// };

// Array.prototype.forEach.call(checkboxes, function (checkbox) {
//     checkbox.addEventListener('change', filter);
// });

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

// //全てのチェックボックスにチェックを付ける
// const checkAll = () => {
//     for (let i = 0; i < el.length; i++) {
//         el[i].checked = true;
//     }
// };

// //全てのチェックボックスのチェックを外す
// const uncheckAll = () => {
//     for (let i = 0; i < el.length; i++) {
//         el[i].checked = false;
//     }
// };

// //全選択ボタンをクリックした時「checkAll」を実行
// checkBtn.addEventListener("click", checkAll, false);
// //全解除ボタンをクリックした時「uncheckAll」を実行
// uncheckBtn.addEventListener("click", uncheckAll, false);


// // 途中から右側固定
// var nav_pos = $("#keep_btn").offset().top;
// var nav_height = $("#keep_btn").outerHeight();
// $(window).scroll(function () {
//     if ($(this).scrollTop() > nav_pos) {
//         $("filter").css("padding-top", nav_height);
//         $("#keep_btn").addClass("fixed");
//     } else {
//         $("filter").css("padding-top", 0);
//         $("#keep_btn").removeClass("fixed");
//     }
// });

// 途中から右固定
var nav_pos = $("#filter_side").offset().top;
var nav_height = $("#filter_side").outerHeight();
$(window).scroll(function () {
    // if ($(this).scrollTop() > nav_pos -90) {
    if ($(this).scrollTop() > nav_pos - 150) {
        $("filter").css("padding-top", nav_height);
        // $("#filter_side").addClass("fixed");
        $(".filter_left_wrapper").addClass("white");
        $(".filter_left_wrapper").removeClass("none");

    } else {
        $("filter").css("padding-top", 0);
        // $("#filter_side").removeClass("fixed");
        $(".filter_left_wrapper").addClass("none");
        // $(".filter_left_wrapper").removeClass("white");

    }
});

$(function () {
    //.scroll_topを変数[topBtn]に入れる 
    var topBtn = $('#filter_side');
    var fixed = $('.filter_left_wrapper');
    //topBtnはhide()にして見えないようにする 
    topBtn.hide();
    fixed.hide();
    $(window).scroll(function () {
        //1300pxスクロールしたらtopBtnをフェードイン表示させる 
        if ($(this).scrollTop() > 1600) {
            topBtn.fadeIn();
            fixed.fadeIn();
        } else {
            //もし上にスクロールして1300px未満になったらフェードアウトさせる 
            topBtn.fadeOut();
            fixed.fadeOut();
        }
    });
});

// $(function () {
//         var topBtn = $('#filter_side');
//         topBtn.hide();
//     $(window).scroll(function () {
//         var imgPos = $(this).offset().top;
//         var scroll = $(window).scrollTop();
//         var windowHeight = $(window).height();
//         // if (scroll > imgPos - windowHeight + 300) {
//               if (scroll > imgPos - windowHeight + windowHeight/5){
//             topBtn.fadeIn();
//             // $(this).addClass("fade-in");
//             // $("#filter_side").addClass("fixed");
//             // $(".filter_left_wrapper").addClass("white");
//             // $(".filter_left_wrapper").removeClass("none");
//         } else {
//             topBtn.fadeOut();
//             // $(this).removeClass("fade-in");
//             // $("#filter_side").removeClass("fixed");
//             // $(".filter_left_wrapper").removeClass("white");
//         }
//     });
// });


// jQuery(function ($) {
//   var fadeIn = $('.fade-in');
//   $(window).on('scroll', function () {
//     $(fadeIn).each(function () {
//       var offset = $(this).offset().top;
//       var scroll = $(window).scrollTop(); 
//       var windowHeight = $(window).height();
//       if (scroll > offset - windowHeight + 100) {
//         $(this).addClass("scroll-in");
//       }
//     });
//   });
// });


// // キープ一覧にあるエージェントを最初は非表示
// const keepAgentElements = document.querySelectorAll('.keep_agent_box');

// for (let i = 1; i < keepAgentElements.length ; i++) {
//     let keep_agent_box = document.getElementById("keep_agent_box_" + i);
//     keep_agent_box.style.display = "none";
// }

// キープ一覧にあるエージェントを最初は非表示
//     const keepBoxElements =document.querySelectorAll(".keep_agent_box")
//     for (let i = 1; i <= keepBoxElements.length; i++) {
//     let keep_agent_box = document.getElementById("keep_agent_box_" + i);
//     keep_agent_box.style.display = 'none';
// }

// 岩村さん、ここお願いします！
// function check(id) {
// $(function () {
//     $('input:checkbox').change(function() {
//         var cnt = $('#tohoku input:checkbox:checked').length;
//         $('div.tohokuret').text('選択：' + cnt + '個');
//     }).trigger('change');
// });
// }

// $(function() {}) の書き方はHTMLを全部読み込んでから中の処理を実行してねって書き方なので引数を取らない?と思います
// なので以下の形で元々あるcheck関数に処理を追加してしまうのが良さそう、懸念:チェックされるたびにchangeのイベント登録しているからパフォーマンス悪くなるかも？
// パフォーマンスとかは二の次なので一旦気にせず作成します

function check(id) {
    let keep_agent_box = document.getElementById("keep_agent_box_" + id);
    // キープ押されたら表示
    // if (keep_agent_box.style.display = "block") {
    //     keep_agent_box.style.display = "none";
    // } else {
    //     keep_agent_box.style.display = "block";
    // }
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

    // let modal_keep = document.getElementById('modal_keep');
    // if (count !== 0){
    //     modal_keep.classList.remove('none');
    // } 
    // else {
    //     modal_keep.style.display= "block";
    // }

    if (count == 0) {
        $('.trigger_keep_btn').removeClass('btn_orange');
        $('.trigger_keep_btn').addClass('btn_gray');
        $('.tohokuret').addClass('btn_gray');
        $('.tohokuret').removeClass('int_white');
        $('.keep_inquiry_btn').addClass('btn_gray');

    }
    else {
        $('.keep_inquiry_btn').removeClass('btn_gray');
        $('.trigger_keep_btn').removeClass('btn_gray');
        $('.trigger_keep_btn').addClass('btn_orange');
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
    let tohokuret2 = document.getElementById('tohokuret2');
    let keep_inquiry_btn = document.getElementById('keep_inquiry_btn');
    // let modal_keep = document.getElementById('modal_keep');
    // let count_dis = document.getElementById('count_dis');
    keep_agent_box.style.display = "none";
    keep.checked = false;


    // countをなんかしらで定義して、134行目から1引く、ってやりたい
    // できたああああああああ
    // let count = keep_agent_box.length;

    let count = tohokuret.innerHTML;
    // console.log(count);
    count--;
    tohokuret.innerHTML = count;
    tohokuret2.innerHTML = count;

    if (count === 0) {
        // modal_keep.style.display= "none";
        // modal_keep.classList.add('none');
        keep_inquiry_btn.classList.add('btn_gray');
        trigger_keep_btn.classList.add('btn_gray');

    } else {
        keep_inquiry_btn.classList.remove('btn_gray');

    }
    // if (count !== 0){
    //     modal_keep.style.display= "block";
    // }
}
// let modal_keep = document.getElementById('modal_keep');
// let count = tohokuret.innerHTML;
// if (count !== 0){
//     modal_keep.style.display= "block";
// }


// // キープの数をカウント
// let state = { count: 0 };
// let btn = document.getElementById('keep_btn');
// btn.addEventListener('click', () => {
//     let keep_counter = document.getElementById('keep_counter');
//     keep_counter.innerHTML = ++state.count;
//     return;
// });


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

    // function setConditions() {//条件設定

    //     count = 0;
    //     box.removeClass('js_selected');

    //     for (var i = 0; i < conditions.length; i++) {//data-typeごとの処理

    //         currentType = conditions[i].getAttribute('data-type');
    //         findConditions = conditions[i].querySelectorAll('input');

    //         for (var n = 0; n < findConditions.length; n++) {//inputごとの処理
    //             if (findConditions[n].checked){//現在選択中のインプットが選択されている場合
    //                 condition[currentType][findConditions[n].value] = true;
    //                 checkcount++
    //             } else {
    //                 condition[currentType][findConditions[n].value] = false;
    //             }
    //             if (findConditions.length === n+1){//ループが最後の場合
    //                 if (checkcount === 0) {
    //                     for (var t = 0; t < findConditions.length; t++) {
    //                         condition[currentType][findConditions[t].value] = true;
    //                     }
    //                 }
    //                 checkcount = 0;
    //             }
    //         }
    //     }


    //     for (var m = 0, len = box.length; m < len; ++m) {//最初に取得したターゲットの情報と、現在のinputの選択状態を比較して処理を行う

    //         for (var i = 0; i < conditions.length; i++) {//ターゲットのdata-typeを参照し、メソッドとしてconditionに個別に代入する
    //             currentType = conditions[i].getAttribute('data-type');
    //             //現在のターゲットのtype情報をカンマ区切りで分割し、配列に代入
    //             var currentBoxTypes = $(box[m]).data(currentType).split(',');

    //             for (var j = 0; j < currentBoxTypes.length; j++) {
    //                 if (condition[currentType][currentBoxTypes[j]]) {
    //                     data_check++;//選択した条件のうちひとつでもマッチしてたらdata_checkを加算してループを抜ける
    //                     break;
    //                 } else {
    //                 }
    //             }
    //         }

    //         if (data_check === conditions.length) {
    //             count++;
    //             $(box[m]).addClass('js_selected');
    //         } else {
    //         }
    //         data_check = 0;
    //     }

    //     $('.js_numerator').text(count);//件数表示の分子をセット
    // }

    // setConditions();

    // $(document).on('click', 'input', function () {

    //     setConditions();

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