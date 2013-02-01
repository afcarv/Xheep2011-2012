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

// se for uma chamad com get deve trazer o sido e o sei md5
if ( $xmov != 'SUP' && $xmov != 'SEL' && $xmov != 'NUP' ) {
		if ( $xval != md5($sido)) {
		echo 'acesso não identificado  <a href="/index.php" > continuar »»»</a>';
		die();
		} else $xmov = "SUP";
}

// printf("[===========> %s | %s |  %s | %s ]",$xent,$xusi,$sido,$xmov);

if (strlen($xidinq) == 0) $xidinq = 0;  // se não a aparece fica a zero !!!!
$xtipe = substr($xent,0,1);
$xtipu = substr($sido,0,2);

if ( ( $xtipe == "M" || $xtipe == "A") && ( $xtipu == "MU" || $xtipu == "AM")  && ( $xmov == "NUP" || $xmov == "SUP") ) { // NUP aquando da entrada ................
		// ferra-lhe com os dados
		
		$_SESSION['sid_usi'] = $xusi;
		$_SESSION['sid_ido'] = $sido;
		$_SESSION['sid_ace'] = 300;
		$_SESSION['sid_ent'] = $xent;
		
    }

 	if (isset($_SESSION["sid_usi"])) $usi = $_SESSION["sid_usi"];
 	 		else { echo "Acesso não autorizado E01:$xusi";
 	 				exit -1;
 	 			}
 	if (isset($_SESSION["sid_ido"])) { $ido = $_SESSION["sid_ido"];
				$sido = $_SESSION["sid_ido"];
				}
 	 		else { echo "Acesso não autorizado E02";
 	 				exit -1;
 	 			}
 	if ($_SESSION["sid_ace"] < 200) { // 200 é o nível mínimo de entrada
 	 				echo "Acesso não autorizado E03";
 	 				exit -1;
 	 			}
 	if (isset($_SESSION["sid_ent"])) $ident = $_SESSION["sid_ent"];
 	 			else {
 					// PROBLEMAS COM A IDENTIFICAÇÃO DA ENTIDADE .....
	 				echo "Acesso não autorizado E04";
					exit -1;
 	 			}
	$sent = $ident;
						
			if ( ( $xtipe == "M" || $xtipe == "A") && ( $xtipu == "MU" || $xtipu == "AM")  &&  ( $xmov == "SUP" || $xmov == "NUP" )  ) { // SUP ou NUP aquando da entrada ................
			// ferra-lhe com os dados
			$_SESSION['sid_usi'] = $xusi;
	   		$_SESSION['sid_ido'] = $sido;
	   		$_SESSION['sid_ace'] = 300;
	   		$_SESSION['sid_ent'] = $xent;
    }

    $lini = 0;
    $i = 0;

  include('../us/acw1.php');	// .... ....
  
  $liga=mysql_connect($xho,$xus,$xpw);
  if ( !$liga ) {
			printf("Problema [mun101DB]!!!");
			printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
}

        $sccoi = 0; // aqui i id scco é zero .....


/*
if ( substr($sent,0,1) != "M" && substr($sent,0,3) != 'USI' )  {
         printf("<hr><br><DIV STYLE=\"font-size:20; color: #000067\"> Acesso reservado aos municípios </div> ");
         printf("<hr> <a href=\"/anmp/div2009/xvcong/index.html\"> Sair »»» </a>" );
exit ;
}
*/

							
$mun0 = $_REQUEST["mun0"]; 

$emailcc0 = $_REQUEST["emailcc0"];
$emailca0 = $_REQUEST["emailca0"];

$xmov = $_REQUEST["xmov"];	
$xent =  $_REQUEST["xent"]; 
$ref_upl = "nome_upl";

if ( strlen($xmov) == 0 ) $xmov = "SEL" ; // por defeito fica SEL

			$idtablog = 'munp6.entidadelog';
//			$idtab = 'munp6.exp30figuras';
			$idbas = 'munp6';
			$xtab=10;
			$xref="dat7001fimail.php";

			if ( strlen($xmov) == 0 ) $xmov = "SEL";
	
