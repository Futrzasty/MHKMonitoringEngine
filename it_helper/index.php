<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../index.css" rel="stylesheet" type="text/css" />
<title>IT Helper WEB-APP</title>
</head>
<body style="cursor: initial;">

<form onSubmit="return findALL();">
<input type="text" id="user" name="testtext" />
<input type="button" onclick="findUser();" value="Find User" />
<input type="button" onclick="findName();" value="Find Name" />
<input type="submit" onclick="return findALL();" value="Find ALL" />
</form>

<span id="wynik1" style="cursor: text;"></span>
<span id="wynik2" style="cursor: text;"></span>

<script>
function findUser() {
	var TestVar = document.getElementById("user").value;
        span = document.getElementById("wynik1");
        span.innerHTML = "";
        span = document.getElementById("wynik2");
        span.innerHTML = "";

	var xmlhttp = new XMLHttpRequest();
	var url = "http://monitoring.mhk.local/JSON/getLOGUserbyName.php?" + TestVar;
	xmlhttp.onreadystatechange = function() {
	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		var myArr = JSON.parse(xmlhttp.responseText);
		myFunction(myArr);
	}
	}

	xmlhttp.open("GET", url, true);
	xmlhttp.send();


	function myFunction(arr) {
		var out = "";
		var i;
		for(i = 0; i < arr.length; i++) {
			out += arr[i]+ "<br/>";
		}
		span = document.getElementById("wynik1");
		span.innerHTML = out;
	}
}


function findName() {
	var TestVar = document.getElementById("user").value;
        span = document.getElementById("wynik1");
        span.innerHTML = "";
        span = document.getElementById("wynik2");
        span.innerHTML = "";	
	
	var xmlhttp = new XMLHttpRequest();
	var url = "http://monitoring.mhk.local/JSON/getLOGNamebyUser.php?" + TestVar;
	xmlhttp.onreadystatechange = function() {
	if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		var myArr = JSON.parse(xmlhttp.responseText);
		myFunction(myArr);
	}
	}

	xmlhttp.open("GET", url, true);
	xmlhttp.send();


	function myFunction(arr) {
		var out = "";
		var i;
		for(i = 0; i < arr.length; i++) {
			out += arr[i]+ "<br/>";
		}
		span = document.getElementById("wynik2");
		span.innerHTML = out;
	}
}

function findALL() {
	findUser();
	findName();
	return false;


}


</script>


</body>
</html>
