<?php

if (!isset($_POST["submit-button"])) {
	header("location:index.php");
} else {
	
	if (strlen($_POST["text1"]) > 10000 || strlen($_POST["text2"]) > 10000) {
		header("location:index.php");
	}
	
	$text1 = trim($_POST["text1"]);
	$text2 = trim($_POST["text2"]);
	
	$nearby_range = $_POST["nearby-range"];
	$no_punctuation = isset($_POST["no-punctuation"]) ? "on" : "";
}

$text1_colored = compare_text($text1, $text2, $nearby_range, $no_punctuation);
$text2_colored = compare_text($text2, $text1, $nearby_range, $no_punctuation);

?>

<!doctype html>
<html>
<head>
	<title>Words2Words.com - Result</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<link type="text/css" rel="stylesheet" href="styles.css" media="all">
	<script type="text/javascript" src="scripts.js"></script>
</head>
<body onload="highlight();return false;">

	<header>
		
	</header>
		
	<section id="setting-icons">
		<input type="range" min="1" max="1000" value="10" id="range-value" oninput="slider();return false;"><br>
		<a href="#" onclick="set_defaults();set_defaults();return false;"><img src="images/color-icon-01.png"></a> 
		<a href="#" onclick="set_defaults();set_colors_same_in();return false;"><img src="images/color-icon-02.png"></a> 
		<a href="#" onclick="set_defaults();set_colors('w-same');return false;"><img src="images/color-icon-03.png"></a> 
		<a href="#" onclick="set_defaults();set_colors('w-in');return false;"><img src="images/color-icon-04.png"></a> 
		<a href="#" onclick="set_defaults();set_colors('w-out');return false;"><img src="images/color-icon-05.png"></a> 
		<a href="#" onclick="set_defaults();set_colors('w-not');return false;"><img src="images/color-icon-06.png"></a>
		<img src="images/stat-icon-down.png" onclick="toggle_stats(this);return false;"> &nbsp; &nbsp; 
	</section>

	<main>

		<?php
			print "<div class='stats div-column'>" . $text1_colored[0] . "</div><div class='stats div-column'>" . $text2_colored[0] . "</div>";
			print "<div id='text1' class='div-column'>" . $text1_colored[1] . "</div><div id='text2' class='div-column'>" . $text2_colored[1] . "</div>";
		?>

		<div class="center clear-float">
			<br>
			<input id="back-button" name="back-button" type="button" value="Go back" class="button" onclick="window.history.back();">
		</div>

	</main>
		
	<?php include("footer.php"); ?>


</body>
</html>



<?php 

