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

// echo 'User name: ' . $user->username . '<br />';
//  echo 'Real name: ' . $user->name . '<br />';
//  echo 'User ID  : ' . $user->id . '<br />';
//  echo 'User email  : ' . $user->email . '<br />';

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

	// INSERT
	$id = $afor["id"];
	
			$db =& JFactory::getDBO();
			// echo "####result: " .  $result . "#####"; WHERE id = '$id'
			$query = " SELECT * FROM jos_afc_consultas WHERE id = '$id' ";
			$db->setQuery($query);
			$db->query();
			
			/* UMA LINHA */
			$obj_row = $db->loadObject();
			// print_r ($obj_row);
			$afor["id"] = $obj_row->id;
			$afor["ut"] = $obj_row->id_ut;
			$afor["med"] = $obj_row->id_med;
			$afor["esp"] = $obj_row->id_esp;
			$afor["dat"] = $obj_row->data_consulta;
			$afor["pag"] = $obj_row->paga;
			
			echo "<hr>" . $afor["id"] . "|" . $afor["ut"] . "|" . $afor["med"] . "|" . $afor["esp"] . "|" . $afor["dat"] . "|" . $afor["pag"] ;
	
			echo "Especialidade: <b>". $aesp[$afor["esp"]]. "</b>";	
			echo "<br />Médico: <b>". $amed[$afor["med"]][1]. "</b>";
			echo "<br />Data: <b>". $afor["dat"]."</b>";

			// $afor[""]
			// $afor["esp"]
			
			/*
			foreach($obj_row as $a) {
				// echo "<br> .... »»» " . print_r ($a);
				echo "<br> Med: " . $obj_row->id_med;
			 }
			*/
			// echo "<hr> Med: " . $obj_row->id_med; 
			
				// foreach($obj_row as $a){
				// 	echo $a->id;
				// }

		echo"<hr>";
		 // printf("««« <A HREF=\"/cinove/pro/med33.php?id=%s\" target=\"_top\" ><FONT COLOR=\"#0000dd\"> <b>Eliminar a Consulta</b></a> ",$afor);
		
		printf("<form name=\"%s\" method=\"GET\" action=\"%s\">",$prog,$prog);
		printf(" <input type=\"hidden\" name=\"option\" value=\"%s\">","com_content");
		printf(" <input type=\"hidden\" name=\"view\" value=\"%s\">","article");
		printf(" <input type=\"hidden\" name=\"id\" value=\"%s\">",$xid);
		printf(" <input type=\"hidden\" name=\"Itemid\" value=\"%s\">",$xitid);
		printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[id]", $afor["id"]);

	// printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[esp]", $afor["esp"]);
	// printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[med]", $afor["med"]);
	// printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[dat]", $afor["dat"]);

	printf("<br><br><input type=\"submit\" value=\"%s\">","Remover");

	printf("</form>");	

	$xidx=74;
	$xitidx=83;
	
		printf("<form name=\"%s\" method=\"GET\" action=\"%s\">",$prog,$prog);
		printf(" <input type=\"hidden\" name=\"option\" value=\"%s\">","com_content");
		printf(" <input type=\"hidden\" name=\"view\" value=\"%s\">","article");
		printf(" <input type=\"hidden\" name=\"id\" value=\"%s\">",$xidx);
		printf(" <input type=\"hidden\" name=\"Itemid\" value=\"%s\">",$xitidx);
		printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[id]", $afor["id"]);
		printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[esp]", $afor["esp"]);
		printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[med]", $afor["med"]);
		printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[dat]", $afor["dat"]);
		printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[pag]", $afor["pag"]);
		printf(" <input type=\"hidden\" name=\"%s\" value=\"%s\">","afor[sta]", "UPD");

	printf("<br><br><input type=\"submit\" value=\"%s\">","Alterar");

	printf("</form>");	
	
	
	
?>
