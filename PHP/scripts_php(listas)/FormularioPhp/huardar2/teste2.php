<?php defined('_JEXEC') or die('Restricted access'); 

/**
 *
 * @author afcarv
 */
 
$image = "logois_p.png";  
$width = 300;
$height = 280;
echo '<center> <img src="'.$image.'" style=width:"' . $width . 'px;height:' . $height . 'px;"></center>';
echo '<tr><td><center><strong>Formulário de Registo Impressões e Soluções,Lda</strong></center></tr></td>';
// variáveis de ambientec

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

$itemid = JRequest::getInt('Itemid', 0); 
$articleId = JRequest::getInt('id', 0);
// printf("%s %s",$sido, $sent );


// 1. variáveis de input (tipmov é )

$tipmov = JRequest::getVar('tipmov');
$nome = JRequest::getVar('nome');
$apelido = JRequest::getVar('apelido');
$morada = JRequest::getVar('morada');
$telemovel = JRequest::getVar('telemovel');
$email = JRequest::getVar('email');
$codpost = JRequest::getVar('codpost');
$municip = JRequest::getVar('municip');
$sexo = JRequest::getVar('sexo');
$aniversario = JRequest::getVar('aniversario');

$ximp = 0; // valor inicial 
 echo ' <hr> ' .
 $tipmov .'Nome:'.$nome . ' Apelido:'.$apelido. '  Morada:'.$morada. ' Telemóvel:'.$telemovel . '  Endereço electrónico:'.$email . '  Código Postal:'.$codpost . '  Área de residência:'.$municip . '  Sexo:'.$sexo.'  Data de Aniversário:'. $aniversario .
 ' <center>*Todos os campos são de preenchimento obrigatório. Obrigado</center><hr> ' ;
 
 // se o tipmov for nulo vai directo para o form de imput 
 
  // 2. validações
  // 2.1
if ( strlen($nome) < 2 ) {
echo 'Por favor indique o Nome';
 $ximp = 1;
}

if ( strlen($apelido) < 2 ) {
echo 'Por favor indique o Apelido';
 $ximp = 1;
}

if ( strlen($email) < 5 ) {
echo 'Por favor indique um endereço de e-mail';
 $ximp = 1;
}

// 2.2 - se o ximp fôr 1, ou tipmov nulo, não pode fazer insert, vai para o form 

if( $ximp == 0 && $tipmov == "IMP") { // tenta saber se o e-mail já existe
//echo "ponto 2";
if (strlen($email) > 5) {	
// verifica se o e-mail existe na base de dados
$sql = mysql_query("SELECT email FROM " . $table_prefix . "users WHERE email='" . $email . "'");   // refsql#1
$num_rows = mysql_num_rows($sql);
if($num_rows == 0){
$email = $email;
$emailexiste = "0"; 
} else {	 
$emailexiste = "1"; //This email already exists in the joomla user db
$ximp = 1; // liga o form 
echo '<br/>
PPor favor utilize outro endereço de e-mail, já exite uma conta associada ao email que inseriu.'. $email;
}
}
}
// 3. Passa ao insert
if( $ximp == 0 && $tipmov == "IMP" && $emailexiste == "0") { // tenta fazer o insert
// temos nome , apelido e email, já podemos gerar uma conta!
// na primeira fase, u utilizador é gerado pela funçaõ time...
//echo "ponto 3";
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


echo '
<hr>
Obrigado '. $nome .
' Agradecemos o seu registo, <br /> a sua conta tem o utlizador:' .
$username . 
' password: ' . $password .
'<hr>';

/*
echo '
<hr>
Registo efectuado com secesso.  Obrigado caro(a) '. $nome .
' pelo seu registo.  Dados da sua conta: Nome de utlizador:' .
$username . 
' Senha: ' . $password .
'Por favor guarde estas credenciais para proceder à autenticação na página da Impressões e Soluções, lda';

*/

}

// Form para a recolha dos dados 
if ( $ximp == 1) {
$tipmov = "Dados de Registo: "; // variável hidden para acontrolo
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
<tr> <td><strong>Morada:</strong></td><td>
<tr> <td><input type="text" name="morada" value="'.$morada.'" size="45">  </td></tr>
<tr> <td><strong>Telemóvel: </strong></td></tr>
<tr> <td>(+351)<input type="text" name="telemovel" value="'.$telemovel.'" size="25"> </td></tr>
<tr> <td><strong>Email:</strong></td><td>
<tr> <td><input type="text" name="email" value="'.$email.'" size="45">  </td></tr>



<tr> <td><strong>Código Postal:</strong></td><td>
<tr> <td><input type="text" name="codpost" value="'.$codpost.'" size="45">  </td></tr>

<tr> <td><strong>Município:</strong></td><td>
<tr> <td><input type="text" name="municip" value="'.$municip.'" size="45">  </td></tr>





<tr> <td><strong>Sexo:</strong></td><td> 
<tr> <td>Masculino: <input type="radio" name="sexo" value="M" ';
if ( $sexo == "M") echo "CHECKED";
echo ' > Feminino:<input type="radio" name="sexo" value="F" ';
if ( $sexo == "F") echo "CHECKED";
echo ' ></td></tr>

<tr> <td><strong>Aniversário:</strong></td><td>
<tr> <td><strong><input type="text" name="aniversario" value="'.$aniversario.'" size="15"> (AAAA-MM-DD)</strong></td></tr>
</table>
';	
		printf("<br><br><input type=\"submit\" value=\"%s\">",$nomebot);
		printf("</form>");
		
		
		
		
		

}
/*
/*$to = "recipient@example.com";
 $subject = "Hi!";
 $body = "Hi,\n\nHow are you?";
 if (mail($to, $subject, $body)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");*/


?> 

