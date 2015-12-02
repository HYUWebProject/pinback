<!DOCTYPE html>
<html>
    <head>
        <title>회원가입 페이지</title>
        <meta charset="utf-8" >
        <link rel="stylesheet" href ="/common/css/register.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
  		<script src="http://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js" type="text/javascript"></script>
    	<script src="/common/js/join.js" type="text/javascript"></script>
    </head>
    <body>
		<header>
			<img src="/resource/image/loginlogo.png" alt="logo" width="100px" height="60px" />
        </header>
    	<div id="join_logo">
    		<p>회 원 가 입</P>
    	</div>
        <div id="join_window">
	        <form id="joinform" name="join_form" method="post" font="12px">
	        	
	        	<p><input id="name" class="id_pw_input" type="text" name="user_name" placeholder= " name "/></p>
	            <p><input id="id" class="id_pw_input" type="text" name="user_id" placeholder= " student ID "/></p>
	            <p><input id="pass" class="id_pw_input" type="password" name="user_pass" placeholder= " Password " /></p>
	            <div class="option">
	            	교수<input type="radio" name="vocation" value="professor"/>
	            	학생<input type="radio" name="vocation" value="student"/>
	            </div>
	      		  </br>
	            <button id="submit" class="btn btn-info">제 출</button>
				<button id="cancel" class="btn btn-info">취 소</button>
	        </form>    
	    </div>
	    <footer>
        </footer>
    </body>
</html>
