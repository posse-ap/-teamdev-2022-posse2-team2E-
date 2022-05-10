// キープボタン押した時
function OnButtonClick() 
    let keep_agent_box = document.getElementsById("keep_agent_box");
    keep.innerHTML = "キープ中";
    keep.style.backgroundColor = "#C0C0C0";
    keep.classList.remove("bn632-hover");
    keep.classList.remove("bn19");
    keep.style.boxShadow = "0 4px 15px 0 rgba(0,0,0,0.25)";
    keep.style.borderWidth = "0px";
    keep_agent_box.style.display = "block";
  }