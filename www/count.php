<?php


session_start();


if (!isset($_SESSION['logged'])) {
	header('Location: index.php');
	exit();
}



require_once 'connect.php'; 


$conn = oci_connect($db_username, $db_passwd, $db_name, $type_coding);


if (!$conn) {
	$msg = oci_error();
	echo $msg['message'], "\n";
}
else {
	$od      = $_POST['od'];
	$do      = $_POST['do'];
	
	$dat_od    = date_create($od);
	$dat_do    = date_create($do);
	
	if ( $dat_od == false || $dat_do == false )  {
		$_SESSION['blad_data']='<span style="color:red">Błąd. Nieprawidłowy format daty</span>';
		header('Location: account.php');
		oci_close($conn);
		exit();	
	}
	else {

		if ($dat_do < $dat_od) {
			$_SESSION['blad_data']='<span style="color:red">Błąd. Data do musi być późniejsza niż data od</span>';
			header('Location: account.php');
			oci_close($conn);
			exit();	
		}
	}
	
	//$query  = "select count_time(" . $e  . ") from dual";
	if ( empty($od) && empty($do) ) {
		$q = "select employ_id, login_date, logout_date, ((extract(second from logout_date-login_date))  + ";
		$q = $q . " extract(minute from logout_date-login_date)*60 + extract(hour from logout_date-login_date)*60*60";
		$q = $q . " + extract(day from logout_date-login_date)*24*60*60 )";
		$q = $q . " from occurrences order by login_date desc";
		$opis = "<h3>Czas pracy pracowników</h3>";
	}
	else {
		$q = "select employ_id, login_date, logout_date, ((extract(second from logout_date-login_date))  + ";
		$q = $q . " extract(minute from logout_date-login_date)*60 + extract(hour from logout_date-login_date)*60*60";
		$q = $q . " + extract(day from logout_date-login_date)*24*60*60 )";
		$q = $q . " from occurrences where login_date > (select to_timestamp( '$od' ,'YYYY-MM-DD HH24:MI:SS') from dual) ";
		$q = $q . " and logout_date < (select to_timestamp( '$do' ,'YYYY-MM-DD HH24:MI:SS') from dual) order by login_date desc";
		$opis = "<h3>Czas pracy pracowników  od " . $od . " do " . $do . " </h3>";
	}
		
	$statid = oci_parse($conn, $q);
	oci_execute($statid);
		
	echo $opis;
		
	$ident = array(0, 0, 0, 0, 0, 0, 0, 0, 0);

	while ($row = oci_fetch_array($statid, OCI_RETURN_NULLS+OCI_ASSOC)) {
			
		$i = 0;   $poz = 0;
		foreach ($row as $it) {
			if ($i == 0) { $poz = $it; }
			if ($i == 3) { $it = $it/3600;  $it = round($it,4); $ident[$poz] += $it; $it = $ident[$poz]; }        //przeskalowanie na godzine
			$i++;
		}
	}
	
	// Przechwycenie każdego wiersza do tworzonej tabli
	print '<table border="1" cellpading="10" cellspacing="0">';
	print '<tr><th>Id pracownika</th><th>Czas pracy [h]</th></tr>';
	for ($y=1; $y < 9; $y++) {
		
		if ( $ident[$y] != 0 ) {
			print '<tr>';
			print '<td align=center>' . $y . '</td>';
			print '<td align=center>' . $ident[$y] . '</td>';
			print '<tr>';
		}
	}
	print '</table>';
	
	oci_close($conn);

	echo '<br/><br/>';
	echo '<a href="account.php">Powrót</a>';
}

?>
