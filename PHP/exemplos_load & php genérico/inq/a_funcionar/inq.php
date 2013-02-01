<?php
session_start();
// os parâmetros x... são passados em modo post ao chamar o programa
$email =  $_REQUEST["email"]; 
// $id_inq =  $_REQUEST["id_inq"]; 
// if (strlen($id_inq) == 0) $id_inq = 0;  // se não a aparece fica a zero !!!!
// controlo de páginas
$pagref = $_REQUEST["pagref"];
if ( strlen($pagref) == 0 ) $pagref=1;
$pag=$pagref;
$pagtot = 5;
$id_inq = "0"; //inquerito 1, mas tambem pode ser chamado com o id_inq




//###################################  AQUI




// a chave do inquerito vai ser o e-mail
if (strlen($email) > 0 ){ // se entra como parâmetro , é posto na sessão
	$_SESSION['email'] = $email;
	} else if (isset($_SESSION["email"])) { $email = $_SESSION["email"];
			} else { 
			die('Pedimos desculpa mas o e-mail '.$email.'<br /> não é válido');
			} 

			
			


			
			
// ao re-chamar o programa, deve fazê-lo com um tipo de movimento (IN,UPD,SEL)		
$tip_mov = $_REQUEST["tip_mov"];
$ref_mov = $_REQUEST["ref_mov"];

