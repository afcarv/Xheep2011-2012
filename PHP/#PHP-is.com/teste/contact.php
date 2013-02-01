

<?php 


$id_ref=$_REQUEST["id_ref"];


$nome = $_REQUEST["nome"];// este é o nome do gajo que referiu e que vem de campaign.php
$emailA = $_REQUEST["emailA"];// este é o email do gajo que referiu e que vem de campaign.php


$nome = utf8_decode($nome);



echo 'Caro '.$nome;



	//session_start();
$notificationemail == "1";
$image = "logois_p.png";  
$width = 300;
$height = 280;
//echo '<center> <img src="'.$image.'" style=width:"' . $width . 'px;height:' . $height . 'px;"></center>';
//echo '<tr><td><center><strong>Formulário de Registo Impressões e Soluções,Lda</strong></center></tr></td>';
echo '<br>O seu Nome aparecerá no e-mail a enviar ao seu amigo. <br>(Os campos marcados com ** devem ser inseridos correctamente para poder referir a um amigo.)<br>
Obrigado por recomendar o nosso Site!<br><br><br>A equipa da Impressões e Soluções.';

/* ******
 *
 * @author afcarv
******* */
 

// ===  1. variáveis de input ======

//include 'listas1.php';

	/*
$nomeA = $_REQUEST["nomeA"];//este é o que vai ser apanhado no form
$apelido = $_REQUEST["apelido"];
$email = $_REQUEST["email"];
*/

$nomeA;
$apelido;
$email;





$mensagem;
$tipmov = "IMP";

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
  
if ( strlen($nomeA) < 2 ) {
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

if(strlen($mensagem)>1){
$mensagemFinal="Campos inválidos: ".$mensagem;

}
else{
$mensagemFinal="";
}

}



$ximp = 0 ;
 $tipmov = "IMP";
 $emailexiste = "0";


// 3. Passa ao insert
 // tenta fazer o insert
// temos nome , apelido e email, já podemos gerar uma conta!
// na primeira fase, u utilizador é gerado pela função time...


$username = time();	
$password =  rand(1001, 9999);
$block = '0';
$sendmail = '0';
$usertype ='2';
	
$nomeA = utf8_encode($nomeA);
$morada = utf8_encode($morada);
$apelido = utf8_encode($apelido);
$empresa = utf8_encode($empresa);	
	
$teste = "olá";
$ximp = 1 ;
	
// Form para a recolha dos dados 
if ( $ximp == 1 || $tipmov != "IMP" ) {
$tipmov = "IMP"; // variável hidden para acontrolo
$nomebot="Enviar Mensagem";
echo '
<form onsubmit="return validate_form(this);"  action="email.php" method="post" enctype="multipart/form-data">
';

//hiddne porque preciso de os passar no formulário para o email.php
echo '	


<strong>Nome:</strong> <input style="text-align:left" type="text" name="nomeA" size="60" value="'.$nomeA.'" class="sel2" >
<strong>Apelido: </strong> <input style="text-align:left" type="text" name="apelido" size="60" value="'.$apelido.'" class="sel2">
<strong>E-mail:</strong> <input style="text-align:left" type="text" name="email" size="60" value="'.$email.'" class="sel2" >
	
<input type="hidden" name="tipmov" value="'. $tipmov .'">
<input type="hidden" name="id_ref" value="'. $id_ref .'">
<input type="hidden" name="nome" value="'. $nome .'">
<input type="hidden" name="emailA" value="'. $emailA .'">
	
      <input name="button" type="submit" id="button" tabindex="9" value="Enviar Mensagem"/>
	  
	  
    </span></span>

 ';
	
	
	
	
// printf("<input type=\"button\" value=\"Submeter \" onclick=\"javascript:PagFin(this.form)\">&nbsp;");

		//    printf("<p class=\"sel4\"> <a href=\"campaign.php?tip_mov=%s&id_ref=%s\"><b>Submeter</b></a></span>","NEW",0);
		//printf("<br><br><input type=\"submit\" value=\"%s\">",$nomebot);
		
		
echo '
</form>';
}
echo '
</body>
</html>';
?> 
 



