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

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once

$user =& JFactory::getUser();
 
if ( strlen($jumi[0]) > 0 ) $progcal = $jumi[0];
if ( strlen($jumi[1]) > 0 ) $nomebot = $jumi[1];
if ( strlen($jumi[2]) > 0 ) $xmov = $jumi[2];
	
if ($user->guest) {

	$mensagem = "Esta informação está reservada aos clientes, se o é, faça «login».";
	
	echo '<hr>' . $mensagem;
	
	// printf("<a title=\"%s\" href=\"#\">%s</a>",$mensagem, $nom);

	//JError::raiseError( 403, 'Esta zona está reservada, em caso de dúvida contacte a ANMP' );    // ESTA PORQUEIRA DE LINHA ESTÀ A DAR ERRO !!!!!
	
	// $module = &JModuleHelper::getModule('login');
//	echo '<pre>';var_dump($module);echo'</pre>';
//	$output = JModuleHelper::renderModule( $module );
//	echo '<pre>';var_dump($output);echo'</pre>';

//$_module = &JModuleHelper::getModule( 'login' );
//echo '<xmp>', print_r($_module, true), '</xmp>';
//$output = JModuleHelper::renderModule( $_module, array('style'=>'xhtml') );
//echo '<xmp>', print_r($output, true), '</xmp>';

} else {

// session_start();
// $_SESSION['usanm'] = $user->username;
 
  echo 'Cliente:<br />';
  echo 'Identificação: ' . $user->username . '<br />';
  echo 'Designação: ' . $user->name . '<br />';
  echo 'ID  : ' . $user->id . '<br />';

  echo "<hr>". $_SERVER['SCRIPT_FILENAME'] . "<hr>"; 
  
 //  /var/www/vhosts/cinove.com/httpdocs
	$id = $user->id;
	$ext = 'jpg';
	///home/impresso/public_html/xheep/xheep2/images
  
 	$fxf ='/home/impresso/public_html/xheep/xheep2/images/logo/empresas/'; // directorio físico
	$fxl ='/xheep2/images/logo/empresas/'; // directorio lógico
	$fx = $id . '.' . $ext;
	$fxf .= $fx;
	$fxl .= $fx;
	 // printf("[$fxf]");
	
	if ( strlen($ext) > 0 && file_exists($fxf) ) {
	 printf ("<BR><img SRC=\"%s\" border=0 width=200>",$fxl);
     }
	 else echo "[SEM IMAGEM]";

	 
  
// echo "<br> » ", ' <a href="http://mune4.anmp.pt/',$xprog,'?xent=',$xent,'&sido=',$xid,'&XL=',$XL,'&ref=',$xnoment,'&xmov=NUP">',$xdes,'»»»</a>', " [ ",$xnoment , " | $xent | $xtyp ] ";
$nomebot = "ir para aqui";
$progcal = 'http://81.92.207.206/MarketingConsole/login.aspx ';


if ( strlen($xmov) == 0 ) $xmov = "NUP";
		if ( $sace < 1 ) $sace = "300";
		printf("<form name=\"%s\" method=\"POST\" action=\"%s\">",$progcal,$progcal);
		printf(" <input type=\"hidden\" name=\"xmov\" value=\"%s\">",$xmov);
		printf(" <input type=\"hidden\" name=\"xent\" value=\"%s\">",$xent);
		printf(" <input type=\"hidden\" name=\"sido\" value=\"%s\">",$sido);
		printf(" <input type=\"hidden\" name=\"sace\" value=\"%s\">",$sace);
		printf("<input type=\"submit\" value=\"%s\">",$nomebot);
		printf("</form>");
	
}

/* ########  Variáveis 

function selidocod($ido, &$cod ) {
	$sqls="select cod_ent from munp1.usi01 where uid = '$ido'";
	$ress=mysql_db_query("munp1",$sqls); //
		if ($ress) {
				$regs=mysql_fetch_array($ress);
				if ( $regs ) {
								$cod = $regs["cod_ent"];
													
								mysql_free_result($ress);
								return 1;
							}
 					else return 0;
		   }
// printf("vai sair 0");
return 0;
}


		selidocod($sido, $sent );
		if ( substr($sido,0,2) == "AM" )  { // Assembleia unicipal
					   	$xent = M . substr($sent,1,4);  // passa ao código do município
						$xtpe = "M"; 
					    } else if ( substr($sido,0,3) == "MUN" )  { // Município
						$xtpe = "M"; 
					   	$xent = M . substr($sent,1,4);  // passa ao código do município
						} else { 
						// as freguesias não estão previstas ....if (  substr($xent,0,1) == "F" ) $xtpe = "F";  // Freguesias .... também podem 
						echo "...";
						// exit;
					}
		 	
		printf("<form name=\"%s\" method=\"POST\" action=\"%s\">",$progcal,$progcal);
		printf(" <input type=\"hidden\" name=\"xmov\" value=\"%s\">","NUP");
		printf(" <input type=\"hidden\" name=\"xent\" value=\"%s\">",$xent);
		printf(" <input type=\"hidden\" name=\"sido\" value=\"%s\">",$sido);
		printf("<input type=\"submit\" value=\"%s\">",$nomebot);
		printf("</form>");

?>


Object Member Variables and Parameters

These are the relevant member variables automatically generated on a call to getUser():

    * id - The unique, numerical user id. Use this when referencing the user record in other database tables.
    * name - The name of the user. (e.g. Vint Cerf)
    * username - The login/screen name of the user. (e.g. shmuffin1979)
    * email - The email address of the user. (e.g. crashoverride@hackers.com)
    * password - The encrypted version of the user's password
    * password_clear - Set to the user's password only when it is being changed. Otherwise, remains blank.
    * usertype - The role of the user within Joomla!. (Super Administrator, Editor, etc...)
    * gid - Set to the user's group id, which corresponds to the usertype.
    * block - Set to '1' when the user is set to 'blocked' in Joomla!.
    * registerDate - Set to the date when the user was first registered.
    * lastvisitDate - Set to the date the user last visited the site.
    * guest - If the user is not logged in, this variable will be set to '1'. The other variables will be unset or default values.

In addition to the member variables (which are stored in the database in columns), there are parameters for the user that hold preferences. To get one of these parameters, call the getParam() member function of the user object, passing in the name of the parameter you want along with a default value in case it is blank.

************** 
*/

?>
