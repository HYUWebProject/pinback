"use strict";
//lecture note label 붙는 부분 
document.observe("dom:loaded", function() {
	$("write").observe("click", function() {
        var write_left = event.pointerX()-60;
        var write_top = event.pointerY()-60;
        make_writing_label(write_left,write_top);
        contextMenu.setStyle({
            display: "none"
        });
    });
	for(var i = 0 ; i< $$(".lectureNote_label").length ; i++){
		$$(".lectureNote_label")[i].observe("dblclick", generate_question_image);
	}
	

});



function make_writing_label(x_position, y_position){
	var label = document.createElement("div");
	label.className = "lectureNote_label";
	label.setStyle({
    'position': 'absolute',
    'left': x_position+'px',
    'top' : y_position+'px',
    'border': '0px solid transparent'
	}); 
	if($$(".lectureNote_label").length >= 1){
		label.name = ""+ $$(".lectureNote_question_image").length-1;
	}
	$("post_note").appendChild(label);
	$$(".lectureNote_label")[$$(".lectureNote_label").length-1].observe("dblclick", generate_question_image);	
}

function reVisible_label(){
	for(var i = 0 ; i< $$(".lectureNote_label").length ; i++){
		$$(".lectureNote_label")[i].setStyle({
			'visibility': 'visible'
		});
	}

}

function remove_Question(){
	var question = $$(".lectureNote_question_image")[$$(".lectureNote_question_image").length-1];
	$("notepage").removeChild(question);
}

function cancel_Question(){
	var question = $$(".lectureNote_question_image")[$$(".lectureNote_question_image").length-1];
	$("notepage").removeChild(question);

}

function save_Question(){
	var question_textarea = $$(".lectureNote_question_textarea")[$$(".lectureNote_question_textarea").length-1];
	alert(question_textarea);
	question_textarea.innerHTML = ""+question_textarea.value;
}

function generate_question_image() {
	var question = document.createElement("div");
	question.className="lectureNote_question_image";
	$("notepage").appendChild(question);

	question.name = ""+ $$(".lectureNote_question_image").length-1;

	for(var i = 0 ; i< $$(".lectureNote_label").length ; i++){
		$$(".lectureNote_label")[i].setStyle({
			'visibility': 'hidden'
		});
	}
	var textarea = document.createElement("textarea");
	textarea.addClassName("lectureNote_question_textarea");
	textarea.innerHTML = "질문 작성하기 :";
	question.appendChild(textarea);

	var btn1 = document.createElement("button");
	btn1.writeAttribute("type", "submit");
	btn1.addClassName("question_button");
	btn1.addClassName("del_question");
	btn1.addClassName("btn");
	btn1.addClassName("btn_btn-info");
	btn1.innerHTML = "삭제";
	question.appendChild(btn1);

	var btn2 = document.createElement("button");
	btn2.writeAttribute("type", "submit");
	btn2.addClassName("question_button");
	btn2.addClassName("cancel_question");
	btn2.addClassName("btn");
	btn2.addClassName("btn_btn-info");
	btn2.innerHTML = "취소";
	question.appendChild(btn2);

	var btn3 = document.createElement("button");
	btn3.writeAttribute("type", "submit");
	btn3.addClassName("question_button");
	btn3.addClassName("save_question");
	btn3.addClassName("btn");
	btn3.addClassName("btn_btn-info");
	btn3.innerHTML = "저장";
	question.appendChild(btn3);

	for(var i = 0 ; i< $$(".question_button").length ; i++){
		$$(".question_button")[i].observe("click", reVisible_label);
	}

	$$(".del_question")[0].observe("click", remove_Question);
	$$(".cancel_question")[0].observe("click", cancel_Question);
	$$(".save_question")[0].observe("click", save_Question);


	/*
	if(memo["confirm_flag"] == 1) {
		div.addClassName("posted");
	} else {
		new Draggable(div,{revert: true});
	}
	*/

}