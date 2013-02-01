<?php defined('_JEXEC') or die('Restricted access'); 

$image = "logois_p.png";  
$width = 300;
$height = 280;
echo '<center> <img src="'.$image.'" style=width:"' . $width . 'px;height:' . $height . 'px;"></center>';
echo '<tr><td><center><strong>Formulário de Registo Xheep</strong></center></tr></td>';

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

include 'listas1.php';

$tipmov = JRequest::getVar('tipmov');
$nome = JRequest::getVar('nome');
$apelido = JRequest::getVar('apelido');
$morada = JRequest::getVar('morada');
$telemovel = JRequest::getVar('telemovel');
$email = JRequest::getVar('email');
$codpost1 = JRequest::getVar('codpost1');
$codpost2 = JRequest::getVar('codpost2');
$codpost3 = JRequest::getVar('codpost3');
$municip = JRequest::getVar('municip');
$sexo = JRequest::getVar('sexo');
$aniversario = JRequest::getVar('aniversario');
$aceite = JRequest::getVar('aceite');

$ximp = 0; // valor inicial 

/* ************************
 echo ' <hr>[ ' .
 $tipmov . $nome . $apelido. $morada. $telemovel . $email . $codpost . $municip . $sexo. $aniversario .
 '<br>] <center>*Todos os campos são de preenchimento obrigatório. Obrigado</center> <hr> ' ;
 ********************** */
 
 // se o tipmov for nulo vai directo para o form de imput 
 
  // 2. validações
  // 2.1
  if( $tipmov == "IMP") {
  
if ( strlen($nome) < 2 ) {
echo '<p style="color:#F00">  Por favor indique o Nome </p>';
 $ximp = 1;
}

if ( strlen($apelido) < 2 ) {
echo '<p style="color:#F00"> Por favor indique o Apelido</p>';
 $ximp = 1;
}

if ( strlen($email) < 5 ) {
echo '<p style="color:#F00">  Por favor indique um endereço de e-mail</p>';
 $ximp = 1;
}

if ( strlen($telemovel) < 9 ) {
echo '<p style="color:#F00"> Por favor indique um contacto de telemovel</p>';
 $ximp = 1;
}

if ( strlen($morada) < 2 ) {
echo '<p style="color:#F00">  Por favor indique o seu local de residência</p>';
 $ximp = 1;
}
$codpost=$codpost1;
if ( strlen($codpost1) < 9 ) {
echo '<p style="color:#F00">  Por favor indique o seu código postal</p>';
 $ximp = 1;
}


if ( $aceite != "SIM" ) {
echo '<p style="color:#F00">  Por favor confirme que leu e aceita os termos de serviço </p>';
 $ximp = 1;
}

}

// - 2.2 - se o ximp fôr 1, ou tipmov nulo, não pode fazer insert, vai para o form 

