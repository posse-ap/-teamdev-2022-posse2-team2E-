$(function() {
    $('input[type="radio"]').change(function() {
      if (
        $('input[value="柴犬"]').prop("checked") == true &&
        $('input[value="白色"]').prop("checked") == true 
        // $('input[value="大人"]').prop("checked") == true
      ) {
        $(".no_list li").css("display", "block");
      } else if (
        $('input[value="柴犬"]').prop("checked") == true &&
        $('input[value="黒色"]').prop("checked") == true &&
        $('input[value="赤ちゃん"]').prop("checked") == true
      ) {
        $(".no_list li").css("display", "block");
      } else if (
        $('input[value="ポメラニアン"]').prop("checked") == true &&
        $('input[value="黒色"]').prop("checked") == true &&
        $('input[value="赤ちゃん"]').prop("checked") == true
      ) {
        $(".no_list li").css("display", "block");
      } else if (
        $('input[value="ポメラニアン"]').prop("checked") == true &&
        $('input[value="黒色"]').prop("checked") == true &&
        $('input[value="大人"]').prop("checked") == true
      ) {
        $(".no_list li").css("display", "block");
      } else {
        $(".no_list li").css("display", "none");
      }
      $(".reset .reset-button").click(function() {
        $(listItem).removeClass(hideClass);
      });
    });
  });
  
  /**
   * チェックボックスがクリックされた瞬間を拾うコード
   **/
  $(function() {
    $(".label").click(function() {
      $(".list li").removeClass("list_toggle");
    });
    if ($(".list li").hasClass("list_toggle")) {
      $(".reset .reset-button").click(function() {
        $(".list li").addClass("list_toggle");
      });
    }
  });
  
  /**
   * 絞り込み機能
   **/
  var searchBox = ".search-box"; // 絞り込む項目を選択するエリア
  var listItem = ".list_item"; // 絞り込み対象のアイテム
  var hideClass = "is-hide"; // 絞り込み対象外の場合に付与されるclass名
  
  $(function() {
    // 絞り込み項目を変更した時
    $(document).on("change", searchBox + " input", function() {
      search_filter();
    });
  });
  
  /**
   * リストの絞り込みを行う
   */
  function search_filter() {
    // 非表示状態を解除
    $(listItem).removeClass(hideClass);
    for (var i = 0; i < $(searchBox).length; i++) {
      var name = $(searchBox)
        .eq(i)
        .find("input")
        .attr("name");
      // 選択されている項目を取得
      var searchData = get_selected_input_items(name);
      // 選択されている項目がない、またはALLを選択している場合は飛ばす
      if (searchData.length === 0 || searchData[0] === "") {
        continue;
      }
      // リスト内の各アイテムをチェック
      for (var j = 0; j < $(listItem).length; j++) {
        // アイテムに設定している項目を取得
        var itemData = $(listItem)
          .eq(j)
          .data(name);
        // 絞り込み対象かどうかを調べる
        if (searchData.indexOf(itemData) === -1) {
          $(listItem)
            .eq(j)
            .addClass(hideClass);
        }
      }
    }
  }
  
  /**
   * inputで選択されている値の一覧を取得する
   * @param  {String} name 対象にするinputのname属性の値
   * @return {Array}       選択されているinputのvalue属性の値
   */
  function get_selected_input_items(name) {
    var searchData = [];
    $("[name=" + name + "]:checked").each(function() {
      searchData.push($(this).val());
    });
    return searchData;
  }