<?php
session_start();
// os par�metros x... s�o passados em modo post ao chamar o programa
$email =  $_REQUEST["email"]; 
// $id_inq =  $_REQUEST["id_inq"]; 
// if (strlen($id_inq) == 0) $id_inq = 0;  // se n�o a aparece fica a zero !!!!
// controlo de p�ginas
$pagref = $_REQUEST["pagref"];
if ( strlen($pagref) == 0 ) $pagref=1;
$pag=$pagref;
$pagtot = 5;
$id_inq = "0"; //inquerito 1, mas tambem pode ser chamado com o id_inq




//###################################  AQUI




// a chave do inquerito vai ser o e-mail
if (strlen($email) > 0 ){ // se entra como par�metro , � posto na sess�o
	$_SESSION['email'] = $email;
	} else if (isset($_SESSION["email"])) { $email = $_SESSION["email"];
			} else { 
			die('Pedimos desculpa mas o e-mail '.$email.'<br /> n�o � v�lido');
			} 

			
			


			
			
// ao re-chamar o programa, deve faz�-lo com um tipo de movimento (IN,UPD,SEL)		
$tip_mov = $_REQUEST["tip_mov"];
$ref_mov = $_REQUEST["ref_mov"];

// ########################################################################
// OK chegou aqui avan�a para o programa
// Defini��es GLOBAIS

		// include('acw1.php');	// .... ....
		// ou 
		
		
		
		$xho = "localhost";
		$xus = "impresso_andre";
		$xpw = "Serv2011";
		
		$liga=mysql_connect($xho,$xus,$xpw);
		
		if ( !$liga ) {
			printf("Erro de liga��o � base de dados!");
			printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
		}
		

		$idtab = 'impresso_ISsite.impresso_inqext02';
		$idbas = 'impresso_ISsite';
		
		/*
		$xho = "localhost";
		$xus = "impresso_andre";
		$xpw = "Serv2011";
		
		$liga=mysql_connect($xho,$xus,$xpw);
		if ( !$liga ) {
			printf("Problema [mun101DB]!!!");
			printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
		}

		$idtab = 'impresso_ISsite.impresso1_users';
		$idbas = 'impresso_ISsite';
		==============
		
		$xho = "localhost";
		$xus = "dbus02";
		$xpw = "aristas15";
		
		$liga=mysql_connect($xho,$xus,$xpw);
		if ( !$liga ) {
			printf("Problema [mun101DB]!!!");
			printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
		}

		$idtab = 'cinove_2.inqext01';
		$idbas = 'cinove_2';
		
		*/
		
		
	include('arrext01.php');	// FAZ SEMPRE !!!! a Defini��o dos arrais para os registos....
	include("inqlayout.css");  // defini��es de layout
	
	//tentativa de fazer um insert � for�a
	//$sql = " insert into $idtab  (id_inq, dados, cod_sta, dat_sta, dat, ido, nom, func, email) values ('4','','','', '', '','andre', '', 'andre@s.pt' ) ";
 	//$result= mysql_db_query($idbas,$sql);

	$xtab= 10;
	// $xtab= '\n';
	// IN e UPD - se for o caso, preenche recebe o array do form com os dados de insert ou update
	if ( $tip_mov == "UPD" || $tip_mov == "IN" ) {  
			$vinq =  $_REQUEST["vinq"];
			$id = $_REQUEST["id"];
			$nom = $_REQUEST["nom"];
			$func = $_REQUEST["func"];
			$cod_sta = $_REQUEST["cod_sta"];
    }
	
	
// ########################################################################
// fun��es locais


// SELINS
 function selinqs($email,$id_inq) {
	
	global $idtab;
	global $idbas;
    $sqls="SELECT * FROM $idtab WHERE email ='$email' AND id_inq ='$id_inq'";
	$ress=mysql_db_query($idbas,$sqls); //
		if ($ress) {
			while( $regs=mysql_fetch_array($ress)) {
			$id = $regs["id"]; 
			printf("<p class=\"sel4\"> >>> <a href=\"inq.php?tip_mov=%s&id=%s\"><b>Rever Inqu�rito</b></a>  |     <a href=\"inq.php?tip_mov=%s&id=%s&ximp=%s\"><b>Imprimir</b></a> </a></p>","SUP",$id,"SUP",$id,"IMP");
			}
	}}
