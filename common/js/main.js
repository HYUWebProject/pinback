document.observe("dom:loaded", function() {
	$("post_note").setStyle({
		visibility: "hidden"
	});
	$("post_feedback").setStyle({
		visibility: "hidden"
	});
	$("manage").observe("click", function() {
		var id = prompt("학번을 입력해주세요.", "");
		new Ajax.Request("../../framework/function/findID.php", {
			method: "post",
			parameters: {id: id},
			onSuccess: successfind,
			onFailure: onFailed,
			onException: onFailed
		});
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