

<tr><td valign=top><strong>Aniversário:</strong></strong></td></tr>
<td valign=top><strong>Dia:</strong></strong></td>

<tr> <td>
    <select name="dia">
    <option selected>Selecione</option>';
	if ( strlen($dia) == 0) $dia = "1";
	foreach ($dias as $nm1) {
	if ( $dia == $nm1) $sel = "SELECTED"; else $sel = "";
  echo '<option value="' .$nm1. '" '. $sel .'>'.$nm1.'</option>';
}
 echo '</select>
    </tr>
    </td>
	
	<td valign=top><strong>Mês:</strong></strong></td>
<tr> <td>
    <select name="mes">
    <option selected>Selecione</option>';
	if ( strlen($mes) == 0) $mes = "Janeiro";
	foreach ($meses as $nm2) {
	if ( $mes == $nm2) $sel = "SELECTED"; else $sel = "";
  echo '<option value="' .$nm2. '" '. $sel .'>'.$nm2.'</option>';
}
 echo '</select>
    Insira a sua data de aniversário, para receber um presente.</tr>
    </td>
	

