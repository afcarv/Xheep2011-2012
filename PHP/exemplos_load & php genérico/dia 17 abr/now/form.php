<?php defined('_JEXEC') or die('Restricted access'); 

$image = "logois_p.png";  
$width = 300;
$height = 280;
//echo '<center> <img src="'.$image.'" style=width:"' . $width . 'px;height:' . $height . 'px;"></center>';
//echo '<tr><td><center><strong>Formulário de Registo Impressões e Soluções,Lda</strong></center></tr></td>';

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

//include 'listas1.php';

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

$aceite = JRequest::getVar('aceite');

$empresa = JRequest::getVar('empresa');





$ximp = 0; // valor inicial 

/* ************************
 echo ' <hr>[ ' .
 $tipmov . $nome . $apelido. $morada. $telemovel . $email . $codpost . $municip . $sexo. $empresa .
 '<br>] <center>*Todos os campos são de preenchimento obrigatório. Obrigado</center> <hr> ' ;
 ********************** */
 
 // se o tipmov for nulo vai directo para o form de imput 
 
  // 2. validações
  // 2.1
  if( $tipmov == "IMP") {
  
if ( strlen($nome) < 2 ) {
//echo '<p style="color:#F00">  Por favor indique o Nome </p>';
$mensagem1="Nome, ";
$mensagem=$mensagem. $mensagem1;
//echo '<p style="color:#F00"> '.$mensagem;
 $ximp = 1;
}

if ( strlen($apelido) < 2 ) {
//echo '<p style="color:#F00"> Por favor indique o Apelido</p>';
$mensagem2="Apelido, ";
$mensagem=$mensagem. $mensagem2;
 $ximp = 1;
}

if ( strlen($email) < 5 ) {
//echo '<p style="color:#F00">  Por favor indique um endereço de e-mail</p>';
$mensagem3="E-mail, ";
$mensagem=$mensagem. $mensagem3;
 $ximp = 1;
}

/*

if ( strlen($telemovel) < 9 ) {
//echo '<p style="color:#F00"> Por favor indique um contacto de telemovel</p>';
$mensagem4="Telemóvel, ";
$mensagem=$mensagem. $mensagem4;
 $ximp = 1;
}

*/


if ( strlen($morada) < 2 ) {
//echo '<p style="color:#F00">  Por favor indique o seu local de residência</p>';
$mensagem5="Morada, ";
$mensagem=$mensagem. $mensagem5;
 $ximp = 1;
}

if(strlen($codpost3) < 3){

	$mensagem300="Localidade, ";
	$mensagem=$mensagem. $mensagem300;
	$ximp = 1;

}


$codpost=$codpost1 . '-' . $codpost2 . ' '. $codpost3;
if ( strlen($codpost) < 9 ) {
//echo '<p style="color:#F00">  Por favor indique o seu código postal</p>';
$mensagem6="Código Postal, ";
$mensagem=$mensagem. $mensagem6;
 $ximp = 1;
}



if ( strlen($empresa) < 2 ) {
//echo '<p style="color:#F00">  Por favor indique o nome da sua Empresa.</p>';
$mensagem7="Empresa, ";
$mensagem=$mensagem. $mensagem7;
 $ximp = 1;
}

if ( $aceite != "SIM" ) {
//echo '<p style="color:#F00">  Por favor confirme que leu e aceita os termos de serviço </p>';
$mensagem8="Condições de Registo. ";
$mensagem=$mensagem. $mensagem8;
 $ximp = 1;
}

if(strlen($mensagem)>1){
$mensagemFinal="Campos inválidos: ".$mensagem;

}
else{
$mensagemFinal="";
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
Por favor utilize outro endereço de e-mail, já exite uma conta associada ao e-mail que inseriu.'. $email;
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

$nome = utf8_decode($nome);
$morada = utf8_decode($morada);
$apelido = utf8_decode($apelido);
$empresa = utf8_decode($empresa);



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

$usn = "Xheep". $user_id;
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
// $municip
 if ( strlen($municip) > 1 ) {
  $ord = 6;
  $sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering)   values ('$user_id','profile.municip','$municip','$ord')";
  mysql_query($sql3);
    }
// $sexo
if ( strlen($sexo) > 0 ) {
  $ord = 7;
  $sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering)   values ('$user_id','profile.sexo','$sexo','$ord')";
  mysql_query($sql3);
    }
