<?php 
	include 'functions.php';	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1251">
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>Hangman Game</title>
</head>
<body>
<div id="wrapper">
	<h1 class="headings">Hangman<h1>
	<h3 class="headings">Try and guess the name of the one of Capital Cities of Europe.</h3>
    <table id="main_table">
    	<tr>
		<?php
		$letters = range('A','Z');
		$user_letters = array();
		if((!isset($_POST['restart_game'])) && (!isset($_POST['submit']))){
			$number = 1;
		}
		if(isset($_POST['restart_game'])){
			$number = 1;
			restart_game();
		}	
		if(isset($_POST['submit'])){
			$letter = $_POST['letter_choice'];
			$user_letters[] = $letter;
			if(isset($_COOKIE['letters_cookie'])){
			
				process_last_letter_cookie($_COOKIE['letters_cookie'], $user_letters);
			}
			sendCookie($user_letters);
			$letters_from_city = from_cookie_to_array($_COOKIE['city_cookie']);
			
			if(isset($_COOKIE['letters_cookie'])){
				
				$letters_from_cookie = from_cookie_to_array($_COOKIE['letters_cookie']);
				$letters_from_cookie = array_merge($user_letters, $letters_from_cookie);
			}else{
				$letters_from_cookie = from_cookie_to_array($_POST['letter_choice']);
			}
			
			$result = array_intersect($letters_from_city, $letters_from_cookie);
			$win_flag = true;
			for($i = 0; $i < count($letters_from_city); $i++){
				
				if(array_key_exists($i, $result)){
					echo "<td>".$result[$i]."</td>";
				}else{
					echo "<td>--</td>";
					$win_flag = false;
				}
			}
			if($win_flag == true){
				header("Location: gamewon.php");
				exit;
			}
			$flag = false;	
			$number = $_POST['user'];
			for($j = 0; $j < count($letters_from_city); $j++){
				if($letters_from_city[$j] == $letter){
					$flag = true;
				}
			}
		}
		?>
		</tr>	
	</table>
	<form method="post">
	<input type="hidden" name="user" value="<?php
	
		if((isset($_POST['submit'])) && ($flag == false)){
		 	
		 	$number++;
			echo $number;
		}else{
			echo $number;
		}
	?>"/>
	<?php 
		echo "<img src=\"img/hang".$number.".jpg\">";
		if(isset($_COOKIE['city_cookie']) || isset($_POST['restart_game'])){
			
			echo "<select name=\"letter_choice\">";
			echo "<option value=\"--\">--</option>";
			if(isset($_COOKIE['letters_cookie']) && (!isset($_POST['restart_game']))){
				$letters_cookie = from_cookie_to_array($_COOKIE['letters_cookie']);
				$letters = array_diff($letters, $letters_cookie);//
				$letters = array_diff($letters, $user_letters);
				foreach($letters as $value){
					echo "<option value=\"".$value."\">".$value."</option>";
				}
			}else{
				$letters = array_diff($letters, $user_letters);
				foreach($letters as $value){
					echo "<option value=\"".$value."\">".$value."</option>";
				}
			}
			echo "</select>";
			echo "<input type=\"submit\" value=\"Try letter\" name=\"submit\"/>";
		}
	?>
		<input type="submit" value="New game" name="restart_game"/>
	</form>
	<?php
	if(isset($_POST['letter_choice']) && (!isset($_POST['restart_game']))){ 
		if(isset($_COOKIE['letters_cookie'])){

			$letters_from_cookie = from_cookie_to_array($_COOKIE['letters_cookie']);
			$letters_from_cookie = array_merge($user_letters, $letters_from_cookie);
			$letters_from_cookie = array_diff($letters_from_cookie, $letters_from_city); //new
			$letters_from_cookie = array_unique($letters_from_cookie);
			foreach($letters_from_cookie as $value){
				echo "<span>".$value."</span>";
				echo " ";
			}
		}else{
			$letters_from_cookie = array();
			$letters_from_cookie[] = $_POST['letter_choice'];
			$letters_from_cookie = array_diff($letters_from_cookie, $letters_from_city);//new
			foreach($letters_from_cookie as $value){
				echo "<span>".$value."</span>";
				echo " ";
			}
		}		
	}	
	if($number == 8){
		header("Location: gameover.php");
		exit;
	}
	?>
</div>	
</body>
</html>