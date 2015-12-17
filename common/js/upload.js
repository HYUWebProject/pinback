
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
<<<<<<< HEAD
 		alert("error_code : "+ parse.error);
 }
=======
 		alert("Input page number and file. \nerror_code : "+ parse.error);
 }

 window.onload = upload_init;
>>>>>>> ae958d63c840c25871d13ab8298f56c34ea0b00b
