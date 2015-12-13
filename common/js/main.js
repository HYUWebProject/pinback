//global variable indicates div.
var div_array = [false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false];

document.observe("dom:loaded", function() {
	//initializing
	//초기에는 소개페이지 이외의 다른것들은 display:none으로 설정되어 보이지 않게 한다.
	new Ajax.Request("framework/function/loadFeedbackPage.php", {
		method: "post",
		parameters: {type: "course"},
		onSuccess: loadCourseList,
		onFailure: onFailed,
		onException: onFailed
	});

	$("course").observe("change", function() {
		new Ajax.Request("framework/function/loadFeedbackPage.php", {
			method: "post",
			parameters: {course: $F("course")},
			onSuccess: loadLectureList,
			onFailure: onFailed,
			onException: onFailed
		});
	});

	$("lecture").observe("change", function() {
		new Ajax.Request("framework/function/loadFeedbackPage.php", {
			method: "post",
			parameters: {course: $F("course"), lecture: $F("lecture")},
			onSuccess: loadFeedbackMemo,
			onFailure: onFailed,
			onException: onFailed
		});
	});
//lectureNote load
	new Ajax.Request("../../framework/function/lectureNoteRoad.php", {
		method: "post",
		parameters: {type: "lecturecourse"},
		onSuccess: loadlectureCourseList,
		onFailure: onFailed,
		onException: onFailed
	});

	$("lecturecourse").observe("change", function() {
		new Ajax.Request("../../framework/function/lectureNoteRoad.php", {
			method: "post",
			parameters: {lecturecourse: $F("lecturecourse")},
			onSuccess: loadLecturenumberList,
			onFailure: onFailed,
			onException: onFailed
		});
	});

	$("lecturenumber").observe("change", function() {
		new Ajax.Request("../../framework/function/lectureNoteRoad.php", {
			method: "post",
			parameters: {course: $F("lecturecourse"), lecture: $F("lecturenumber")},
			onSuccess: loadLectureNote,
			onFailure: onFailed,
			onException: onFailed
		});
	});

	var pageArray = $$(".mainpage:not(#firstpage)");
	for(var i=0; i<pageArray.length; i++)
		pageArray[i].setStyle({display: "none"});


	//로그아웃 기능 추가
	$("logout").observe("click", function() {
		new Ajax.Request("../../framework/function/logout.php", {});
		window.location.href = "index.php";
	});

	//패스워드 변경기능 추가
	$("changepw").observe("click", function() {
		var id = prompt("학번을 입력해주세요.", "");
		new Ajax.Request("../../framework/function/findID.php", {
			method: "post",
			parameters: {id: id},
			onSuccess: successfind,
			onFailure: onFailed,
			onException: onFailed
		});
	});

	//네비게이션 맨 앞의 pinback글씨를 누르면 맨 앞 페이지로 이
	$(".navbar-brand")[0].observe("click", function() {
		$("firstpage").setStyle({display: "block"});
		var temparray = $$(".mainpage:not(#firstpage)");
		for(var j=0; j<temparray.length; j++)
			temparray[j].setStyle({display: "none"});
	});

	//qna dropdown메뉴에서 3학년 클릭하면 화면이 바뀌게 설정
	$$("#qna>li")[1].observe("click", function() {
		$("notepage").setStyle({display: "block"});
		var temparray = $$(".mainpage:not(#notepage)");
		for(var j=0; j<temparray.length; j++)
			temparray[j].setStyle({display: "none"});
	});

	//feedback dropdown메뉴에서 3학년 클릭하면 화면이 바뀌게 설정
	$$("#feedback>li")[1].observe("click", function(){
		$("feedbackpage").setStyle({display: "block"});
		var temparray = $$(".mainpage:not(#feedbackpage)");
		for(var j=0; j<temparray.length; j++)
			temparray[j].setStyle({display: "none"});
	});

	//계정관리 화면 누르면 화면이 바뀌게 설정
	$("manage").observe("click", function(){
		$("managepage").setStyle({display: "block"});
		var temparray = $$(".mainpage:not(#managepage)");
		for(var j=0; j<temparray.length; j++)
			temparray[j].setStyle({display: "none"});
	});

	$("new_memo").observe("click", New_Memo);

	var droparray = $$("#feedbackpage > .feedback_div");
	for(var i=0; i<droparray.length; i++) {
		Droppables.add(droparray[i], {onDrop: MemoSelect});
	}
});

