<?php

/**
 * Dodawanie logowań do systemu rejestracji czasu pracy pracowników
 *
 * Funkcja dodaje logowania i wylogowania do tabeli occurrences
 *
 * Przykładowe wywołanie:
 *
 * <pre>
 * add_log(conn, emp, 0);  //dodaje stempel czasu logowania
 * add_log(conn, emp, 1);  //dodaje stempel czasu wylogowania
 * </pre>
 *
 * <b>Funkcja nie sprawdza typu otrzymanych parametrów.</b>
 *
 * @param handle  con - uchwyt do podłączenia z bazą danych
 * @param integer emp - id pracownika
 * @param integer fg  - określa logowanie i wylogowanie
 */
 function add_log($con, $emp, $fg)
 {
	 $retval = 1;
	 
	 $s = oci_parse($con, 'begin add_occur(:param1, :param2, :param3); end;');
	 oci_bind_by_name($s, ':param1', $emp);
	 oci_bind_by_name($s, ':param2', $fg);
	 oci_bind_by_name($s, ':param3', $retval, 40);

	 oci_execute($s); 
	 
	 if (!$ret) {
		 $msg = oci_error();
		 echo $msg['message'], "\n";
	 }
	 
	 return $retval;
 }

?>