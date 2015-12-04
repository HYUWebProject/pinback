document.observe("dom:loaded", function(){
	$("submit").observe("click", function(){
		//alert("click");
		try {
			var vocation = Form.getInputs('joinform','radio','vocation').find(function(radio) { return radio.checked; }).value;	
		} catch(err) {
			alert("신분을 입력하세요.");
			return;
		}
		new Ajax.Request("/framework/function/join.php", {
			method: "post",
			parameters: {id: $F("id"), name: $F("name"),
					pass: $F("pass"), vocation: vocation},
			onSuccess: submit,
			onFailure: onFailed,
			onException: onFailed
		});
	});
	$("cancel").observe("click", cancel);
});

function submit(ajax) {
	var result = ajax.responseXML.getElementsByTagName("result")[0].firstChild.nodeValue;
	if(result == "success") {
		alert("회원가입이 정상적으로 완료되었습니다.");
		window.close();
	} else if(result == "fail") {
		alert("모든 정보를 입력하여 주시기 바랍니다.");
	} else if(result == "SQLException") {
		alert("정보를 정확하게 입력해주시기 바랍니다.\nID:10자리수\nName:10byte내");
	}
}

function cancel() {
	window.close();
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