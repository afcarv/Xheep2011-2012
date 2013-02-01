<?php defined('_JEXEC') or die('Restricted access'); 

/* ******
 * @author afcarv
******* */
 
// variáveis de ambiente

//echo "\n TESTE4 \n";

//   Set query DB
$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query->select('MAX(map.group_id) as gid');
$query->from('#__user_usergroup_map as map');
$query->where('map.user_id='.$uid);
$db->setQuery((string)$query);
$message = $db->loadObject();   
$gid = $message->gid;   
//echo "<br />group id: ".$gid;
$groupid = $gid; // The groupid
//db establish
$jconfig = new JConfig();
$db_error = "Mysql error!";
$db_config = mysql_connect( $jconfig->host, $jconfig->user, $jconfig->password ) or die( $db_error );
mysql_select_db( $jconfig->db, $db_config ) or die( $db_error ); 

//Get Joomla DB prefix
$config =& JFactory::getConfig();
$table_prefix = $config->getValue( 'dbprefix' );

jimport('joomla.user.helper');

$itemid = JRequest::getInt('Itemid', 0); 
$articleId = JRequest::getInt('id', 0);
// printf("%s %s",$sido, $sent );

// ===  1. variáveis de input ======
include 'listas2.php';

$arsel = array();  
$arsel = JRequest::getVar('arsel');

function lisprof($table_prefix,$ido) { // Lista geral dos profiles de um utilizador
	// global $table_prefix;
	$sqls="select * FROM " . $table_prefix . "user_profiles WHERE user_id = '$ido'";
	
//	echo "----$sqls";
	$ress=mysql_query($sqls); //
		if ($ress) {					
 				while( $regis=mysql_fetch_array($ress)) { 				
 				// funçao de seleccção 									
				$nome = $regis["profile_key"];
				$val = $regis["profile_value"];
					
				 printf ( "<br> : $nome - $val");
				// return 1;  // sai logo ao primeiro !!!!
			}
		   }
// printf("vai sair 0");
mysql_free_result($ress);
return 0;
}

function lisprofx($table_prefix,$ido,$pkey,&$pval) { // devolve um profile
	$px = 'profile.' . $pkey;
	
	$sqls="select * FROM " . $table_prefix . "user_profiles WHERE user_id = '$ido' AND profile_key = '$px' ";
// echo $sqls;
	$ress=mysql_query($sqls); //
		if ($ress) {
			$regs=mysql_fetch_array($ress);
				if ( $regs ) {
						$pval  = $regs["profile_value"];
						return 1;
				}
				else {
					$pval  = "";
					return 0;
					}
		   }
return 0;
	
}


$sql = "select * FROM " . $table_prefix . "users";

// echo  "o SQL: $sql ";
 	$result=mysql_query($sql); 							
 		if ($result) {	
 echo '<table border=1> '	;	
	echo '<tr><td>' . "Nome" .' </td><td> ' . "Apelido" . ' </td><td> ' . "email" .' </td><td> ' ."registerDate  / lastvisitDate"  ;
 	foreach ( $profiles as $iti => $itlis) {
					if ( $iti == 0) continue;
						if ( $arsel[$iti] == 1) {
							echo '</td><td> ' . $itlis  ;
						}
		}
		echo '</td></tr> '	;
		
 				while( $regis=mysql_fetch_array($result)) { 				
 				// funçao de seleccção 									
					$id = $regis["id"];
					$nome = $regis["name"];
					
					$n=lisprofx($table_prefix,$id,'apelido',$apelido);
					
					$email = $regis["email"];
					$registerDate = $regis["registerDate"];
					$lastvisitDate = $regis["lastvisitDate"];
					
					$nome = utf8_encode($nome);
					$morada = utf8_encode($morada);
					$apelido = utf8_encode($apelido);

					
					echo '<tr><td>' .  $nome .' </td><td> ' . $apelido. ' </td><td> ' . $email .' </td><td> ' .$registerDate .' / ' .$lastvisitDate  ;
					foreach ( $profiles as $iti => $itlis) {
					if ( $iti == 0) continue;
						if ( $arsel[$iti] == 1) {
							$n=lisprofx($table_prefix,$id,$itlis,$apx);
							 echo '</td><td> ' . $apx  ;
						}
				
		} 
	echo '</td></tr> '	;
   }
   echo '</table> '	;
 }
 
// printf ( "<br> Não achou $cod_org - $ord  !!!!");
$nomebot = "Listar";
echo '
<form onsubmit="return validate_form(this);"  action="'.JRoute::_('index.php?option=com_content&view=article&id='.$articleId.'&Itemid='.$itemid).'" method="post" enctype="multipart/form-data">
';
	foreach ( $profiles as $iti => $itlis) {
				if ( $iti == 0) continue; // salta o primeiro ()apelido)
				/* o inqx é a vcersão base do inq + ositems resumo que sejam necessários para acumulação de dados ...*/
				if ( $arsel[$iti] == 1) $xche = "CHECKED"; else $xche = "";
				printf("<br> <input type=\"checkbox\" name=\"arsel[$iti]\" value=\"%s\" %s>%s", "1", $xche, $itlis);
				
		} 
	
		printf("<br><br><input type=\"submit\" value=\"%s\">",$nomebot);
		printf("</form>");

?> 




