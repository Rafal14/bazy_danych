<?php


session_start();

//przekierowanie na index.php dla niezalogowanego użytkownika
if ((!isset($_POST['login'])) || (!isset($_POST['haslo']))) {
	header('Location: index.php');
	exit();
}


require_once 'connect.php'; 
require_once 'add_log.php';	   

//nawiąż połączenie z bazą danych Oracle 11g XE
$conn = oci_connect($db_username, $db_passwd, $db_name, $type_coding);

//jeżeli nie udało się połączyć z bazą danych zwróć odpowiedni komunikat o błędzie
if (!$conn) {
   $msg = oci_error();
   echo $msg['message'], "\n";
}
else {
   $login = $_POST['login'];
   $haslo = $_POST['haslo'];
   
   $login = htmlentities($login, ENT_QUOTES, "UTF-8");   //encja html
   $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
   
   
   echo "<br/><br/><br/><br/><br/><br/>";
   
   //sprawdzenie czy login i hasło jest liczbą
   if (ctype_digit($login)) {
	   if (ctype_digit($haslo)) {
		   $query = "select * from employees where pesel=" . $haslo . " and emp_id=" . $login;
		   $statid = oci_parse($conn, $query);
		   oci_execute($statid);
		   $nrows = oci_fetch_all($statid, $res);
		   
		   
		   //sprawdz czy znaleziono login i haslo
		   if ($nrows > 0) {
	
			   $ret = 1;
			   
			   if(isset($_POST['wejscie'])) { 
					$today = date("D M j G:i:s T Y"); 
					$ret   = add_log($conn, $login, 0);    //zapisanie logowania
					
					if ( $ret == 0 )
						$_SESSION['info']='<span style="color:black">'.$today . ' - Nastąpiło wejście pracownika o id: ' . $login . ' </span>';
					else
						$_SESSION['info']='<span style="color:red">'.$today . ' - Błąd. Pracownika o id: ' . $login . ' jest w pracy</span>';
					header('Location: index.php');
			   }
			   elseif(isset($_POST['wyjscie'])) {
				   $today = date("D M j G:i:s T Y"); 
				   $ret = add_log($conn, $login, 1);     //zapisanie wylogowania
				   
				   if ( $ret == 0 )
						$_SESSION['info']='<span style="color:black">'.$today . ' - Nastąpiło wyjście pracownika o id: ' . $login . ' </span>';
					else
						$_SESSION['info']='<span style="color:red">'.$today . ' - Błąd. Pracownika o id: ' . $login . ' nie ma w pracy</span>';
					header('Location: index.php');
			   }
			   
			   //jeżeli nastąpiło prawidłowe logowanie dla administratora
			   elseif(isset($_POST['logowanie'])) {
				   $query = "select job_id from employees where emp_id=" . $login;
				   $s = oci_parse($conn, $query);
				   oci_define_by_name($s, 'JOB_ID', $jobid);
				   oci_execute($s);
				   
				   oci_fetch($s);
				   
				   //stanowisko administratora
				   if ( $jobid == '7' ) {
					   $_SESSION['logged'] = true;           //flaga logowania
					   unset($_SESSION['info']);
					   header('Location: account.php');
				   }
				   else {
					   $_SESSION['blad']='<span style="color:red">Błąd. Nieprawidłowy login lub hasło.</span>';
					   header('Location: index.php');
				   }
			   }
		   }
		   else {
			   $_SESSION['info']='<span style="color:red">Błąd. Nieprawidłowy login lub hasło.</span>';
			   header('Location: index.php');
		   }
	   }
   }
   else {
	   $_SESSION['info']='<span style="color:red">Błąd. Nieprawidłowy login lub hasło.</span>';
	   header('Location: index.php');
   }
   
   oci_close($conn);
}

?>