// $empresa
if ( strlen($empresa) > 1 ) {
  $ord = 8;
  $sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering)   values ('$user_id','profile.empresa','$empresa','$ord')";
  mysql_query($sql3);
    }
	
	

$nome = utf8_encode($nome);
$morada = utf8_encode($morada);
$apelido = utf8_encode($apelido);
$empresa = utf8_encode($empresa);	
		
	
	
	
$username = $usn;
$adminnotificationemail = "1"; // NOTOFICA
$notificationemail = "1"; // NOTOFICA	
// envia e-mailS ......
//send notification to added user
if($notificationemail == "1"){
		//Send notification email
		$fromname = "Xheep - Novo Registo de Utilizador";
		//$from = "geral@euestouaqui.com";
		//$from = "andre@impressoesesolucoes.com";
		$from = "info@xheep.com";
		$recipient = $email;
		$subject = "Registo no site da Xheep, Lda";
		$body   = 'Obrigado '. $nome .
				'.<br>Agradecemos o seu registo no Site da Xheep. <br /> <br> <br> Aceda ao site da Xheep e esteja atento às nossas soluções de negócio.<br><br><br><br><br>A Equipa da Xheep, Lda';
		//Send notification
		// echo 'vai enviar o mail'. $from . ' - ' . $fromname . ' - ' . $recipient . ' - ' . $subject . ' - ' . $body;
		$x= JUtility::sendMail($from, $fromname, $recipient, $subject, $body, $mode=1, $cc=null, $bcc=null, $attachment=null, $replyto=null, $replytoname=null);
		//echo "[$x]";
		} 

