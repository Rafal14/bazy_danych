<?php

session_start();

//przekierowanie na index.php dla niezalogowanego użytkownika
if (!isset($_SESSION['logged'])) {
	header('Location: index.php');
	exit();
}


require_once 'connect.php';  
require_once 'display_list.php';           //funckcja wypisywania listy pracowników i stanowisk           



//nawiąż połączenie z bazą danych Oracle 11g XE
$conn = oci_connect($db_username, $db_passwd, $db_name, $type_coding);

//jeżeli nie udało się połączyć z bazą danych zwróć odpowiedni komunikat o błędzie
if (!$conn) {
	$msg = oci_error();
	echo $msg['message'], "\n";
}
else {
	echo '<h2>Lista stanowisk</h2>';

	//wyświetl listę wszystkich stanowisk
	display_list($conn, 1);
	
	oci_close($conn);

	echo '<br/><br/>';
	echo '<a href="account.php">Powrót</a>';
}

?>

