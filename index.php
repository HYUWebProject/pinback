<!DOCTYPE html>
<html>
    <head>
        <title>로그인 페이지</title>
        <meta charset="utf-8" >
        <link rel="stylesheet" href="/common/css/index.css"/>
        <link rel="stylesheet" href="/common/css/font-awesome.min.css">
        <link rel="stylesheet" href="/common/css/bootstrap.min.css">
  		<link rel="stylesheet" href="/common/css/bootstrap-theme.min.css">
        <script src="http://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js" type="text/javascript"></script>
        <script src="/common/js/login.js" type="text/javascript"></script>
    </head>
    <body>
		<header>
        </header>
    	<div id="login_logo">
    	<img src = "/resource/image/loginlogo.png" alt="longlogo" width="450px" height ="200" />
		</div>
        <div id="login_window">
	        <form name="login_form" method="post" font="12px">
	        	<br />
	  	       	<br />
	            <p class="id_pw"><input id="id" class="id_pw_input" type="text" name="user_id" placeholder =" ID "/></p><br />
	            <p class="id_pw"><input id="pw" class="id_pw_input" type="password" name="user_pass" placeholder =" Password "/></p><br />
	            <br />
	            <button id="findPW" class="btn btn-info">비번찾기</button>
				<button id="join" class="btn btn-info">회원가입</button>
				<button id="login" class="btn btn-info">로그인</button>
	        </form>    
	    </div>
	    <footer>
        </footer>
    </body>
</html>
