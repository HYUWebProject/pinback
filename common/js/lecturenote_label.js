"use strict";
//lecture note label 붙는 부분 
document.observe("dom:loaded", function() {
	make_writing_label('500','500');
	make_writing_label('600','600');


	for(var i = 0 ; i< $$(".lectureNote_label").length ; i++){
		$$(".lectureNote_label")[i].observe("dblclick", popUp_question_window);
	}

});



function make_writing_label(x_position, y_position){
	var label = document.createElement("img");
	label.className = "lectureNote_label";
	label.setStyle({
	'border': '0px solid',
    'position': 'absolute',
    'top': x_position+'px',
    'left' : y_position+'px'
	}); 
	$("post_note").appendChild(label);		
}

function popUp_question_window(){
	window.open('../../framework/function/lectureNote_question_popUp.php', '질문', 'width=300, height=300, menubar=no, status=no, toolbar=no, top=300, left= 500');
}