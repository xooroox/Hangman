<?php
function sendCookie($arr){
	if(count($arr) > 0){
		
		$cookie_value = implode(",", $arr);
		setcookie('letters_cookie', $cookie_value, time() + 1800);
	}
}
function process_last_letter_cookie($cookie, &$user_letters){
	
	$last_letter_arr = explode(",", $cookie);
	foreach($last_letter_arr as $value){
		
		$user_letters[] = $value;
	}
}
function from_cookie_to_array($cookie){
	
	$letter_arr = str_split($cookie);
	return $letter_arr;
}
function restart_game(){
		$cities = array( "Athens", "Bern", "Budapest", "Bratislava", "Brussels", "Belgrad", "Bucharest",
				"Berlin", "Copenhagen", "Dublin","Helsinki", "Kiev", "Lisbon", "London", "Madrid",
				"Moscow", "Monaco", "Oslo", "Paris", "Prague", "Rome", "Stockholm", "Sofia", "Tirana",
				"Vienna", "Warsaw", "Zagreb");
		$random = rand(0, 5);
		$current_city = strtoupper($cities[$random]);
		$city_letters = str_split($current_city);
	
		foreach ($city_letters as $value){
			echo "<td>--</td>";
		}
		setcookie('city_cookie', $current_city, time() + 1800);
		setcookie('letters_cookie', '',time() -1800);
}
function try_again(){
	setcookie('letters_cookie', '',time() -1800);
	setcookie('city_cookie', '',time() -1800);
	header("Location: index.php");
	exit;
}
?>