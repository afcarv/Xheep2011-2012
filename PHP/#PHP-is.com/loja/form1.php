<?php defined('_JEXEC') or die('Restricted access'); 

$image = "logois_p.png";  
$width = 300;
$height = 280;
echo '<center> <img src="'.$image.'" style=width:"' . $width . 'px;height:' . $height . 'px;"></center>';
echo '<tr><td><center><strong>Formulário de Registo Impressões e Soluções,Lda</strong></center></tr></td>';

/* ******
 *
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

jimport( 'joomla.user.helper' );
jimport( 'joomla.utilities.utility' );
// jimport( 'joomla.mail.mail' );

$itemid = JRequest::getInt('Itemid', 0); 
$articleId = JRequest::getInt('id', 0);
// printf("%s %s",$sido, $sent );

// ===  1. variáveis de input ======

include 'artigos.php';

$tipmov = JRequest::getVar('tipmov');
$nome = JRequest::getVar('nome');
$codcat = JRequest::getVar('codcat');
$codart = JRequest::getVar('codart');

$ximp = 0; // valor inicial 
  
/* este locx é pelo método 1 
$locx = 'index.php?option=com_content&view=article&id='.$articleId.'&Itemid='.$itemid; // página ativa
*/

$locx = $_SERVER['PHP_SELF'].'?loja='.$nome;
// Categorias
   echo '<a href="' . $locx . '">Categorias</a> ';
 if ( strlen($codart) != 0) {
   $codcat = $artigos[$codart]["cat"];
   }
 if ( strlen($codcat) == 0) { // todas as categorias
 echo ':';
   foreach ($categorias as $keyx => $catx) { // lista categorias
	 echo ' | <a href="' . $locx . '&codcat=' . $keyx . '">'.$catx[1] . '</a>';
	 }
   } else if ( strlen($codcat) != 0) { // procura subcategorias
 echo '<br /> ' . $categorias[$codcat][1];
   foreach ($categorias as $keyx => $catx) { // lista categorias
	 if ( $codcat == $catx[0] ) echo ' | <a href="' . $locx . '&codcat=' . $keyx . '">'.$catx[1] . '</a>';
	 }
   } else if ( strlen($codart) != 0  ){ 
			 echo ' | <a href="' . $locx . '&codcat=' . $codcat . '">'. $categorias[$codcat][1] . '</a>'; // mostra a categoria
	} else { 
			echo " » ". $categorias[$codcat][1] . " <br />";
	}

	// artigos
    $ximp = 0;
	if (strlen($codart) != 0)  {
	$ximp = 1;
	// trata o artigo x
	} else if ( strlen($codcat) != 0 ) { // esta escolhida uma categoria e não um artigo
			echo "<br />lista de artigos";
			foreach ($artigos as $codx => $artx) { // percorre os artigos
				if ( $artx[0] == $codcat ) {   // lista os artigos da categoria $codcat 
					// echo '<br />' . $categorias[$artx["cat"]];
					 	 echo ' <br /> - <a href="' . $locx . '&codart=' . $codx . '">'. $artx[1] . ' »»»</a>';
						 echo '<br />';
				}
		}
    } 
	
	
// Form para a recolha dos dados 
if ( $ximp == 1 ) {
$tipmov = "IMP"; // variável hidden para acontrolo
$nomebot="Comprar";
echo '
<form onsubmit="return validate_form(this);"  action="'.JRoute::_('index.php?option=com_content&view=article&id='.$articleId.'&Itemid='.$itemid).'" method="post" enctype="multipart/form-data">
';
 
/* ***************
echo '	
<input type="hidden" name="tipmov" value="'. $tipmov .'">
<table bgcolor=#f4f4f4>
<tr> <td><strong>Nome:</strong></td><td>
<tr> <td><input type="text" name="nome" value="'.$nome.'" size="25"> </tr>
<tr> <td><strong>Apelido:</td><td>
<tr> <td><input type="text" name="apelido" value="'.$apelido.'" size="25"> </tr>
<tr> <td><strong>Morada:</strong></td><td>
<tr> <td><input type="text" name="morada" value="'.$morada.'" size="45">  </td></tr>
<tr> <td><strong>Telemóvel: </strong></td></tr>
<tr> <td>(+351)<input type="text" name="telemovel" value="'.$telemovel.'" size="25"> </td></tr>
<tr> <td><strong>Email:</strong></td><td>
<tr> <td><input type="text" name="email" value="'.$email.'" size="45">  </td></tr>
<tr><td valign=top><strong>Município:</strong></strong></td></tr>
<tr> <td>
    <select name="municip">
    <option selected>Selecione</option>';
	if ( strlen($municip) == 0) $municip = "Coimbra";
	foreach ($municipios as $nm) {
	if ( $municip == $nm) $sel = "SELECTED"; else $sel = "";
  echo '<option value="' .$nm. '" '. $sel .'>'.$nm.'</option>';
}
 echo '</select>
    </tr>
    </td>
<tr> <td><strong>Código Postal</strong></td><td>
<tr> <td><input type="text" name="codpost1" value="'.$codpost1.'" size="3">
-<input type="text" name="codpost2" value="'.$codpost2.'" size="2"> 
<input type="text" name="codpost3" value="'.$codpost3.'" size="40">
</td></tr>
<tr> <td><strong>Sexo:</strong></td><td> 
<tr> <td>Masculino: <input type="radio" name="sexo" value="M" ';
if ( $sexo == "M") echo "CHECKED";
echo ' > Feminino:<input type="radio" name="sexo" value="F" ';
if ( $sexo == "F") echo "CHECKED";
echo ' ></td></tr>

<tr> <td><strong>Aniversário:</strong></td><td>
<tr> <td><strong><input type="text" name="aniversario" value="'.$aniversario.'" size="15"> (AAAA-MM-DD)</strong></td></tr>
<tr> <td><br>Li e aceito os termos de serviço <input type="checkbox" value="SIM" name="aceite"><br /></tr> </td> <br/> 
</table>
';	

************************   */
 echo ' Campos para o Artigo .... ' . $artigos[$codart]["nome"] . ' »»»';


		printf("<br><br><input type=\"submit\" value=\"%s\">",$nomebot);
		printf("</form>");

}

?> 