// SELent
 function selent($cod,&$nom,&$num_habit) {
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
// LFDH .... passa o campo iti como hidden 
function lfdh($iti,$vinq) {
global $xtab;
/*
- o iti � a chave do campo para fazer o input
- essa chave � que vai localizar no inq e no vinq o elemento para o INPUT, mas:
*/
  printf("<input type=\"hidden\" name=\"vinq[$iti]\" value=\"%s\"> %c",$vinq[$iti],$xtab);
} 
// LFDX .... formata o c�digo de input para o form
function lfdx ($iti,$inq,$vinq,$che,$def) {
global $ron;
global $xtab;
/*
- o iti � a chave do campo para fazer o input
- essa chave � que vai localizar no inq e no vinq o elemento para o INPUT, mas:
	+ se o che tiver um valor, ser� usado nos campo do tipo Radio e checkbox, para a valida��o de checked e para �value=...�
- usa uma vari�vel gloval ron que se estiver READONLY impede a altera��o
*/

       if ( $inq[$iti][2] == "T" ) { 
	   // input text....								// TEXTO
            printf("<input style=\"text-align:left\" type=\"text\" name=\"vinq[$iti]\" size=\"%s\" value=\"%s\" class=\"sel2\">%s %c",$inq[$iti][3],$vinq[$iti],$inq[$iti][6],$xtab);
			
			
			
	  } else if ( $inq[$iti][2] == "D" ) { 
	  // input data 									// DATA
				$xli=10; // tamanho; por defeito � 10
				if (strlen($vinq[$iti]) == 0 && $tip_mov == "IN" ) { // se for nulo p�e a data de hoje  se o arg D se H p�e dat e hora
							if ( $inq[$iti][3] == 'D') { $vinq[$iti] = $hoje; $xli=10;}
								else if ( $inq[$iti][3] == 'H') { $vinq[$iti] = $hoje . ' ' . $agora; $xli=15;}
					}			
         printf("<input style=\"text-align:left\" type=\"text\" name=\"vinq[$iti]\" size=\"%s\" value=\"%s\" class=\"sel2\">%s %c",$xli,$vinq[$iti],$inq[$iti][6],$xtab);
		 
		
		 
		 
	  } else if ( $inq[$iti][2] == "N" ) { 
	  // input N�mero 									// NUMERO
			if (strlen($vinq[$iti]) == 0 ) { // n�mero de decimais ....
							if ( $inq[$iti][4] == '0') $vinq[$iti] = '0';
								else if ( $inq[$iti][4] == '1') $vinq[$iti] = '00,0';
									else if ( $inq[$iti][4] == '2' || $inq[$iti][4] == '%'  ) $vinq[$iti] = '00,00';
										else if ( $inq[$iti][4] == '3') $vinq[$iti] = '00,000';
											else $vinq[$iti] = '0';
						}
				printf("<input style=\"text-align:right\" type=\"text\" name=\"vinq[$iti]\" size=\"%s\" value=\"%s\" class=\"sel2\" $ron> %s %c",$inq[$iti][3],number_format($vinq[$iti], $inq[$iti][4], '.', ' '),$inq[$iti][6],$xtab);
				
			
				
		} else if ($inq[$iti][2] == "C" ) { 
		// input Check Box.... 						// CHECKBOX		
					if ( strlen($che) > 0 ) $xvalche  = $che; else $xvalche = $inq[$iti][3];
						if ( $vinq[$iti]== $xvalche ) $xche = "CHECKED"; else $xche = "";  // se esta op��o estiver 
 			printf("%s<input type=\"checkbox\" name=\"vinq[$iti]\" value=\"%s\" %s>%s%c",$inq[$iti][4], $xvalche, $xche, $inq[$iti][6], $xtab );
		} else if ($inq[$iti][2] == "R" ) { // input radio.... 	// RADIO
				if ( strlen($che) > 0 ) $xvalche  = $che; else $xvalche = $inq[$iti][3];  // a vari�vel che pode trazer o valor do radiom se n�o � o que est� no array
				if ( $vinq[$iti]== $xvalche ) $xche = "CHECKED"; else $xche = "";  // se esta op��o estiver 
				// o $inq[$i][4] permite fazer break ante do radio ...
			 	if ( $ximp != "IMP"  ||  $xche == "CHECKED" ) {  // se for s� para impress�o,  s� mostra o seleccionado
				printf("%s<input type=\"radio\" name=\"vinq[$iti]\" value=\"%s\" %s >%c",$inq[$iti][4], $xvalche , $xche, $xtab);
				
				
			
				
				}
		printf("%s",$inq[$iti][6]); // fecha o item com <br>, etc	
		} else if ( $inq[$iti][2] == "O" ) { 
		// Quadro de observa��es ....					TEXTAREA
		
			if ( $ximp != "IMP"  ) {  // se n�o for impress�o mostra a text area
		    	  printf("%s<textarea name=\"vinq[$iti]\" cols=\"120\" rows=\"%s\" class=\"sel2\">%s</textarea>%s %c",$inq[$iti][4],$inq[$iti][3],$vinq[$iti],$inq[$iti][6],$xtab );
				  
				  
				
			} else {
			    $stri=$vinq[$iti];
				if ( strlen($stri) != 0 ) { 
				$stro="";
				$stro = str_replace ("\n", "<br>", "$stri");
				printf("%s%s",$inq[$iti][4],$stro);
				
				
				
			
				
				}				
			}
        }
    return;  
	} 
	// Fim da fun��o de imput dos campos	   

//  ################################################################################
// Defini��es para o HTML ....
 ?>

<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INQU�RITO:Inq:1-2012</title>
</head>
<!-- estas fun��es javacript n�o est�o a ser aqui usadas mas podem ser!!!   -->
<SCRIPT LANGUAGE="JavaScript">
<!-- Hide script from some browsers
function foc()
 {
   window.status="Popula��o afectada";
 }

function blu()
 {
   window.status="";
 }

function ValidaReg(fx) {
	// n�o faz nada s� submete ....
	document.frm2.submit();
}

function xValidaReg(fx) {
var can = fx["vinq[2][1]"];
var apr = fx["vinq[2][1]"];

var ncan = can.value;
var napr = apr.value;

	if ( ncan > 0 ) {
			if ( Number(napr) >  Number(ncan) ) {
			    alert("Erro: O n�mero de candidaturas apresentadas \n tem de ser igual ou superior ao n�mero de candidaturas  aprovadas. \n Corrija este dado e prima novamente o bot�o Submeter" );
					can.focus();
					return;
			}
   }
	document.frm2.submit();
}

// ------- Dia 30  ------------

function drop()
{
	alert(entrei);
   var value = "Ficha";
   
}

function PagAnt(formx) {
pagref = formx.elements["pagref"];
var npag = pagref.value;
    if ( npag > 1 ) {
            npag--;
            }
pagref.value = npag;
document.frm2.submit();
}


function PagSeg(formx) {
pagref = formx.elements["pagref"];
var npag = pagref.value;
            npag++;
pagref.value = npag;
document.frm2.submit();
}

function PagFin(formx) {
pagref = formx.elements["ref_mov"];
var ref_mov = pagref.value;
    ref_mov = "FIN";
pagref.value = ref_mov;
document.frm2.submit();
}



/*
// ----------------------------  FUN��ES JAVASCRIPT ANTIGAS



function PagAnt(formx) {
var pagref = formx["pagref"];
var npag = pagref.value;
	if ( npag > 1 ) {
			npag--;
			}
	pagref.value = npag;
	formx["pagref"] = pagref;
   
	document.frm2.submit();
}

function PagSeg(formx) {//formx = formul�rio actual

var pagref = formx["pagref"];//vai buscar id do formul�rio ao objecto formx
var npag = pagref.value;//vai buscar n�mero de p�gina do formul�rio ao objecto formx

	npag++;

	
	pagref.value = npag;
	

	
	
	//at� aqui tudo fino
	
	formx["pagref"] = pagref;		         alert("Erro: oi");
   	document.frm2.submit();alert("Erro: oi oi oi");
}

/*
function PagFin(formx) {
var pagref = formx["ref_mov"];
var ref_mov = pagref.value;
	ref_mov = "FIN";
	pagref.value = ref_mov;
	formx["pagref"] = pagref;
   	document.frm2.submit();
}

*/


function checkEmail(email) {
 if(email.length > 0)  {
      if (email.indexOf(' ') >= 0)
           alert("Erro: O Endere�o (email) n�o pode conter espa�os. \n Corrija este dado e prima novamente o bot�o Submeter");
       else if (email.indexOf('@') == -1)
           alert("Erro: O Endere�o (email) tem de conter o caracter @. \n Corrija este dado e prima novamente o bot�o Submeter");
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
// zona de cabe�alho ....
$hoje=date('Y-m-d',time());
$agora=date('H:i',time());
// printf("<b>in�cio do dito !!!!! mov=%s</b>",$tip_mov);
echo '
					<div align="center">
					<table width=900 bgcolor=#ffffff>
					
					</td><td>
					
					<br>
					<br>
					</td><td><IMG SRC="/inq/cabecalho-final.jpg" ALT="IPL"  border=0>
					<br><br>
					<div class="sel3a" align="center"><span class="sel3i"> INQU�RITO DE SATISFA��O
					</td></tr></table>
					<table width=900 bgcolor=#ffffff>
		'; // Cabe�alho!!!
		// fim da tabela 1
		if ($tip_mov != "IN" && $tip_mov != "UPD"  ) {  // nos casos de IM ou UPD n�o mostra as notas
					?>
					</span></div></td></tr>
					<tr><td colspan=2 class="sel3">
					<div class="sel3" align="justify">
					
					<strong>Obrigado </strong>por responder ao nosso question�rio de satisfa��o.
					<br>
					O question�rio demora apenas 5 minutos do seu tempo
					<br>
					<br>

					<br>
					
					
					<!--
					<p><strong>Instru��es de preenchimento</strong></p>
					<p>Numa fase em que o quadro legal relativo ao mercado energ�tico est� a sofrer significativas altera��es e, sobretudo, numa fase em que se avizinha um excessivo aumento dos custos com energia el�trica para valores incomport�veis, pretende a ANMP perceber, de forma mais concreta, que medidas podem ser tomadas para reduzir a pesada fatura energ�tica que os Munic�pios suportam mensalmente, sem contudo p�r em causa o conforto e a seguran�a dos mun�cipes.
					<p>A resposta desse Munic�pio ao presente inqu�rito ser� da m�xima utilidade para a defini��o de uma estrat�gia de atua��o neste dom�nio e para a discuss�o quer com o Governo com os fornecedores do servi�o de fornecimento de energia el�ctrica, particularmente com a EDP.
					<hr>
						-->	
					<?php
					}
                    // $k = selent($xent,$xmun,$xnumhab);
					$k=1; // este k � martelado !!!!!!!!... deve ser vaidados com e e-mail do cliente ou otro m�todo
										
				//# comentado a 26/03/2012						
				//	printf("[=====E06======> %s | %s |  %s | %s ]",$xent,$xmun);
					if (  $k == 0 ) {
					 	// PROBLEMAS COM A IDENTIFICA��O DA Entidade
						 	 				echo " Acesso n�o ajustado a este Inqu�rito - E07 [$ident| $xnom]";
					 	 				exit -1;
					 }
		

$erro = 0;
$xct2 = "";   // as (rotina 0211a) e (rotina 0211b) for�am a que se o campo 0211 estiver assinalado com S passe todos os anteriores a nulo....

/*												 VERIFICA��ES ANTES DE INSERT OU UPDATE
 											  (valida campos e caracteres especiais....)
											==============================================	
*/
if ($tip_mov == "IN" || $tip_mov == "UPD"  ) {  // SE insert ou update
	// data $vinq[$iti] = $hoje .'/' . $agora;  // data e hora
  	$werr ="";
	// excep�es de erro
	foreach ($vinq as $iti => $valit) {
		if ( $inq[$iti][2] == "N" ) { //  N�mero ������
			$vinq[$iti] = str_replace(",",".",$vinq[$iti]);  // as virgulas por pontos .....no pr�prio array
			$vinq[$iti] = str_replace("%","",$vinq[$iti]);  // os sinais de %  por nada .....
			$vinq[$iti] = str_replace(" ","",$vinq[$iti]);  // os espa�os por ada .....
			if (!is_numeric( $vinq[$iti] ) ) {
			// est� a mostrar $inq[$iti][7]
				if ( $inq[$iti][4] == "%" ) $werr = "<hr><div class=sel3r  align=left>  - O valor " .  $vinq[$iti] .  " referente a (<b>" . $inq[$iti][1] . "</b>), � inv�lido. <b>Deve ser preenchido apenas com o valor de percentagem </b></div>"; // imprime erros de aviso, caso haja
					else
				$werr = "<hr><div class=sel3r align=left> - O valor " .  $vinq[$iti]  .  " referente a (<b>" . $inq[$iti][1] . "</b>), � inv�lido. <b>Deve ser preenchido apenas com o valor num�rico </b></div>"; // imprime erros de aviso, caso haja				
				$vinq[$iti] = '0';
				$erro = 1;
			}
	    } else if ( $inq[$iti][2] == "T" ) { // Texto �����
			$vinq[$iti] = str_replace("'","`",$vinq[$iti]);  // troca os apostrofes!!!
		}  else if ( $inq[$iti][2] == "D" && strlen($vinq[$iti]) > 0 ) { // data ���������
				$ndia = substr($vinq[$iti],8,2);
				$nmes = substr($vinq[$iti],5,2);
				$nano = substr($vinq[$iti],0,4);
				
				if( checkdate($nmes,$ndia,$nano) == false) {
				$erro = 1;
				$werr .= "<div class=sel3r  align=left><br> - As datas devem estar no formato <b>aaaa-mm-dd</b></div>";
				} 
			 } else if ( $inq[$iti][2] == "O" ) { // janela de observa��es ��������
			 $vinq[$iti] = str_replace("'","`",$vinq[$iti]);  // troca os apostrofes!!!
			 if( strlen($vinq[$iti]) > 0 && $inq[$iti][7] > 0 ) { // TRUNCA TEXTI ACIMA DE x caracyteres
			   if( strlen( $vinq[$iti]) > $inq[$iti][7] ) {
				$vinq[$iti] = substr($vinq[$iti],0, $inq[$iti][7]);
				echo " ";
				
				//$erro = 1;
				// $werr .= "<div class=sel3r  align=left><br> - As datas devem estar no formato <b>aaaa-mm-dd</b></div>";
				}
			   }
			 }
	}
	$nom  = str_replace("'","`",$nom);  // troca os apostrofes!!!
	$func = str_replace("'","`",$func);  // troca os apostrofes!!!
	}

//  ################################################################################
// Aqui podem ser colocadas Valida��es e outrs condi��es fora de IN ou UPD ###########
// #################

if ( $erro == 0 ) {  // SE n�o h� erros impeditivos e atingiu a pag final, continua
   // ###### avan�a com INPUT UPDATE ETC... ###########
   // ... se n�o vai para o fim do if (ap�s o bloco SUP)...
   // #################
   // UPD
   
    $dat = $hoje . ' ' . $agora;
	$dat_sta = $hoje;
	   
  if ($tip_mov == "UPD" && $ref_mov == "FIN" ) {
    // #################
    // FAZ O UPDATE ....se a ref_mov = FIN
    // aqui entra o UPDATE

	 $dados = serialize($vinq); // serialize ....

	$sql = " update $idtab set dados = '$dados', cod_sta = '$cod_sta', dat_sta = '$dat_sta', dat = '$dat', ido = '$sido', nom = '$nom', func = '$func', email = '$email' where id ='$id' ";
	// printf("SQL:%s",$sql);

	
	
   		$result= mysql_db_query($idbas,$sql);
		
		
		
	 	 $regins=mysql_affected_rows();
  		 $ni = $regins;

      if ( $ni > 0 ) {
			printf("<p class=\"sel3i\">%s</p>","Inqu�rito actualizado com sucesso. ");
				printf("<p class=\"sel3a\">%s</p>  ","<br> Para Rever/Alterar os dados recebidos, prima:");
			}
    // torna o movomento em SEL e limpa o nome, refas e observ.
    $tip_mov = "SEL";
 	// limpa os campos ....
 	// fun�ao de limpeza
    // $id=$reg=$it=$v1=$v2=$v3=$v4=$v5="";
  }

  // #################
  // INSERT
  if ( $tip_mov == "IN"  && $ref_mov == "FIN" ) {  // faz insert....se a ref_mov = FIN
    
  $dados=serialize($vinq); // serialize ....
  
 // #################
 // aqui entra O INSERT ....
 
 // aqui no debaixo vou tirar o cod_ent
//$sql = " insert into $idtab  (cod_ent,id_inq, dados, cod_sta, dat_sta, dat, ido, nom, func, email) values ('$xent','$id_inq','$dados','$cod_sta','$dat_sta', '$dat', '$sido','$nom', '$func', '$email' ) ";

	
	//echo 'idtab '.$idtab. 'id_inq '.$id_inq.'dados '.$dados.'cod_sta'.$cod_sta.'dat_sta '.$dat_sta.'dat '.$dat.'sido '.$sido.'nom '.'nom '.$nom.'func '.$func.'email '.$email ;

	/*
	echo 'idtab: '.$idtab. 'id_inq: '.$id_inq.'dados: '.$dados.'nom '.$nom.'func '.$func.'email '.$email.'dat '.$dat.'cod_sta'.$cod_sta.'dat_sta '.$dat_sta.'sido '.$sido;
	
	$sql = " INSERT INTO". $idbas. " idtab (id_inq, dados, nom,func,   email,dat,cod_sta, dat_sta,  ido) values ('$id_inq','$dados','$nom','$func',  '$email','$dat','$cod_sta','$dat_sta',  '$sido' ) ";
	//mysql_query($sql5);
	
	
/*
$sql1 = "INSERT INTO " . $table_prefix . "users (name,username,email,password,usertype,block,sendEmail,registerDate,lastvisitDate,activation,params) values ('$nome','$username','$email',md5('$password'),'$usertypename','$block','$sendmail', NOW(),'0000-00-00 00:00:00','','')";
mysql_query($sql1);
*/	
	
 	$sql = "insert into $idtab  (id_inq, dados, cod_sta, dat_sta, dat, ido, nom, func, email) values ('$id_inq','$dados','$cod_sta','$dat_sta', '$dat', '$sido','$nom', '$func', '$email' ) ";
	
	
	/*
	
	-< Dados da tabela inqext02 >-
	
	CREATE TABLE IF NOT EXISTS `impresso_inqext02` (
  `id` int(11) NOT NULL auto_increment,
  `id_inq` int(4) NOT NULL default '0',
  `dados` text,
  `nom` varchar(64) default NULL,
  `func` varchar(64) default NULL,
  `email` varchar(64) default NULL,
  `dat` datetime default NULL,
  `cod_sta` char(3) default NULL,
  `dat_sta` date default NULL,
  `ido` varchar(32) default NULL,
  PRIMARY KEY  (`id`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

		$xho = "localhost";
		$xus = "impresso_andre";
		$xpw = "Serv2011";		
		$idtab = 'impresso_ISsite.inqext02';
		$idbas = 'impresso_ISsite';


*/
	
	//$sql = " insert into $idtab  (id, id_inq, dados, cod_sta, dat_sta, dat, ido, nom, func, email) values ('$id', '$id_inq','$dados','$cod_sta','$dat_sta', '$dat', '$sido','$nom', '$func', '$email' ) ";
 	
	
		
	//$sql = " insert into $idtab (id, id_inq, dados, nom,func,   email,dat,cod_sta, dat_sta,  ido) values ('$id','$id_inq','$dados','$nom','$func',  '$email','$dat','$cod_sta','$dat_sta',  '$sido' ) ";
	//$sql = " INSERT INTO". $idbas. " idtab (id, id_inq, dados, nom,func,   email,dat,cod_sta, dat_sta,  ido) values ('$id','$id_inq','$dados','$nom','$func',  '$email','$dat','$cod_sta','$dat_sta',  '$sido' ) ";
 	
	//$sql = " insert into impresso_ISsite.inqext02 (id, id_inq, dados, nom,func,   email,dat,cod_sta, dat_sta,  ido) values ('$id','$id_inq','$dados','$nom','$func',  '$email','$dat','$cod_sta','$dat_sta',  '$sido' ) ";
	$result= mysql_db_query($idbas,$sql);
	echo '<hr>'.$sql;
	
	//tentativa de preencher � for�a
	//$sql = " insert into $idtab  (id_inq, dados, cod_sta, dat_sta, dat, ido, nom, func, email) values ('5','','','', '', '','andre', '', 'andre@andre.pt' ) ";
 	//$result= mysql_db_query($idbas,$sql);
	
	
 	// echo mysql_error();
 	$regins=mysql_affected_rows();
	$ni = $regins;
 
 
	printf("valor do ni: ".$ni);
	
 
  if ( $ni > 0 ) {
			printf("<p class=\"sel3i\">%s</p>","Inqu�rito inserido com sucesso");
			printf("<p class=\"sel3b\">%s</p>","<br><br> Para Rever/Alterar os dados recebidos, prima:");
   }
   printf("Deu bode");
 	$tip_mov = "SEL";
 	// limpa os campos ....
    // $id=$reg=$it=$v1=$v2=$v3=$v4=$v5="";
 }

//  TESTA SEMPRE A EXIST�NCIA sempre que o movimento � diferente de IN, UPD e SEL, passa a SUP (com a respetiva valida��o)
if ( $tip_mov != "IN" && $tip_mov != "UPD" && $tip_mov != "SUP" && $tip_mov != "SEL" ) $tip_mov = "SUP" ;

// ################# ##################################################################33333
// SUP
 if ( $tip_mov == "SUP" ) {  // Faz select para testar e exist�ncia de um registo, passnado-o a update,caso exista
  $n = 0;

	   $sql="select * from  $idtab  where email = '$email' AND id_inq = $id_inq ";
	 	$result=mysql_db_query($idbas,$sql);
 		if ($result) {
 			$regis=mysql_fetch_array($result);
		if ( $regis ) {
			 // fun�ao de selecc��o
			$id = $regis["id"]; 
			$dados = $regis["dados"];
			$nom = $regis["nom"];
			$func = $regis["func"];
			$dat = $regis["dat"];
			$cod_sta = $regis["cod_sta"];

			$n = 1;
			$vinq = unserialize($dados);

			if ( $dat == "0000-00-00 00:00") $dat = $hoje . ' ' . $agora;			
			echo '<hr> data:'. $dat . '|'. $hoje . ' ' . $agora. ']';
			
			$january = new DateTime($dat);
			$february = new DateTime($hoje . ' ' . $agora);
			//$interval = $february->diff($january);

			// %a will output the total number of days.
			// echo $interval->format('%h total horas') ."<hr>";
			//$k = $interval->format('%i');
			echo $k;
			
			if ( $cod_sta == "ENC" && $limpa != "1") {  // se est� encerrado fica readonly e muda o status para IMp (apenas imprime)
			$ron = "READONLY";
			$ximp = "IMP"; 
			}
			else $ron = "";  
			/* ******** depois de encerrar o inqu�rito apenas � poss�vel ver os dados, 
						importa estabelecer o processo de encerramento, por a��o do operador ou automaticamento ap�s n dias
						*/
			}
		}

	if ( $n > 0) { $tip_mov = "UPD";
		printf("<p class=\"sel3\">%s</div>","Consulta/Actualiza��o");
		// printf("<p class=\"sel3b\">%s</div>"," Depois de efectuar as altera��es desejadas prima o bot�o [Gravar]");
	} else {
		$tip_mov = "IN";
	 	// printf("<p class=\"sel3b\">%s</div>","Responda ao Inqu�rito e prima o bot�o [Gravar] ...");
   }
   // fim da valida��o do SUP 
  }
 // fim do if erro=0
} else { // se h� erro 
// mostra o erro !!!
	printf("<p class=\"sel3b\"><hr><b>ERROS:<br>%s</b><br>%s<hr></div>",$werr,"Fa�a as correc��es e prima a o bot�o submeter ...");
}

//# tr�s linhas abaixo (26/03/2012)
//echo " ...... $tip_mov <br>";
if ( $tip_mov == "NEW") $tip_mov = "IN";  // os novos passam aqui a IN ....
//echo " ...... $tip_mov <br>";

//  FROM DE INPUT .... PRINCIPAL -->

if ( $tip_mov == "IN" || $tip_mov == "UPD" )  {
	 printf("<form name=\"frm2\" method=\"POST\" action=\"inq.php\" class=\"sel2\">");
	 // o tip_mov �  hidden e apenas mostrado , n�o alterado
	// dados gerais
	 printf(" <input type=\"hidden\" name=\"tip_mov\" value=\"%s\">",$tip_mov);
	 printf(" <input type=\"hidden\" name=\"xent\" value=\"%s\">",$xent);
	 printf(" <input type=\"hidden\" name=\"id\" value=\"%s\">",$id);
	 printf(" <input type=\"hidden\" name=\"id_inq\" value=\"%s\">",$id_inq);
	 
	 
	 
	 
	 
		 	 
	 // printf("<table width=800 border=1 cellspacing=0 cellpadding=1>");
	 // printf("<tr bgcolor=\"#FEFEFE\"><td align=left height=20 colspan=2><b>%s</b>"," &ensp;");

	/*
			###########################################################################3
						CONSTROI UM FORM COM OS ELEMEMENTOS .....   
	
				a fun��o lfdx("0101",$inq,$vinq,"SIM","Escreva a qui o seu nome") � evocada sempre que queremos inserir um campo de input. os par�metros:
				0101 -> chave do campo, no array de defini��es $inq e no array de valores a passar para o form $vinq
				$inq-> array de defini��es 
				$vinq-> array de valores a passar para o form e a registar na base de dados
				["SIM|NAO|MUTO..."]-> s�o as constantes a fixar para o campos do tipo Radio ou Checkbox
				["Escreva a qui o seu nome"] -> pode ser usado para preecher, por defeito um capo, mas ainda n�o est� a ser usado.
		
	*/
	// PARTICULARIDADE DO INQU�RITO 1024 ... $vinq[] ... � martelado com os habitantes do munic�pio....
	// nq["0210"] = $xnumhab;
	$cor0="#009966";
	$cor1="#FFFFA8";
	$cor2="#FFCC66";
	$cor4="#fafafa";
	
	?>
	
<!--                                  ######################  CORPO DE INQU�RITO   #############################    -->
	
	<table border =0>
	<tr><td>CLIENTE: </td><td> <input style="text-align:left" type="text" name="nom" size="60" value="<?php echo $nom;?>" class="sel2"></td></tr>
	<tr><td>E-MAIL: </td><td> <input style="text-align:left" type="text" name="email" size="60" value="<?php echo $email;?>" class="sel2" onChange="checkEmail(this.value)">
	</td></tr>
</table>	
	</p>


<!-- PAGINA 1 -->
<?php 
$lq=850; // largura dos quadros
if ( $pag == "1" || $pag == "99" ) { 
?>
Por favor classifique os itens no quadro abaixo seleccionando, com um clique do seu rato, a coluna correspondente � sua avalia��o.
<br>
<strong><h1>Departamento Comercial</h1></strong>
<table border =1 width ="<?php echo $lq?>">
<tr><td> &nbsp;</td><td align="center">Muito Insatisfeito</td><td align="center">Insatisfeito</td><td align="center">Sem Opini�o</td><td align="center">Satisfeito</td><td align="center">Muito Satisfeito
</td></tr>
<tr><td>Simpatia e disponibilidade no atendimento</td><td align="center"><?php lfdx("1010",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("1010",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("1010",$inq,$vinq,"3",""); ?>  </td><td align="center"><?php lfdx("1010",$inq,$vinq,"4",""); ?> </td><td align="center"><?php lfdx("1010",$inq,$vinq,"5","");?>
</td></tr>
<tr><td>Qualidade do servi�o prestado:</td><td align="center"><?php lfdx("1020",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("1020",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("1020",$inq,$vinq,"3",""); ?> </td><td align="center"><?php lfdx("1020",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1020",$inq,$vinq,"5",""); ?>
</td></tr>

<tr><td>Tempo de resposta at� obter or�amento</td><td align="center"><?php lfdx("1030",$inq,$vinq,"1",""); ?></td><td align="center"><?php lfdx("1030",$inq,$vinq,"2",""); ?></td><td align="center"><?php lfdx("1030",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("1030",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1030",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Cumprimento dos prazos de t�rmino do trabalho</td><td align="center"><?php lfdx("1040",$inq,$vinq,"1",""); ?></td><td align="center"><?php lfdx("1040",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("1040",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("1040",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1040",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Preocupa��es da empresa com a exequibilidade do trabalho<br /> nomeadamente pela proposta de altera��es antes e durante a execu��o dos trabalhos</td><td align="center"><?php lfdx("1050",$inq,$vinq,"1",""); ?></td><td align="center"><?php lfdx("1050",$inq,$vinq,"2",""); ?></td><td align="center"> <?php lfdx("1050",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("1050",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1050",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Disponibilidade para resolu��o de problemas durante o trabalho</td><td align="center"><?php lfdx("1060",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("1060",$inq,$vinq,"2",""); ?></td><td align="center"><?php lfdx("1060",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("1060",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1060",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Apoio P�s Venda</td><td align="center"><?php lfdx("1070",$inq,$vinq,"1",""); ?></td><td align="center"><?php lfdx("1070",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("1070",$inq,$vinq,"3",""); ?> </td><td align="center"><?php lfdx("1070",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1070",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Condi��es do espa�o f�sico no atendimento</td><td align="center"><?php lfdx("1080",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("1080",$inq,$vinq,"2",""); ?></td><td align="center"> <?php lfdx("1080",$inq,$vinq,"3",""); ?> </td><td align="center"><?php lfdx("1080",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1080",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Qualidade/pre�os</td><td align="center"><?php lfdx("1090",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("1090",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("1090",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("1090",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1090",$inq,$vinq,"5",""); ?>
</td></tr>
</table>

<?php 
} else { // se n�o mostra a p�gina ... passa todos os campos como hidden
lfdh("1010",$vinq);
lfdh("1020",$vinq);
lfdh("1030",$vinq);
lfdh("1040",$vinq);
lfdh("1050",$vinq);
lfdh("1060",$vinq);
lfdh("1070",$vinq);
lfdh("1080",$vinq);
lfdh("1090",$vinq);
}
?>
<!-- PAGINA 2 -->
<?php 
if ( $pag == "2" || $pag == "99" ) { 
?>
<br>	
<br><br><strong><h1>Departamento de desenvolvimento de servi�o</h1></strong>	
<table border =1 width ="<?php echo $lq?>">
<tr><td> &nbsp;</td><td align="center">Muito Insatisfeito</td><td align="center">Insatisfeito</td><td align="center">Sem Opini�o</td><td align="center">Satisfeito</td><td align="center">Muito Satisfeito
</td></tr>

</td></tr>
<tr><td>Simpatia e disponibilidade dos colaboradores</td><td align="center"><?php lfdx("2010",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2010",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2010",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2010",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2010",$inq,$vinq,"5",""); ?>
</td></tr>

</td></tr>
<tr><td>Qualidade do servi�o prestado</td><td align="center"><?php lfdx("2020",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2020",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2020",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2020",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2020",$inq,$vinq,"5",""); ?>
</td></tr>

</td></tr>
<tr><td>Solu��es oferecidas pelos nossos produtos</td><td align="center"><?php lfdx("2030",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2030",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2030",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2030",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2030",$inq,$vinq,"5",""); ?>
</td></tr>

</td></tr>
<tr><td>Responsabilidade dos nossos Servi�os T�cnicos</td><td align="center"><?php lfdx("2040",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2040",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2040",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2040",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2040",$inq,$vinq,"5",""); ?>
</td></tr>


</td></tr>
<tr><td>Tempo de resposta/execu��o dos nossos servi�os T�cnicos</td><td align="center"><?php lfdx("2050",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2050",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2050",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2050",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2050",$inq,$vinq,"5",""); ?>
</td></tr>

</td></tr>
<tr><td>Satisfa��o geral com os nossos servi�os t�cnicos</td><td align="center"><?php lfdx("2060",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2060",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2060",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2060",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2060",$inq,$vinq,"5",""); ?>
</td></tr>

</td></tr>
<tr><td>Como classifica os materiais e equipamentos da empresa</td><td align="center"><?php lfdx("2070",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2070",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2070",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2070",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2070",$inq,$vinq,"5",""); ?>
</td></tr>

</table>




<?php 
} else { // se n�o mostra a p�gina ... passa todos os campos como hidden
lfdh("2010",$vinq);
lfdh("2020",$vinq);
lfdh("2030",$vinq);
lfdh("2040",$vinq);
lfdh("2050",$vinq);
lfdh("2060",$vinq);
lfdh("2070",$vinq);
}
?>

<!-- PAGINA 3 -->
<?php 
if ( $pag == "3" || $pag == "99" ) { 
?>
<br>	
<br><br><strong><h1>Qualidade</h1></strong>	
<table border =1 width ="<?php echo $lq?>">
<tr><td> &nbsp;</td><td align="center">Muito Insatisfeito</td><td align="center">Insatisfeito</td><td align="center">Sem Opini�o</td><td align="center">Satisfeito</td><td align="center">Muito Satisfeito
</td></tr>
<tr><td>Informa��o t�cnica dos produtos/servi�os fornecidos</td><td align="center"><?php lfdx("4010",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("4010",$inq,$vinq,"2",""); ?></td><td align="center"> <?php lfdx("4010",$inq,$vinq,"3",""); ?> </td><td align="center"><?php lfdx("4010",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("4010",$inq,$vinq,"5",""); ?>

 </td></tr>
<tr><td>Efici�ncia no tratamento de reclama��es/sugest�es: </td><td align="center"><?php lfdx("4020",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("4020",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("4020",$inq,$vinq,"3",""); ?> </td><td align="center"><?php lfdx("4020",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("4020",$inq,$vinq,"5",""); ?>
</td></tr>
</table>


<?php 
} else { // se n�o mostra a p�gina ... passa todos os campos como hidden
lfdh("4010",$vinq);
lfdh("4020",$vinq);

}
?>


<!-- PAGINA 4 -->
<?php 
if ( $pag == "4" || $pag == "99" ) { 
?>
<br>



<br><br><strong><h1>Pol�tica Empresarial</h1></strong>	

<table border =1 width ="<?php echo $lq?>">
<tr><td> &nbsp;</td><td align="center">Muito Insatisfeito</td><td align="center">Insatisfeito</td><td align="center">Sem Opini�o</td><td align="center">Satisfeito</td><td align="center">Muito Satisfeito
</td></tr>
<tr><td>Posi��o da Impress�es e solu��es face � concorr�ncia</td><td align="center"><?php lfdx("5010",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("5010",$inq,$vinq,"2",""); ?></td><td align="center"> <?php lfdx("5010",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("5010",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("5010",$inq,$vinq,"5",""); ?>
</td></tr>
<tr><td>Diversidade da gama de produtos/servi�os: </td><td align="center"><?php lfdx("5020",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("5020",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("5020",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("5020",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("5020",$inq,$vinq,"5",""); ?>
</td></tr>
</table>



<?php 
} else { // se n�o mostra a p�gina ... passa todos os campos como hidden
lfdh("5010",$vinq);
lfdh("5020",$vinq);
}

?>

<!-- PAGINA 5 -->
<?php 
if ( $pag == "5" || $pag == "99" ) { 
?>
<br>

<table border =1 width ="<?php echo $lq?>">
<tr><td>

<br><br/><big><strong>&nbsp;&nbsp;&nbsp;Sugeria a Impress�es e Solu��es? </strong></big><br>Sim<?php lfdx("6030",$inq,$vinq,"SIM",""); ?> | N�o<?php lfdx("6030",$inq,$vinq,"NAO",""); ?>

<br><br><br><big>Indique porque escolheu a <strong>IMPRESS�ES & SOLU��ES </strong> para os seus servi�os </big>:<br>
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3010",$inq,$vinq,"SIM",""); ?> Localiza��o
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3020",$inq,$vinq,"SIM",""); ?> Pre�o
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3030",$inq,$vinq,"SIM",""); ?> Qualidade do servi�o
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3040",$inq,$vinq,"SIM",""); ?> Atitude da empresa
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3050",$inq,$vinq,"SIM",""); ?> Confian�a na organiza��o
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3060",$inq,$vinq,"SIM",""); ?> Prazo da execu��o
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3070",$inq,$vinq,"SIM",""); ?> Outros
</p>
</p><p class="p3">
<br><strong><big>Reclama��es e Sugest�es de melhoria dos nossos produtos/servi�os:</strong></big>
<br>&nbsp;&nbsp;&nbsp;<br><?php lfdx("9090",$inq,$vinq,"",""); ?>
<br><br><strong><big>Ou em:</strong></big>
<br>www.impressoesesolucoes.com / geral@impressoesesolucoes.com
</p>

</td></tr>
</table>

<?php 
} else { // se n�o mostra a p�gina ... passa todos os campos como hidden
lfdh("6030",$vinq);

lfdh("3010",$vinq);
lfdh("3020",$vinq);
lfdh("3030",$vinq);
lfdh("3040",$vinq);
lfdh("3050",$vinq);
lfdh("3060",$vinq);
lfdh("3070",$vinq);

lfdh("9090",$vinq);
}

/*
.........................................
n�o estamos a usar ....
if ( $cod_sta == "ENC" ) $xche = "CHECKED"; else $xche = "";  // se esta op��o estiver 
 			printf("<br><br>Se concluiu a introdu��o dos seus dados, por favor assinale aqui <input type=\"checkbox\" name=\"cod_sta\" value=\"%s\" class=\"sel2\" %s>(<b>inqu�rito conclu�do</b>) %c ", "ENC", $xche, $xtab );
*/

echo '<table border =0 width ="'. $lq . '">
    <tr><td>
    <p align="right"> p�gina:'.$pag.' / total: '. $pagtot . 
	'</p><p align="center">';

if( $pag > 1 ) { // permite andar para a anterior
 printf("<input type=\"button\" value=\" ��� P�gina anterior\" onclick=\"javascript:PagAnt(this.form)\">&nbsp;");
}
 if( $pag < $pagtot ) { // permite andar para a seguinte printf("kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk"); echo '<input name="submit" id="submit" value="Submit" onClick="PagSeg(this.form);">';// echo '<hr>...<hr>';
 printf("<input type=\"button\" value=\"P�gina seguinte ��� \" onclick=\"return PagSeg(this.form)\">&nbsp;");// echo '--- <input name="submit" id="submit" value="submit" onclick="return PagSeg(this.form);">'; 

 }
 if( $pag == $pagtot ) { // permite registar
 printf("<input type=\"button\" value=\"Submeter Inqu�rito\" onclick=\"javascript:PagFin(this.form)\">&nbsp;");
 }
 
 echo '</p>	</td></tr>
	</table> 
	<hr />';
if ( $ximp != "IMP"  ) {  // se n�o for impress�o mostra AS NOTAS a text area
	?>
	<div align="left">
                 Notas:<br> 1. Os dados introduzidos s� ser�o aceites depois de premir o bot�o <b><u>"Submeter Inqu�rito"</u></b>
						<br>2. Este inqu�rito ficar� dispon�vel on-line, podendo ser consultado/impresso/alterado, durante o per�odo de consulta.
		<br>
		<br>
			<i>A Impress�es e Solu��es agradece a sua colabora��o</i>
	</div>
	<?php
	} else  {
	  printf("<br /><input type=\"button\" value=\"Imprimir\" onclick=\"javascript:printpage()\"><br />&nbsp; ");
	}
 
	if ( strlen($dat) == 0) $dat = $hoje . ' ' . $agora;
	printf("<input style=\"text-align:left\" type=\"text\" name=\"dat\" size=\"18\" value=\"%s\" class=\"sel2\" READONLY>%c",$dat,$xtab);
 
	   printf(" <input type=\"hidden\" name=\"pagref\" value=\"%s\">",$pagref);
	   printf(" <input type=\"hidden\" name=\"pagtot\" value=\"%s\">",$pagtot);
	   printf(" <input type=\"hidden\" name=\"ref_mov\" value=\"%s\">",$ref_mov);

  	printf(" </form>");
	
}	else {
          if ( strlen($werr) > 0 ) {
			    printf("<b>Avisos:</b>%s",$werr); // imprime erros de aviso, caso haja
            }
			printf("<p class=\"sel4\"> >>> <a href=\"inq.php?tip_mov=%s\"><b>CONTINUAR</b></a></span>","SUP");
 
   }


?>


<br> [ <a href="/index.php" class="sel4">Sair</a> ]

</div>

 <?php
 //                                                                              ###############             Rodap�               #################
 // include ('xxxxm2.inc');
 // mun101m2("xxxxxxx.php");
 // printf("%s",$tip_mov);

printf("<div class=sel3a><br>Em caso de d�vidas no preenchimento do presente inqu�rito contactar:");
printf("<br>Impress�es e Solu��es, Lda");
printf("<br>");
printf("<br>E-mail: geral@impressoesesolucoes.com");
printf("<br>Tel: +351 239 70 11 88");
printf("</div>");
//aqui est� a faltar um argumento


//p�r aqui o id_inq a 1


selinqs($email,$id_inq); // mostra, caso existam aneoxos e possibilidade de novo
/* *****************************
TESTAR: 			http://www.cinove.com/pro/inq/inqext01fi.php?xmov=NUP&xent=M3360&sido=MUNPCV
*****************************  */
 ?>
 <div class="sel5">
 <hr>
 <br>- (c)Impress�es e Solu��es,Lda [INQ-2012]
 </div>
  </body>

 </html>
</body></html>