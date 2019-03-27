<?php

/**
 * Wyświetlenie listy zadarzeń (logowan i wylogowań)
 *
 * Funkcja wyświetla tabelę occurrences
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
function display_occur($con, $e)
{
	$query  = "select * from occurrences order by login_date desc";
	
	if ($e > 0) {
		$query = "select * from occurrences where employ_id=" . $e . "order by login_date desc";
	}
	
	$statid = oci_parse($con, $query);
	oci_execute($statid);

	// Przechwycenie każdego wiersza do tworzonej tabli
	print '<table border="1" cellpading="10" cellspacing="0">';
	print '<tr><th>Id pracownika</th><th>Logowanie</th><th>Wylogowanie</th></tr>';
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