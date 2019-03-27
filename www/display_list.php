<?php

/**
 * Wyświetlenie listy pracowników, stanowisk
 *
 * Funkcja wyświetla tabelę employees lub tabelę jobs
 *
 * Przykładowe wywołanie:
 *
 * <pre>
 * display_list(conn, 0);  //wyświetla listę pracowników
 * display_list(conn, 1);  //wyświetla listę stanowisk
 * </pre>
 *
 * <b>Funkcja nie sprawdza typu otrzymanych parametrów.</b>
 *
 * @param handle  uchwyt do podłączenia z bazą danych
 * @param integer flaga
 */
function display_list($con, $fg)
{
  $query  = "select * from employees";
  
  if ($fg > 0) {
	  $query  = "select * from jobs";
  }
  $statid = oci_parse($con, $query);
  $res    = oci_execute($statid);
  
  // Przechwycenie każdego wiersza do tworzonej tabli
  print '<table border="1" cellpading="10" cellspacing="0">';
  
  if ($fg > 0) {
	  print '<tr><th>Id stanowiska</th><th>Nazwa stanowiska</th><th>Liczba godziny pracy</th></tr>';
  }
  else {
	  print '<tr><td>Id pracownika</td><td>Imię</td><td>Nazwisko</td><td>Pesel</td><td>Numer telefonu</td>';
	  print '<td>Email</td><td>Data zatrudnienia</td><td>Ulica</td><td>Numer budynku</td>';
	  print '<td>Kod pocztowy</td><td>Miasto</td><td>Id stanowiska</td></tr>';
  }
  
  while ($row = oci_fetch_array($statid, OCI_RETURN_NULLS+OCI_ASSOC)) {
	  print '<tr>';
	  foreach ($row as $it) {
		  print '<td align=center>'.($it !== null ? htmlentities($it, ENT_QUOTES) : '&nbsp').'</td>';
	  }
	  print '</tr>';
  }
  print '</table>';
}

?>