var stats_on = 0;
var stats_display = "";
function toggle_stats(element) {
	if (stats_on == 0) {
		stats_on = 1;
		stats_display = "block";
		element.src = "images/stat-icon-up.png";
	} else {
		stats_on = 0;
		stats_display = "none";
		element.src = "images/stat-icon-down.png";
	}
	
	var stats_classes = document.getElementsByClassName("stats");
	for (var i = 0; i < stats_classes.length; i++) {
		stats_classes[i].style.display = stats_display;
	}

}



function set_defaults() {

	var classes = document.getElementsByClassName("w-same");
	for (var i = 0; i < classes.length; i++) {
		classes[i].style.color = "#007B00";
	}
	classes = document.getElementsByClassName("w-in");
	for (var i = 0; i < classes.length; i++) {
		classes[i].style.color = "teal";
	}
	classes = document.getElementsByClassName("w-out");
	for (var i = 0; i < classes.length; i++) {
		classes[i].style.color = "chocolate";
	}
	classes = document.getElementsByClassName("w-not");
	for (var i = 0; i < classes.length; i++) {
		classes[i].style.color = "red";
	}

}

function set_colors_same_in() { // words at same-position and in-range

	// gray out all text
	var classes = document.getElementsByTagName("em");
	for (var i = 0; i < classes.length; i++) {
		classes[i].style.color = "#CCC";
	}

	classes = document.getElementsByClassName("w-same");
	for (var i = 0; i < classes.length; i++) {
		classes[i].style.color = "#007B00";
	}
	classes = document.getElementsByClassName("w-in");
	for (var i = 0; i < classes.length; i++) {
		classes[i].style.color = "teal";
	}
}

function set_colors(type) {

	// gray out all text
	var classes = document.getElementsByTagName("em");
	for (var i = 0; i < classes.length; i++) {
		classes[i].style.color = "#CCC";
	}

	// set color for passed type
	var color = "";
	if (type == "w-same") {
		color = "#007B00";
	} else if (type == "w-in") {
		color = "teal";
	} else if (type == "w-out") {
		color = "chocolate";
	} else if (type == "w-not") {
		color = "red";
	}

	classes = document.getElementsByClassName(type);
	for (var i = 0; i < classes.length; i++) {
		classes[i].style.color = color;
	}

}

function highlight() {
	// text 1
	text1_ems = document.getElementById('text1').getElementsByTagName('em');
	for(var i = 0; i < text1_ems.length; i++) {
		text1_ems[i].addEventListener("mouseover", function(){
			this.style.backgroundColor = "yellow";
			
			text2_ems = document.getElementById('text2').getElementsByTagName('em');
			for(var k = 0; k < text2_ems.length; k++) {
				if (text2_ems[k].innerText == this.innerText) {
					text2_ems[k].style.backgroundColor = "yellow";
				}
			}
			
			
		});
		text1_ems[i].addEventListener("mouseout", function(){
			this.style.backgroundColor = "transparent";

			text2_ems = document.getElementById('text2').getElementsByTagName('em');
			for(var k = 0; k < text2_ems.length; k++) {
				text2_ems[k].style.backgroundColor = "transparent";
			}
		});

	}
	
	// text 2
	text2_ems = document.getElementById('text2').getElementsByTagName('em');
	for(var i = 0; i < text2_ems.length; i++) {
		text2_ems[i].addEventListener("mouseover", function(){
			this.style.backgroundColor = "yellow";
			
			text1_ems = document.getElementById('text1').getElementsByTagName('em');
			for(var k = 0; k < text1_ems.length; k++) {
				if (text1_ems[k].innerText == this.innerText) {
					text1_ems[k].style.backgroundColor = "yellow";
				}
			}
			
			
		});
		text2_ems[i].addEventListener("mouseout", function(){
			this.style.backgroundColor = "transparent";

			text1_ems = document.getElementById('text1').getElementsByTagName('em');
			for(var k = 0; k < text1_ems.length; k++) {
				text1_ems[k].style.backgroundColor = "transparent";
			}
		});

	}
	
}




function slider() {
	
	var range = document.getElementById('range-value').value;
	
	// create word arrays
	var text1_ems = document.getElementById('text1').getElementsByTagName('em');
	var text1_words = new Array(text1_ems.length);
	for (var i = 0; i < text1_ems.length; i++) {
		text1_words[i] = text1_ems[i].innerText;
	}

	var text2_ems = document.getElementById('text2').getElementsByTagName('em');
	var text2_words = new Array(text2_ems.length);
	for (var i = 0; i < text2_ems.length; i++) {
		text2_words[i] = text2_ems[i].innerText;
	}

	text1_words_colored = text1_words.slice();
	text2_words_colored = text2_words.slice();

// -------------------------------------------------------------- text 1

	// out of range
	for (var i = 0; i < text1_words.length; i++) {
		if (in_array(text1_words[i], text2_words)) {
			text1_words_colored[i] = "<em class='w-out'>" + text1_words[i] + "</em>";
		} else {
			text1_words_colored[i] = "<em class='w-not'>" + text1_words[i] + "</em>";
		}
	}

	// in range
	for (var i = 0; i < text1_words.length; i++) {
		for (var k = 0; k < range; k++) {
			s = (i - k);
			if (s > 0 && text1_words[s] == text2_words[i]) {
				text1_words_colored[s] = "<em class='w-in'>" + text1_words[s] + "</em>";
			}
			s = (i + k);
			if (s < text1_words.length-1 && text1_words[s] == text2_words[i]) {
				text1_words_colored[s] = "<em class='w-in'>" + text1_words[s] + "</em>";
			}
		}
	}

	// same position
	for (var i = 0; i < text1_words.length; i++) {
		if (text1_words[i] == text2_words[i]) {
			text1_words_colored[i] = "<em class='w-same'>" + text1_words[i] + "</em>";
		}
	}
	
	
// -------------------------------------------------------------- text 2

	// out of range
	for (var i = 0; i < text2_words.length; i++) {
		if (in_array(text2_words[i], text1_words)) {
			text2_words_colored[i] = "<em class='w-out'>" + text2_words[i] + "</em>";
		} else {
			text2_words_colored[i] = "<em class='w-not'>" + text2_words[i] + "</em>";
		}
	}

	// in range
	for (var i = 0; i < text2_words.length; i++) {
		for (var k = 0; k < range; k++) {
			s = (i - k);
			if (s > 0 && text2_words[s] == text1_words[i]) {
				text2_words_colored[s] = "<em class='w-in'>" + text2_words[s] + "</em>";
			}
			s = (i + k);
			if (s < text2_words.length-1 && text2_words[s] == text1_words[i]) {
				text2_words_colored[s] = "<em class='w-in'>" + text2_words[s] + "</em>";
			}
		}
	}

	// same position
	for (var i = 0; i < text2_words.length; i++) {
		if (text2_words[i] == text1_words[i]) {
			text2_words_colored[i] = "<em class='w-same'>" + text2_words[i] + "</em>";
		}
	}
	
	
	document.getElementById('text1').innerHTML = text1_words_colored.join(' ');
	document.getElementById('text2').innerHTML = text2_words_colored.join(' ');
	
	
	
	
	
	highlight();
	// console.log(text1_words_colored);

}


function in_array(value, target_array) {
	
	for (var i = 0; i < target_array.length; i++) {
		if (value == target_array[i]) {
			return true;
		}
	}
	
	return false;
	
}
