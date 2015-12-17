<?php
require_once("framework/framework.php");
?>
<!DOCTYPE html>
<?php
	if(!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
		echo "<meta http-equiv='refresh' content='0;url=/index.php'>";
		echo "<script>alert(\"로그인 정보가 없습니다. 로그인창으로 이동합니다.\");</script>";
		exit;
	}
	$pin_id = $_SESSION["id"];
	$pin_name = $_SESSION["name"];
	$pin_level = $_SESSION["level"];
	$pin_point = $_SESSION["point"];
?>
<html>
    <head>
        <title>메인 페이지</title>
        <meta charset="utf-8" >
        <link rel="stylesheet" href="./common/css/main.css"/>
        <link rel="stylesheet" href="./common/css/font-awesome.min.css">
        <link rel="stylesheet" href="./common/css/bootstrap.min.css">
  		<link rel="stylesheet" href="./common/css/bootstrap-theme.min.css">
		<link href="./common/css/contextMenu.css" rel="stylesheet" type="text/css" />
		<!-- Latest compiled and minified JavaScript -->
		<script src="./common/js/jquery-1.11.3.min.js"></script>
		<script src="./common/js/bootstrap.min.js"></script>
		<script src="./common/js/prototype.js"></script>
		<script src="./common/js/scriptaculous.js"></script>
		<script src="./common/js/main.js"></script>
		<script src="./common/js/board_grade.js"></script>
		<script src="./common/js/lecturenote_label.js" type="text/javascript"></script> <!-- lecture note label 추가-->
		<script src="./common/js/upload.js" type="text/javascript"></script>



    </head>
    <body>
		<header>
			<div id="login_logo">
			<img src ="./resource/image/loginlogo.png" alt = "loginlogo" width="320px" height="80px" /> 
		</div>
        </header>


		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		     <a class="navbar-brand" href="#">PinBack</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <!--<li class="active"><a href="#"> <span class="sr-only">(current)</span></a></li>
		        <li><a href="#">Link</a></li> -->
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> 학년별 Q & A <span class="caret"></span></a>
		          <ul id="qna" class="dropdown-menu" role="menu">
		            <li><a href="#">4학년</a></li>
		            <li><a href="#">3학년</a></li>
		            <li><a href="#">2학년</a></li>
		            <li><a href="#">1학년</a></li>
		          </ul>
		        </li>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">학년별 Feedback <span class="caret"></span></a>
		          <ul id="feedback" class="dropdown-menu" role="menu">
		            <li><a href="#">4학년</a></li>
		            <li><a href="#">3학년</a></li>
		            <li><a href="#">2학년</a></li>
		            <li><a href="#">1학년</a></li>
		          </ul>
		        </li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		      	<li><a id="user_name"><?=$_SESSION['name']?>님,</a></li>
		      	<li><a id="logout" href="#">Logout</a></li>
		        <li><a id="changepw" href="#">비밀번호 변경</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<!-- 맨 처음 pinback소개화면 -->
		<div id="firstpage" class="mainpage">
			<div id="notice">
				<img src ="./resource/image/firstpage.png" type ="image/png" alt = "design" width="1100px" height="1000px" />
			</div>
		</div>
		<!-- 강의노트 질의응답페이 -->
		
		<form id= "upload_form" method="post" enctype="multipart/form-data" action="./framework/function/upload.php">
			<div id="notepage" class="mainpage">
				<div id="post_note" class="select_nav">				
					Course : 
					<select id="lecturecourse" name = "lecturecourse">
					</select>

					Lecture # : 
					<select id="lecturenumber" name = "lecturenumber">
					</select>

					Page # :
					<select id="pagenumber" name="pagenumber">
					</select>
					</br>
					input page #:
					<input type = "text" name ="input_page" id = "input_page"/> 
		    		<input type="file" name="file_name" id="images" multiple />
		    		<button type="submit" id="uploadbutton">Upload Files!</button></br>
		    		<iframe id = "iframe_upload" name ="iframe_upload" src ="" width="0" height="0" frameborder="0"> </iframe>
				</div>
				
				<div id = "lecture_image">
				</div>
			</div>
		</form>
		

		<!-- 피드백화면 -->
		<div id="feedbackpage" class="mainpage">
			<div id="feedback_nav" class="select_nav">
				Course : 
				<select id="course">
				</select>
				Lecture # : 
				<select id="lecture">
				</select>
				<button type="submit" id="new_memo" class="btn btn-default" >메모지 만들기</button>
			</div>
			<?php
			for($i =0; $i<25; $i++) {
			?>
			<div id="div_<?=$i?>"class="feedback_div"></div>
			<?php
			}
			?>
		</div>
		<!-- 계정관리 페이지 -->
		<div id="managepage" class="mainpage">
			<div id="management">
				<div class="manage_div">
					<button id="changepw">비밀번호 변경</button>
				</div>
			</div>
		</div>
		<!-- 컨텍스트 메뉴 -->
		<div id="contextMenu" class="dropdown clearfix">
			<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
				<li id="write"><a tabindex="-1" href="#">Write Note</a></li>
			</ul>
		</div>
	    <footer>
        </footer>
    </body>
</html>