//send notification to admin
	if($adminnotificationemail == "1") {
	// Send notification email //
	$fromname = "Xheep - Novo registo de utilizador";
	//$from = "geral@euestouaqui.com";
	//$from = "andre@impressoesesolucoes.com";
	$from = "info@xheep.com";
	$recipient = $from;
	$subject = "Novo utilizador da plataforma:";
	$body   = "Novo utilizador:" .  $nome . ' [' . $username . ' - ' . $email . ']';
 
 	// Send notification //
	// echo 'vai enviar o mail'. $from . ' - ' . $fromname . ' - ' . $recipient . ' - ' . $subject . ' - ' . $body;
	$x = JUtility::sendMail($from, $fromname, $recipient, $subject, $body, $mode=1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
	// Send
	//echo "[$x]";
} 
echo '<table width="680" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="100" align="center" valign="middle" style= "color:#6a7f08;font-size:14px;"><b><br>
      Obrigado '. $nome .
	'.<br>Agradecemos o seu registo. <br /><br>Esteja atento às nossas soluções de negócio!<br>
    </b></td>
  </tr>
</table>';


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
<style type="text/css">
.Cuprum {
	font-size: 20px;
	font-family: Cuprum;
	color: #6a7f08;
}
.cup {
	font-family: CuprumFFU;
}
lett {
	font-weight: bold;
}
.cuuup {
	color: #666666;
}
.cuuup {
	font-family: CuprumFFU;
}
.white {
	color: #FFFFFF;
}
.cuprum14 {
	font-size: 14px;
}
.cuprum14white {
	color: #FFFFFF;
}
.cuprum14 {
	font-family: CuprumFFU;
}
.cuprum14 {
	font-size: 14px;
}
.cuprum14 {
	font-size: 16px;
}
.C12white {
	font-family: CuprumFFU;
}
.C12white {
	font-size: 14px;
}
</style>
</head>

<body>
<table width="680" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="35" colspan="4" valign="top" class="Cuprum">Formulário de Registo</td>
  </tr>
  <tr class="C12white">
    <td valign="bottom" class="cuprum14white" style="font-size: 12px; font-family: CuprumFFU; color: #6a7f08;">EMPRESA </td>
    <td valign="bottom" class="cuprum14white" style="font-size: 12px; color: #6a7f08;">MORADA / RUA</td>
    <td valign="bottom" class="cuprum14white" style="font-size: 12px; color: #6a7f08;">E-MAIL</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" valign="top"><span class="left">
      <input name="empresa" value="'.$empresa.'" type="text" id="empresa" size="30" tabindex="1"/>
    </span></td>
    <td height="30" valign="top"><span class="left">
      <input name="morada" value="'.$morada.'" type="text" id="morada" size="30" tabindex="4"/>
    </span></td>
    <td height="30" valign="top"><span class="left">
      <input name="email" value="'.$email.'" type="text" id="email" size="30" tabindex="8"/>
    </span></td>
    <td height="30" valign="top">&nbsp;</td>
  </tr>
  <tr class="C12white">
    <td valign="bottom" class="cuprum14white" style="font-size: 12px; color: #6a7f08;">NOME</td>
    <td valign="bottom" class="cuprum14white" style="font-size: 12px; color: #6a7f08;">CÓDIGO POSTAL</td>
    <td valign="bottom" class="cuprum14white" style="font-size: 12px; color: #6a7f08;">TELEMÓVEL (+351)</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" valign="top"><span class="left">
      <input name="nome" value="'.$nome.'" type="text" id="nome" size="30" tabindex="2"/>
    </span></td>
    <td height="30" valign="top"><span class="left">
      <input name="codpost4" value="'.$codpost1.'" type="text" id="codpost4" size="4" maxlength="4" tabindex="5"/>
      -
      <input name="codpost4" value="'.$codpost2.'" type="text" id="codpost5" size="3" maxlength="3" tabindex="6"/>
    </span></td>
    <td height="30" valign="top"><span class="left">
      <input name="telemovel" value="'.$telemovel.'" type="text" id="telemovel" size="20" maxlength="9" tabindex="9"/>
    </span></td>
    <td height="30" valign="top">&nbsp;</td>
  </tr>
  <tr class="C12white">
    <td valign="bottom" class="cuprum14white" style="font-size: 12px; color: #6a7f08;">APELIDO</td>
    <td valign="bottom" class="cuprum14white" style="font-size: 12px; color: #6a7f08;">LOCALIDADE</td>
    <td valign="bottom" class="cuprum14" style="font-size: 12px">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" valign="top"><span class="left">
      <input name="apelido" value="'.$apelido.'" type="text" id="apelido" size="30" tabindex="3"/>
    </span></td>
    <td height="30" valign="top"><span class="left">
      <input name="codpost3" value="'.$codpost3.'" type="text" id="codpost3" size="30" tabindex="7"/>
    </span></td>
    <td valign="bottom"><input type="checkbox" value="SIM" name="aceite" tabindex="10" />
      <span class="tahoma10white"  style= "color:#ffffff;">Aceito as Condições de Registo deste Site!</span></td>
    <td valign="bottom"><input name="button" type="submit" id="button" tabindex="11" value="OK"/></td>
  </tr>
  <tr>
    <td height="25" colspan="4" valign="bottom"><span class="tahoma10white" style="color:#6a7f08"><span class="cuprum14"><span class="C12white">'.$mensagemFinal.'&nbsp;</span></span></span></td>
  </tr>
</table>
</body>';	
		//printf("<br><br><input type=\"submit\" value=\"%s\">",$nomebot);
		
		
		
		
		
		printf("</form>");
		
		
		

}

?> 
 



