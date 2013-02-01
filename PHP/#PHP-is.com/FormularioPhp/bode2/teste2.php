<?php defined('_JEXEC') or die('Restricted access'); 

// variáveis de ambiente

//   Set query DB
$db = JFactory::getDBO();
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
 $tipmov . $nome . $apelido. $morada. $telemovel . $email . $codpost . $municip . $sexo. $aniversario .
 ' <hr> ' ;
 
 // se o tipmov for nulo vai directo para o form de imput 
 
  // 2. validações
  // 2.1
if ( strlen($nome) < 2 ) {
echo 'Tem de indicar o Nome';
 $ximp = 1;
}

if ( strlen($apelido) < 2 ) {
echo 'Tem de indicar o Apelido';
 $ximp = 1;
}

if ( strlen($email) < 5 ) {
echo 'Tem de indicar um e-mail para contacto';
 $ximp = 1;
}

// 2.2 - se o ximp fôr 1, ou tipmov nulo, não pode fazer insert, vai para o form 

if( $ximp == 0 && $tipmov == "IMP") { // tenta saber se o e-mail já existe
echo "ponto 2";
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
Por favor utilize outro endereço de e-mail, já exite uma conta associada a este mail ....'. $email;
}
}
}
// 3. Passa ao insert
if( $ximp == 0 && $tipmov == "IMP" && $emailexiste == "0") { // tenta fazer o insert
// temos nome , apelido e email, já podemos gerar uma conta!
// na primeira fase, u utilizador é gerado pela funçaõ time...
echo "ponto 3";
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
}

// Form para a recolha dos dados 
if ( $ximp == 1) {
$tipmov = "IMP"; // variável hidden para acontrolo
$nomebot="Continuar";
echo '
<form onsubmit="return validate_form(this);"  action="'.JRoute::_('index.php?option=com_content&view=article&id='.$articleId.'&Itemid='.$itemid).'" method="post" enctype="multipart/form-data">
';
echo '	
<input type="hidden" name="tipmov" value="'. $tipmov .'">
<table bgcolor=#f4f4f4>
<tr> <td>Nome</td><td><input type="text" name="nome" value="'.$nome.'" size="25"> <b>primeiro</b> nome</td></tr>
<tr> <td>Apelido</td><td><input type="text" name="apelido" value="'.$apelido.'" size="25"> o <b>último</b> nome</td></tr>
<tr> <td>Morada</td><td><input type="text" name="morada" value="'.$morada.'" size="45"> <b>rua, nº de porta, andar</b> </td></tr>
<tr> <td>Telemóvel</td><td><input type="text" name="telemovel" value="'.$telemovel.'" size="25"> </td></tr>
<tr> <td>Email</td><td><input type="text" name="email" value="'.$email.'" size="45"> <b>e-mail</b> </td></tr>
<tr> <td>Código Postal</td><td><input type="text" name="codpost" value="'.$codpost.'" size="45"> <b>9999-999 COIMBRA</b> </td></tr>
<tr> <td>Município</td><td><input type="text" name="municip" value="'.$municip.'"  size="45"> escolha</td></tr>
<tr> <td>Sexo</td><td> Masculino: <input type="radio" name="sexo" value="M" ';
if ( $sexo == "M") echo "CHECKED";
echo ' >  Feminino:<input type="radio" name="sexo" value="F" ';
if ( $sexo == "F") echo "CHECKED";
echo ' ></td></tr>
<tr> <td>Aniversário</td><td><input type="text" name="aniversario" value="'.$aniversario.'" size="15"> (AAAA-MM-DD)</td></tr>
</table>
';	
		printf("<br><br><input type=\"submit\" value=\"%s\">",$nomebot);
		printf("</form>");

}

?> 