function successfind(ajax) {
	var result = ajax.responseXML.getElementsByTagName("result")[0].firstChild.nodeValue;
	if(result == "success") {
		var id = ajax.responseXML.getElementsByTagName("id")[0].firstChild.nodeValue;
		var newpw = prompt("변경할 비밀번호를 입력하세요.");
		new Ajax.Request("../../framework/function/modifyPassword.php", {
			method: "post",
			parameters: {id: id, pw: newpw},
			onSuccess: modifyPassword,
			onFailure: onFailed,
			onException: onFailed
		});
	} else if (result == "SQLException"){
		var exception = ajax.responseXML.getElementsByTagName("exception")[0].firstChild.nodeValue;
		var string = "<ERROR: SQLException>\n\n"+exception;
		alert(string);
		//alert("입력하신 학번은 존재하지 않는 회원입니다.");
	} else if (result == "inputValidID") {
		alert("학번을 올바르게 입력해주세요. (10자리의 0부터9까지의 숫자조합)");
	} else if (result == "NotExistingID") {
		alert("가입되지 않은 학번입니다. 다시한번 확인해주시기 바랍니다.");
	}
}

function loadCourseList(ajax) {
	var courses = JSON.parse(ajax.responseText);

	for(var i=0; i<courses.length; i++) {
		var option = document.createElement("option");
		option.innerHTML = courses[i];
		$("course").appendChild(option);
	}

	new Ajax.Request("framework/function/loadFeedbackPage.php", {
		method: "post",
		parameters: {course: $F("course")},
		onSuccess: loadLectureList,
		onFailure: onFailed,
		onException: onFailed
	});

	new Ajax.Request("framework/function/loadFeedbackPage.php", {
		method: "post",
		parameters: {course: $F("course"), lecture: $F("lecture")},
		onSuccess: loadFeedbackMemo,
		onFailure: onFailed,
		onException: onFailed
	});


}

function loadLectureList(ajax) {
	var memo_array = $$(".image_post");
	for(var i=0; i<memo_array.length; i++) {
		while(memo_array[i].firstChild!=null)
			memo_array[i].removeChild(memo_array[i].firstChild);
		memo_array[i].removeClassName("image_post");
		if(memo_array[i].hasClassName("posted"))
			memo_array[i].removeClassName("posted");
	}

	while($("lecture").firstChild!=null)
		$("lecture").removeChild($("lecture").firstChild);

	div_array = [false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false];

	var lecture_list = JSON.parse(ajax.responseText);

	for(var i=0; i<lecture_list.length; i++) {
		var option = document.createElement("option");
		option.innerHTML = lecture_list[i];
		$("lecture").appendChild(option);
	}

	new Ajax.Request("framework/function/loadFeedbackPage.php", {
		method: "post",
		parameters: {course: $F("course"), lecture: $F("lecture")},
		onSuccess: loadFeedbackMemo,
		onFailure: onFailed,
		onException: onFailed
	});
}

function loadFeedbackMemo(ajax) {
	var memo_array = $$(".image_post");
	for(var i=0; i<memo_array.length; i++) {
		while(memo_array[i].firstChild!=null)
			memo_array[i].removeChild(memo_array[i].firstChild);
		memo_array[i].removeClassName("image_post");
	}

	div_array = [false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false];

	Draggables.drags = [];

	var jsonarray = JSON.parse(ajax.responseText);
	for(var i=0; i<jsonarray.length; i++) {
		div_array[jsonarray[i]["div_no"]] = true;
		generateFeedbackMemo(jsonarray[i]);
	}
}

