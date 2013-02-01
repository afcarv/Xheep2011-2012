<?php

require_once('php_mailer/class.phpmailer.php');
      
	  $nome = $_REQUEST['nome'];//quem referiu(nome)
	 $nomeA = $_REQUEST['nomeA'];//nome alvo
	 $apelido = $_REQUEST['apelido'];//apelido alvo
	 $email = $_REQUEST['email'];//alvo
	 $emailA = $_REQUEST['emailA'];//email de quem referiu
	 $id_ref = $_REQUEST['id_ref'];//quem referiu
	 echo '<br>Quem referiu tinha o id: '.$id_ref.'<br>';
	 echo '<br>Nome de quem referiu '.$nome.'<br>';
	 echo '<br>Nome : '.$nomeA.'<br>';
	 echo '<br>Apelido: '.$apelido.'<br>';
	 echo '<br>E-mail: '.$email.'<br><br>';
	 
    // Inicia a classe PHPMailer
    $mail = new PHPMailer();     
    // Define os dados do servidor e tipo de conexão
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    $mail->IsSMTP(); // Define que a mensagem será SMTP    $mail->Host = "smtp.dominio.net"; // Endereço do servidor SMTP
    $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
    $mail->Username = 'geral@impressoesesolucoes.com'; // Usuário do servidor SMTP
    $mail->Password = 'Gis2011'; // Senha do servidor SMTP
         // Define o remetente
   // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->From = "geral@impressoesesolucoes.com"; // Seu e-mail
   $mail->FromName = "Impressões e Soluções"; // Seu nome
     
   // Define os destinatário(s)    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=   
   $mail->AddAddress($email, $nomeA);//    $mail->AddAddress('ciclano@site.net');
    //$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
    //$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
     $new="NEW";
    // Define os dados técnicos da Mensagem
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
   //$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
     
    // Define a mensagem (Texto e Assunto)
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->Subject  = "Campanha Impressões e Soluções"; // Assunto da mensagem
	/* $mail->Body = 'Caro (a) '.$nomeA.'.<br>
O seu amigo, '. $nome .' ('.$emailA.'), pensa que estará interessado(a) na campanha para personalização de calendários, da Impressões e Soluções.<br>
Consulte a campanha online em: http://www.impressoesesolucoes.com/teste/campaign.php?tip_mov=$new&email=$email&id_ref=$id_ref e aproveite para personalizar já o seu calendário.<br><br>
A Equipa da Impressões e Soluções, Lda';
*/

// $mail->Body = '<p>A alteração deste endereço pode ser realizada seguindo o link:<a href="http://www.impressoesesolucoes.com/teste/campaign.php?tip_mov=.'$new.'&email=.'$email.'&id_ref=.'$id_ref.'></a></p>'; 

$body = '<p>Caro (a) '.$nomeA.'.<br>
O seu amigo, '. $nome .' ('.$emailA.'), pensa que estará interessado(a) na campanha para personalização de calendários, da Impressões e Soluções.<br>
Consulte a campanha online em: <a href="http://www.impressoesesolucoes.com/teste/campaign.php?tip_mov='.
$new . '&email='. $email .'&id_ref=' . $id_ref . '"> Campanha Impressões e Soluções </a> e aproveite para personalizar já o seu calendário.<br><br>
A Equipa da Impressões e Soluções, Lda</p>';

echo 'aqui vai o body'. $body;

	$mail->Body = $body;
	 $mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n ";
   // $mail->Body = "Este é o corpo da mensagem de teste, em <b>HTML</b>! <br /> //<img src="http:blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";
   // $mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n <img src="http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";
    
    // Define os anexos (opcional)
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
	 //-------------------------------------------------------------------------------------------------------------
    //insere na tabela impresso_camp um registo
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
	
	$nome = $nomeA;
	$apelido = $apelido;
	$aniversario = "referral";
	$email = $email;
	$opcao = "referral";
	$data = "referral";
	$id_ref = $id_ref;
	
	
	// AQUI NÃO TENHO A CERTEZA MAS ACHO QUE TEM DE SER COMENTADO PORQUE ISTO SÓ DEVE SER INSERIDO QUANDO O GAJO INSERE O CALENDÁRIO
	//$sql = "insert into $idtab  ( nome,apelido,aniversario,email,opcao,date,id_ref) values ('$nome','$apelido','$aniversario', '$email', '$opcao','$data', '$id_ref') ";
	
	//echo 'vai inserir '.$sql;
	
	//echo $sql;
	$result= mysql_db_query($idbas,$sql);
	
	//-------------------------------------------------------------------------------------------------------------
	
	
	// Envia o e-mail
	$enviado = $mail->Send();
     
    // Limpa os destinatários e os anexos
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
     
    // Exibe uma mensagem de resultado
    if ($enviado) {
    echo "E-mail enviado com sucesso!<br>O seu amigo receberá um e-mail com um link para a campanha da Impressões e Soluções.<br>Obrigado por sugerir a nossa campanha.";
    } else {
    echo "Não foi possível enviar o e-mail.<br /><br />";
   echo "<b>Informações do erro:</b> <br />" . $mail->ErrorInfo;
    }
	
	
