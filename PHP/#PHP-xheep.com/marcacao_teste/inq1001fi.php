<?php
session_start();


/**
* IHC - Marcação de consultas online - Grupo 33
* André Fernandes de Carvalho - 2006130976
* Nuno Costa
*/

$xent =  $_REQUEST["xent"]; 
$xusi =  $_REQUEST["xent"]; // fica o xent no usi
$sido =  $_REQUEST["sido"]; 
$xmov =  $_REQUEST["xmov"]; 
$ximp =  $_REQUEST["ximp"];  // apenas indica que o movimento é de impressão ... bloqueia o botão submeter e altera o ouput de alguns tipos de dados , redio botão e textarea
$xidinq =  $_REQUEST["xidinq"]; 

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
 	if (isset($_SESSION["sid_ido"])) $ido = $_SESSION["sid_ido"];
 	 		else { echo "Acesso não autorizado E02";
 	 				exit -1;
 	 			}
 	if ( $_SESSION["sid_ace"] < 200) { // 200 é o nível mínimo de entrada
 	 				echo "Acesso não autorizado E03";
 	 				exit -1;
 	 			}
 	if (isset($_SESSION["sid_ent"])) $ident = $_SESSION["sid_ent"];
 	 			else {
 					// PROBLEMAS COM A IDENTIFICAÇÃO DA ENTIDADE .....
	 				echo "Acesso não autorizado E04";
					exit -1;
 	 			}
				
// ########################################################################
// OK chegou aqui avança para o programa
// Definições GLOBAIS
		include('../us/acw1.php');	// .... ....
		 $liga=mysql_connect($xho,$xus,$xpw);
		if ( !$liga ) {
			printf("Problema [mun101DB]!!!");
			printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
		}

		$idtab = 'munp4.inq1001';
		$idbas = 'munp4';
		// $eid =  $usi;       // a chave de entrada é o código de utilizador ....ie. MUNXXX
		$xent =  $ident;       // a chave de entrada é o código de entidade, em alguns inquériots pode ser o utilizador(udi) ....
	$tip_mov = $_REQUEST["tip_mov"];

	include('arr1001.php');	// FAZ SEMPRE !!!! a Definição dos arrais para os registos....

	// $xtab= 10;
	$xtab= '\n';
// IN e UPD se for o caso, preenche recebe o array do form com os dados de insert ou update
 if ( $tip_mov == "UPD" || $tip_mov == "IN" ) {  // Faz select para update ao registo
	$vinq =  $_REQUEST["vinq"];
			$nom = $_REQUEST["nom"];
			$func = $_REQUEST["func"];
			$email = $_REQUEST["email"];
			// $ref_upl = "nome_upl";  // upl-1 dentro da funçao de upload é usado a variável ref_upload para fazer o request....
    }

// funções locais
// SELMUN
 function selinqs($cod) {
	global $idtab;
	global $idbas;

    $sqls="select * from $idtab where cod_ent ='$cod'";
	$ress=mysql_db_query($idbas,$sqls); //
		if ($ress) {
			while( $regs=mysql_fetch_array($ress)) {
			
			$id_inq = $regs["id_inq"]; 
			if ($id_inq == 0) printf("<p class=\"sel4\"> >>> <a href=\"inq1001fi.php?tip_mov=%s&xidinq=%s\"><b>Rever Inquérito</b></a>  |     <a href=\"inq1001fi.php?tip_mov=%s&xidinq=%s&ximp=%s\"><b>Imprimir</b></a> </a></p>","SUP",$id_inq,"SUP",$id_inq,"IMP");
			else printf("<p class=\"sel4\"> >>> <a href=\"inq1001fi.php?tip_mov=%s&xidinq=%s\"><b>Rever Inquérito [anexo: %s ]</b></a>  |  <a href=\"inq1001fi.php?tip_mov=%s&xidinq=%s&ximp=%s\"><b>Imprimir</b></a>  </p>","SUP",$id_inq,$id_inq,"SUP",$id_inq,"IMP");
			}
			
			/*  NAO HA NOVOS
			/* Só há anexos para estes municípios...
			*/
			// $munmais = array("M2900","M2950","M2970","M5300","M8900","M2350","M7520");
			// if (in_array($cod, $munmais))
			//	printf("<p class=\"sel4\"> >>> <a href=\"inq1001fi.php?tip_mov=%s&xidinq=%s\"><b>Novo Inquérito [anexo: %s (para outra área)]</b></a></span>","SUP",$id_inq+1,$id_inq+1);
	}
}

