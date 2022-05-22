


// 絞り込み
var widget = document.getElementById('js-filter');
var checkboxes = widget.querySelectorAll('.filter-cond input[type="checkbox"]');
var checkedList = [];
var filter = function () {
    checkedList = [];

    Array.prototype.forEach.call(checkboxes, function (input) {
        if (input.checked) {
            checkedList.push(input.value);
        }
    });

    widget.setAttribute('data-filter-view', checkedList.join(' '));
};

Array.prototype.forEach.call(checkboxes, function (checkbox) {
    checkbox.addEventListener('change', filter);
});



//全選択ボタンを取得する
const checkBtn = document.getElementById("check-btn");
//全解除ボタンを取得する
const uncheckBtn = document.getElementById("uncheck-btn");
//チェックボックスを取得する
const el = document.getElementsByClassName("checks");

//全てのチェックボックスにチェックを付ける
const checkAll = () => {
    for (let i = 0; i < el.length; i++) {
        el[i].checked = true;
    }
};

//全てのチェックボックスのチェックを外す
const uncheckAll = () => {
    for (let i = 0; i < el.length; i++) {
        el[i].checked = false;
    }
};

//全選択ボタンをクリックした時「checkAll」を実行
checkBtn.addEventListener("click", checkAll, false);
//全解除ボタンをクリックした時「uncheckAll」を実行
uncheckBtn.addEventListener("click", uncheckAll, false);


// 途中から右側固定
var nav_pos = $("#keep_btn").offset().top;
var nav_height = $("#keep_btn").outerHeight();
$(window).scroll(function () {
    if ($(this).scrollTop() > nav_pos) {
        $("filter").css("padding-top", nav_height);
        $("#keep_btn").addClass("fixed");
    } else {
        $("filter").css("padding-top", 0);
        $("#keep_btn").removeClass("fixed");
    }
});

// 途中から左側固定
var nav_pos = $("#filter_side").offset().top;
var nav_height = $("#filter_side").outerHeight();
$(window).scroll(function () {
    if ($(this).scrollTop() > nav_pos) {
        $("filter").css("padding-top", nav_height);
        $("#filter_side").addClass("fixed");
    } else {
        $("filter").css("padding-top", 0);
        $("#filter_side").removeClass("fixed");
    }
});


// キープ一覧にあるエージェントを最初は非表示
    for (let i = 1; i < 4; i++) {
    let keep_agent_box = document.getElementById("keep_agent_box_" + i);
    keep_agent_box.style.display ="none";
    }
    

    function check(id) {
        let keep_agent_box = document.getElementById("keep_agent_box_" + id);
        // キープ押されたら表示
        if(keep_agent_box.style.display=="block"){
            keep_agent_box.style.display ="none";
        
        }else{
            keep_agent_box.style.display ="block";
            
    };
}


// 岩村さん、ここお願いします！
// function check(id) {
$(function check(id) {
    $('input:checkbox').change(function() {
        var cnt = $('#tohoku input:checkbox:checked').length;
        $('div.tohokuret').text('選択：' + cnt + '個');
    }).trigger('change');
});
// }




// キープしたやつを取り消す
function buttonDelete(id){
    let keep = document.getElementById("keep_" + id);
    let keep_agent_box = document.getElementById("keep_agent_box_" + id);
        keep_agent_box.style.display ="none";     
        keep.checked = false;
}



// キープの数をカウント
let state = { count: 0 };
let btn = document.getElementById('keep');
btn.addEventListener('click', () => {
  let keep_counter = document.getElementById('keep_counter');
  keep_counter.innerHTML = ++state.count;
  return;
});