function compare_text($text_source, $text_target, $nearby_range, $no_punctuation) {

	$count_at_same_position = 0;
	$count_within_range = 0;
	$count_out_of_range = 0;
	$count_not_found = 0;
	
	// remove punctuation
	if ($no_punctuation == "on")  {
		$text_source = str_replace(["ّ", "ٖ", "ٰ", "’", "‘", "۔", "'", "،", "ُ", "ْ", "َ", "ِ", "ٗ", "ـ", "؟", "/", "\\", "ٌ", "ٔ", ")", "(", "“", "”", "!", ":", ";", "؎", "ؔ", "ً", "ٍ", "-", ",", ".", "_", "`", "!", "~", "@", "#", "$", "%", "^", "&", "*", "+", "=", "\\", "{", "}", "[", "]", "/", "<", ">", "'", "\"", "?", "|"], "", $text_source);
		$text_target = str_replace(["ّ", "ٖ", "ٰ", "’", "‘", "۔", "'", "،", "ُ", "ْ", "َ", "ِ", "ٗ", "ـ", "؟", "/", "\\", "ٌ", "ٔ", ")", "(", "“", "”", "!", ":", ";", "؎", "ؔ", "ً", "ٍ", "-", ",", ".", "_", "`", "!", "~", "@", "#", "$", "%", "^", "&", "*", "+", "=", "\\", "{", "}", "[", "]", "/", "<", ">", "'", "\"", "?", "|"], "", $text_target);
		// remove extra spaces
		while (strpos($text_source, "  ")) {
			$text_source = str_replace("  ", " ", $text_source);
		}
		while (strpos($text_target, "  ")) {
			$text_target = str_replace("  ", " ", $text_target);
		}
	} else {
		// replace linebreaks for now
		$text_source = str_replace("\n", " {|} ", $text_source);
		$text_target = str_replace("\n", " {|} ", $text_target);
		//$text_source = str_replace("\n", " ", $text_source);
		//$text_target = str_replace("\n", " ", $text_target);
	}

	// convert texts to arrays
	$words_source = explode(" ", $text_source);
	$words_target = explode(" ", $text_target);

	// trim all elements
	$words_source = array_map('trim', $words_source);
	$words_target = array_map('trim', $words_target);

	$words_source_length = sizeof($words_source);
	$words_target_length = sizeof($words_target);

	// make both arrays of same size
	if (sizeof($words_source) < sizeof($words_target)) {
		$words_source = array_pad($words_source, sizeof($words_target), "");
	} else if (sizeof($words_target) < sizeof($words_source)) {
		$words_target = array_pad($words_target, sizeof($words_source), ""); 
	}
	
	// make a copy of array to store colored words
	$words_source_colored = $words_source;

	// mark all words as out of range if found in target text (will be overriden by subsequent loops)
	for ($i = 0; $i < sizeof($words_source); $i++) {
		if (in_array($words_source[$i], $words_target) && !empty($words_source[$i])) {
			$words_source_colored[$i] = "<em class='w-out'>" . $words_source[$i] . "</em>";
		} else if (!empty($words_source[$i])) {
			$words_source_colored[$i] = "<em class='w-not'>" . $words_source[$i] . "</em>";
		}
	} 

	// mark words in range
	for ($i = 0; $i < sizeof($words_source); $i++) {
		
		for ($k = 0; $k <= $nearby_range; $k++) {
			if (isset($words_source[$i-$k]) && $words_source[$i-$k] == $words_target[$i]) { // prev range
				$words_source_colored[$i-$k] = "<em class='w-in'>" . $words_source[$i-$k] . "</em>";
			}
			// separate if-statement because if word found in previous range else-if will skip it in next range
			if (isset($words_source[$i+$k]) && $words_source[$i+$k] == $words_target[$i]) { // next range
				$words_source_colored[$i+$k] = "<em class='w-in'>" . $words_source[$i+$k] . "</em>";
			}
		}
	} 

	// mark words as same position
	for ($i = 0; $i < sizeof($words_source); $i++) {
		if (isset($words_source[$i]) && $words_source[$i] == $words_target[$i]) { // same position
			$words_source_colored[$i] = "<em class='w-same'>" . $words_source[$i] . "</em>";
		}
	}

	// stats
	for ($s = 0; $s < sizeof($words_source_colored); $s++) {
		if (strpos($words_source_colored[$s], "w-out")) {
			$count_out_of_range++;
		} else if (strpos($words_source_colored[$s], "w-in")) {
			$count_within_range++;
		} else if (strpos($words_source_colored[$s], "w-same")) {
			$count_at_same_position++;
		} else if (strpos($words_source_colored[$s], "w-not")) {
			$count_not_found++;
		}
	}
	
	$count_total = $words_source_length;

	$stats = "
		<span>$count_total</span>
		 Total words
		<br>

		<span class='w-same'>$count_at_same_position</span>
		At the same position in other text
		<br>

		<span class='w-in'>$count_within_range</span>
		Within range in other text
		<br>

		<span class='w-out'>$count_out_of_range</span>
		Out of range in other text
		<br>

		<span class='w-not'>$count_not_found</span>
		Do not exist in other text
		<br>"; 
	
	
	$text_colored = implode(" ", $words_source_colored);
	$text_colored = str_replace("{|}", "<br>", $text_colored);
	
	return array($stats, "<div class='words'>" . $text_colored . "</div>");

}

?>
