<?php
session_start();

// printf("[===========> %s | %s | %s ]",$xent,$sido,$xmov);

$xent =  $_REQUEST["xent"]; 
$xusi =  $_REQUEST["xent"]; // fica o xent no usi
$sido =  $_REQUEST["sido"]; 
$xmov =  $_REQUEST["xmov"]; 
$xval =  $_REQUEST["xval"]; 
$ximp =  $_REQUEST["ximp"];  // apenas indica que o movimento é de impressão ... bloqueia o botão submeter e altera o ouput de alguns tipos de dados , redio botão e textarea
$xidinq =  $_REQUEST["xidinq"]; 

// se for uma chamada com get deve trazer o sido e o sei md5
//if ( $xmov != 'LINK' && $xval != md5($sido)) {
if ( $xmov != "LINK" && $xval != "AFC") {
		echo 'acesso não identificado  <a href="/index.php" > continuar »»»</a>';
		die();
		} else $xmov = "SUP";

  include('../us/acw1.php');	// .... ....
  
  $liga=mysql_connect($xho,$xus,$xpw);
  if ( !$liga ) {
			printf("Problema [mun101DB]!!!");
			printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
}

$sccoi = 0; // aqui i id scco é zero .....

$mun0 = $_REQUEST["mun0"]; 

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/> 
<!-- dat0701fimail.php -->										
<title>ANMP - E-mail de contacto do Município</title>					
</head>																	

<body>	
<div align="center">
<div align="left" style="width: 800px;">
   
<?php																	
// funções locais													
// ARRMUN Array com municípios de um distrito

 // SELENX ...
 function selentpx($cod_ent,&$uid,&$pwd) {
	$sqls="select * from munp1.usi01 where cod_ent = '$cod_ent'";
	$ress=mysql_db_query("munp1",$sqls); //
		if ($ress) {
				$regs=mysql_fetch_array($ress);
				if ( $regs ) {
								$uid = $regs["uid"];
								$pwd = $regs["pwd"];
								mysql_free_result($ress);
								return 1;
								}
								
 					else return 0;
		   }
// printf("vai sair 0");
return 0;
}

// SELMUNDAT .... dados do municip !!!!
// tabela municip
 function selmundat($xent, &$area, &$habit, &$freg, &$dia_fer, &$des_fer ) {
	$sqls="select * from munp1.municip where cod = '$xent'";
	$ress=mysql_db_query("munp1",$sqls); //
		if ($ress) {
				$regs=mysql_fetch_array($ress);
				if ( $regs ) {
								$area = $regs["med_area"];
								$habit = $regs["num_habit"];
								$freg = $regs["num_freg"];
								$dia_fer = $regs["dat_fermun"];
								$des_fer = $regs["des_fermun"];
															
								mysql_free_result($ress);
								return 1;
							}
 					else return 0;
		   }
// printf("vai sair 0");
return 0;
}

// 	.....							MAIN   ================

$hoje=date('Y-m-d',time());											
$agora=date('H:i',time());											
// este «body» vai servir para enviar um e-mail
$body = '<body style="margin: 10px;">
<div style="width: 720px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
<div align="left"><img src="../phpmail/ANMPL0.gif" style="height: 150px; width: 150px"></div><br>
<br>
&nbsp;Lista de links   
<hr>';


 $sql = "select * from munp1.municip order by nom" ;
	 $res=mysql_db_query("munp1",$sql); //
		if ($res) {
				$i = 0;
				while( $reg=mysql_fetch_array($res)) {
						$nom =$reg["nom"];
						$cod_ent = $reg["cod"];
						$i++;
						$k = selentpx($cod_ent,$uid,$pwd);	
					if ($k == 0) {
						$uid = $pwd = "0000";
						}
					$xval = md5($uid);	
					echo ' <br /> ' . $nom . ' - <a href="dat0701fimail.php?xent=' .$cod_ent.'&sido=' .$uid . '&xval=' .$xval. '&xmov=SUP">xxx</a>'; 
					$body .= ' <br /> ' . $nom . ' - <a href="http://www.anmp.pt/anmp/pro/inq/dat0701fimail.php?xent=' .$cod_ent.'&sido=' .$uid . '&xval=' .$xval. '&xmov=SUP">xxx</a>'; 
					
			}
		}
 mysql_free_result($res);	

 $body .= '
 <hr> pode usar um deste links
 <br>
 </div>
 </div>
  </body>' ;

//  ****** composição do e-mail

if ( $k > 0 ) {
// envia um E-MAIL com PHPmailer

require_once('../phpmail/class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
$mail             = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "192.168.1.42"; // SMTP server
// descomentar para mostrar ---- $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
// o corpo do email é feito acima 
										   
$mail->SetFrom('afcarvalho@anmp.pt', 'Aristides Carvalho');
$mail->AddReplyTo('afcarvalho@anmp.pt', 'Aristides Carvalho');

$mail->Subject    = "Links de alteração de e-mails dos Município";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$address = "info@anmp.pt";
$mail->AddAddress($address, "ANMP");

// $mail->AddAttachment("images/phpmailer.gif");      // attachment
// $mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  // echo "ok!";
  echo " ";
}

}


/* *****************************


        if ( $xoper == "GER" ) {		// [MENU]  - GER poder tratar Gerais; ....

		printf("<hr>%c<form method = \"POST\" action=\"eve209fcx.php\">",10);
	    // Lista Geral de Municípios
	    printf("<select class=\"sel2\" name=\"xxx2\" size=1 onChange=\"window.location.href=this.options[this.selectedIndex].value\">");
	 	printf("<OPTION value=\"dat0701fimail.php?xmov=%s&xent=%s&sido=%s&xins=%s\">Município:","NUP","FFF","111gfr66721Dnivel4");
	 	
		$n = arrmun("TOT",$lmunt);
		for ( $i = 0; $i < $n; $i++) {
	 	printf("<OPTION value=\"dat0701fimail.php?xmov=%s&xent=%s&sido=%s&xins=%s\">%s%c","NUP", $lmunt[$i]["cod_mun"], $sido,$agora, $lmunt[$i]["nom"],10);
		}
		printf("</select>%c",10);
}

*/
// FIM DO php 
 ?> 
 </div>
 <hr>
  ANMP/TI[2007], (c)  A.N.M.P.- Associação Nacional de Municípios Portugueses <br>
 </div>
 </div>
 </div>
 
 </body>
 </html>			