// SELMUN
 function selent($cod,&$nom) {
    $sqls="select * from munp1.municip where cod ='$cod'";
	$ress=mysql_db_query("munp4",$sqls); //
		if ($ress) {
				$regs=mysql_fetch_array($ress);
				if ( $regs ) {
						$nom  = $regs["nom"];
						$cod_1 = $regs["cod_1"]; 
						$num_freg = $regs["num_freg"];
						$num_habit = $regs["num_habit"];
					return 1;
				}
					else return 0;
		   }
// printf("vai sair 0");
return 0;
}


// SELDIS  DISTRITOS , REGIOES

 function seldis($cod, &$nom) {
	$sqls="select * from disreg where cod = '$cod'";
	$ress=mysql_db_query("munp1",$sqls); //
		if ($ress) {
				$regs=mysql_fetch_array($ress);
				if ( $regs ) {
								$nom=$regs["nom"];
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

//	UPL-2 - funções de UPLOAD do ficheiro  

function uplext(&$ext) {  // 2.1.devolve a extensão
  global $ref_upl;								
	$ext="";
   $mime = $_FILES[$ref_upl]["type"];
   $name  = $_FILES[$ref_upl]["name"];
   $array = explode(".", $name);
   $nr    = count($array);
   $ext  = $array[$nr-1];
   return 0;
 }
  
function uploadme($upname) {  // 2.2. faz upload
  $ok = false;
  global $ref_upl;								
   // Check file
   $mime = $_FILES[$ref_upl]["type"];
	
	 // echo "<br>mine: [$mime]";
     $name  = $_FILES[$ref_upl]["name"];
     $array = explode(".", $name);
     $nr    = count($array);
     $ext  = $array[$nr-1];

    // echo "<br>| $name |$nr | $ext |";

	$ext = strtolower($ext);

	$maxfilesize = 30000000;  // 30M
	$filesise = $_FILES[$var]["size"];

     if( $filesise > $maxfilesize) { 
	     echo "<br> ... está a mandar um ficheiro com $filesise  mais de $maxfilesize"   ;
	     echo "<br> ... (Erro:UPL02)!" ;
		return 0;
      }

     $tempname = $_FILES[$ref_upl]['tmp_name'];
	//	echo "<br>tmp_name ....:$tempname]";

	
	// 2.3 LOCAL!!!!!!!!
	// $uploaddir = "/var/www/webp1/anmp/inq/2009/71/";
	// $uploadfile = $uploaddir . $upname . "." . $ext;  // nome e local onde vai ficar - junta e exte
	// $uploadfile = $uploaddir . $upname;  // nome e local onde vai ficar, já traz a EXT
	// echo "<br>Enviado:$tempname, para   $uploadfile";

	if (move_uploaded_file($tempname, $uploadfile)) {
   echo "enviado.\n";
   return 1;
	} else {
   echo "Falha de envio!(Erro:UPL03)\n";
   return 0;
	}
	// echo '<PRE>Here is some more debugging info:';
	// print_r($_FILES);
    // print "</pre>";

}


//  ################################################################################
// Definições para o HTML ....
 ?>

<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INQUÉRITO: PLANOS DE PREVENÇÃO DE RISCOS DE GESTÃO, INCLUINDO OS DE CORRUPÇÃO E INFRACÇÕES CONEXAS| Inq:01/01-2010</title>
<style type="text/css">
<!--
TD {
	font-family : Arial,Helvetica;
	font-size : 9pt;
	color : #000000;
 }
.sel1 { font-family : arial,Helvetica;
	font-size : 9pt;
	color : #636B70;
      }
.sel2 { font-family : arial,Helvetica;
	font-size : 9pt;
	color : #000000;
      }
.sel3 { font-family : arial,Helvetica;
	font-size : 9pt;
	font-weight: normal;
	color : #636B70;
      }
	  .sel3a { font-family : arial,Helvetica;
	font-size : 10pt;
	font-weight:normal;
	color : #636B70;
      }
	  .sel3b { font-family : arial,Helvetica;
	font-size : 10pt;
	font-weight: normal;
	color : #252525;
      }
  .sel3r { font-family : arial,Helvetica;
	font-size : 10pt;
	font-weight: normal;
	color : #aa0000;
      }	  
	  
.sel4 { font-family : arial,Helvetica;
	font-size : 10pt;
	font-weight: normal;
	color : #151515;
	}
.sel4b { font-family : arial,Helvetica;
	font-size : 10pt;
	font-weight: bold;
	color : #151555;
	}
.sel5 { font-family : arial,Helvetica;
	font-size : 8pt;
	color : #aa0000;
      }
.sel6 { font-family : arial,Helvetica;
	font-size : 10pt;
	color : #636B70;
	background-color : #fafa44;
	border-color : #000088;
	background-image : url(ok.gif);
      }
.sel7 { font-family : arial,Helvetica;
	font-size : 9pt;
	color : #636B70;
	background-color : #ffff80;
    }

    -->
</style>

</head>

<SCRIPT LANGUAGE="JavaScript">
<!-- Hide script from some browsers

function foc()
 {
   window.status="População afectada";
 }

function blu()
 {
   window.status="";
 }

function ValidaReg(fx) {
	// não faz nada só submete ....
	document.frm2.submit();
}

function xValidaReg(fx) {
var can = fx["vinq[2][1]"];
var apr = fx["vinq[2][1]"];

var ncan	= can.value;
var napr	= apr.value;

	if ( ncan > 0 ) {
			if ( Number(napr) >  Number(ncan) ) {
			    alert("Erro: O número de candidaturas apresentadas \n tem de ser igual ou superior ao número de candidaturas  aprovadas. \n Corrija este dado e prima novamente o botão Submeter" );
					can.focus();
					return;
				}
   }
	document.frm2.submit();
}

function checkEmail(email) {
 if(email.length > 0)  {
      if (email.indexOf(' ') >= 0)
           alert("Erro: O Endereço (email) não pode conter espaços. \n Corrija este dado e prima novamente o botão Submeter");
       else if (email.indexOf('@') == -1)
           alert("Erro: O Endereço (email) tem de conter o caracter @. \n Corrija este dado e prima novamente o botão Submeter");
    }
 }

 function printpage()
{
window.print();
}
 
 
 
// end script hiding from some browsers -->
</SCRIPT>

<body>

<?php
$hoje=date('Y-m-d',time());
$agora=date('H:i',time());


// 	################################  Cabeçalho #####################
		// printf("<b>início do dito !!!!! mov=%s</b>",$tip_mov);

					printf("<div align=\"center\">");
					printf("<table width=780 bgcolor=#ffffff>");
					printf("<tr><td width=15%% valign=top bgcolor=\"ffffff\">");
					printf("<IMG SRC=\"/images/anmp/logo/ANMPL0.gif\" ALT=\"ANMP\"  border=0>");
					// printf("<br>[$tip_mov|$usi] ");
					printf("</td><td>");
					printf("<div class=\"sel3a\" align=\"center\">INQUÉRITO: <b> PLANOS DE PREVENÇÃO DE RISCOS DE GESTÃO, INCLUINDO OS DE CORRUPÇÃO E INFRACÇÕES CONEXAS | Inq:01/01-2010");
					printf("<br><br>QUEIRA POR FAVOR PREENCHER ESTE INQUÉRITO até 15 de Janeiro de 2010");
					// printf("<div class=sel3b align=right><b><u>Submeter até nn de Dezembro</u></b></div>");
                    if ($tip_mov != "IN" && $tip_mov != "UPD"  ) {  // nos casos de IM ou UPD não mostra as notas
							
					printf("</span></div></td></tr><tr><td colspan=3 class=\"sel3\">");
					
                   //  printf("<hr>Com o presente inquérito pretende-se realizar um levantamento do número de processos de contra-ordenação, e de sanções aplicadas, por infracções praticadas no âmbito do DL n.º 124/2006, cuja competência é das Câmaras Municipais, devendo os dados reportar-se aos anos de 2008 e 2009.");

					// printf("<hr>");
					if ( $ximp != "IMP") {  // Se for opção de impressão não mostra os avisos ...
                                printf("<hr>Notas:<br> 1. Os dados introduzidos só serão aceites depois de premir o botão <b><u>Submeter Inquérito</u></b> que se encontra no fim do formulário.");
	                             printf("<br>2. Se prolongar o tempo de introdução dos dados além de 30 minutos, prima o botão <b><u>Submeter Inquérito</u></b> para salvaguardar a informação já registada,  após o que, poderá continuar a introdução.");
	                            //  printf("<br>3. Após a introdução dos dados, e durante todo o período em que o inquérito se encontra a decorrer, poderá sempre voltar a este formulário e proceder à sua alteração, actualização ou impressão.");
	                               // printf("<br>4. Se pretender imprimir o formulário, prima em primeiro lugar botão <b><u>Submeter Inquérito</b></u>, e só depois a opção imprimir, desde modo fica com uma cópia exacta da informação colocada na base de dados.Seleccione, nas opções de impressão, Orientação: Horizontal(/Landscape).");
						
	                        printf("<hr>");
							}
							
                           }
					$k = selent($xent,$xmun);
					if (  $xidinq > 0 ) printf("[===== INQUÉRITO ANEXO %s ======> ]",$xidinq);
					
					printf("[=====E06======> %s | %s |  %s | %s ]",$xent,$xmun);
					if (  $k == 0 ) {
					 					// PROBLEMAS COM A IDENTIFICAÇÃO DO Município
						 	 				echo " Acesso não ajustado a este Inquérito - E06 [$ident| $xnom]";
					 	 				exit -1;
					 	 			}
					// printf("<div class=\"sel3b\" align=\"center\">Município:</span><span class=\"sel3\"> %s</span> </div>", $xmun);
					// fim da tabela 1

			printf("<div class=sel4>Município:<b> %s </b></div>", $xmun);

$erro = 0;
$xct2 = "";   // as (rotina 0211a) e (rotina 0211b) forçam a que se o campo 0211 estiver assinalado com S passe todos os anteriores a nulo....

//																	 VERIFICAÇÕES ANTES DE INSERT OU UPDATE

if ($tip_mov == "IN" || $tip_mov == "UPD"  ) {  // SE insert ou update

	// onde por a data $vinq[1][1] = $hoje .'/' . $agora;  // data e hora
  	$werr ="";
	// excepões de erro
	for ( $i = 0; $i < count($inq); $i++ ) {
		if ( $inq[$i][2] == "N" ) { // input Número....
			$vinq[$i][1] = str_replace(",",".",$vinq[$i][1]);  // as virgulas por pontos .....
			$vinq[$i][1] = str_replace("%","",$vinq[$i][1]);  // os sinais de %  por nada .....
			if (!is_numeric( $vinq[$i][1] ) ) {
			// está a mostrat $inq[$i][7]
				if ( $inq[$i][4] == "%" ) $werr = "<hr><div class=sel3r  align=left>  - O valor " .  $vinq[$i][1]  .  " referente a (<b>" . $inq[$i][1] . "</b>), é inválido. <b>Deve ser preenchido apenas com o valor de percentagem </b></div>"; // imprime erros de aviso, caso haja
					else
				$werr = "<hr><div class=sel3r align=left> - O valor " .  $vinq[$i][1]  .  " referente a (<b>" . $inq[$i][1] . "</b>), é inválido. <b>Deve ser preenchido apenas com o valor numérico </b></div>"; // imprime erros de aviso, caso haja				
				$vinq[$i][1] = '0';
				$erro = 1;
			}
	    } else if ( $inq[$i][2] == "T" ) { // input texto
			$vinq[$i][1] = str_replace("'","`",$vinq[$i][1]);  // troca os apostrofes!!!
		}  else if ( $inq[$i][2] == "D" && strlen($vinq[$i][1]) > 0 ) { // data
				$ndia = substr($vinq[$i][1],8,2);
				$nmes = substr($vinq[$i][1],5,2);
				$nano = substr($vinq[$i][1],0,4);
				
				if( checkdate($nmes,$ndia,$nano) == false) {
				$erro = 1;
				$werr .= "<div class=sel3r  align=left><br> - As datas devem estar no formato <b>aaaa-mm-dd</b></div>";
				} 
			 } else if ( $inq[$i][2] == "O" ) {
			 $vinq[$i][1] = str_replace("'","`",$vinq[$i][1]);  // troca os apostrofes!!!
			 if( strlen($vinq[$i][1]) > 0 && $inq[$i][7] > 0 ) { // TRUNCA TEXTI ACIMA DE x caracyteres
			   if( strlen( $vinq[$i][1]) > $inq[$i][7] ) {
				$vinq[$i][1] = substr($vinq[$i][1],0, $inq[$i][7]);
				echo " XXXXXXXXXXXXXXXXXXXXXXXXXXXX";
				
				//$erro = 1;
				// $werr .= "<div class=sel3r  align=left><br> - As datas devem estar no formato <b>aaaa-mm-dd</b></div>";
				}
			   }
			 }
	
	}
	
	$nom  = str_replace("'","`",$nom);  // troca os apostrofes!!!
	$func = str_replace("'","`",$func);  // troca os apostrofes!!!
	
	// especiais
	// if( $vinq[0][1] != 'S' ) $vinq[1][1] =""; // se não assinala os procedimentos, limpa a data
	// if( $vinq[2][1] != 'A' ) $vinq[3][1] =""; // se não assinala «elaboração da Agenda 21 Local», limpa a data
	
		// printf("Recebido inq%s", count($inq));
		// for ( $i=0; $i < count($inq); $i++) {
		// printf("<br>V:%s-[%s|%s]",$i,$vinq[$i][0], $vinq[$i][1]);
		// }			

		
	}
//  ################################################################################
// Aqui podem ser colocadas Validações e outrs condições fora de IN ou UPD ###########
// #################
if ( $erro == 0 ) {  // SE não há erros impeditivos continua
   // ###### avança com INPUT UPDATE ETC... ###########
   // ... se não vai para o fim do if (após o bloco SUP)...
   // #################
   // UPD
   
    $dat= $hoje . ' ' . $agora;
   
     if ($tip_mov == "UPD") {
    // #################
    // FAZ O UPDATE ....
    // aqui entra o UPDATE

	 $dados = serialize($vinq); // serialize ....

	$sql = " update $idtab set dados = '$dados', cod_sta = '$cod_sta', dat_sta = '$dat_sta', dat = '$dat', ido = '$sido', nom = '$nom', func = '$func', email = '$email' where cod_ent ='$xent' AND id_inq = $xidinq ";
	// printf("SQL:%s",$sql);

   		$result= mysql_db_query($idbas,$sql);
	 	 $regins=mysql_affected_rows();
  		 $ni = $regins;

      if ( $ni > 0 ) {
			printf("<p class=\"sel3\">%s</div>","Inquérito actualizado. ");
				printf("<p class=\"sel3a\">%s</div>  ","<br> Para Visualizar/ Alterar prima:");

			}
    // torna o movomento em SEL e limpa o nome, refas e observ.
    $tip_mov = "SEL";
 	// limpa os campos ....
 	// funçao de limpeza
    // $id=$reg=$it=$v1=$v2=$v3=$v4=$v5="";
  }

  // #################
  // INSERT
  if ( $tip_mov == "IN" ) {  // faz insert
    
  $dados=serialize($vinq); // serialize ....
  
 // #################
 // aqui entra O INSERT ....

 	$sql = " insert into $idtab  (cod_ent,id_inq, dados, cod_sta, dat_sta, dat, ido, nom, func, email) values ('$xent','$xidinq','$dados','$cod_sta','$dat_sta', '$dat', '$sido','$nom', '$func', '$email' ) ";
 	$result= mysql_db_query($idbas,$sql);
 	// echo mysql_error();
 	 $regins=mysql_affected_rows();
   $ni = $regins;
 
  if ( $ni > 0 ) {
			printf("<p class=\"sel4\">%s</div>","Inquérito inserido ...");
			printf("<p class=\"sel3b\">%s</div>","<br><br> Para visualizar/ Alterar prima:");
			
			
   }
 	$tip_mov = "SEL";
 	// limpa os campos ....
    // $id=$reg=$it=$v1=$v2=$v3=$v4=$v5="";
 }

//  TESTA SEMPRE A EXISTÊNCIA sempre que o movimento é diferente de IN, UPD e SEL
if ( $tip_mov != "IN" && $tip_mov != "UPD" && $tip_mov != "SUP" && $tip_mov != "SEL" ) $tip_mov = "SUP" ;


// ################# ##################################################################33333
// SUP
 if ($tip_mov == "SUP" ) {  // Faz select para update ao registo
  $n = 0;

	   $sql="select * from  $idtab  where cod_ent = '$xent' AND id_inq = $xidinq ";
	 	$result=mysql_db_query($idbas,$sql);
 		if ($result) {
 			$regis=mysql_fetch_array($result);
		if ( $regis ) {
			 // funçao de seleccção
			$dados = $regis["dados"];
			$nom = $regis["nom"];
			$func = $regis["func"];
			$email = $regis["email"];
			$dat = $regis["dat"];
			$n = 1;
			$vinq = unserialize($dados);

			if ( $dat == "0000-00-00 00:00") $dat= $hoje . ' ' . $agora;			
					
			}
		}


if ( $n > 0) { $tip_mov = "UPD";
			printf("<p class=\"sel3\">%s</div>","Consulta/Actualização");
			// printf("<p class=\"sel3b\">%s</div>"," Depois de efectuar as alterações desejadas prima o botão [Gravar]");
	}
   else {
   $tip_mov = "IN";
	 		// printf("<p class=\"sel3b\">%s</div>","Responda ao Inquérito e prima o botão [Gravar] ...");
   }
}

} else {
// mostra o erro !!!
	printf("<p class=\"sel3b\"><hr><b>ERROS:<br>%s</b><br>%s<hr></div>",$werr,"Faça as correcções e prima a o botão submeter ...");
}

 // #################
 // ###### aqui termina o if erro > 0 ###########
 // #################
 

//  FROM DE INPUT .... PRINCIPAL -->

?>

<?php

if ( $tip_mov == "IN" || $tip_mov == "UPD" )  {
	 printf("<form name=\"frm2\" method=\"POST\" action=\"inq1001fi.php\" class=\"sel2\">");
	 // o tip_mov é  hidden e apenas mostrado , não alterado
	// dados gerais
	 printf(" <input type=\"hidden\" name=\"tip_mov\" value=\"%s\">",$tip_mov);
	 printf(" <input type=\"hidden\" name=\"xent\" value=\"%s\">",$xent);
	 printf(" <input type=\"hidden\" name=\"xidinq\" value=\"%s\">",$xidinq);

	 printf(" <table width=760>");
	 printf("<tr bgcolor=\"#FEFEFE\"><td align=left height=20 colspan=2><b>%s</b>"," &ensp;");

		 // --- Ciclo para os items

	for ( $i = 0; $i < count($inq); $i++ ) {

		// percorre os items do array			
		 printf(" <input type=\"hidden\" name=\"vinq[$i][0]\" value=\"%s\">",$inq[$i][0]);  // chave d0 item

		// registo de definição é dados por inq[i]

		// procura o título				
          for ( $n = 0; $n < count($inqcab); $n++) {
	                  if ( $inq[$i][0] == $inqcab[$n][0] ) { // temos 						########## cabeçalho
	                  		if ( $inqcab[$n][2] == "T") { // é uma nova linha da tabela ...
	                  			printf("</td></tr><tr bgcolor=\"#FFFF99\"><td align=left height=20 colspan=2><b>%s</b></td></tr>"," ");
	                  			printf("<tr bgcolor=\"#ffffff\"><td align=left witdth=30 bgcolor=\"#FFFF99\"> &ensp;
 </td><td bgcolor=\"#ffffff\">%s<SPAN CLASS=%s><b>%s</b> </SPAN> %s ",$inqcab[$n][4],$inqcab[$n][3],$inqcab[$n][1],$inqcab[$n][5]);
	            			}	
	                  		else if ( $inqcab[$n][2] == "S"  ) { // temos apenas span de informação
                          	printf("%s<SPAN CLASS=\"%s\">%s </SPAN> %s",$inqcab[$n][4],$inqcab[$n][3],$inqcab[$n][1],$inqcab[$n][5]);
        				 	}
	                    }

	       }
 
 		// imprime o nome 
  		printf("%s%s", $inq[$i][5], $inq[$i][1]); // [5] - controlo antes do nome, Por exemplo br; no caso do R r O pode tamber colocar br [4] entre o nome e o input
 
 // TEXTO
       if ( $inq[$i][2] == "T" ) { // input text....
                      printf("<input style=\"text-align:left\" type=\"text\" name=\"vinq[$i][1]\" size=\"%s\" value=\"%s\" class=\"sel2\">%s %c",$inq[$i][3],$vinq[$i][1],$inq[$i][6],$xatb);
// DATA
					  } else if ( $inq[$i][2] == "D" ) { // input data
				$xli=10; // tamanho; por defeito é 10
				if (strlen($vinq[$i][1]) == 0 && $tip_mov == "IN" ) { // se for nulp põe a data de hoje  se o arg D se H põe dat e hora
							if ( $inq[$i][3] == 'D') { $vinq[$i][1] = $hoje; $xli=10;}
								else if ( $inq[$i][3] == 'H') { $vinq[$i][1] = $hoje . ' ' . $agora; $xli=15;}
					}			
         printf("<input style=\"text-align:left\" type=\"text\" name=\"vinq[$i][1]\" size=\"%s\" value=\"%s\" class=\"sel2\">%s %c",$xli,$vinq[$i][1],$inq[$i][6],$xatb);
// NUMERO
		 } else if ( $inq[$i][2] == "N" ) { // input Número
		
						if (strlen($vinq[$i][1]) == 0 ) { // número de decimais ....
							if ( $inq[$i][4] == '0') $vinq[$i][1] = '0';
								else if ( $inq[$i][4] == '1') $vinq[$i][1] = '00,0';
									else if ( $inq[$i][4] == '2' || $inq[$i][4] == '%'  ) $vinq[$i][1] = '00,00';
										else if ( $inq[$i][4] == '3') $vinq[$i][1] = '00,000';
											else $vinq[$i][1] = '0';
						}
											
                printf("<input style=\"text-align:right\" type=\"text\" name=\"vinq[$i][1]\" size=\"%s\" value=\"%s\" class=\"sel2\"> %s %c",$inq[$i][3],$vinq[$i][1],$inq[$i][6],$xatb);
// CHECKBOX		
		} else if ($inq[$i][2] == "C" ) { // input Check Box....

		if ( $vinq[$i][1] == $inq[$i][3] ) $xche = "CHECKED"; else $xche = "";  // se esta opção estiver
 			printf("%s <input type=\"checkbox\" name=\"vinq[$i][1]\" value=\"%s\" class=\"sel2\" %s>%s %c ",$inq[$i][4],$inq[$i][3], $xche, $inq[$i][6], $xtab );
// RADIO
			} else if ($inq[$i][2] == "R" ) { // input radio....
			$ri = $inq[$i][3];  // ordem do array inqrad que dá as opçoes rádio
 			for ( $r = 0; $r < count($inqrad[$ri]); $r++ ) {
				if ( $vinq[$i][1] == $inqrad[$ri][$r] ) $xche = "CHECKED"; else $xche = "";  // se esta opção estiver 
				// o $inq[$i][4] permite fazer break ante do radio ...
			 	if ( $ximp != "IMP"  ||  $xche == "CHECKED" ) {  // se for só para impressão,  só mostra o seleccionado
				printf("%s %s <input type=\"radio\" name=\"vinq[$i][1]\" value=\"%s\" class=\"sel2\" %s>  %c ",$inq[$i][4],  $inqrad[$ri][$r+1], $inqrad[$ri][$r] , $xche, $xtab );
				}
				$r++; // sata 2 de cada vez um para o valor outro para o nom	
			}
		printf(" %s",$inq[$i][6]); // fecha o item com <br>, etc	
		} else if ($inq[$i][2] == "R0" ) { // input radio....mas com o botão à esquerda
			$ri = $inq[$i][3];  // ordem do array inqrad que dá as opçoes rádio
 			for ( $r = 0; $r < count($inqrad[$ri]); $r++ ) {
				if ( $vinq[$i][1] == $inqrad[$ri][$r] ) $xche = "CHECKED"; else $xche = "";  // se esta opção estiver 
				// o $inq[$i][4] permite fazer break ante do radio ...
			 	printf("%s <input type=\"radio\" name=\"vinq[$i][1]\" value=\"%s\" class=\"sel2\" %s> %s %c ",$inq[$i][4], $inqrad[$ri][$r] , $xche, $inqrad[$ri][$r+1],$xtab );
				$r++; // sata 2 de cada vez um para o valor outro para o nom	
			}
		printf(" %s",$inq[$i][6]); // fecha o item com <br>, etc	
		}
		
				
		else if ( $inq[$i][2] == "O" ) { // Quadro de observações ....
		
			if ( $ximp != "IMP"  ) {  // se não for impressão mostra a text area
		    	  printf("%s<textarea name=\"vinq[$i][1]\" cols=\"140\" rows=\"%s\" class=\"sel2\">%s</textarea>%s %c",$inq[$i][4],$inq[$i][3],$vinq[$i][1],$inq[$i][6],$xtab );
			} else {
			    $stri=$vinq[$i][1];
				if ( strlen($stri) != 0 ) { 
				$stro="";
				$stro = str_replace ("\n", "<br>", "$stri");
				printf("%s%s",$inq[$i][4],$stro);
				}				
			}
        }
       
	} // Fim do ciclo for	   
	
	
	if ( $ximp != "IMP"  ) {  // se não for impressão mostra a text area
			printf("<tr bgcolor=\"ffffff\"><td align=right colspan=2> <input type=\"button\" value=\"Submeter Inquérito\" onclick=\"javascript:ValidaReg(this.form)\"></td></tr>");
      } else  {
	  printf("<tr bgcolor=\"ffffff\"><td align=right colspan=2> <input type=\"button\" value=\"Imprimir\" onclick=\"javascript:printpage()\"></td></tr>");
	  }
  
  
  printf("<tr  bgcolor=\"#CBE8ED\"><td colspan=2>  ");
// IDENTIFICAÇÃO DO RESPONSÁVEL PELO PREENCHIMENTO DESTE INQUÉRITO:
if (strlen($dat) == 0) $dat = $hoje . ' ' . $agora;
	printf("Gratos pela colaboração.<br>");
	printf("data: <input style=\"text-align:left\" type=\"text\" name=\"dat\" size=\"18\" value=\"%s\" class=\"sel2\" READONLY>%c",$dat,$xatb);
	printf("<br>Nome [do(a) responsável pelo preenchimento do inquérito]:<br> <input style=\"text-align:left\" type=\"text\" name=\"nom\" size=\"60\" value=\"%s\" class=\"sel2\">%c",$nom,$xatb);
	printf("<br>Cargo:<br> <input style=\"text-align:left\" type=\"text\" name=\"func\" size=\"60\" value=\"%s\" class=\"sel2\">%c",$func,$xatb);
	printf("<br>E-mail:<br> <input style=\"text-align:left\" type=\"text\" name=\"email\" size=\"60\" value=\"%s\" class=\"sel2\"  onChange=\"checkEmail(this.value)\">(para contacto)%c",$email,$xatb);
  printf("</td></tr>");
	printf("</table>");
	printf(" </form>");

	
  }	else {
          if ( strlen($werr) > 0 ) {
			    printf("<b>Avisos:</b>%s",$werr); // imprime erros de aviso, caso haja
            }
			printf("<p class=\"sel4\"> >>> <a href=\"inq1001fi.php?tip_mov=%s\"><b>CONTINUAR</b></a></span>","SUP");
 
      }

printf("</span></div></td></tr></table>");

?>

<br> [ <a href="/index.php" class="sel4">Sair</a> ]

</div>

 <?php
 // Menus de rodapé
 // include ('xxxxm2.inc');
 // mun101m2("xxxxxxx.php");
 // printf("%s",$tip_mov);

printf("<div class=sel3a><br>Para questões e/ou esclarecimentos adicionais, por favor, contacte:");
printf("<br>ANMP Coimbra| Luis Ramos");
// printf("<br>");
printf("<br>E-MAIL: <br> - lramos@anmp.pt");
printf("<br>TELEFONES: 239 40 44 34 ");
printf("</div>");

selinqs($xent); // mostra, caso existam aneoxos e possibilidade de novo


 ?>
 <div class="sel5">
 <hr>
 <br>- (c)ANMP/TI [INQ-1001/2010]
 </div>
  </body>

 </html>
</body></html>