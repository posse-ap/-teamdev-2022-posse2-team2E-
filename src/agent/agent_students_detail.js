var display=function() {
    //切り替える対象の状態を取得
    var form = document.getElementById('view');
    //取得した情報からスタイルについての状態のみをstateに代入
    state=form.style.display;
    //非表示中のときの処理
    if(state=="none"){
         //スタイルを表示(inline)に切り替え
         form.setAttribute("style","display:inline");
    }
}

$('.mukou_to_form').on('click', function () {
    $('.mukou_to_form').addClass('usukusuru');
});