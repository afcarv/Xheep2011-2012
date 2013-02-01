<?php defined('_JEXEC') or die('Restricted access'); 


$image = "logois_p.png";  
$width = 300;
$height = 280;
//echo '<center> <img src="'.$image.'" style=width:"' . $width . 'px;height:' . $height . 'px;"></center>';
echo '<tr><td><center><strong>Formulário de Registo Impressões e Soluções</strong></center></tr></td>';
//echo '<tr><td><br><br>*Todos os campos são de preenchimento obrigatório. <br></tr></td>';


/* ******
 *
 * @author André Carvalho(afcarv)
 * Jan´12
******* */
 
// variáveis de ambiente

//echo "\n TESTE4 \n";

//   Set query DB

$xho = "localhost";
$xus = "impresso_andre";
$xpw = "Serv2011";

$liga=mysql_connect($xho,$xus,$xpw);

if ( !$liga ) {
	printf("Erro de ligação à base de dados!");
	printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
}


$idtab = 'impresso_ISsite.impresso_camp';
$idbas = 'impresso_ISsite';

/*
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
*/


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

$telemovel = JRequest::getVar('telemovel');
$email = JRequest::getVar('email');

$sexo = JRequest::getVar('sexo');
$aniversario = JRequest::getVar('aniversario');

$conhecimento = JRequest::getVar('conhecimento');

$aceite = JRequest::getVar('aceite');

//== variáveis extra para data de aniversário:
$mes = JRequest::getVar('mes');
$dia = JRequest::getVar('dia');





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


/*
if ( strlen($telemovel) < 9 ) {
echo '<p style="color:#F00"> Por favor indique um contacto de telemovel</p>';
 $ximp = 1;
}
*/


$codpost=$codpost1 . '-' . $codpost2 . ' '. $codpost3;
if ( strlen($codpost) < 9 || strlen($codpost)<2) {
echo '<p style="color:#F00">  Por favor indique o seu código postal</p>';
 $ximp = 1;
}



/*

if ( strlen($conhecimento) < 1 ) {
echo '<p style="color:#F00">  Por favor indique o veículo pelo qual tomou conhecimento da impressões  e soluções</p>';
 $ximp = 1;
 
}*/


$aniversario=$mes . '-' . $dia ;
/*
if ( strlen($aniversario) < 2 ) {
echo '<p style="color:#F00">  Por favor indique o aniversario</p>';
 $ximp = 1;
}

*/

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
Por favor utilize outro endereço de e-mail, já existe uma conta associada ao email que inseriu: <br>'. $email;
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

$usn = "IS". $user_id;
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
// $aniversario
if ( strlen($aniversario) > 1 ) {
  $ord = 8;
  $sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering)   values ('$user_id','profile.aniversario','$aniversario','$ord')";
  mysql_query($sql3);
    }
	
// $conhecimento
if ( strlen($conhecimento) > 0 ) {
  $ord = 9;
  $sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering)   values ('$user_id','profile.conhecimento','$conhecimento','$ord')";
  mysql_query($sql3);
    }
	
$username = $usn;
$adminnotificationemail = "1"; // NOTOFICA
$notificationemail = "1"; // NOTOFICA	

$nome = utf8_encode($nome);
$morada = utf8_encode($morada);
$apelido = utf8_encode($apelido);


// envia e-mailS ......
//send notification to added user
if($notificationemail == "1"){
		//Send notification email
		$fromname = "Impressões e Soluções - Novo Registo de Utilizador";
		//$from = "geral@euestouaqui.com";
		//$from = "andre@impressoesesolucoes.com";
		$from = "geral@impressoesesolucoes.com";
		$recipient = $email;
		$subject = "Registo no site da Impressões e Soluções, Lda";
		
		$body   = 'Obrigado '. $nome .
				'.<br>Agradecemos o seu registo no Site da Impressões e Soluções. <br /> Os dados da sua conta são:<br><hr> - Nome de Utilizador: ' .
				$usn. '<br>- Senha: ' . $password .
				'<hr> Guarde este e-mail para futuros acessos à área de cliente do Site da Impressões e Soluções. <br> <br> Aceda ao site da Impressões e Soluções com a sua nova conta em:<br>www.impressoesesolucoes.com<br><br><br><br><br>A Equipa da Impressões e Soluções, Lda';
		//Send notification
		// echo 'vai enviar o mail'. $from . ' - ' . $fromname . ' - ' . $recipient . ' - ' . $subject . ' - ' . $body;
		$x= JUtility::sendMail($from, $fromname, $recipient, $subject, $body, $mode=1, $cc=null, $bcc=null, $attachment=null, $replyto=null, $replytoname=null);
		//echo "[$x]";
		} 
			
		

