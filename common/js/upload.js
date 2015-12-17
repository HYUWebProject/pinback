
 function upload_init(){
 	$("upload_form").onsubmit = function(){
 		$("upload_form").target = "iframe_upload";
 		$("iframe_upload").onload = upload_finish;
 	}
 }

 function upload_finish(){

 	var result = frames["iframe_upload"].document.body.innerHTML;
 	alert(result);
 	var parse = eval("("+result+")");

 	if(parse.result == "SUCCESS"){
 		alert("upload success");
 	}
 	else
 		alert("Input page number and file. \nerror_code : "+ parse.error);
}
 window.onload = upload_init;
