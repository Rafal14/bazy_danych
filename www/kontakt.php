<?php

session_start();


if (isset($_SESSION['logged']) && $_SESSION['logged']==true) {
	header('Location: account.php');
	exit();
}


?>


<!doctype html>
<html lang="pl">
	<head>
	<meta charset="utf-8" />
	<title>System rejestracji czasu pracy pracowników</title>
	<meta name="descricption" content="Baza danych czasu pracy pracowników" />
	<meta name="keywords" content="baza, dane" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="author" content="Rafał Januszewski, Wojciech Suszczewicz" />
	
	
	
	<script type="text/javascript">
	function pomiarCzasu()
	{
		var today = new Date();
		var day = today.getDate();
		var month = today.getMonth()+1;
		var year = today.getFullYear();

		var hour = today.getHours();
		if ( hour<10) hour="0"+hour;

		var minute = today.getMinutes();
		if ( minute<10) minute="0"+minute;

		var second = today.getSeconds();
		if (second<10) second="0"+second;
	  
		document.getElementById("clock").innerHTML = 
		day+"/"+month+"/"+year+"<br/>"+hour+":"+minute+":"+second;

		setTimeout("pomiarCzasu()", 1000);
		}

	</script>
	
	

	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Lato:400,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

</head>

<body onload="pomiarCzasu()">

	<div id="container">

		<div id="logo">
			System rejestracji czasu pracy pracowników
		</div>

		<div id="menu">
			<div class="option"><a href="index.php" style="text-decoration : none; color : #FFFFFF;">Strona główna</a></div>
			<div class="option"><a href="kontakt.php" style="text-decoration : none; color : #FFFFFF;">Kontakt</a></div>
			<div style="clear:both;"></div>
		</div>

		<div id="topbar">
			<div id="topbarL">
				<img src="work.png" />
			</div>
			<div id="topbarR">
				<span class="bigtitle">Kontakt</span>
				<div style="height: 15px;"></div>
				 Proszę kontaktować się w godzinach pracy firmy.
			</div>
			<div style="clear:both;"></div>
		</div>

		<div id="sidebar">
		<div class="optionL"><a href="index.php" style="text-decoration : none; color : #000000;">Strona główna</a></div>
		<div class="optionL"><a href="kontakt.php" style="text-decoration : none; color : #000000;">Kontakt</a></div>
		<br/><br/>
		<div id="clock" align=center></div>
		</div>

		<div id="content">
					<span class="bigtitle">Numery kontaktowe</span>

					<div class="dottedline"></div>

					Infolinia (65) 523 41 56

					<br /><br />
					Dyrektor 256 321 458

					<br /><br />
					
					Prezes 789 215 364
				</div>

			  </form>
			  </div>

		<div id="footer">

      System bazodanowy wykonali: Rafał Januszewski i Wojciech Suszczewicz.
		</div>

	</div>

</body>
</html>
