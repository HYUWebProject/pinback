document.observe("dom:loaded", function(){
	$("submit").observe("click", function(){
		alert("click");
		new Ajax.Request("/framwork/function/join.php", {
			method: "post",
			parameters: {id: $F("id"), name: $F("name"),
					pw: $F("pw"), vocation: $F("joinform")["vocation"]},
			onSuccess: submit,
			onFailure: onFailed,
			onException: onFailed
		});
	});
	$("cancel").observe("click", cancel);
});

function submit(ajax) {
	alert(ajax.responseText);
	//alert("회원가입이 정상적으로 완료되었습니다.");
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