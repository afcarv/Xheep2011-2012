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

	
	$id = $afor["id"];
		echo "<br>:[" . $id . "]";
			$db =& JFactory::getDBO();
			$sql = "DELETE FROM jos_afc_consultas WHERE id = '$id' ";
			$db->setQuery($sql);
			$result = $db->query();
			
			
	if ( $result == 1 ) {
		echo "Registo eliminado:" . $id ;
	}
	
printf("<hr><b>Identifica a consulta</b>");
printf("<hr />");
		printf("<form name=\"%s\" method=\"GET\" action=\"%s\">",$prog,$prog);
		printf(" <input type=\"hidden\" name=\"option\" value=\"%s\">","com_content");
		printf(" <input type=\"hidden\" name=\"view\" value=\"%s\">","article");
		printf(" <input type=\"hidden\" name=\"id\" value=\"%s\">",$xid);
		printf(" <input type=\"hidden\" name=\"Itemid\" value=\"%s\">",$xitid);

	printf("<br /> Qual o número: ");
    printf("<br><input style=\"text-align:right\" type=\"text\" name=\"%s\" size=\"%s\" value=\"%s\" class=\"sel2\"> %c", "afor[id]", "8", $afor["id"],10);
 	printf("<br><br><input type=\"submit\" value=\"%s\">","Seleccionar");
	printf("</form>");	

?>
