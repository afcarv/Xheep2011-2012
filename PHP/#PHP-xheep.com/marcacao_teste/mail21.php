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

if ( strlen($jumi[0]) > 0 ) $progcal = $jumi[0];
if ( strlen($jumi[1]) > 0 ) $nomebot = $jumi[1];
if ( strlen($jumi[2]) > 0 ) $xid = $jumi[2];
if ( strlen($jumi[3]) > 0 ) $xitid = $jumi[3];
	
// Limpa tudo ao entrar ....
$ok = 0;	

if (strlen($progcal) == 0) $progcal = "/index.php";  // programa a chamar
$progrec="/index.php"; // programa recursivo ....

// if ($user->guest ) { // NO caso de guest tenta validar o cartão de utilizador ....  MESMO QUE SEJA REGISTADO ... VALIDA O CARTAO .... termina em (**)

$mensagem = "Esta informação está reservada aos Associados, se o é, faça «login».";
//	printf("<a title=\"%s\" href=\"#\">%s</a>",$mensagem, $nom);

$nome =  $_REQUEST["nome"];
$mail =  $_REQUEST["mail"];
$texto =  $_REQUEST["texto"];

if ( strlen($nome) > 1 ) {

				// $to = $end_email;
					$to =  "aristides.carvalho@gmail.com";
					// $headers  = "From:info@anmp.pt";
					$headers  = "From: " . $email ;
					$subject = $assbase . " - " . $nome;
					$message = sprintf("%s \n\n\n Pedido de informação de %s, \n\n ",$texto ,$nome);	
				// if ( $xins == 'D' && $xent != 'M3500' ) { // se fôr delegado avisa sobre as condições de inscrioção ....!!!! exclui também do aviso CM-Viseu
				//	$message .= sprintf("\n\n Notas:"); // específico para o Congresso
				//	$message .= sprintf("\n Os Municípios deverão assegurar as reservas necessárias à participação dos seus Delegados, directamente junto das unidades hoteleiras escolhidas ou por via de agência de viagem à sua escolha. ");
				
				$subject=iconv( "UTF-8","ISO-8859-1", $subject);
				$message=iconv( "UTF-8","ISO-8859-1", $message);
				$resp = @mail ($to, $subject, $message, $headers);
				
			if ($resp == 1) printf("<hr><b>Obrigado pela sua mensagem</b>");	
				
				
			} else {

$u =& JFactory::getURI();
$progrec = $u->toString();
// echo " ... $progrec";  // URI completo mas no form só fica a base 

	$pn1 = strpos($progrec,"?");
	$prog = substr($progrec,0,$pn1);
	// echo "... $prog|";  // nome do programa 
 
	$pn1 = strpos($progrec,"&id=");
	$px = substr($progrec,$pn1+4);
	$pn2 = strpos($px,"&");
	$xid=substr($px,0,$pn2);

	$pn1 = strpos($px,"&Itemid=");
	$px = substr($px,$pn1+8);
	$pn2 = strpos($px,"&");
	if ( $pn2 > 0 ) $xitid=substr($px,0,$pn2); else $xitid=$px;

// echo "IT:$xid ite,: $xitid";
	
printf("<hr><b>Dexe-nos a sua mensagem</b>");
printf("<hr />");
		printf("<form name=\"%s\" method=\"GET\" action=\"%s\">",$prog,$prog);
		printf(" <input type=\"hidden\" name=\"option\" value=\"%s\">","com_content");
		printf(" <input type=\"hidden\" name=\"view\" value=\"%s\">","article");
		printf(" <input type=\"hidden\" name=\"id\" value=\"%s\">",$xid);
		printf(" <input type=\"hidden\" name=\"Itemid\" value=\"%s\">",$xitid);
		//printf(" <input type=\"hidden\" name=\"xent\" value=\"%s\">",$xent);
		//printf(" <input type=\"hidden\" name=\"sido\" value=\"%s\">",$sido);
				printf("<br> Remetente<br>Nome <input type=\"text\" name=\"nome\" value=\"%s\" size=\"45\"> (*) ","");
				printf("<br><br>E-mail:<br> <input type=\"text\" name=\"email\" value=\"%s\" size=\"45\"> <b>O seu e-mail</b> (*) para contacto","");
				printf("<br>Resumo:<br><textarea style=\"text-align:left; background-color:#e0e0e0; font-weight:normal\" name=\"texto\" cols=\"80\" rows=\"10\" class=\"sel2\">%s</textarea>"," ");  // texto 
				printf("<br><br><input type=\"submit\" value=\"%s\">","Submeter");
		printf("</form>");
}		

?>
