document.observe("dom:loaded", function() {
	$("findPW").observe("click", function(){
		var stdid = prompt("학번을 입력해주세요.", "");
		new Ajax.Request("/framework/function/resetpassword.php", {
			method: "post",
			parameters: {id: stdid},
			onSuccess: findPW,
			onFailure: onFailed,
			onException: onFailed
		});
	});
	$("join").observe("click", join);
	$("login").observe("click", function(){
		new Ajax.Request("/framework/function/login.php", {
			method: "post",
			parameters: {id: $F("id"), pw: $F("pw")},
			onSuccess: login,
			onFailure: onFailed,
			onException: onFailed
		});
	});
});

function findPW(ajax) {
	var text = ajax.responseText;
	var result = ajax.responseXML.getElementsByTagName("result")[0].firstChild.nodeValue;
	if(result == "success") {
		var temppw = ajax.responseXML.getElementsByTagName("password")[0].firstChild.nodeValue;
		alert("임의생성된 비밀번호는 \'"+temppw+"\' 입니다.");
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

function join() {
	window.open("signup.php");
}

function login(ajax) {
	var text = ajax.responseText;
	var result = ajax.responseXML.getElementsByTagName("result")[0].firstChild.nodeValue;
	if(result == "success")
		window.location.href = "main.php";
	else if(result == "selectionFailed")
		alert("잘못된 정보를 입력하셨습니다.");
	else if(result == "inputValidInformation")
		alert("ID와 PW를 모두 입력해 주시기 바랍니다.");
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


