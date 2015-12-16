
 function upload_init(){
 	$("upload_form").onsubmit = function(){
 		$("upload_form").target = "iframe_upload";
 		$("iframe_upload").onload = upload_finish;
 	}
 }

 function upload_finish(){

 	var result = frames["iframe_upload"].document.body.innerHTML;
 	var parse = eval("("+result+")");

 	if(parse.result = "SUCCESS"){
 		alert("success");
 	}
 	else
 		alert("error_code : "+ parse.error);
 }

 window.onload = upload_init;