// printf("[$xent]");
// ===============================================================================  head html ===============================================================================  
// se fôre posta é a seguir ao  head <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
// <META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"> 
// POsso precisar de usar a funcao $x2=iconv("UTF-8", "ISO-8859-1", $text) para os nomes dos campos se a tabela for iso ...
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/> 
<!-- dat0701fimail.php -->										
<title>ANMP - E-mail de contacto do Município</title>					
<style type="text/css">										
<!--														

INPUT {	background-color : #fefefe;											
	border-color : #000088;											
	}			
TD { 																
	font-family : Arial,Helvetica;									
	font-size : 8pt;													
	color : #ffffff;													
 }																	
.sel1 { font-family : arial,Helvetica;				
	font-size : 12pt;													
	color : #000000;													
	background-color : #fefece;											
	border-color : #000088;											
	}																
.sel2 { font-family : arial,Helvetica;				
	font-size : 10pt;													
	color : #000088;													
	background-color : #f1f100;											
	border-color : #222222;											
    }																
.sel3 { font-family : arial,Helvetica;							
	font-size : 8pt;													
	font-weight: normal;												
	color : #707070;													
      }
	  
a.sel3 { font-family : arial,Helvetica;							
	font-size : 8pt;													
	font-weight: normal;												
   }	
a.sel3:hover { font-family : arial,Helvetica;							
	font-size : 8pt;													
	font-weight: normal;												
	color : #0000A0;													
      }		  	  															
.sel4 { font-family : arial,Helvetica;							
	font-size : 10pt;													
	font-weight: bold;												
	color : #ff0000;														
	background-color : #f1f100;											
      }																	
																		
-->																		
</style>

</head>																	

<SCRIPT LANGUAGE="JavaScript">
<!-- Hide script from some browsers
//                                                                    JAVASCRIPT
function printWindow(){
browserVersion = parseInt(navigator.appVersion)
if (browserVersion >= 4) window.print()
}

//                                                                    JAVASCRIPT
function DateGood(y, m, d) { 
  var D // m = 1..12 ; y m d ints, y!=0
  with (D=new Date(y, --m, d))
  return (getMonth()==m && getDate()==d) ? D : NaN 
  }

function DateFieldOK(D) { var X = D.split(/-/);
  return DateGood(+X[0], +X[1], +X[2]);/* DObj or NaN */ 
  }

function ValDatas(D1, D2) { 
  var Ini, Fim, Now = new Date()
  var X = D1.split(/-/);
  var ano0 = 1976;  // ano mínimo permotido.
 
 if ( X[0] < ano0 ) { alert("O ano de início "+X[0]+ ", não pode ser anterior a "+ ano0 +" \n Corrija este dado e prima novamente o botão Submeter" );
return -1 ;
}

  if (!(Ini = DateFieldOK(D1))) {
    	  alert("Erro: A data de início de funções não está correcta \n ----- \n Corrija este dado e prima novamente o botão Submeter" );
			// can.focus();
			return -1;
}
  if (!(Fim = DateFieldOK(D2))) {
    	  alert("Erro: A data de fim de funções não está correcta \n ----- \n Corrija este dado e prima novamente o botão Submeter" );
			// can.focus();
			return -1 ;
}
  if ( Ini > Fim ) {
    	  alert("Erro: o início de funções não pode depois do fim \n ----- \n Corrija este dado e prima novamente o botão Submeter" );
			// can.focus();
			return -1;
		}

 	//  alert(" início " + Ini + " fim " + Fim );

return 0;
 
}

function ValidaReg(fx) {

var errdat = 0;

if ( errdat == 0 )document.frm2.submit();
				else	return;

}
function checkEmail(email) {
 if(email.length > 0)  {
      if (email.indexOf(' ') >= 0)
           alert("Erro: O Endereço (email) não pode conter espaços. \n Corrija este dado e prima novamente o botão Submeter" );
       else if (email.indexOf('@') == -1)
           alert("Erro: O Endereço (email) tem de conter o caracter @. \n Corrija este dado e prima novamente o botão Submeter" );
    }
 }

//-->
</script>


<body>	
<div align="center">
<div align="left" style="width: 800px;">
   
<?php																	

// funções locais													

