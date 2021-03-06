"use strict";

function MemoSelect(drag, drop, event) {
	var div_no = parseInt(drop.id.substring(4));
	if(div_array[div_no] === true) {
		alert("같은 위치에 포스트잇을 겹처붙일 수 없습니다.");
		return 0;
	}
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
	drop.select(".del_memo")[0].stopObserving();
	drop.select(".del_memo")[0].observe("click", function(){del_btn_clicked(textarea, drop_div);});
	if(drop.select(".fix_memo")[0] != null) {
		var btn2 = drop.select(".fix_memo")[0];
		btn2.stopObserving();
	}
	var btn3 = drop.select(".pin_memo")[0];
	if(btn3 != null) {
		btn3.stopObserving();
		btn3.observe("click", function(){pin_btn_clicked(textarea, btn2);});
	}
	drag.removeClassName("image_post");
	drop.addClassName("image_post");
	if(drag.hasClassName("posted")) {
		drag.removeClassName("posted");
		drop.addClassName("posted");
	}

	var div_no = parseInt(drop.id.substring(4));
	new Ajax.Request("../../framework/function/moveFeedback.php", {
		method: "post",
		parameters: {feedback_no: feedback_no, div_no: div_no},
		onSuccess: blank,
		onFailure: onFailed,
		onException: onFailed
	});

	for(var i=0; i<Draggables.drags.length; i++) {
		if(Draggables.drags[i]["element"] === drag) {
			Draggables.drags[i].destroy();
			break;
		}
	}
	new Draggable(drop, {revert: true});
}
function blank(ajax){}

function New_Memo(){
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
	btn1.addClassName("del_memo");
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

	btn2.observe("click", function(){fix_btn_clicked(textarea, div_no, "write");});

	var btn3 = document.createElement("button");
	btn3.writeAttribute("type", "submit");
	btn3.addClassName("pin_memo");
	btn3.addClassName("btn");
	btn3.addClassName("btn_btn-info");
	btn3.innerHTML = "PIN";
	div.appendChild(btn3);

	btn3.observe("click", function(){pin_btn_clicked(textarea, btn2);});

	new Draggable(div,{revert: true});
}

function del_btn_clicked(textarea, div_no) {
	if($("div_"+div_no).select(".fix_memo")[0]==null) {
		var feedback_no = parseInt(textarea.value.substring(4, textarea.value.indexOf("\n")));
		new Ajax.Request("../../framework/function/deleteFeedback.php", {
			method: "post",
			parameters: {feedback_no: feedback_no, div_no: div_no},
			onSuccess: removeFeedback,
			onFailure: onFailed,
			onException: onFailed
		});
		alert("feedback 메모가 삭제되었습니다.");
	} else {
		while($("div_"+div_no).firstChild!=null)
			$("div_"+div_no).removeChild($("div_"+div_no).firstChild);
		$("div_"+div_no).removeClassName("image_post");
		div_array[div_no] = false;
	}
}
function removeFeedback(ajax) {
	var ajaxtext = ajax.responseText;
	var result = ajax.responseXML.getElementsByTagName("result")[0].firstChild.nodeValue;
	if(result == "failure") {
		alert("작성자만 글을 삭제할 수 있습니다.");
		return;
	} else if(result == "SQLException") {
		alert(ajax.responseXML.getElementsByTagName("exception")[0]);
		return;
	}
	var div_no = ajax.responseXML.getElementsByTagName("div")[0].firstChild.nodeValue;
	var div = $("div_"+div_no);
	while(div.firstChild != null)
		div.removeChild(div.firstChild);
	div.removeClassName("image_post");
	div.removeClassName("posted");
	div_array[div_no] = false;
}

function fix_btn_clicked(textarea, div_no) {
	var content = textarea.value;

	var btn = $$("#div_"+div_no+">.fix_memo")[0];
	btn.removeClassName("fix_memo");
	btn.addClassName("already_done");
	new Ajax.Request("../../framework/function/writeFeedback.php", {
		method: "post",
		parameters: {course: $F("course"), lecture: $F("lecture"), content: content, div_no: div_no},
		onSuccess: writeFeedback,
		onFailure: onFailed,
		onException: onFailed
	});
}
function writeFeedback(ajax) {
	var text = ajax.responseText;
	var result = ajax.responseXML.getElementsByTagName("result")[0].firstChild.nodeValue;
	if(result == "success") {
		var addNo = ajax.responseXML.getElementsByTagName("no")[0].firstChild.nodeValue;
		var div = ajax.responseXML.getElementsByTagName("div")[0].firstChild.nodeValue;
		var textarea_text = $("div_"+div).firstChild.value;
		textarea_text = "No. "+addNo+"\n"+textarea_text;
		$("div_"+div).firstChild.value = textarea_text;
		$("div_"+div).firstChild.readOnly = true;

	} else if(result == "SQLException") {
		alert(ajax.responseXML.getElementsByTagName("exception")[0]);
		return;
	}
}

function pin_btn_clicked(textarea, btn2) {
	if(btn2!=null) {
		if(btn2.hasClassName("fix_memo")) {
			alert("제출된 피드백 포스트잇만 PIN을 꽂을 수 있습니다.");
			return;
		}
	}
	var div_no = parseInt(textarea.parentNode.id.substring(4));
	var feedback_no = parseInt(textarea.value.substring(4, textarea.value.indexOf("\n")));
	new Ajax.Request("../../framework/function/pinFeedback.php", {
		method: "post",
		parameters: {feedback_no: feedback_no, div_no: div_no},
		onSuccess: pinFeedback,
		onFailure: onFailed,
		onException: onFailed
	});
}
function pinFeedback(ajax) {
	var text = ajax.responseText;
	var result = ajax.responseXML.getElementsByTagName("result")[0].firstChild.nodeValue;
	if(result == "PermissionDenied") {
		alert("현재 로그인된 계정은 교수계정이 아닙니다.");
		return;
	} else if(result == "DataTransitionError") {
		alert("올바르지 않은 정보가 입력되었습니다.");
		return;
	} else if(result == "SQLException") {
		var errormsg = ajax.responseXML.getElementsByTagName("exception")[0].firstChild.nodeValue;
		alert("errormsg");
	}
	var div = ajax.responseXML.getElementsByTagName("div")[0].firstChild.nodeValue;
	$("div_"+div).firstChild.readOnly = true;

	var btn_fix = $$("#div_"+div+">.pin_memo")[0];
	btn_fix.stopObserving();
	btn_fix.removeClassName("pin_memo");
	btn_fix.addClassName("already_done");
	var btn_update = $$("#div_"+div+">.del_memo")[0];
	btn_update.stopObserving();
	btn_update.removeClassName("del_memo");
	btn_update.addClassName("already_done");

	var pin_div = $("div_"+parseInt(div));
	pin_div.addClassName("posted");

	for(var i=0; i<Draggables.drags.length; i++) {
		if(Draggables.drags[i]["element"] === $("div_"+div)) {
			Draggables.drags[i].destroy();
			break;
		}
	}
}