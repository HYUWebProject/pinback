"use strict";

function MemoSelect(drag, drop, event) {
	var textarea = drag.firstChild;
	var text = drag.firstChild.value;
	var feedback_no = parseInt(text.substring(4, text.indexOf("\n")));
	while(drag.firstChild!=null) {
		drop.appendChild(drag.firstChild);
	}

	var drag_div = drag.id.substring(4);
	div_array[drag_div] = false;
	var drop_div = drop.id.substring(4);
	div_array[drop_div] = true;
	if(drop.select(".fix_memo")[0] != null) {
		drop.select(".fix_memo")[0].stopObserving();
		drop.select(".fix_memo")[0].observe("click", function(){fix_btn_clicked(textarea, drop_div);});
	}
	drop.select(".cancel_memo")[0].stopObserving();
	drop.select(".cancel_memo")[0].observe("click", function(){del_btn_clicked(textarea, drop_div);});
	drag.removeClassName("image_post");
	drop.addClassName("image_post");

	var div_no = parseInt(drop.id.substring(4));
	new Ajax.Request("../../framework/function/updateFeedback.php", {
		method: "post",
		parameters: {feedback_no: feedback_no, div_no: div_no},
		onSuccess: blank,
		onFailure: onFailed,
		onException: onFailed
	});
	new Draggable(drop, {revert: true});
}
function blank(ajax){}

function New_Memo(){
	/*
	<div class = "image_post">
		<textarea class="memo_input" rows="10" cols="10" name="memo_contents"></textarea>
		<button type="submit" id = "cancel_memo" class="btn btn-warning ">취소</button>
		<button type="submit" id ="fix_memo" class="btn btn-info ">제출</button>
		<button type="submit" id = "pin_memo" class="btn btn-danger ">PIN</button>
	</div>
	*/

	if($F("course") == null || $F("lecture") == null) {
		alert("course와 lecture를 먼저 선택해 주시기 바랍니다.");
		return;
	}
	for(var i=0; i<div_array.length; i++) {
		if(div_array[i] === false) {
			var div_no = i;
			div_array[i] = true;
			break;
		}
	}
	if(i>=div_array.length) {
		alert("더이상 Feedback memo를 붙일 수 없습니다.");
		return;
	} else {
		var div = $("div_"+div_no);
		div.addClassName("image_post");
	}


	var textarea = document.createElement("textarea");
	textarea.addClassName("memo_input");
	textarea.writeAttribute("rows", 10);
	textarea.writeAttribute("cols", 10);
	textarea.writeAttribute("name", "memo_contents");
	div.appendChild(textarea);

	var btn1 = document.createElement("button");
	btn1.writeAttribute("type", "submit");
	btn1.addClassName("cancel_memo");
	btn1.addClassName("btn");
	btn1.addClassName("btn_btn-info");
	btn1.innerHTML = "삭제";
	div.appendChild(btn1);

	btn1.observe("click", function(){del_btn_clicked(textarea, div_no);});

	var btn2 = document.createElement("button");
	btn2.writeAttribute("type", "submit");
	btn2.addClassName("fix_memo");
	btn2.addClassName("btn");
	btn2.addClassName("btn_btn-info");
	btn2.innerHTML = "제출";
	div.appendChild(btn2);

	btn2.observe("click", function(){fix_btn_clicked(textarea, div_no);});

	var btn3 = document.createElement("button");
	btn3.writeAttribute("type", "submit");
	btn3.addClassName("pin_memo");
	btn3.addClassName("btn");
	btn3.addClassName("btn_btn-info");
	btn3.innerHTML = "PIN";
	div.appendChild(btn3);

	new Draggable(div,{revert: true});
}

function fix_btn_clicked(textarea, div_no) {
	var content = textarea.value;
	new Ajax.Request("../../framework/function/writeFeedback.php", {
		method: "post",
		parameters: {course: $F("course"), lecture: $F("lecture"), content: content, div_no: div_no},
		onSuccess: writeFeedback,
		onFailure: onFailed,
		onException: onFailed
	});
}

function del_btn_clicked(textarea, div_no) {
	if($("div_"+div_no).select(".fix_memo")[0]==null) {
		var text = textarea.value;
		var feedback_no = parseInt(text.substring(4, text.indexOf("\n")));
		new Ajax.Request("../../framework/function/deleteFeedback.php", {
			method: "post",
			parameters: {feedback_no: feedback_no, div_no: div_no},
			onSuccess: removeFeedback,
			onFailure: onFailed,
			onException: onFailed
		});		
	} else {
		while($("div_"+div_no).firstChild!=null)
			$("div_"+div_no).removeChild($("div_"+div_no).firstChild);
		$("div_"+div_no).removeClassName("image_post");
	}

}

function writeFeedback(ajax) {
	//alert("메모지가 고정되었습니다.");
	var text = ajax.responseText;

	var div = ajax.responseXML.getElementsByTagName("div")[0].firstChild.nodeValue;
	$("div_"+div).firstChild.readOnly = true;

	var btn_fix = $$("#div_"+parseInt(div)+">.fix_memo")[0];
	btn_fix.stopObserving();
	btn_fix.removeClassName("fix_memo");
	btn_fix.addClassName("fixed_memo");
}

function removeFeedback(ajax) {
	var div_no = ajax.responseXML.getElementsByTagName("div")[0].firstChild.nodeValue;
	var div = $("div_"+div_no);
	while(div.firstChild != null)
		div.removeChild(div.firstChild);
	div.removeClassName("image_post");
}


function Cancel_Memo(){
	$("test").removeChild(document.getElementById("new_image_post"));
	alert("메모지가 삭제되었습니다.");
}