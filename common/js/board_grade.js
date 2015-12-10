"use strict";

function MemoSelect(drag, drop, event) {
	if(drop.id == "test"){
		alert(drag);
		$("test").removeChild(drag);
		$("test").appendChild(drag);
	}
}
function New_Memo(){
	/*
	<div class = "image_post">
		<textarea class="memo_input" rows="10" cols="10" name="memo_contents"></textarea>
		<button type="submit" id = "cancel_memo" class="btn btn-warning ">취소</button>
		<button type="submit" id ="fix_memo" class="btn btn-info ">제출</button>
		<button type="submit" id = "pin_memo" class="btn btn-danger ">PIN</button>
	</div>
	*/
	var div = document.createElement("div");
	div.addClassName("image_post");

	var textarea = document.createElement("textarea");
	textarea.addClassName("memo_input");
	textarea.writeAttribute("rows", 10);
	textarea.writeAttribute("cols", 10);
	textarea.writeAttribute("name", "memo_contents");
	div.appendChild(textarea);

	var btn1 = document.createElement("button");
	btn1.writeAttribute("type", "submit");
	btn1.id = "cancel_memo";
	btn1.addClassName("btn");
	btn1.addClassName("btn_btn-info");
	btn1.innerHTML = "취소";
	div.appendChild(btn1);

	var btn2 = document.createElement("button");
	btn2.writeAttribute("type", "submit");
	btn2.id = "fix_memo";
	btn2.addClassName("btn");
	btn2.addClassName("btn_btn-info");
	btn2.innerHTML = "제출";
	div.appendChild(btn2);

	var btn3 = document.createElement("button");
	btn3.writeAttribute("type", "submit");
	btn3.id = "pin_memo";
	btn3.addClassName("btn");
	btn3.addClassName("btn_btn-info");
	btn3.innerHTML = "PIN";
	div.appendChild(btn3);

	$("feedbackpage").appendChild(div);
	new Draggable(div,{revert: true});
	//Droppables.add("test", {onDrop: MemoSelect});
	alert("메모지가 생성되었습니다.");
}

function Fix_Memo(){
	alert("메모지가 고정되었습니다.")
	var Text_area = document.getElementById("text_area");
	var text_value = Text_area.value;
	alert(text_value);
	$("new_image_post").innerHTML = "<p class='image_message'>"+text_value+"</p>";
}

function Cancel_Memo(){
	$("test").removeChild(document.getElementById("new_image_post"));
	alert("메모지가 삭제되었습니다.");
}