function generateFeedbackMemo(memo) {
	var div_no = parseInt(memo["div_no"]);
	var div = $("div_"+div_no);
	div.addClassName("image_post");
	if(memo["confirm_flag"] == 1) 
		div.addClassName("posted");

	var textarea = document.createElement("textarea");
	textarea.addClassName("memo_input");
	textarea.writeAttribute("rows", 10);
	textarea.writeAttribute("cols", 10);
	textarea.writeAttribute("name", "memo_contents");
	textarea.readOnly = true;
	textarea.innerHTML = "No. "+memo["feedback_no"]+"\n"+memo["content_text"];
	div.appendChild(textarea);

	var btn1 = document.createElement("button");
	btn1.writeAttribute("type", "submit");
	btn1.addClassName("btn");
	btn1.addClassName("btn_btn-info");
	btn1.innerHTML = "삭제";
	div.appendChild(btn1);

	var btn2 = document.createElement("button");
	btn2.writeAttribute("type", "submit");
	btn2.addClassName("already_done");
	btn2.addClassName("btn");
	btn2.addClassName("btn_btn-info");
	btn2.innerHTML = "제출";
	div.appendChild(btn2);

	var btn3 = document.createElement("button");
	btn3.writeAttribute("type", "submit");
	btn3.addClassName("btn");
	btn3.addClassName("btn_btn-info");
	btn3.innerHTML = "PIN";
	div.appendChild(btn3);

	if(div.hasClassName("posted")) {
		btn1.addClassName("already_done");
		btn3.addClassName("already_done");
	} else {
		btn1.addClassName("del_memo");
		btn3.addClassName("pin_memo");
		btn1.observe("click", function(){del_btn_clicked(textarea, div_no);});
		btn3.observe("click", function(){pin_btn_clicked(textarea, btn2);});
		new Draggable(div, {revert: true});
	}
}

//lectureNote
function loadlectureCourseList(ajax) {
	var courses = JSON.parse(ajax.responseText);
	for(var i=0; i<courses.length; i++) {
		var option = document.createElement("option");
		option.innerHTML = courses[i];
		$("lecturecourse").appendChild(option);
	}
}
function loadLecturenumberList(ajax) {

	while($("lecturenumber").firstChild!=null)
		$("lecturenumber").removeChild($("lecturenumber").firstChild);

	
	//alert(JSON.parse(ajax.responseText));
	var lecture_list = JSON.parse(ajax.responseText);
	//alert(lecture_list);
	for(var i=0; i<lecture_list.length; i++) {
		var option = document.createElement("option");
		option.innerHTML = lecture_list[i];
		$("lecturenumber").appendChild(option);
	}
}

function loadLectureNote(ajax){
	var _img = document.getElementById('id1');
	var newImg = new Image;
	newImg.onload = function() {
	    _img.src = this.src;
	}
	newImg.src = 'http://whatever';
}

function modifyPassword(ajax) {
	var result = ajax.responseXML.getElementsByTagName("result")[0].firstChild.nodeValue;
	if(result == "success") {
		alert("비밀번호 변경이 완료되었습니다.");
	} else if (result == "SQLException"){
		var exception = ajax.responseXML.getElementsByTagName("exception")[0].firstChild.nodeValue;
		var string = "<ERROR: SQLException>\n\n"+exception;
		alert(string);
	}
}

function loadFeedbackPage(ajax) {
	$("feedbackpage").setStyle({display: "block"});
	var temparray = $$(".mainpage:not(#feedbackpage)");
	for(var j=0; j<temparray.length; j++)
		temparray[j].setStyle({display: "none"});
}

function onFailed(ajax, exception) {
	var errorMessage = "Error making Ajax request:\n\n";
	if (exception) {
		errorMessage += "Exception: " + exception.message;
	} else {
		errorMessage += "Server status:\n" + ajax.status + " " + ajax.statusText + 
		                "\n\nServer response text:\n" + ajax.responseText;
	}
	alert(errorMessage);
}