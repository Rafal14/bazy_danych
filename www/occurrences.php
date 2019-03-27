<?php

session_start();

//przekierowanie na index.php dla niezalogowanego użytkownika
if (!isset($_SESSION['logged'])) {
	header('Location: index.php');
	exit();
}


require_once 'connect.php'; 
require_once 'display_occur.php';           //funkcja wypisywania listy pracowników i stanowisk



//nawiąż połączenie z bazą danych Oracle 11g XE
$conn = oci_connect($db_username, $db_passwd, $db_name, $type_coding);

//jeżeli nie udało się połączyć z bazą danych zwróć odpowiedni komunikat o błędzie
if (!$conn) {
   $msg = oci_error();
   echo $msg['message'], "\n";
   exit();
}




$str = "Lista wejść i wyjść ";

$em = $_POST['empid'];

if (empty($em)) {
	$em = 0;
	$str= $str . "wszystkich pracowników";
	echo '<h2>' . $str . '</h2>';
}

if ($em > 0) {
	$str= $str . "pracownika o id " . $em;
	echo '<h2>' . $str . '</h2>';
}
//wyświetl listę logowań i wylogowań
display_occur($conn, $em);

oci_close($conn);

echo '<br/><br/>';
echo '<a href="account.php">Powrót</a>';

?>

