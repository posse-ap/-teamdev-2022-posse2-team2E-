var clicked = [];//クリックされたボタンのindexを格納

// カートボタンを押した際の処理
cart_btns.forEach(function (cart_btn,index) {
    cart_btn.addEventListener('click',function () {
  
      // カートボタンがすでに押されているかの判定
      if (clicked.indexOf(index) >= 0) {
  
        //カートアイコンの数を減らす
        cart_cnt--;
        //0の時はカートアイコンのカウントを表示させない
        if(cart_cnt == 0){
          cart_cnt_icon.parentNode.classList.add('hidden');
        }
        cart_cnt_icon.innerHTML = cart_cnt;
  
        //カートボタンを非アクティブにする
        cart_btn.classList.remove('item_cart_btn_active');
  
      }else if(clicked.indexOf(index) == -1){
  
        //カートボタンがクリックされていない場合の処理
        //ボタンのindexが配列に含まれていなかったら、配列に追加
        clicked.push(index);

        //カートアイコンのカウントを増やす
        cart_cnt++;
        if( cart_cnt >= 1 ){
          cart_cnt_icon.parentNode.classList.remove('hidden');
        }
        cart_cnt_icon.innerHTML = cart_cnt;

        //カートボタンをアクティブにする
        cart_btn.classList.add('item_cart_btn_active');
      }
  
    });
  });



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
    let keep = document.getElementById("keep_" + id);

    keep.innerHTML = "キープを外す";
    keep.style.backgroundColor = "#C0C0C0";
    keep.classList.remove("bn632-hover");
    keep.classList.remove("bn19");
    keep.style.boxShadow = "0 4px 15px 0 rgba(0,0,0,0.25)";
    keep.style.borderWidth = "0px";
    keep.classList.add("cursor");


    let keep_agent_box = document.getElementById("keep_agent_box_" + id);

    // キープ押されたら表示
    if(keep_agent_box.style.display=="block"){
		// noneで非表示
		keep_agent_box.style.display ="none";
        keep.innerHTML = "キープする";
        keep.classList.add("bn632-hover");
        keep.classList.add("bn19");
        keep.classList.add("cursor");
	}else{
		// blockで表示
		keep_agent_box.style.display ="block";
	}
    
}



// キープしたやつを取り消す
function buttonDelete(id){
    let keep = document.getElementById("keep_" + id);
    let keep_agent_box = document.getElementById("keep_agent_box_" + id);
        keep_agent_box.style.display ="none";
        keep.innerHTML = "キープする";
        keep.classList.add("bn632-hover");
        keep.classList.add("bn19")
        keep.classList.add("cursor");        
}



// キープの数をカウント
let state = { count: 0 };
let btn = document.getElementById('keep');
btn.addEventListener('click', () => {
  let keep_counter = document.getElementById('keep_counter');
  keep_counter.innerHTML = ++state.count;
  return;
});

