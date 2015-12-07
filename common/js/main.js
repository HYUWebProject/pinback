document.observe("dom:loaded", function() {
	//initializing
	var pageArray = $$(".mainpage:not(#firstpage)");
	for(var i=0; i<pageArray.length; i++)
		pageArray[i].setStyle({display: "none"});

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
	$$(".navbar-brand")[0].observe("click", function(){window.location.reload();});
	var qnaArray = $$("#qna>li");
	for(var i=0; i<qnaArray.length; i++) {
		qnaArray[i].observe("click", function(){
			$("notepage").setStyle({display: "block"});
			var temparray = $$(".mainpage:not(#notepage)");
			for(var j=0; j<temparray.length; j++)
				temparray[j].setStyle({display: "none"});
		});
	}
	var feedbackArray = $$("#feedback>li");
	for(var i=0; i<feedbackArray.length; i++) {
		feedbackArray[i].observe("click", function(){
			$("feedbackpage").setStyle({display: "block"});
			var temparray = $$(".mainpage:not(#feedbackpage)");
			for(var j=0; j<temparray.length; j++)
				temparray[j].setStyle({display: "none"});
		});
	}
	$("manage").observe("click", function(){
		$("managepage").setStyle({display: "block"});
		var temparray = $$(".mainpage:not(#managepage)");
		for(var j=0; j<temparray.length; j++)
			temparray[j].setStyle({display: "none"});
	});
	$("announce").observe("click", function(){
		$("announcementpage").setStyle({display: "block"});
		var temparray = $$(".mainpage:not(#announcementpage)");
		for(var j=0; j<temparray.length; j++)
			temparray[j].setStyle({display: "none"});
	});
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