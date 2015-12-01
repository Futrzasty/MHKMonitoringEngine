<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>IT Helper WEB-APP</title>
<style type="text/css">
	body {
		color: white;
		background-color: #303030;
		font-family: Helvetica, sans-serif;
	}

	a:link {
		text-decoration: none;
		color: skyblue;
	}

	a:visited {
		text-decoration: none;
		color: skyblue;
	}

	a:hover {
		text-decoration: underline;
		color: skyblue;
	}

	a:active {
		text-decoration: none;
		color: skyblue;
	}
	fieldset {
		border: none;
		margin: 0;
		padding: 0;
	}
	p {
		margin: 0;
		padding: 0;
	}
</style>
</head>
<body>

<form onSubmit="return findALL();" action="">
	<fieldset>
		<input type="text" id="user" name="testtext" title="" />
		<input type="button" onclick="findUser();" value="Find User" />
		<input type="button" onclick="findName();" value="Find Name" />
		<input type="submit" onclick="return findALL();" value="Find ALL" />
	</fieldset>
</form>
<p>
	<br/>
	<span id="wynik1" style="cursor: text;"></span>
	<br/>
	<span id="wynik2" style="cursor: text;"></span>
</p>
<script type="application/javascript">
function findUser() {
	var TestVar = document.getElementById("user").value;
        var span = document.getElementById("wynik1");
        span.innerHTML = "";
        span = document.getElementById("wynik2");
        span.innerHTML = "";

	var xmlhttp = new XMLHttpRequest();
	var url1 = window.location.href;
	var arr = url1.split("/");
	var hostname = arr[0] + "//" + arr[2];
	var url = hostname+"/JSON/getLOGUserbyName.php?" + TestVar;
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var myArr = JSON.parse(xmlhttp.responseText);
			myFunction(myArr);
		}
	};

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
        var span = document.getElementById("wynik1");
        span.innerHTML = "";
        span = document.getElementById("wynik2");
        span.innerHTML = "";	
	
	var xmlhttp = new XMLHttpRequest();
	var url1 = window.location.href;
	var arr = url1.split("/");
	var hostname = arr[0] + "//" + arr[2];
	var url = hostname+"/JSON/getLOGNamebyUser.php?" + TestVar;
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var myArr = JSON.parse(xmlhttp.responseText);
			myFunction(myArr);
		}
	};

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