// SELENTT .... nºs dos resultados eleuitorais !!!!
 function selentt($cod,&$tip,&$nom) {
	$sqls="select * from munp1.entidade where cod = '$cod'";
	$ress=mysql_db_query("munp1",$sqls); //
		if ($ress) {
				$regs=mysql_fetch_array($ress);
				if ( $regs ) {
								$nom = $regs["nom"];
								$tip = $regs["tip"];
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

// ARRMUN Array com municípios de um distrito

 function arrmun($cod_dis, &$lmun) {
   if ( $cod_dis ==  "TOT" ) $sqls = "select * from munp1.municip order by nom" ;
    else $sqls= "select * from munp1.municip where substring(cod_1,1,2) like '$cod_dis' order by nom";
	 $ress=mysql_db_query("munp1",$sqls); //
		if ($ress) {
				$i = 0;
				while( $regs=mysql_fetch_array($ress)) {
						$lmun[$i]["nom"]=$regs["nom"];
						$lmun[$i]["cod_dis"]=$regs["cod_1"];
						$lmun[$i]["cod_mun"]=$regs["cod"];
						$i++;
					}
						mysql_free_result($ress);
						return $i;
		   }
// printf("vai sair 0");
return 0;
}


// SELENTDAT .... da entidade !!!! para a câmara e assembleia

 function selentdat($tip, $xent, &$mun, &$distr, &$nompc, &$sexpc, &$end1, &$end2, &$codpostal, &$telef, &$fax, &$email, &$emailpre, &$emailcon, &$web) {
	if ( $tip == "MUN") {
		$sqls="select * from munp1.entidade where cod = '$xent'";  // Câmara 
	} else if ( $tip == "AM") {
		$sqls="select * from munp1.entidade where cod_munref = '$xent'"; // Assembleia
	}
		$ress=mysql_db_query("munp1",$sqls); //
		if ($ress) {
				$regs=mysql_fetch_array($ress);
				if ( $regs ) {
								$mun = $regs["nom"];
								$distr = $regs["distr"];
								$nompc = $regs["nom_cont1"];
								$sexpc = $regs["cod_sexc1"];
								$end1 = $regs["end_1"];
								$end2 = $regs["end_2"];
								$codpostal = $regs["cod_postal"];
								$telef = $regs["num_telef"];
								$fax = $regs["num_fax"];
								$email = $regs["mail_ger"];
								$emailpre = $regs["mail_pre"];
								$emailcon = $regs["mail_con"];
								$web = $regs["end_web"];
								mysql_free_result($ress);
								return 1;
						}
 					else return 0;
		   }
// printf("vai sair 0");
return 0;
}

// FORNUM - Formata xpt para um número ....													
 function fornum(&$numx) {								

 $xn = "";
 $n1= strlen($numx);
 for ( $i = 0; $i < $n1 ; $i++) { 
 // echo " xn [$xn][$numx[$i]][$i] ";

 	// limpa espaços ....
 	 if ( $numx[$i] == " ") {
 	   		continue;
		}
	// converte vigula 
	 if ( $numx[$i] == "," ) {
	    if ( $i < $n1-3 ) {
 			 continue;
 			}
			else {
			$xn .= ".";
 			 continue;
			}
	  }
	 if ( $numx[$i] == "." ){
	 	    if ( $i < $n1-3 ) {
 			 continue;
 			}
			else {
			$xn .= ".";
 			 continue;
			}
	  }
  $xn .= $numx[$i];
 }
$numx = $xn; 
return 0;								
}	

// 															MAIN

$hoje=date('Y-m-d',time());											
$agora=date('H:i',time());											

if ( strlen( $xent) > 0 ) {

    $xtipent = "";
    $k = selentt($xent,$xtipent,$xnome);

    if ( $xtipent == "MUN") {
    $xntipe = "Câmara Municipal";
    	
	}
  }

printf(" Município de <b>%s</b>", $xnome ); 
printf(",<br/> verificação de dados para contacto com o município"); 
printf("<hr color=#66CC33>");										

// select dos dados 

$xent = M . substr($xent,1,4);

// echo " .... $xent";

selentdat("MUN",$xent, $mun, $distr, $nompc, $sexpc, $endcm1, $endcm2, $codpostalcm, $telefcm, $faxcm, $emailcm,$emailpc, $emailcc, $webcm);
selentdat("AM",$xent, $am, $da, $nompa, $sexpa, $endam1, $endam2, $codpostalam, $telefam, $faxam, $emailam, $emailpa,$emailca, $webam);

selmundat($xent,$area,$habit,$freg,$dia_fer,$des_fer);

$updent = 0; 
$updmun = 0; 
$updam = 0; 

$xmsg = $hoje . $agora . "- Alterado ";

 // VERIFICAÇÕES ANTES DE UPDATE
 // Permite a alteração de nº de freguesias, área, feriado, endreço, presidentes, tel, fax, email, web, 

 
 // verifica se houve alteraçãoes aos dados da +++++++++++++++ Câmara Municipal
 
	if ( strlen($emailcc0) > 5 && $emailcc != $emailcc0) {
			$xmsg .= " - email CC [de:" . $emailcc . " - para: " . $emailcc0. " ]";
			$emailcc = $emailcc0;
			$updent = 1;
	}
	
// verifica se houve alteraçãoes aos dados da ---------- Assembleia  Municipal
 
	// ENDEREÇOS
	if ( strlen($emailca0) > 5 && $emailca != $emailca0) {
			$xmsg .= " - email CA [de:" . $emailca . " - para: " . $emailca0. " ]";
			$emailca = $emailca0;
			$updam = 1;
	}
	

 // #################

 if ( $updent > 0 ) {  // SE há alteração actualiza a tabela para o município
 	  	$sqlux = "update munp1.entidade set mail_con = '$emailcc' where cod='$xent' and tip = 'MUN'";
 		$resultux= mysql_db_query("munp1",$sqlux);
		echo mysql_error();
		//	printf("[%s]",$sqlux);
		$xmov = "SEL" ; // após a alteração volta a colocar SEL
   }

 if ($updam > 0 ) {  // SE há alteração do AM actualiza a tabela para AM
	$sqlux = "update munp1.entidade set mail_con = '$emailca' WHERE cod_munref = '$xent' and tip = 'AM'";
	$resultux= mysql_db_query("munp1",$sqlux);
	echo mysql_error();
	//	printf("[%s]",$sqlux);
	$xmov = "SEL" ; // após a alteração volta a colocar SEL
   }

// se há erros mostra-os agora...
if ( $updent > 0 || $updmun > 0  || $updam > 0 ) {
  // printf("<div class=sel4>%s</div>",$xmsg);
	echo '<p>Novos contatos:</p>';
// 							deve fazer um insert no 								log.
$sqlux = "insert into $idtablog (cod, ref, des, dat, ido, nom_cont, email_cont) values ('$xent','$xref', '$xmsg', '$hoje', '$sido','$nomalt0','$mailalt0')";
 		$resultux = mysql_db_query($idbas,$sqlux);
		 	echo mysql_error();
  
// envia um E-MAIL com PHPmailer

require_once('../phpmail/class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "192.168.1.42"; // SMTP server
// descomentar para mostrar ---- $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$body = '<body style="margin: 10px;">
<div style="width: 720px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
<div align="left"><img src="../phpmail/ANMPL0.gif" style="height: 150px; width: 150px"></div><br>
<br>
&nbsp;O município de ' . $xnome . ' 
<br>
acaba de alterar os seus dados.<br>:' . $xmsg . ' | ' . $nomalt . '
<br>
</div>
</body>' ;
										   
$mail->SetFrom('afcarvalho@anmp.pt', 'Aristides Carvalho');
$mail->AddReplyTo('afcarvalho@anmp.pt', 'Aristides Carvalho');

$mail->Subject    = "Alteração de coordenadas do Município";

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

 // Manipulação do status
 if ( $xmov == "SUP" ) $xmov = "UPD" ; // ......

 // só  UPD
 if ( $xmov == "UPD" )  {

 $_SESSION['numid'] = 0; // coloca o numid a zero para permitir o insert
 printf("<form  name=\"frm2\" method=\"POST\" action=\"dat0701fimail.php\" > ");
 // printf(" <SPAN class=\"sel4\">[ %s ] </SPAN> ","..."); 
 // o xmov é  hidden e apenas mostrado , não alterado 
 printf(" <input type=\"hidden\" name=\"xmov\" value=\"%s\">",$xmov);
 printf(" <input type=\"hidden\" name=\"id\" value=\"%s\">",$id);
 printf(" <input type=\"hidden\" name=\"xent\" value=\"%s\">",$xent);
 printf("<input type=\"hidden\" name=\"sido\" value=\"%s\">",$sido);
 printf("<input type=\"hidden\" name=\"xval\" value=\"%s\">",$xval);
 printf("<input type=\"hidden\" name=\"mun0\" value=\"%s\">",$mun );
 echo '<div class="sel1">';
  printf("<br><br>E-mail:(Para <strong>contacto da ANMP com a Câmara Municipal</strong>)<br> <input type=\"text\" name=\"emailcc0\" size=\"50\" value=\"%s\" ><i>(1)</i>",$emailcc );
 echo '</div>';
  echo '<br /><br />';
   echo '<div class="sel1">';
  printf("<br><br>E-mail:(Para <strong>contacto da ANMP com a Assembleia Municipal</strong>)<br> <input type=\"text\" name=\"emailca0\" size=\"50\" value=\"%s\" ><i>(1)</i>",$emailca );
	echo '</div>';
 printf("<hr bgcolor=\"#FaFaFa\">");
 printf(" &nbsp; <i>(1)</i>Efectue as correcções desejadas e prima o botão submeter ");

 printf("<br /><br /><br /> &nbsp; &nbsp; &nbsp; &nbsp; <input type=\"button\" value=\"Submeter Alterações\" onclick=\"javascript:ValidaReg(this.form)\">");
 
 printf("<br><IMG SRC=\"/images/anmp/logo/ANMPL0.gif\" ALT=\"ANMP\"  border=0 >");			
 printf(" </form>");

}
else {

 printf("<form  name=\"frm0\" method=\"POST\" action=\" \" class=\"sel1\"> ");
 // printf(" <SPAN class=\"sel4\">[ %s ] </SPAN> ","..."); 
 printf(" <input type=\"hidden\" name=\"xent\" value=\"%s\">",$xent);
 printf("<input type=\"hidden\" name=\"sido\" value=\"%s\">",$sido);
 printf("<input type=\"hidden\" name=\"xval\" value=\"%s\">",$xval);
 printf(" <input type=\"hidden\" name=\"xmov\" value=\"%s\">",$xmov);

 $xro = "READONLY";  // só para leitura
  
 	printf("Município:<br> <input $xro type=\"text\" name=\"mun0\" size=\"50\" value=\"%s\" class=\"sel2\" READONLY>",$mun );
echo '<br /><br />';
	printf("<br>E-mail:(Para contacto da ANMP com a Câmara Municipal)<br> <input $xro type=\"text\" name=\"emailcc0\" size=\"50\" value=\"%s\" class=\"sel2\">",$emailcc );
echo '<br /><br />';
 	 printf("<br>E-mail:(Para contacto da ANMP com a Assembleia Municipal)<br> <input $xro type=\"text\" name=\"emailca0\" size=\"50\" value=\"%s\" class=\"sel2\">",$emailca );

 printf(" </form>");
 
printf("<div align=center>  <a href=\"dat0701fimail.php?xmov=%s&xent=%s&sido=%s&xval=%s&th=%s\"><b>Alterar</b></a>","SUP",$xent,$sido,$xval,$agora);
printf(" | <a href=\"javascript:printWindow()\"> Imprimir  </a>");
printf("</div><hr>");
	printf("<div class=sel3 align=left>[ %s | %s]</div>",$hoje, $agora);

	printf("<div align=right><IMG SRC=\"/images/anmp/logo/ANMPL0.gif\" ALT=\"ANMP\"  border=0 ></div>");			
}


// echo "$xoper|$sido";

        if ( $xoper == "GER" ) { 					// [MENU]  - GER poder tratar Gerais; ....

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


// FIM DO php 
 ?> 
 <div class="sel3" align=left>
   | <a href="/index.php" CLASS=sel3>ANMP</a>
   | <a href="mailto:anmp@anmp.pt" CLASS=sel3>Comentários e sugestões</a>
</div>
 <hr>
 <div class="sel3" align=right>
  ANMP/TI[2007], (c)  A.N.M.P.- Associação Nacional de Municípios Portugueses <br>
 </div>
 </div>
 </div>
 
 </body>
   </html>			