printf("<p class=\"sel4\"> <a href=\"campaign.php?\"><b>Continuar</b></a></span>"); 

/*
//aqui apanha as coisas que vêm de contact.php:
$destinatario_nome = $_REQUEST['nomeA'];
$id_ref = $_REQUEST['id_ref'];//quem referiu		
$destinatario_email = $REQUEST['email'];		
$destinatario_apelido = $REQUEST['apelido'];		

echo 'id_ref->'.$id_ref;

//require_once("lib/Components/PHPMailer/class.phpmailer.php");
require_once('php_mailer/class.phpmailer.php');

$PHPMailer = new PHPMailer();

$PHPMailer->Host = '81.92.207.154';

$PHPMailer->From = 'geral@impressoesesolucoes.com';

$PHPMailer->Subject = 'Campanha de Marketing Personalizado - Impressões e Soluções';

$PHPMailer->AddAddress('andrevercetti@gmail.com');

$PHPMailer->Body = 'Caro '.$nome.'<br>.
					O seu Amigo, '. $nomeA .' , pensa que estará interessado na nossa campanha para personalização de calendários
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Consulte a campanha online em: http://www.impressoesesolucoes.com/teste/campaign.php e aproveite para personalizar já o seu calendário.
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
A Equipa da Impressões e Soluções, Lda';



# Tenta enviar o e-mail e analisa o resultado

if($PHPMailer->Send()) {

    echo "E-mail enviado com sucesso.";

} else {

    echo "Erro ao tentar enviar o e-mail: ".$PHPMailer->ErrorInfo;

}

printf("<p class=\"sel4\"> <a href=\"campaign.php?\"><b>Continuar</b></a></span>"); 


/*


//aqui há uma função para enviar e-mail através do phpmailer

//aqui apanha as coisas que vêm de contact.php:
$destinatario_nome = $_REQUEST['nomeA'];
$id_ref = $_REQUEST['id_ref'];//quem referiu		
$destinatario_email = $REQUEST['email'];		
$destinatario_apelido = $REQUEST['apelido'];		
$teste = $REQUEST['teste'];		

echo 'o que cá chegou: <br>Nome:'.$nomeA.' ,<br>id_ref: '.$id_ref.' , <br>email:' .$email, '<br>apelido:'.$apelido.'<br>';



//variáveis para este script  
$assunto = $REQUEST['ass'];
$mensagem = $REQUEST['msg'];

//$nomeA = $REQUEST['nome']
       
$destinatario_nome="andre";
$destinatario_email="andrevercetti@gmail.com";
$assunto="teste";
$mensagem="this is a test";
	   
	   
	   
//function enviaPara ($destinatario_nome,$destinatario_email,$assunto,$mensagem) {


require_once('php_mailer/class.phpmailer.php');

// Definir variáveis

       
        $mail = new PHPMailer(true);   // true - Retorna excepcões
       
        $mail->IsSMTP();   // Utilização de SMTP
       
       
                $mail->Host       = " lisbon01.euestouaqui.com";  // Servidor SMTP
                $mail->SMTPAuth   = true;                   // Activar autenticação SMTP
                $mail->Username   = "geral@impressoesesolucoes.com";  // Utilizador do servidor SMTP
                $mail->Password   = "1q2W3e4R5t6Y";         // Password do utilizador do SMTP
               
                $mail->AddReplyTo('geral@impressoesesolucoes.com', 'Impressões e Soluções');       // Email e nome para onde será enviada a resposta (opcional)
                $mail->SetFrom('andre@impressoesesolucoes.com', 'Andre Carvalho');          // Email e nome de envio

                $mail->AddAddress($destinatario_email, $destinatario_nome);   // Email e nome do destinatário
               
                //$mail->Subject = $assunto;                                    // Assunto da mensagem
               //$mail->Subject = "Campanha Calendários Impressões e Soluções";                                    // Assunto da mensagem
			   $mail->Subject = "Campanha";
                $mail->IsHTML(false);                                         // false - O conteúdo da mensagem será enviado como texto e não HTML
                //$mail->Body = $mensagem;                                      // Conteúdo da mensagem em si
               $mail->Body = 'HI';
			   
			   /*
Olá '. $nomeA .
				',

O seu Amigo, '. $nomeA .
				' , pensa que estará
interessado na nossa campanha para personalização de calendários
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Consulte a campanha online em: http://www.impressoesesolucoes.com/teste/campaign.php e aproveite para personalizar já o seu calendário.


~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~<br><br><br><br><br>A Equipa da Impressões e Soluções, Lda';
*/
/*
				echo 'ok1?';
			   $mail->Send();
			   echo 'ok2?';
       /*
       
               if( $mail->Send())
			   {
				 echo "<p>Mensagem enviada com sucesso!</font></p>\n";   // Mensagem enviada!
			   }
			   else  echo "<p>Erro!</font></p>\n";   // Mensagem enviada!
			   
		*/	   
			   
      //}
	  
	  //echo 'vai enviar';
     //enviaPara ($destinatario_nome,$destinatario_email,$assunto,$mensagem);   
	//echo 'já enviou';
	//printf("<p class=\"sel4\"> <a href=\"campaign.php?\"><b>Continuar</b></a></span>");

?>
