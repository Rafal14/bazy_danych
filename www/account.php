<?php

session_start();

//przekierowanie na index.php dla niezalogowanego użytkownika
if (!isset($_SESSION['logged'])) {
	header('Location: index.php');
	exit();
}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>System rejestracji czasu pracy pracowników </title>
	<meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1"/>


	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Lato:400,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

</head>

<body>

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
				<span class="bigtitle">Jak to działa?</span>
				<div style="height: 15px;"></div>
				 Używając swojego loginu oraz hasła zaloguj się na swoje konto, które umożliwi Ci rejestrację Twojego czasu pracy oraz dostarczy niezbędnych informacji
			</div>
			<div style="clear:both;"></div>
		</div>

		<div id="sidebar">
		<div class="optionL"><a href="index.php" style="text-decoration : none; color : #000000;">Strona główna</a></div>
		<div class="optionL"><a href="kontakt.php" style="text-decoration : none; color : #000000;">Kontakt</a></div>
		</div>

		<div id="content">
			<span class="bigtitle">Konto administratora</span>

			
		<br/><br/>
		<br/><br/>
			
		<!--  Po naciśnięciu przycisku wyświetla się lista pracowników      --> 
		<form action="employees.php" method="post" size="15"/>
		<input type="submit" value="Lista pracowników">
		</form>	

		<br/>
		<!--  Po naciśnięciu przycisku wyświetla się lista stanowisk       --> 
		<form action="jobs.php" method="post" />
		<input type="submit" value="Lista stanowisk">
		</form>
		
		<br/>
		<!--  Po naciśnięciu przycisku wyświetla się lista zdarzeń       -->
		<h4>Wyświetl listę wejść i wyjść pracowników</h4>
		<form action="occurrences.php" method="post" />
		Nr pracownika: <br/>
		<input type="text" name="empid" size="12" maxlength="2">
		<input type="submit" value="Wyświetl">
		</form>

		<br/>

		<!--  Po naciśnięciu przycisku zostanie obliczony czas pracy       --> 
		<h4>Oblicz czas pracy pracowników</h4>
		<form action="count.php" method="post" />
		Od:<input type="text" name="od" size="16" maxlength="16">
		Do:<input type="text" name="do" size="16" maxlength="16">
		<input type="submit" value="Oblicz">
		</form>
		
		
		<?php
		
		if (isset($_SESSION['blad_data'])) {
			echo $_SESSION['blad_data'];
			unset($_SESSION['blad_data']);
			header('Refresh: 10; URL=account.php');      //odśwież po 10s
		}
		
		?>
		
		
		<br/>	
		
		<!--  Po naciśnięciu przycisku zostanie wyświetlona lista błędów       --> 
		<h4>Wyświetl listę błędów</h4>
		<form action="warnings.php" method="post" />
		Nr pracownika: <br/>
		<input type="text" name="emp" size="12" maxlength="2">
		<input type="submit" value="Wyświetl">
		</form>

		<?php

		echo '<br/><br/>';
		echo '<a href="logout.php">Wyloguj się</a>';

		?>


			
		</div>
		

		<div id="footer"> 
		
		
		System bazodanowy wykonali: Rafał Januszewski i Wojciech Suszczewicz.  </div>

	</div>

</body>
</html>
