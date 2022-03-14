
<!doctype html>
<html>
<head>
	<title>Compare similar texts, articles, theses, essays, study papers, stories and news reports</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<link type="text/css" rel="stylesheet" href="styles.css" media="all">
</head>
<body>
	
	<header>
		<h1>Compare Texts</h1>
	</header>
	
	<main>

		<form action="result.php" method="post">
			
			<p>
			<label for="text1">
				Text 1
			</label><br>
			<textarea id="text1" name="text1" maxlength="10000" autofocus required></textarea>
			</p>
			
			<p>
			<label for="text2">
				Text 2
			</label><br>
			<textarea id="text2" name="text2" maxlength="10000" required></textarea>
			</p>
			
			<p>
			<label for="nearby-range">How far can a word be in the other text to be considered within the range?</label> &nbsp; <br>
			<input id="nearby-range" name="nearby-range" type="number" min="0" max="500" value="10"> &nbsp; words
			</p>

			<p>
			<input id="no-punctuation" name="no-punctuation" type="checkbox"> &nbsp; &nbsp; 
			<label for="no-punctuation">Compare texts without punctuation</label>
			</p>
			
			<p class="center">
				<input id="submit-button" name="submit-button" type="submit" value="Compare" class="button">
			</p>

		</form>

		<hr>

		<section>
			<h2>Why a text comparison tool?</h2>
			
			<p>
				As a publishing team, we have to work on several articles every day. It gets confusing when there are a couple of versions of an article to choose from. Reading both versions and comparing their contents to find out the differences is time consuming. So we needed a tool that could quickly tell us how these two versions of an article differ from each other. So we developed our own text comparison web application that tells us:
			</p>
			<ul>
				<li style="color:green">How many words are in the same position in both versions of the text.</li>
				<li style="color:teal">How many words are within range (nearby) in both texts.</li>
				<li style="color:chocolate">How many words are out of range (far) in both texts.</li>
				<li style="color:red">How many words don't exist in the other text at all.</li>
			</ul>
			<p>
				And all these words are shown in different colors which helps us quickly compare both texts and identify where the changes are. We found this tool useful and we wanted everyone to use it and benefit from it. 
				
				This text comparison service can be used for articles, theses, essays, study papers, stories, news reports and other types of texts. We hope that you find our text comparison tool useful. Good luck!
				
				
			</p>
			
			
		</section>
		

	</main>

	<?php include("footer.php"); ?>


</body>
</html>