if( $ximp == 0 && $tipmov == "IMP" ) { // tenta saber se o e-mail já existe

if (strlen($email) > 5) {	
// verifica se o e-mail existe na base de dados
$sql = mysql_query("SELECT email FROM " . $table_prefix . "users WHERE email='" . $email . "'");   // refsql#1
$num_rows = mysql_num_rows($sql);
if($num_rows == 0) {
$email = $email;
$emailexiste = "0"; 
} else {	 
$emailexiste = "1"; //This email already exists in the joomla user db
$ximp = 1; // liga o form 
echo '<br/>
Por favor utilize outro endereço de e-mail, já exite uma conta associada ao emaail que inseriu.'. $email;
}
}
}
// 3. Passa ao insert
if( $ximp == 0 && $tipmov == "IMP" && $emailexiste == "0") { // tenta fazer o insert
// temos nome , apelido e email, já podemos gerar uma conta!
// na primeira fase, u utilizador é gerado pela função time...
$username = time();	
$password =  rand(1001, 9999);
$block = '0';
$sendmail = '0';
$usertype ='2';
//$datreg=...;

// Insere o registo de utilizador

$sql1 = "INSERT INTO " . $table_prefix . "users (name,username,email,password,usertype,block,sendEmail,registerDate,lastvisitDate,activation,params) values ('$nome','$username','$email',md5('$password'),'$usertypename','$block','$sendmail', NOW(),'0000-00-00 00:00:00','','')";
mysql_query($sql1);

// recupera o user ID
$sql2 = "SELECT id FROM " . $table_prefix . "users WHERE username = '$username'";
$result = mysql_query($sql2);
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$row = mysql_fetch_row($result);
$user_id = $row[0]; // o id 

// insere o registo na tabela user_usergroup_map  
$sql3 = "INSERT INTO " . $table_prefix . "user_usergroup_map (group_id,user_id) values ('$usertype','$user_id')";
mysql_query($sql3);

$usn = "X". $user_id;
$sql4 = "UPDATE " . $table_prefix . "users SET username = '$usn' WHERE id = '$user_id'";
mysql_query($sql4);

// TABELA DE PROFILES
if ( strlen($apelido) > 1 ) {
 $ord = 1;
  $sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering) values ('$user_id','profile.apelido','$apelido','$ord')";
  mysql_query($sql3);
  }
 
/*          ***********************
 // recupera o user profile
$sql2 = "SELECT user_id,profile_key,profile_value,ordering FROM " . $table_prefix . "user_profiles WHERE user_id = '$user_id'";
$result = mysql_query($sql2);
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$row = mysql_fetch_row($result);
echo 'profile : ' . $row[0] .'---'  . $row[1] .'---'  .$row[2] .'---'  .$row[3] .'---' ; // o id  
         **********************************  */ 
 
// $email
if ( strlen($email) > 1 ) {
 $ord = 2;
  $sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering) values ('$user_id','profile.email','$email','$ord')";
  mysql_query($sql3);
  }
// $telemovel
if ( strlen($telemovel) > 1 ) {
 $ord = 3;
  $sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering)   values ('$user_id','profile.telemovel','$telemovel','$ord')";
  mysql_query($sql3);
    }
// $morada
if ( strlen($morada) > 1 ) {
 $ord = 4;
  $sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering)   values ('$user_id','profile.morada','$morada','$ord')";
  mysql_query($sql3);
    }
// $codpost
 if ( strlen($codpost) > 1 ) {
  $ord = 5;
  $sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering)   values ('$user_id','profile.codpost','$codpost','$ord')";
  mysql_query($sql3);
    }

	
$username = $usn;
$adminnotificationemail = "1"; // NOTOFICA
$notificationemail = "1"; // NOTOFICA	
// envia e-mailS ......
//send notification to added user
if($notificationemail == "1"){
		//Send notification email
		$fromname = "Xheep - Novo Registo de utilizador";
		$from = "info@xheep.com";
		$recipient = $email;
		$subject = "Registo no nosso site";
		$body   = 'Obrigado '. $nome .
				'.<br>Agradecemos o seu registo no Site da Xheep. <br /> <br> <br> Aceda ao site da Xheep e esteja atento às nossas soluções de negócio.<br><br><br><br><br>A Equipa da Xheep, Lda';
		//Send notification
		// echo 'vai enviar o mail'. $from . ' - ' . $fromname . ' - ' . $recipient . ' - ' . $subject . ' - ' . $body;
		$x= JUtility::sendMail($from, $fromname, $recipient, $subject, $body, $mode=1, $cc=null, $bcc=null, $attachment=null, $replyto=null, $replytoname=null);
		echo "[$x]";
		} 

