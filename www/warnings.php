<?php


session_start();

//przekierowanie na index.php dla niezalogowanego użytkownika
if (!isset($_SESSION['logged'])) {
	header('Location: index.php');
	exit();
}



require_once 'connect.php'; 


//nawiąż połączenie z bazą danych Oracle 11g XE
$conn = oci_connect($db_username, $db_passwd, $db_name, $type_coding);

//jeżeli nie udało się połączyć z bazą danych zwróć odpowiedni komunikat o błędzie
if (!$conn) {
	$msg = oci_error();
	echo $msg['message'], "\n";
}
else {
	$str = "Lista wygenerowanych ostrzeżeń";
	
	$em = $_POST['emp'];
	
	$query  = "select * from warnings";

	if (empty($em)) {
		$em = 0;
		echo '<h2>' . $str . '</h2>';
		$query = $query . " order by time_warn desc";
	}

	if ($em > 0 ) {
		$str= $str . "dla pracownika o id " . $em;
		echo '<h2>' . $str . '</h2>';
		$query  = $query . " where employ_id=" . $em . "order by time_warn desc";
	}

	
	$statid = oci_parse($conn, $query);
	$res    = oci_execute($statid);
	
	
	print '<table border="1" cellpading="10" cellspacing="0">';
	print '<tr><th>Id pracownika</th><th>Czas zadarzenia</th><th>Opis zdarzenia</th></tr>';
	while ($row = oci_fetch_array($statid, OCI_RETURN_NULLS+OCI_ASSOC)) {
		print '<tr>';
		foreach ($row as $it) {
			print '<td>'.($it !== null ? htmlentities($it, ENT_QUOTES) : '&nbsp').'</td>';
		}
		print '</tr>';
	}
	print '</table>';

	oci_close($conn);

	echo '<br/><br/>';
	echo '<a href="account.php">Powrót</a>';
}

?>

