document.observe("dom:loaded", function() {
	//$("findPW").observe("click", findPW);
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

function findPW() {
	//how to:
	//popup을 통해서 학번을 입력받는다.
	//임의의 비밀번호를 제공한다.
	var stdid = prompt("학번을 입력해주세요.", "");
	if(true/* stdid를 db에서 select해본다. */) {
		//찾았다면 해당 계정의 비밀번호를 임의의 6자리의 알파벳대문자와 숫자로 지정한뒤
		var temppw = randomStr();
		//해당번호를 hashing한 값으로 회원테이블의 PW attribute를 update한다.
		//update(~~~~~);
		//임의생성된 비밀번호를 alert를 통해서 알려준다.
		alert("임의생성된 비밀번호는 \'"+temppw+"\' 입니다.");
	} else {
		alert("입력하신 학번은 존재하지 않는 회원입니다.");
	}
}

function join() {
	//alert("join is clicked");
	window.open("signup.php");
}

function login(ajax) {
	var text = ajax.responseText;
	var result = ajax.responseXML.getElementsByTagName("result")[0].firstChild.nodeValue;
	if(result == "success")
		window.location.assign("main.php");
	else if(result == "selectionFailed")
		alert("잘못된 정보를 입력하셨습니다.");
	else if(result == "inputValidInformation")
		alert("ID와 PW를 모두 입력해 주시기 바랍니다.");
}

function randomStr() {
	var str = "";
	var charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	for (var i=0; i<8; i++)
        str += charset.charAt(Math.floor(Math.random() * charset.length));
    return str;
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