//send notification to admin
	if($adminnotificationemail == "1") {
	// Send notification email //
	$fromname = "Impressões e Soluções - Novo registo de utilizador";
	//$from = "geral@euestouaqui.com";
	//$from = "andre@impressoesesolucoes.com";
	$from = "geral@impressoesesolucoes.com";
	$recipient = $from;
	$subject = "Novo utilizador da plataforma:";
	$body   = "Novo utilizador:" .  $nome . ' [' . $username . ' - ' . $email . ']';
 
 	// Send notification //
	// echo 'vai enviar o mail'. $from . ' - ' . $fromname . ' - ' . $recipient . ' - ' . $subject . ' - ' . $body;
	$x = JUtility::sendMail($from, $fromname, $recipient, $subject, $body, $mode=1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
	// Send
	//echo "[$x]";
} 

echo '
Obrigado '. $nome .
'.<br>Agradecemos o seu registo no site da Impressões e Soluções, onde poderá aceder a promoções exclusivas. <br /> Os dados da sua conta são os seguintes:<br>
- Utlizador: ' .
$usn. '<br>- Password: ' . $password .
'<br>Guarde os dados do seu registo para futuros acessos ao nosso Site. <br>Obrigado!<br><br><br><br>A equipa da Impressões e Soluções, Lda ';
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
<table bgcolor=#f4f4f4>
<tr> <td><strong>Nome:</strong></td><td>
<tr> <td><input type="text" name="nome" value="'.$nome.'" size="25"> </tr>

<tr> <td><strong>Apelido:</td><td>
<tr> <td><input type="text" name="apelido" value="'.$apelido.'" size="25"> </tr>


<tr> <td><strong>E-mail:</strong></td><td>
<tr> <td><input type="text" name="email" value="'.$email.'" size="45">  </td></tr>


<tr> <td><strong>Morada:</strong></td><td>
<tr> <td><input type="text" name="morada" value="'.$morada.'" size="45">  </td></tr>


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
<input type="text" name="codpost3" value="'.$codpost3.'" size="20">
</td></tr>



<tr> <td><strong>Sexo:</strong></td><td> 
<tr> <td>Masculino: <input type="radio" name="sexo" value="M" ';
if ( $sexo == "M") echo "CHECKED";
echo ' > Feminino:<input type="radio" name="sexo" value="F" ';
if ( $sexo == "F") echo "CHECKED";
echo ' ></td></tr>



	
<tr><td valign=top><strong>Aniversário:</strong></strong></td></tr>

<tr> <td>
    <select name="dia">
    <option selected>Dia</option>';
	if ( strlen($dia) == 0) $dia = "1";
	foreach ($dias as $nm1) {
	if ( $dia == $nm1) $sel = "SELECTED"; else $sel = "";
  echo '<option value="' .$nm1. '" '. $sel .'>'.$nm1.'</option>';
}
 echo '</select>
 <select name="mes">
    <option selected>Mês</option>';
	if ( strlen($mes) == 0) $mes = "Janeiro";
	foreach ($meses as $nm2) {
	if ( $mes == $nm2) $sel = "SELECTED"; else $sel = "";
  echo '<option value="' .$nm2. '" '. $sel .'>'.$nm2.'</option>';
}
 echo '</select><strong>
 
 
 
    
    Insira a sua data de aniversário, para receber um presente.</strong></tr></td>
	


<tr> <td><strong>Telemóvel: </strong></td></tr>
<tr> <td>(+351)<input type="text" name="telemovel" value="'.$telemovel.'" size="25"> <strong>Receba as nossas promoções no seu telemóvel por SMS.</strong></td></tr>

<tr> <td><br><strong>Tomei conhecimento do site da Impressões e Soluções via: </strong></tr> </td>
<tr> <td>Facebook: <input type="radio" name="conhecimento" value="facebook" ';
if ( $conhecimento == "facebook") echo "CHECKED";

echo ' > Flyers:<input type="radio" name="conhecimento" value="flyers" ';
if ( $conhecimento == "flyers") echo "CHECKED";

echo ' > Amigos:<input type="radio" name="conhecimento" value="amigos" ';
if ( $conhecimento == "amigos") echo "CHECKED";

echo ' > Outro:<input type="radio" name="conhecimento" value="outro" ';
if ( $conhecimento == "outro") echo "CHECKED";

echo ' ></td></tr>




<tr> <td><br>Li e aceito os Termos e Condições de Utilização e Registo deste Site bem como as Condições de Promoções e Ofertas.  <input type="checkbox" value="SIM" name="aceite"><br /></tr> </td> <br/> 



</table>
';	
		printf("<br><br><input type=\"submit\" value=\"%s\">",$nomebot);
		printf("</form>");

}

?> 




