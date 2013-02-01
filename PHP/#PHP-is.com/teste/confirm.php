<?php

//tem de pegar no id do gajo que tem de estar aqui e fazer update na impresso_ISsite.impresso_camp de status para 1
// um printzeco no ecrã
// e para a acabar um emailzeco a confirmar tudo e a agradecer

require_once('php_mailer/class.phpmailer.php');
     
	 
	 $id = $_REQUEST['id'];//quem referiu
	 $id_ref = $_REQUEST['id_ref'];//quem referiu
	 $nome = $_REQUEST['nome'];//quem referiu(nome)
	 $nomeA = $_REQUEST['nomeA'];//nome alvo
	 $apelido = $_REQUEST['apelido'];//apelido alvo
	 $email = $_REQUEST['email'];//alvo
	 $emailA = $_REQUEST['emailA'];//email de quem referiu
	 echo '<br>Eu sou o id: '.$id.'<br>';
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


// $mail->Body = '<p>A alteração deste endereço pode ser realizada seguindo o link:<a href="http://www.impressoesesolucoes.com/teste/campaign.php?tip_mov=.'$new.'&email=.'$email.'&id_ref=.'$id_ref.'></a></p>'; 

$body = '<p>Caro (a) '.$nomeA.'.<br>
Obrigado por proceder à confirmação do seu status.<br><br>
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

	$idtab = 'impresso_ISsite.impresso_camp';
	$idbas = 'impresso_ISsite';
	
	$nome = $nomeA;
	$apelido = $apelido;
	$aniversario = "referral";
	$email = $email;
	$opcao = "referral";
	$data = "referral";
	$id_ref = $id_ref;
	
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

?>