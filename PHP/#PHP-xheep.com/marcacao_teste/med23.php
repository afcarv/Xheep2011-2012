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
* IHC - Marcação de consultas online
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

$afor = array();
$afor =  $_REQUEST["afor"];

$amem = array();

include('tabelas.php');	// .... ....

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

	echo "Especialidade: <b>". $aesp[$afor["esp"]]. "</b>";
	
	echo "<br />Médico: <b>". $amed[$afor["med"]][1]. "</b>";

	printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[esp]", $afor["esp"]);
	printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[med]", $afor["med"]);
//	printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[dat]", $afor["dat"]);
	printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[pag]", $afor["pag"]);
	printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[sta]", $afor["sta"]);
	printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[id]", $afor["id"]);

	echo "<table><tr>";

	echo "<tr><td>";
	printf("<br> Data:</td>");
		printf("<td><select class=\"sel1\" name=\"%s\" size=1>","afor[dat]"); 
		printf("<OPTION %s value=\"%s\">%s%c",$xs,"","escolha a data",10);
	foreach ($ahor as $chor => $xhor) {
		if ( $chor == $afor["med"] ) {

			foreach ($xhor as $c1hor => $ndat) { $xs = ""; 
				// $xs = "SELECTED"; else $xs = ""; 
				printf("<OPTION %s value=\"%s\">%s%c",$xs,$ndat,$ndat,10);
			}
		}
	}
	echo"</select>";
	
	printf("<br /> Não havendo data disponível, fica e lista de espera: <input type=\"checkbox\" name=\"%s\" value=\"%s\" class=\"sel2\" %s> ", "afor[lesp]","SIM", $xche );

	echo"</td></tr>";

	echo "</table>";
 
 		printf("<br><br><input type=\"submit\" value=\"%s\">","Submeter");
		printf("</form>");	

?>
