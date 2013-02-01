<?php
/**
* @version		$Id: mod_login.php 7692 2007-06-08 20:41:29Z tcp $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/


/**
* IHC - Marcação de consultas online - Grupo 33
* André Fernandes de Carvalho - 2006130976
* Nuno Costa
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once

$user =& JFactory::getUser();

if ( strlen($jumi[0]) > 0 ) $xid = $jumi[0];  // item seguinte
if ( strlen($jumi[1]) > 0 ) $xitid = $jumi[1]; // iteid seguinte
	
// Limpa tudo ao entrar ....
$ok = 0;	

// if ($user->guest ) { // NO caso de guest tenta validar o cartão de utilizador ....  MESMO QUE SEJA REGISTADO ... VALIDA O CARTAO .... termina em (**)

$afor = array();  // array para dados do form...
$afor =  $_REQUEST["afor"];

$amem = array();

include('tabelas.php');	// .... ....

// $afor =  $_REQUEST["afor"];  // o array do form vem evntual input do form
// $mail =  $_REQUEST["mail"];

$u =& JFactory::getURI();
$progrec = $u->toString();
// echo " ... $progrec";  // URI completo mas no form só fica a base 
$pn1 = strpos($progrec,"?");
$prog = substr($progrec,0,$pn1);
	// echo "... $prog|";  // nome do programa 

if ( $afor["sta"] == "UPD" ) printf("<hr><b>Alteração de consulta</b>");
		else printf("<hr><b>Marcação de consulta</b>");
printf("<hr />");
		printf("<form name=\"%s\" method=\"GET\" action=\"%s\">",$prog,$prog);
		printf(" <input type=\"hidden\" name=\"option\" value=\"%s\">","com_content");
		printf(" <input type=\"hidden\" name=\"view\" value=\"%s\">","article");
		printf(" <input type=\"hidden\" name=\"id\" value=\"%s\">",$xid);
		printf(" <input type=\"hidden\" name=\"Itemid\" value=\"%s\">",$xitid);
		printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[sta]", $afor["sta"]);
		printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[id]", $afor["id"]);
		
	echo "Especialidade: <b>". $aesp[$afor["esp"]]. "</b>";
	
	printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[esp]", $afor["esp"]);
	// printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[med]", $afor["med"]);
	printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[dat]", $afor["dat"]);
	printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[pag]", $afor["pag"]);

	echo "<table><tr>";

	echo "</td></tr>";

	echo "<tr><td>";
	printf("<br> Médico:</td>");
		printf("<td><select class=\"sel1\" name=\"%s\" size=1>","afor[med]"); 
		printf("<OPTION %s value=\"%s\">%s%c",$xs,"","escolha a médico",10);
	foreach ($amed as $cmed => $xmed) {
 	if ( $xmed[0] == $afor["esp"] ) {
		if ( $cmed == $afor["med"] ) $xs = "SELECTED"; else $xs = ""; 
			printf("<OPTION %s value=\"%s\">%s%c",$xs,$cmed,$xmed[1],10);
		}
	}
	echo"</select>";
	echo"</td></tr>";

	echo "</table>";
 
 		printf("<br><br><input type=\"submit\" value=\"%s\">","Submeter");
		printf("</form>");	

?>
