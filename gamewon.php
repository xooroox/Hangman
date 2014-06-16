<?php 
	include 'functions.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1251">
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>You won!</title>
</head>
<body>
	<div id="wrapper">
		<h1 class="headings">Hangman<h1>
		<h3 class="headings">Try and guess the name of the one of Capital Cities of Europe.</h3>
		<img src="img/hang9.jpg"/>
		<form id="form" method="post">
		<?php
		if($_SERVER['HTTP_REFERER']){ //$_COOKIE['city_cookie']
			echo "<h3>Congratulations the sity is ".$_COOKIE['city_cookie']."!</h3>";
			echo "<input type=\"submit\" value=\"Try again!\" name=\"try_again\"/>";
			if(isset($_POST['try_again'])){
				try_again();
			}
		}else{
			header("Location: index.php");
			exit;
		}	
		?>
		</form>
	</div>
</body>
</html>