//send notification to admin
	if($adminnotificationemail == "1") {
	// Send notification email //
	$fromname = "Xheep - Novo Registo de utilizador";
	$from = "info@xheep.com";
	$recipient = $from;
	$subject = "Novo utilizador da plataforma:";
	$body   = "Novo utilizador:" .  $nome . ' [' . $username . ' - ' . $email . ']';
 
 	// Send notification //
	// echo 'vai enviar o mail'. $from . ' - ' . $fromname . ' - ' . $recipient . ' - ' . $subject . ' - ' . $body;
	$x = JUtility::sendMail($from, $fromname, $recipient, $subject, $body, $mode=1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
	// Send
	echo "[$x]";
} 

echo 'Obrigado '. $nome .
				'.<br>Agradecemos o seu registo. <br /> <br> <br> Esteja atento às nossas soluções de negócio.<br><br><br><br><br>';
}

// Form para a recolha dos dados 
if ( $ximp == 1 || $tipmov != "IMP" ) {
$tipmov = "IMP"; // variável hidden para acontrolo
$nomebot="Registar";
echo '
<form onsubmit="return validate_form(this);"  action="'.JRoute::_('index.php?option=com_content&view=article&id='.$articleId.'&Itemid='.$itemid).'" method="post" enctype="multipart/form-data">
';
echo '	
<input type="hidden" name="tipmov" value="'. $tipmov .'">


<table width="1150" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="/images/background/bottom_promo_1.jpg" width="274" height="157" /></td>
    <td width="876" height="157" valign="top" background="./images/background/bottom_promo_formulario_registo.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" colspan="3">Formul⳩o de Registo <span class="Boldtitulo">XHEEP.COM<br />
          <br />
        </span></td>
        </tr>
      <tr>
        <td width="5%">&nbsp;</td>
		
		
		
		
		
		
		
        <td width="90%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="260" height="17" valign="bottom" class="left">Empresa              </td>
            <td width="260" valign="bottom" class="left">Morada / Rua</td>
            <td width="233" valign="bottom" class="left">E-Mail</td>
            <td width="4" rowspan="6" valign="bottom" class="left">&nbsp;</td>
            <td width="32" valign="bottom" class="left">&nbsp;</td>
            </tr>
          <tr>
            <td class="left"><input name="empresa2" type="text" id="empresa2" size="35" /></td>
            <td class="left"><input name="empresa2" type="text" id="empresa2" size="35" /></td>
            <td class="left"><input name="empresa2" type="text" id="empresa2" size="25" /></td>
            <td width="32" class="left">&nbsp;</td>
            </tr>
          <tr>
            <td height="17" valign="bottom" class="left">Nome              </td>
            <td valign="bottom" class="left">C󤩧o Postal </td>
            <td valign="bottom" class="left">Telem󶥬 (+351)</td>
            <td width="32" valign="bottom" class="left">&nbsp;</td>
            </tr>
          <tr>
            <td class="left"><input name="empresa3" type="text" id="empresa3" size="35" /></td>
            <td class="left"><input name="empresa3" type="text" id="empresa3" size="4" maxlength="4" />
              -
              <input name="empresa4" type="text" id="empresa4" size="3" maxlength="3" /> </td>
            <td class="left"><input name="empresa2" type="text" id="empresa2" size="25" maxlength="9" /></td>
            <td width="32" class="left">&nbsp;</td>
            </tr>
          <tr>
            <td height="17" valign="bottom" class="left">Apelido              </td>
            <td valign="bottom" class="left">localidade</td>
            <td valign="middle" class="left">&nbsp;</td>
            <td width="32">&nbsp;</td>
            </tr>
          <tr>
            <td class="left"><input name="empresa" type="text" id="empresa" size="35" /></td>
            <td class="left"><input name="empresa" type="text" id="empresa" size="35" /></td>
            <td valign="bottom" class="left"><input type="checkbox" name="checkbox" id="checkbox" />
Aceito as Condi趥s de Registo deste Site.</td>
            <td width="32"><input type="submit" name="button" id="button" value="OK" /></td>
            </tr>
        </table></td>

';	
		printf("<br><br><input type=\"submit\" value=\"%s\">",$nomebot);
		printf("</form>");

}

?> 