// ########################################################################
// OK chegou aqui avança para o programa
// Definições GLOBAIS

		// include('acw1.php');	// .... ....
		// ou 
		
		
		
		$xho = "localhost";
		$xus = "impresso_andre";
		$xpw = "Serv2011";
		
		$liga=mysql_connect($xho,$xus,$xpw);
		
		if ( !$liga ) {
			printf("Erro de ligação à base de dados!");
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
		
		
	include('arrext01.php');	// FAZ SEMPRE !!!! a Definição dos arrais para os registos....
	include("inqlayout.css");  // definições de layout
	
	//tentativa de fazer um insert à força
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
// funções locais


// SELINS
 function selinqs($email,$id_inq) {
	
	global $idtab;
	global $idbas;
    $sqls="SELECT * FROM $idtab WHERE email ='$email' AND id_inq ='$id_inq'";
	$ress=mysql_db_query($idbas,$sqls); //
		if ($ress) {
			while( $regs=mysql_fetch_array($ress)) {
			$id = $regs["id"]; 
			printf("<p class=\"sel4\"> >>> <a href=\"inq.php?tip_mov=%s&id=%s\"><b>Rever Inquérito</b></a>  |     <a href=\"inq.php?tip_mov=%s&id=%s&ximp=%s\"><b>Imprimir</b></a> </a></p>","SUP",$id,"SUP",$id,"IMP");
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
- o iti é a chave do campo para fazer o input
- essa chave é que vai localizar no inq e no vinq o elemento para o INPUT, mas:
*/
  printf("<input type=\"hidden\" name=\"vinq[$iti]\" value=\"%s\"> %c",$vinq[$iti],$xtab);
} 
// LFDX .... formata o código de input para o form
function lfdx ($iti,$inq,$vinq,$che,$def) {
global $ron;
global $xtab;
/*
- o iti é a chave do campo para fazer o input
- essa chave é que vai localizar no inq e no vinq o elemento para o INPUT, mas:
	+ se o che tiver um valor, será usado nos campo do tipo Radio e checkbox, para a validação de checked e para «value=...»
- usa uma variável gloval ron que se estiver READONLY impede a alteração
*/

       if ( $inq[$iti][2] == "T" ) { 
	   // input text....								// TEXTO
            printf("<input style=\"text-align:left\" type=\"text\" name=\"vinq[$iti]\" size=\"%s\" value=\"%s\" class=\"sel2\">%s %c",$inq[$iti][3],$vinq[$iti],$inq[$iti][6],$xtab);
			
			
			
	  } else if ( $inq[$iti][2] == "D" ) { 
	  // input data 									// DATA
				$xli=10; // tamanho; por defeito é 10
				if (strlen($vinq[$iti]) == 0 && $tip_mov == "IN" ) { // se for nulo põe a data de hoje  se o arg D se H põe dat e hora
							if ( $inq[$iti][3] == 'D') { $vinq[$iti] = $hoje; $xli=10;}
								else if ( $inq[$iti][3] == 'H') { $vinq[$iti] = $hoje . ' ' . $agora; $xli=15;}
					}			
         printf("<input style=\"text-align:left\" type=\"text\" name=\"vinq[$iti]\" size=\"%s\" value=\"%s\" class=\"sel2\">%s %c",$xli,$vinq[$iti],$inq[$iti][6],$xtab);
		 
		
		 
		 
	  } else if ( $inq[$iti][2] == "N" ) { 
	  // input Número 									// NUMERO
			if (strlen($vinq[$iti]) == 0 ) { // número de decimais ....
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
						if ( $vinq[$iti]== $xvalche ) $xche = "CHECKED"; else $xche = "";  // se esta opção estiver 
 			printf("%s<input type=\"checkbox\" name=\"vinq[$iti]\" value=\"%s\" %s>%s%c",$inq[$iti][4], $xvalche, $xche, $inq[$iti][6], $xtab );
		} else if ($inq[$iti][2] == "R" ) { // input radio.... 	// RADIO
				if ( strlen($che) > 0 ) $xvalche  = $che; else $xvalche = $inq[$iti][3];  // a variável che pode trazer o valor do radiom se não é o que está no array
				if ( $vinq[$iti]== $xvalche ) $xche = "CHECKED"; else $xche = "";  // se esta opção estiver 
				// o $inq[$i][4] permite fazer break ante do radio ...
			 	if ( $ximp != "IMP"  ||  $xche == "CHECKED" ) {  // se for só para impressão,  só mostra o seleccionado
				printf("%s<input type=\"radio\" name=\"vinq[$iti]\" value=\"%s\" %s >%c",$inq[$iti][4], $xvalche , $xche, $xtab);
				
				
			
				
				}
		printf("%s",$inq[$iti][6]); // fecha o item com <br>, etc	
		} else if ( $inq[$iti][2] == "O" ) { 
		// Quadro de observações ....					TEXTAREA
		
			if ( $ximp != "IMP"  ) {  // se não for impressão mostra a text area
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
	// Fim da função de imput dos campos	   

//  ################################################################################
// Definições para o HTML ....
 ?>

<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INQUÉRITO:Inq:1-2012</title>
</head>
<!-- estas funções javacript não estão a ser aqui usadas mas podem ser!!!   -->
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

var ncan = can.value;
var napr = apr.value;

	if ( ncan > 0 ) {
			if ( Number(napr) >  Number(ncan) ) {
			    alert("Erro: O número de candidaturas apresentadas \n tem de ser igual ou superior ao número de candidaturas  aprovadas. \n Corrija este dado e prima novamente o botão Submeter" );
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
// ----------------------------  FUNÇÕES JAVASCRIPT ANTIGAS



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

function PagSeg(formx) {//formx = formulário actual

var pagref = formx["pagref"];//vai buscar id do formulário ao objecto formx
var npag = pagref.value;//vai buscar número de página do formulário ao objecto formx

	npag++;

	
	pagref.value = npag;
	

	
	
	//até aqui tudo fino
	
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
// zona de cabeçalho ....
$hoje=date('Y-m-d',time());
$agora=date('H:i',time());
// printf("<b>início do dito !!!!! mov=%s</b>",$tip_mov);
echo '
					<div align="center">
					<table width=900 bgcolor=#ffffff>
					
					</td><td>
					
					<br>
					<br>
					</td><td><IMG SRC="/inq/cabecalho-final.jpg" ALT="IPL"  border=0>
					<br><br>
					<div class="sel3a" align="center"><span class="sel3i"> INQUÉRITO DE SATISFAÇÃO
					</td></tr></table>
					<table width=900 bgcolor=#ffffff>
		'; // Cabeçalho!!!
		// fim da tabela 1
		if ($tip_mov != "IN" && $tip_mov != "UPD"  ) {  // nos casos de IM ou UPD não mostra as notas
					?>
					</span></div></td></tr>
					<tr><td colspan=2 class="sel3">
					<div class="sel3" align="justify">
					
					<strong>Obrigado </strong>por responder ao nosso questionário de satisfação.
					<br>
					O questionário demora apenas 5 minutos do seu tempo
					<br>
					<br>

					<br>
					
					
					<!--
					<p><strong>Instruções de preenchimento</strong></p>
					<p>Numa fase em que o quadro legal relativo ao mercado energético está a sofrer significativas alterações e, sobretudo, numa fase em que se avizinha um excessivo aumento dos custos com energia elétrica para valores incomportáveis, pretende a ANMP perceber, de forma mais concreta, que medidas podem ser tomadas para reduzir a pesada fatura energética que os Municípios suportam mensalmente, sem contudo pôr em causa o conforto e a segurança dos munícipes.
					<p>A resposta desse Município ao presente inquérito será da máxima utilidade para a definição de uma estratégia de atuação neste domínio e para a discussão quer com o Governo com os fornecedores do serviço de fornecimento de energia eléctrica, particularmente com a EDP.
					<hr>
						-->	
					<?php
					}
                    // $k = selent($xent,$xmun,$xnumhab);
					$k=1; // este k é martelado !!!!!!!!... deve ser vaidados com e e-mail do cliente ou otro método
										
				//# comentado a 26/03/2012						
				//	printf("[=====E06======> %s | %s |  %s | %s ]",$xent,$xmun);
					if (  $k == 0 ) {
					 	// PROBLEMAS COM A IDENTIFICAÇÃO DA Entidade
						 	 				echo " Acesso não ajustado a este Inquérito - E07 [$ident| $xnom]";
					 	 				exit -1;
					 }
		

$erro = 0;
$xct2 = "";   // as (rotina 0211a) e (rotina 0211b) forçam a que se o campo 0211 estiver assinalado com S passe todos os anteriores a nulo....

/*												 VERIFICAÇÕES ANTES DE INSERT OU UPDATE
 											  (valida campos e caracteres especiais....)
											==============================================	
*/
if ($tip_mov == "IN" || $tip_mov == "UPD"  ) {  // SE insert ou update
	// data $vinq[$iti] = $hoje .'/' . $agora;  // data e hora
  	$werr ="";
	// excepões de erro
	foreach ($vinq as $iti => $valit) {
		if ( $inq[$iti][2] == "N" ) { //  Número »»»»»»
			$vinq[$iti] = str_replace(",",".",$vinq[$iti]);  // as virgulas por pontos .....no próprio array
			$vinq[$iti] = str_replace("%","",$vinq[$iti]);  // os sinais de %  por nada .....
			$vinq[$iti] = str_replace(" ","",$vinq[$iti]);  // os espaços por ada .....
			if (!is_numeric( $vinq[$iti] ) ) {
			// está a mostrar $inq[$iti][7]
				if ( $inq[$iti][4] == "%" ) $werr = "<hr><div class=sel3r  align=left>  - O valor " .  $vinq[$iti] .  " referente a (<b>" . $inq[$iti][1] . "</b>), é inválido. <b>Deve ser preenchido apenas com o valor de percentagem </b></div>"; // imprime erros de aviso, caso haja
					else
				$werr = "<hr><div class=sel3r align=left> - O valor " .  $vinq[$iti]  .  " referente a (<b>" . $inq[$iti][1] . "</b>), é inválido. <b>Deve ser preenchido apenas com o valor numérico </b></div>"; // imprime erros de aviso, caso haja				
				$vinq[$iti] = '0';
				$erro = 1;
			}
	    } else if ( $inq[$iti][2] == "T" ) { // Texto »»»»»
			$vinq[$iti] = str_replace("'","`",$vinq[$iti]);  // troca os apostrofes!!!
		}  else if ( $inq[$iti][2] == "D" && strlen($vinq[$iti]) > 0 ) { // data »»»»»»»»»
				$ndia = substr($vinq[$iti],8,2);
				$nmes = substr($vinq[$iti],5,2);
				$nano = substr($vinq[$iti],0,4);
				
				if( checkdate($nmes,$ndia,$nano) == false) {
				$erro = 1;
				$werr .= "<div class=sel3r  align=left><br> - As datas devem estar no formato <b>aaaa-mm-dd</b></div>";
				} 
			 } else if ( $inq[$iti][2] == "O" ) { // janela de observações »»»»»»»»
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
// Aqui podem ser colocadas Validações e outrs condições fora de IN ou UPD ###########
// #################

if ( $erro == 0 ) {  // SE não há erros impeditivos e atingiu a pag final, continua
   // ###### avança com INPUT UPDATE ETC... ###########
   // ... se não vai para o fim do if (após o bloco SUP)...
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
			printf("<p class=\"sel3i\">%s</p>","Inquérito actualizado com sucesso. ");
				printf("<p class=\"sel3a\">%s</p>  ","<br> Para Rever/Alterar os dados recebidos, prima:");
			}
    // torna o movomento em SEL e limpa o nome, refas e observ.
    $tip_mov = "SEL";
 	// limpa os campos ....
 	// funçao de limpeza
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
	
	//tentativa de preencher à força
	//$sql = " insert into $idtab  (id_inq, dados, cod_sta, dat_sta, dat, ido, nom, func, email) values ('5','','','', '', '','andre', '', 'andre@andre.pt' ) ";
 	//$result= mysql_db_query($idbas,$sql);
	
	
 	// echo mysql_error();
 	$regins=mysql_affected_rows();
	$ni = $regins;
 
 
	printf("valor do ni: ".$ni);
	
 
  if ( $ni > 0 ) {
			printf("<p class=\"sel3i\">%s</p>","Inquérito inserido com sucesso");
			printf("<p class=\"sel3b\">%s</p>","<br><br> Para Rever/Alterar os dados recebidos, prima:");
   }
   printf("Deu bode");
 	$tip_mov = "SEL";
 	// limpa os campos ....
    // $id=$reg=$it=$v1=$v2=$v3=$v4=$v5="";
 }

//  TESTA SEMPRE A EXISTÊNCIA sempre que o movimento é diferente de IN, UPD e SEL, passa a SUP (com a respetiva validação)
if ( $tip_mov != "IN" && $tip_mov != "UPD" && $tip_mov != "SUP" && $tip_mov != "SEL" ) $tip_mov = "SUP" ;

// ################# ##################################################################33333
// SUP
 if ( $tip_mov == "SUP" ) {  // Faz select para testar e existência de um registo, passnado-o a update,caso exista
  $n = 0;

	   $sql="select * from  $idtab  where email = '$email' AND id_inq = $id_inq ";
	 	$result=mysql_db_query($idbas,$sql);
 		if ($result) {
 			$regis=mysql_fetch_array($result);
		if ( $regis ) {
			 // funçao de seleccção
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
			
			if ( $cod_sta == "ENC" && $limpa != "1") {  // se está encerrado fica readonly e muda o status para IMp (apenas imprime)
			$ron = "READONLY";
			$ximp = "IMP"; 
			}
			else $ron = "";  
			/* ******** depois de encerrar o inquérito apenas é possível ver os dados, 
						importa estabelecer o processo de encerramento, por ação do operador ou automaticamento ap´s n dias
						*/
			}
		}

	if ( $n > 0) { $tip_mov = "UPD";
		printf("<p class=\"sel3\">%s</div>","Consulta/Actualização");
		// printf("<p class=\"sel3b\">%s</div>"," Depois de efectuar as alterações desejadas prima o botão [Gravar]");
	} else {
		$tip_mov = "IN";
	 	// printf("<p class=\"sel3b\">%s</div>","Responda ao Inquérito e prima o botão [Gravar] ...");
   }
   // fim da validação do SUP 
  }
 // fim do if erro=0
} else { // se há erro 
// mostra o erro !!!
	printf("<p class=\"sel3b\"><hr><b>ERROS:<br>%s</b><br>%s<hr></div>",$werr,"Faça as correcções e prima a o botão submeter ...");
}

//# três linhas abaixo (26/03/2012)
//echo " ...... $tip_mov <br>";
if ( $tip_mov == "NEW") $tip_mov = "IN";  // os novos passam aqui a IN ....
//echo " ...... $tip_mov <br>";

//  FROM DE INPUT .... PRINCIPAL -->

if ( $tip_mov == "IN" || $tip_mov == "UPD" )  {
	 printf("<form name=\"frm2\" method=\"POST\" action=\"inq.php\" class=\"sel2\">");
	 // o tip_mov é  hidden e apenas mostrado , não alterado
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
	
				a função lfdx("0101",$inq,$vinq,"SIM","Escreva a qui o seu nome") é evocada sempre que queremos inserir um campo de input. os parâmetros:
				0101 -> chave do campo, no array de definições $inq e no array de valores a passar para o form $vinq
				$inq-> array de definições 
				$vinq-> array de valores a passar para o form e a registar na base de dados
				["SIM|NAO|MUTO..."]-> são as constantes a fixar para o campos do tipo Radio ou Checkbox
				["Escreva a qui o seu nome"] -> pode ser usado para preecher, por defeito um capo, mas ainda não está a ser usado.
		
	*/
	// PARTICULARIDADE DO INQUÉRITO 1024 ... $vinq[] ... é martelado com os habitantes do município....
	// nq["0210"] = $xnumhab;
	$cor0="#009966";
	$cor1="#FFFFA8";
	$cor2="#FFCC66";
	$cor4="#fafafa";
	
	?>
	
<!--                                  ######################  CORPO DE INQUÉRITO   #############################    -->
	
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
Por favor classifique os itens no quadro abaixo seleccionando, com um clique do seu rato, a coluna correspondente à sua avaliação.
<br>
<strong><h1>Departamento Comercial</h1></strong>
<table border =1 width ="<?php echo $lq?>">
<tr><td> &nbsp;</td><td align="center">Muito Insatisfeito</td><td align="center">Insatisfeito</td><td align="center">Sem Opinião</td><td align="center">Satisfeito</td><td align="center">Muito Satisfeito
</td></tr>
<tr><td>Simpatia e disponibilidade no atendimento</td><td align="center"><?php lfdx("1010",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("1010",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("1010",$inq,$vinq,"3",""); ?>  </td><td align="center"><?php lfdx("1010",$inq,$vinq,"4",""); ?> </td><td align="center"><?php lfdx("1010",$inq,$vinq,"5","");?>
</td></tr>
<tr><td>Qualidade do serviço prestado:</td><td align="center"><?php lfdx("1020",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("1020",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("1020",$inq,$vinq,"3",""); ?> </td><td align="center"><?php lfdx("1020",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1020",$inq,$vinq,"5",""); ?>
</td></tr>

<tr><td>Tempo de resposta até obter orçamento</td><td align="center"><?php lfdx("1030",$inq,$vinq,"1",""); ?></td><td align="center"><?php lfdx("1030",$inq,$vinq,"2",""); ?></td><td align="center"><?php lfdx("1030",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("1030",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1030",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Cumprimento dos prazos de término do trabalho</td><td align="center"><?php lfdx("1040",$inq,$vinq,"1",""); ?></td><td align="center"><?php lfdx("1040",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("1040",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("1040",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1040",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Preocupações da empresa com a exequibilidade do trabalho<br /> nomeadamente pela proposta de alterações antes e durante a execução dos trabalhos</td><td align="center"><?php lfdx("1050",$inq,$vinq,"1",""); ?></td><td align="center"><?php lfdx("1050",$inq,$vinq,"2",""); ?></td><td align="center"> <?php lfdx("1050",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("1050",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1050",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Disponibilidade para resolução de problemas durante o trabalho</td><td align="center"><?php lfdx("1060",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("1060",$inq,$vinq,"2",""); ?></td><td align="center"><?php lfdx("1060",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("1060",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1060",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Apoio Pós Venda</td><td align="center"><?php lfdx("1070",$inq,$vinq,"1",""); ?></td><td align="center"><?php lfdx("1070",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("1070",$inq,$vinq,"3",""); ?> </td><td align="center"><?php lfdx("1070",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1070",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Condições do espaço físico no atendimento</td><td align="center"><?php lfdx("1080",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("1080",$inq,$vinq,"2",""); ?></td><td align="center"> <?php lfdx("1080",$inq,$vinq,"3",""); ?> </td><td align="center"><?php lfdx("1080",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1080",$inq,$vinq,"5",""); ?>

</td></tr>
<tr><td>Qualidade/preços</td><td align="center"><?php lfdx("1090",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("1090",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("1090",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("1090",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("1090",$inq,$vinq,"5",""); ?>
</td></tr>
</table>

<?php 
} else { // se não mostra a página ... passa todos os campos como hidden
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
<br><br><strong><h1>Departamento de desenvolvimento de serviço</h1></strong>	
<table border =1 width ="<?php echo $lq?>">
<tr><td> &nbsp;</td><td align="center">Muito Insatisfeito</td><td align="center">Insatisfeito</td><td align="center">Sem Opinião</td><td align="center">Satisfeito</td><td align="center">Muito Satisfeito
</td></tr>

</td></tr>
<tr><td>Simpatia e disponibilidade dos colaboradores</td><td align="center"><?php lfdx("2010",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2010",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2010",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2010",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2010",$inq,$vinq,"5",""); ?>
</td></tr>

</td></tr>
<tr><td>Qualidade do serviço prestado</td><td align="center"><?php lfdx("2020",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2020",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2020",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2020",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2020",$inq,$vinq,"5",""); ?>
</td></tr>

</td></tr>
<tr><td>Soluções oferecidas pelos nossos produtos</td><td align="center"><?php lfdx("2030",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2030",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2030",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2030",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2030",$inq,$vinq,"5",""); ?>
</td></tr>

</td></tr>
<tr><td>Responsabilidade dos nossos Serviços Técnicos</td><td align="center"><?php lfdx("2040",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2040",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2040",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2040",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2040",$inq,$vinq,"5",""); ?>
</td></tr>


</td></tr>
<tr><td>Tempo de resposta/execução dos nossos serviços Técnicos</td><td align="center"><?php lfdx("2050",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2050",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2050",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2050",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2050",$inq,$vinq,"5",""); ?>
</td></tr>

</td></tr>
<tr><td>Satisfação geral com os nossos serviços técnicos</td><td align="center"><?php lfdx("2060",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2060",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2060",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2060",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2060",$inq,$vinq,"5",""); ?>
</td></tr>

</td></tr>
<tr><td>Como classifica os materiais e equipamentos da empresa</td><td align="center"><?php lfdx("2070",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("2070",$inq,$vinq,"2",""); ?> </td><td align="center"><?php lfdx("2070",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("2070",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("2070",$inq,$vinq,"5",""); ?>
</td></tr>

</table>




<?php 
} else { // se não mostra a página ... passa todos os campos como hidden
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
<tr><td> &nbsp;</td><td align="center">Muito Insatisfeito</td><td align="center">Insatisfeito</td><td align="center">Sem Opinião</td><td align="center">Satisfeito</td><td align="center">Muito Satisfeito
</td></tr>
<tr><td>Informação técnica dos produtos/serviços fornecidos</td><td align="center"><?php lfdx("4010",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("4010",$inq,$vinq,"2",""); ?></td><td align="center"> <?php lfdx("4010",$inq,$vinq,"3",""); ?> </td><td align="center"><?php lfdx("4010",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("4010",$inq,$vinq,"5",""); ?>

 </td></tr>
<tr><td>Eficiência no tratamento de reclamações/sugestões: </td><td align="center"><?php lfdx("4020",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("4020",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("4020",$inq,$vinq,"3",""); ?> </td><td align="center"><?php lfdx("4020",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("4020",$inq,$vinq,"5",""); ?>
</td></tr>
</table>


<?php 
} else { // se não mostra a página ... passa todos os campos como hidden
lfdh("4010",$vinq);
lfdh("4020",$vinq);

}
?>


<!-- PAGINA 4 -->
<?php 
if ( $pag == "4" || $pag == "99" ) { 
?>
<br>



<br><br><strong><h1>Política Empresarial</h1></strong>	

<table border =1 width ="<?php echo $lq?>">
<tr><td> &nbsp;</td><td align="center">Muito Insatisfeito</td><td align="center">Insatisfeito</td><td align="center">Sem Opinião</td><td align="center">Satisfeito</td><td align="center">Muito Satisfeito
</td></tr>
<tr><td>Posição da Impressões e soluções face à concorrência</td><td align="center"><?php lfdx("5010",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("5010",$inq,$vinq,"2",""); ?></td><td align="center"> <?php lfdx("5010",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("5010",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("5010",$inq,$vinq,"5",""); ?>
</td></tr>
<tr><td>Diversidade da gama de produtos/serviços: </td><td align="center"><?php lfdx("5020",$inq,$vinq,"1",""); ?> </td><td align="center"><?php lfdx("5020",$inq,$vinq,"2",""); ?> </td><td align="center"> <?php lfdx("5020",$inq,$vinq,"3",""); ?></td><td align="center"><?php lfdx("5020",$inq,$vinq,"4",""); ?></td><td align="center"><?php lfdx("5020",$inq,$vinq,"5",""); ?>
</td></tr>
</table>



<?php 
} else { // se não mostra a página ... passa todos os campos como hidden
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

<br><br/><big><strong>&nbsp;&nbsp;&nbsp;Sugeria a Impressões e Soluções? </strong></big><br>Sim<?php lfdx("6030",$inq,$vinq,"SIM",""); ?> | Não<?php lfdx("6030",$inq,$vinq,"NAO",""); ?>

<br><br><br><big>Indique porque escolheu a <strong>IMPRESSÕES & SOLUÇÕES </strong> para os seus serviços </big>:<br>
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3010",$inq,$vinq,"SIM",""); ?> Localização
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3020",$inq,$vinq,"SIM",""); ?> Preço
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3030",$inq,$vinq,"SIM",""); ?> Qualidade do serviço
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3040",$inq,$vinq,"SIM",""); ?> Atitude da empresa
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3050",$inq,$vinq,"SIM",""); ?> Confiança na organização
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3060",$inq,$vinq,"SIM",""); ?> Prazo da execução
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3070",$inq,$vinq,"SIM",""); ?> Outros
</p>
</p><p class="p3">
<br><strong><big>Reclamações e Sugestões de melhoria dos nossos produtos/serviços:</strong></big>
<br>&nbsp;&nbsp;&nbsp;<br><?php lfdx("9090",$inq,$vinq,"",""); ?>
<br><br><strong><big>Ou em:</strong></big>
<br>www.impressoesesolucoes.com / geral@impressoesesolucoes.com
</p>

</td></tr>
</table>

<?php 
} else { // se não mostra a página ... passa todos os campos como hidden
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
não estamos a usar ....
if ( $cod_sta == "ENC" ) $xche = "CHECKED"; else $xche = "";  // se esta opção estiver 
 			printf("<br><br>Se concluiu a introdução dos seus dados, por favor assinale aqui <input type=\"checkbox\" name=\"cod_sta\" value=\"%s\" class=\"sel2\" %s>(<b>inquérito concluído</b>) %c ", "ENC", $xche, $xtab );
*/

echo '<table border =0 width ="'. $lq . '">
    <tr><td>
    <p align="right"> página:'.$pag.' / total: '. $pagtot . 
	'</p><p align="center">';

if( $pag > 1 ) { // permite andar para a anterior
 printf("<input type=\"button\" value=\" ««« Página anterior\" onclick=\"javascript:PagAnt(this.form)\">&nbsp;");
}
 if( $pag < $pagtot ) { // permite andar para a seguinte printf("kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk"); echo '<input name="submit" id="submit" value="Submit" onClick="PagSeg(this.form);">';// echo '<hr>...<hr>';
 printf("<input type=\"button\" value=\"Página seguinte »»» \" onclick=\"return PagSeg(this.form)\">&nbsp;");// echo '--- <input name="submit" id="submit" value="submit" onclick="return PagSeg(this.form);">'; 

 }
 if( $pag == $pagtot ) { // permite registar
 printf("<input type=\"button\" value=\"Submeter Inquérito\" onclick=\"javascript:PagFin(this.form)\">&nbsp;");
 }
 
 echo '</p>	</td></tr>
	</table> 
	<hr />';
if ( $ximp != "IMP"  ) {  // se não for impressão mostra AS NOTAS a text area
	?>
	<div align="left">
                 Notas:<br> 1. Os dados introduzidos só serão aceites depois de premir o botão <b><u>"Submeter Inquérito"</u></b>
						<br>2. Este inquérito ficará disponível on-line, podendo ser consultado/impresso/alterado, durante o período de consulta.
		<br>
		<br>
			<i>A Impressões e Soluções agradece a sua colaboração</i>
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
 //                                                                              ###############             Rodapé               #################
 // include ('xxxxm2.inc');
 // mun101m2("xxxxxxx.php");
 // printf("%s",$tip_mov);

printf("<div class=sel3a><br>Em caso de dúvidas no preenchimento do presente inquérito contactar:");
printf("<br>Impressões e Soluções, Lda");
printf("<br>");
printf("<br>E-mail: geral@impressoesesolucoes.com");
printf("<br>Tel: +351 239 70 11 88");
printf("</div>");
//aqui está a faltar um argumento


//pôr aqui o id_inq a 1


selinqs($email,$id_inq); // mostra, caso existam aneoxos e possibilidade de novo
/* *****************************
TESTAR: 			http://www.cinove.com/pro/inq/inqext01fi.php?xmov=NUP&xent=M3360&sido=MUNPCV
*****************************  */
 ?>
 <div class="sel5">
 <hr>
 <br>- (c)Impressões e Soluções,Lda [INQ-2012]
 </div>
  </body>

 </html>
</body></html>