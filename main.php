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
        <link rel="stylesheet" href ="./common/css/main.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="./common/js/jquery-1.11.3.min.js"></script>
		<script src="./common/js/bootstrap.min.js"></script>
		<script src="./common/js/prototype.js"></script>
		<script src="./common/js/scriptaculous.js"></script>
		<script src="./common/js/main.js"></script>
		<script src="./common/js/board_grade.js"></script>
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
		      <form class="navbar-form navbar-left" role="search">
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Search">
		        </div>
		        <button type="submit" class="btn btn-default">Submit</button>
		      </form>
		      <ul class="nav navbar-nav navbar-right">
		      	<li><a id="user_name"><?=$_SESSION['name']?>님,</a></li>
		      	<li><a id="logout" href="#">Logout</a></li>
		        <li><a id="announce" href="#">공지사항</a></li>
		        <li><a id="manage" href="#">계정관리</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>


		
		<!-- 맨 처음 pinback소개화면 -->
		<div id="firstpage" class="mainpage">
			<div id="notice">
				<p>
					PINBACK 은 학생들의 학업능력 향상을 위한
					<br/>오픈 O&amp;A 및 피드백서비스를 제공해주는 사이트 입니다.
				</p>
			</div>
		</div>
		<!-- 강의노트 질의응답페이 -->
		<div id="notepage" class="mainpage">
			<div id="post_note">
				<p>
					첫째, 강의노트
				</p>
			</div>
		</div>
		<!-- 피드백화면 -->
		<div id="feedbackpage" class="mainpage">
			<div id="feedback_nav">
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
			<div></div>
			<?php
			}
			?>
		</div>
		<!-- 계정관리 페이지 -->
		<div id="managepage" class="mainpage">
			<div id="management">
				<p>
					계정설정 화면.
					<button id="changepw">비밀번호 변경</button>
				</p>
			</div>
		</div>
		<!-- 공지사항 -->
		<div id="announcementpage" class="mainpage">
			<div id="announcement">
				<p>
					공지사항 페이지.
				</p>
			</div>	
		</div>
	    <footer>
        </footer>
    </body>
</html>