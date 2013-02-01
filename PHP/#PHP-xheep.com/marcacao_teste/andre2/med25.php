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

	// INSERT ou UPDATE
	$id_ut = $user->id;
	$id_consulta = $afor["id"];
	$id_med = $afor["med"];
	$id_esp = $afor["esp"];
	$data_consulta = $afor["dat"];
	$data = "2010-04-09 15:30";
	$data_consulta = "2010-06-09 15:30";
	$paga ="VISA";
	
			$db =& JFactory::getDBO();
			
			if ( $afor["sta"] == "UPD" ) {
				$sql = "UPDATE jos_afc_consultas SET id_ut='$id_ut',id_med='$id_med',id_esp='$id_esp',data='$data',data_consulta='$data_consulta',paga='$paga' WHERE id ='$id_consulta' ";
					$db->setQuery($sql);
					$result = $db->query();
			 } else {
				$sql = "INSERT INTO jos_afc_consultas(id_ut,id_med,id_esp,data,data_consulta,paga) VALUES ('$id_ut','$id_med','$id_esp','$data','$data_consulta','$paga')";
			
					$db->setQuery($sql);
					$result = $db->query();
			
				if ( $result == 1 ) {
					// echo "####result: " .  $result . "#####";
					$query = " SELECT MAX(id) FROM jos_afc_consultas ";
					$db->setQuery($query);
					$id_consulta = $db->loadResult();
					// echo "####Maximo: " . $id_consulta . "#####";
				} else {
					echo " Não foi possível marcar a sua consulta, por favor tente mais tarde....";
					}
			}
		
		printf("<hr />");
		echo "<b>Dados da sua consulta:</b>";
		echo " <b>Consulta Nº:</b>" . $id_consulta ;
		echo "<br />Especialidade: <b>". $aesp[$afor["esp"]]. "</b>";	
		echo "<br />Médico: <b>". $amed[$afor["med"]][1]. "</b>";
		echo "<br />Data: <b>". $afor["dat"]."</b>";
	
		// E-MAIL 
		
		$email_from = "consultas@projdei.uc.pt";
		// $to = $end_email;
		$to =  "andrevercetti@gmail.com";
		// $headers  = "From:info@anmp.pt";
		$headers  = "From: " . $email_from ;
		$subject = " Dados de consulta ";
		if ( $afor["sta"] == "UPD") $message = sprintf(" \n\n\n Alteração de marcação de consulta \n\n "); 
			else $message = sprintf(" \n\n\n Confirmação de marcação de consulta \n\n "); 
				$message .= sprintf("\n\n Número da consulta: %s", $id_consulta); // específico para o Congresso
				$message .= sprintf("\n Em nome de: %s\n",$user->name); // específico para o Congresso
				$message .= sprintf("\n Uma consulta da especialidade de: %s",$aesp[$afor["esp"]] ); // específico para o Congresso
				$message .= sprintf("\n Para o Médico:%s\n",$amed[$afor["med"]][1] ); // específico para o Congresso
				$message .= sprintf("\n\n para a data :%s\n",$afor["dat"] ); // específico para o Congresso
				$message .= sprintf("\n\n enviado para :%s\n",$user->email ); // específico para o Congresso
				
		$subject=iconv( "UTF-8","ISO-8859-1", $subject);
		$message=iconv( "UTF-8","ISO-8859-1", $message);
		$resp = @mail ($to, $subject, $message, $headers);
				
		if ($resp == 1) { printf("<hr><b>Obrigado usar o sistema on-line</b>");	
				echo "<br />Foram enviados para a sua conta de correio electrónico, os dados da consulta."; 
			} else {
				echo "Não foi possível enviar para a sua conta de correio electrónico, os dados da consulta."; 
				}
				
		if ( strlen($afor["numcc"]) > 5) {
		echo " A sua consulta foi paga por cartão de crédito";
		} else {
		echo " A sua consulta foi ragistada e será paga próprio dia";
		}

		
		echo"<hr>";
		 printf("««« <A HREF=\"/cinove/pro/med25PDF.php?id=%s&ut=%s&med=%s&esp=%s&dat=%s&sta=%s\" target=\"_blank\" ><FONT COLOR=\"#0000dd\"> <b>Documento Comprovativo</b></a> ",$id_consulta,$user->name,$amed[$afor["med"]][1],$aesp[$afor["esp"]],$afor["dat"],$afor["sta"]);
	

?>
