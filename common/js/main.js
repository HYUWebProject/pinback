//global variable indicates div.
var div_array = [false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false];

var posX;
var posY;
var currentOrder;

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

	$("lecturecourse").observe("change", function() {
		new Ajax.Request("../../framework/function/lectureNoteRead.php", {
			method: "post",
			parameters: {lecturecourse: $F("lecturecourse")},
			onSuccess: loadLecturenumberList,
			onFailure: onFailed,
			onException: onFailed
		});
	});

	$("lecturenumber").observe("change", function() {
		new Ajax.Request(("../../framework/function/lectureNoteRead.php"), {
			method: "post",
			parameters: {lecturecourse: $F("lecturecourse"), lecturenumber: $F("lecturenumber")},
			onSuccess: loadPageList,
			onFaiure: onFailed,
			onException: onFailed
		});
	});

	$("pagenumber").observe("change", function() {
		new Ajax.Request("../../framework/function/lectureNoteRead.php", {
			method: "post",
			parameters: {lecturecourse: $F("lecturecourse"), lecturenumber: $F("lecturenumber"), page: $F("pagenumber")},
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

	//네비게이션 맨 앞의 pinback글씨를 누르면 맨 앞 페이지로 이
	$$(".navbar-brand")[0].observe("click", function() {
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
	$("changepw").observe("click", function(){
		var newpw = prompt("변경할 비밀번호를 입력하세요.");
		new Ajax.Request("../../framework/function/modifyPassword.php", {
			method: "post",
			parameters: {pw: newpw},
			onSuccess: modifyPassword,
			onFailure: onFailed,
			onException: onFailed
		});
	});

	$("new_memo").observe("click", New_Memo);

	var droparray = $$("#feedbackpage > .feedback_div");
	for(var i=0; i<droparray.length; i++) {
		Droppables.add(droparray[i], {onDrop: MemoSelect});
	}

	// 여기서부터는 컨텍스트 메뉴 
	var contextMenu = $("contextMenu");
    var coordX = 0;
    var coordY = 0;
    
    $("lecture_image").observe("contextmenu", function(e){
        e.stop();
    });

    $("lecture_image").observe("contextmenu", function(e) {
        coordX = e.pointerX();
        coordY = e.pointerY();
        contextMenu.setStyle({
            display: "block",
            left: coordX + "px",
            top: coordY + "px"
        });
        return false;
    });
    
    document.observe("click", function() {
        contextMenu.setStyle({
            display: "none"
        });
    });
    
    generateNumber();
	loadPins();
	$("write").observe("click", function() {
		posX = event.pointerX();
		posY = event.pointerY();

        var write_left = posX-60;
        var write_top = posY-60;
        make_writing_label(write_left,write_top);
        contextMenu.setStyle({
            display: "none"
        });
    });
	for(var i = 0 ; i< $$(".lectureNote_label").length ; i++){
		var curLabel = $$(".lectureNote_label")[i];
		curLabel.observe("dblclick", function() {
			loadQuestion(curLabel.getAttribute("order"));
		});
	}

	upload_init();
});

function loadCourseList(ajax) {
	var courses = JSON.parse(ajax.responseText);

	for(var i=0; i<courses.length; i++) {
		var option = document.createElement("option");
		option.innerHTML = courses[i];
		$("course").appendChild(option);
	}

	for(var i=0; i<courses.length; i++) {
		var option = document.createElement("option");
		option.innerHTML = courses[i];
		$("lecturecourse").appendChild(option);
	}

	new Ajax.Request("framework/function/loadFeedbackPage.php", {
		method: "post",
		parameters: {course: $F("course")},
		onSuccess: loadLectureList,
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

	div_array = [false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false,
				false, false, false, false, false];

	var lecture_list = JSON.parse(ajax.responseText);

	while($("lecture").firstChild!=null)
		$("lecture").removeChild($("lecture").firstChild);
	for(var i=0; i<lecture_list.length; i++) {
		var option = document.createElement("option");
		option.innerHTML = lecture_list[i];
		$("lecture").appendChild(option);
	}

	while($("lecturenumber").firstChild!=null)
		$("lecturenumber").removeChild($("lecturenumber").firstChild);
	for(var i=0; i<lecture_list.length; i++) {
		var option = document.createElement("option");
		option.innerHTML = lecture_list[i];
		$("lecturenumber").appendChild(option);
	}

	new Ajax.Request("framework/function/loadFeedbackPage.php", {
		method: "post",
		parameters: {course: $F("course"), lecture: $F("lecture")},
		onSuccess: loadFeedbackMemo,
		onFailure: onFailed,
		onException: onFailed
	});

	new Ajax.Request(("../../framework/function/loadFeedbackPage.php"), {
		method: "post",
		parameters: {lecturecourse: $F("lecturecourse"), lecturenumber: $F("lecturenumber")},
		onSuccess: loadPageList,
		onFaiure: onFailed,
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
	var txt = ajax.responseText;

	while($("lecturenumber").firstChild!=null)
		$("lecturenumber").removeChild($("lecturenumber").firstChild);
	
	var lecture_list = JSON.parse(ajax.responseText);
	for(var i=0; i<lecture_list.length; i++) {
		var option = document.createElement("option");
		option.innerHTML = lecture_list[i];
		$("lecturenumber").appendChild(option);
	}
}

function loadPageList(ajax) {
	var txt = ajax.responseText;

	while ($("pagenumber").firstChild != null)
		$("pagenumber").removeChild($("pagenumber").firstChild);

	if (txt != "" && txt != "[]") {
		var page_list = JSON.parse(ajax.responseText);

		for (var i=0; i < page_list.length; i++) {
			var option = document.createElement("option");
			option.innerHTML = page_list[i];
			$("pagenumber").appendChild(option);
		}

		new Ajax.Request("../../framework/function/lectureNoteRead.php", {
			method: "post",
			parameters: {lecturecourse: $F("lecturecourse"), lecturenumber: $F("lecturenumber"), page: $F("pagenumber")},
			onSuccess: loadLectureNote,
			onFailure: onFailed,
			onException: onFailed
		});
	} else {
		while($("lecture_image").firstChild != null)
			$("lecture_image").removeChild($("lecture_image").firstChild);

		$("lecture_image").setStyle({backgroundImage: "none"});

		var p_element1 = document.createElement("p");
		p_element1.innerHTML = "Lecture Note이미지가 존재하지 않습니다.";
		$("lecture_image").appendChild(p_element1);

		var p_element2 = document.createElement("p");
		p_element2.innerHTML = "렉쳐노트를 업로드해주시기 바랍니다.";
		$("lecture_image").appendChild(p_element2);
	}
}

function loadLectureNote(ajax){
	while($("lecture_image").firstChild != null)
		$("lecture_image").removeChild($("lecture_image").firstChild);

	$("lecture_image").setStyle({backgroundImage: "none"});
	//alert(JSON.parse(ajax.responseText));
	var url = JSON.parse(ajax.responseText);
	//alert(url);
	//alert(JSON.parse(ajax.responseText));
	//$("iframe_upload").innerHTML = "";
	url = "lecturenote/"+url;
	$("lecture_image").setStyle({ backgroundImage: 'url('+url+')' });
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