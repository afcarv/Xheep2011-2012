<?php
session_start();

// os par�metros x... s�o passados em modo post ao chamar o programa
$email =  $_REQUEST["email"]; 
// $id_inq =  $_REQUEST["id_inq"]; 
// if (strlen($id_inq) == 0) $id_inq = 0;  // se n�o a aparece fica a zero !!!!

$id_inq = "1"; //inquerito 1, mas tambem pode ser chamado com o id_inq

// a chave do inquerito vai ser o e-mail
if (strlen($email) > 0 ){ // se entra como par�metro , � posto na sess�o
	$_SESSION['email'] = $email;
	} else if (isset($_SESSION["email"])) { $email = $_SESSION["email"];
			} else { 
			die('Pedimos desculpa mas o mail '.$email.'<br /> n�o � v�lido');
			} 

// ao re-chamar o programa, deve faz�-lo com um tipo de movimento (IN,UPD,SEL)		
$tip_mov = $_REQUEST["tip_mov"];

// ########################################################################
// OK chegou aqui avan�a para o programa
// Defini��es GLOBAIS

		// include('acw1.php');	// .... ....
		// ou 
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
		
		
	include('arrext01.php');	// FAZ SEMPRE !!!! a Defini��o dos arrais para os registos....
	include("inqlayout.css");  // defini��es de layout

	// $xtab= 10;
	$xtab= '\n';
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
			printf("<p class=\"sel4\"> >>> <a href=\"inqext01fi.php?tip_mov=%s&id=%s\"><b>Rever Inqu�rito</b></a>  |     <a href=\"inqext01fi.php?tip_mov=%s&id=%s&ximp=%s\"><b>Imprimir</b></a> </a></p>","SUP",$id,"SUP",$id,"IMP");
			}
	}
}

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

// LFDX .... formata o c�digo de input para o form
function lfdx ($iti,$inq,$vinq,$che,$def) {
global $ron;
/*
- o iti � a chave do campo para fazer o input
- essa chave � que vai localizar no inq e no vinq o elemento para o INPUT, mas:
	+ se o che tiver um valor, ser� usado nos campo do tipo Radio e checkbox, para a valida��o de checked e para �value=...�
- usa uma vari�vel gloval ron que se estiver READONLY impede a altera��o
*/

       if ( $inq[$iti][2] == "T" ) { 
	   // input text....								// TEXTO
            printf("<input style=\"text-align:left\" type=\"text\" name=\"vinq[$iti]\" size=\"%s\" value=\"%s\" class=\"sel2\">%s %c",$inq[$iti][3],$vinq[$iti],$inq[$iti][6],$xatb);
	  } else if ( $inq[$iti][2] == "D" ) { 
	  // input data 									// DATA
				$xli=10; // tamanho; por defeito � 10
				if (strlen($vinq[$iti]) == 0 && $tip_mov == "IN" ) { // se for nulo p�e a data de hoje  se o arg D se H p�e dat e hora
							if ( $inq[$iti][3] == 'D') { $vinq[$iti] = $hoje; $xli=10;}
								else if ( $inq[$iti][3] == 'H') { $vinq[$iti] = $hoje . ' ' . $agora; $xli=15;}
					}			
         printf("<input style=\"text-align:left\" type=\"text\" name=\"vinq[$iti]\" size=\"%s\" value=\"%s\" class=\"sel2\">%s %c",$xli,$vinq[$iti],$inq[$iti][6],$xatb);
	  } else if ( $inq[$iti][2] == "N" ) { 
	  // input N�mero 									// NUMERO
			if (strlen($vinq[$iti]) == 0 ) { // n�mero de decimais ....
							if ( $inq[$iti][4] == '0') $vinq[$iti] = '0';
								else if ( $inq[$iti][4] == '1') $vinq[$iti] = '00,0';
									else if ( $inq[$iti][4] == '2' || $inq[$iti][4] == '%'  ) $vinq[$iti] = '00,00';
										else if ( $inq[$iti][4] == '3') $vinq[$iti] = '00,000';
											else $vinq[$iti] = '0';
						}
				printf("<input style=\"text-align:right\" type=\"text\" name=\"vinq[$iti]\" size=\"%s\" value=\"%s\" class=\"sel2\" $ron> %s %c",$inq[$iti][3],number_format($vinq[$iti], $inq[$iti][4], '.', ' '),$inq[$iti][6],$xatb);
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
<title>INQU�RITO: ..., Inq:1-2012</title>
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

var ncan	= can.value;
var napr	= apr.value;

	if ( ncan > 0 ) {
			if ( Number(napr) >  Number(ncan) ) {
			    alert("Erro: O n�mero de candidaturas apresentadas \n tem de ser igual ou superior ao n�mero de candidaturas  aprovadas. \n Corrija este dado e prima novamente o bot�o Submeter" );
					can.focus();
					return;
				}
   }
	document.frm2.submit();
}

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
					<tr><td><IMG SRC="/images/anmp/logo/ANMPL0.gif" ALT="ANMP"  border=0>
					</td><td>
					<div class="sel3a" align="center"><span class="sel3i"> CARACTERIZA��O: INQU�RITO AOS MUNIC�PIOS
					</td><td><IMG SRC="/images/stories/arq/2012/IPL.png" ALT="IPL"  border=0>
					</td></tr></table>
					<table width=900 bgcolor=#ffffff>
		'; // Cabe�alho!!!
		// fim da tabela 1
		if ($tip_mov != "IN" && $tip_mov != "UPD"  ) {  // nos casos de IM ou UPD n�o mostra as notas
					?>
					</span></div></td></tr>
					<tr><td colspan=2 class="sel3">
					<div class="sel3" align="justify">
					Os dados introduzidos s� ser�o aceites depois de <u>premir o bot�o Submeter Inqu�rito que se encontra no fim do formul�rio</u> 
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
										
					printf("[=====E06======> %s | %s |  %s | %s ]",$xent,$xmun);
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

if ( $erro == 0 ) {  // SE n�o h� erros impeditivos continua
   // ###### avan�a com INPUT UPDATE ETC... ###########
   // ... se n�o vai para o fim do if (ap�s o bloco SUP)...
   // #################
   // UPD
   
    $dat = $hoje . ' ' . $agora;
	$dat_sta = $hoje;
	   
  if ($tip_mov == "UPD") {
    // #################
    // FAZ O UPDATE ....
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
  if ( $tip_mov == "IN" ) {  // faz insert
    
  $dados=serialize($vinq); // serialize ....
  
 // #################
 // aqui entra O INSERT ....

 	$sql = " insert into $idtab  (cod_ent,id_inq, dados, cod_sta, dat_sta, dat, ido, nom, func, email) values ('$xent','$id_inq','$dados','$cod_sta','$dat_sta', '$dat', '$sido','$nom', '$func', '$email' ) ";
 	$result= mysql_db_query($idbas,$sql);
 	// echo mysql_error();
 	$regins=mysql_affected_rows();
   $ni = $regins;
 
  if ( $ni > 0 ) {
			printf("<p class=\"sel3i\">%s</p>","Inqu�rito inserido com sucesso");
			printf("<p class=\"sel3b\">%s</p>","<br><br> Para Rever/Alterar os dados recebidos, prima:");
   }
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
			$interval = $february->diff($january);

			// %a will output the total number of days.
			// echo $interval->format('%h total horas') ."<hr>";
			$k = $interval->format('%i');
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


echo " ...... $tip_mov <br>";
if ( $tip_mov == "NEW") $tip_mov = "IN";  // os novos passam aqui a IN ....
echo " ...... $tip_mov <br>";

//  FROM DE INPUT .... PRINCIPAL -->

if ( $tip_mov == "IN" || $tip_mov == "UPD" )  {
	 printf("<form name=\"frm2\" method=\"POST\" action=\"inqext01fi.php\" class=\"sel2\">");
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
	
<!--                                  ######################  CORPO DE INQU�RITO   ############################# -->


<p><strong>IDENTIFICA��O DO MUNICIPIO</strong></p>
	<p>EMPRESA ??<strong>  <?php  echo $xmun; ?> </strong>  </p>
	<p>Pessoa respons�vel pela resposta ao presente inqu�rito:
	<table border =0>
	<tr><td>Nome </td><td> <input style="text-align:left" type="text" name="nom" size="60" value="<?php echo $nom;?>" class="sel2"></td></tr>
	<tr><td>Email </td><td> <input style="text-align:left" type="text" name="email" size="60" value="<?php echo $email;?>" class="sel2" onChange="checkEmail(this.value)"></td></tr>
	<tr><td>Fun��o </td><td> <input style="text-align:left" type="text" name="func" size="16" value="<?php echo $func;?>" class="sel2">  <!-- est� a usar o campo da fun��o !!!   --></td></tr>
</tr></table>	
	</p>

	</td></tr><tr><td BGCOLOR="cacaca" colspan=2 align="CENTER">
	<p &nbsp;</p>
	</td></tr>
	<tr><td BGCOLOR="FFFFFF" colspan=2 class="sel3">
	<p class="p3">
<strong>1. DADOS GERAIS</strong>	
<br/>&nbsp;&nbsp;  Popula��o: <?php lfdx("1010",$inq,$vinq,"","");?>
<br/>&nbsp;&nbsp;  N� de colaboradores: <?php lfdx("1020",$inq,$vinq,"","");?>ha
<br/>&nbsp;&nbsp;  N� de Computadores: <?php lfdx("1030",$inq,$vinq,"","");?>
</p>
<p class="p3">
<strong>As cobertura comunica��es - Como classifica o n�vel qualidade?</strong>
<br/>&nbsp;&nbsp;&nbsp;	Muito Bom: <?php lfdx("2010",$inq,$vinq,"MB",""); ?>
<br/>&nbsp;&nbsp;&nbsp;	Bom: <?php lfdx("2010",$inq,$vinq,"BOM",""); ?>
<br/>&nbsp;&nbsp;&nbsp;	Mau: <?php lfdx("2010",$inq,$vinq,"MAU",""); ?>
</p><p class="p3">

<strong>Infraestruturas</strong>
<br/>&nbsp;&nbsp;&nbsp;	Fibra Optica : SIM<?php lfdx("2020",$inq,$vinq,"SIM",""); ?> | N�O<?php lfdx("2020",$inq,$vinq,"NAO",""); ?>
<br/>&nbsp;&nbsp;&nbsp;	Cabo : SIM<?php lfdx("2030",$inq,$vinq,"SIM",""); ?> | N�O<?php lfdx("2030",$inq,$vinq,"NAO",""); ?>
<br/>&nbsp;&nbsp;  Outros meios: <?php lfdx("2040",$inq,$vinq,"","");?>(RF; FH; ...)
</p><p class="p3">
<strong>Quais os sistemas usados:</strong>
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3010",$inq,$vinq,"SIM",""); ?> Sitema operativo Windows
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3020",$inq,$vinq,"SIM",""); ?> Microsoft Office
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3030",$inq,$vinq,"SIM",""); ?> Open Office
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3040",$inq,$vinq,"SIM",""); ?> Linux
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3050",$inq,$vinq,"SIM",""); ?> Apple OS
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3060",$inq,$vinq,"SIM",""); ?> Joomla
<br/>&nbsp;&nbsp;&nbsp;		<?php lfdx("3070",$inq,$vinq,"SIM",""); ?> Oracle
</p>
</p><p class="p3">
<br/>&nbsp;&nbsp;&nbsp;		OBSERVA��ES:<br /><?php lfdx("9090",$inq,$vinq,"",""); ?>
</p>

	
<!--
.........................................................................................
n�o estamos a usar ....
if ( $cod_sta == "ENC" ) $xche = "CHECKED"; else $xche = "";  // se esta op��o estiver 
 			printf("<br><br>Se concluiu a introdu��o dos seus dados, por favor assinale aqui <input type=\"checkbox\" name=\"cod_sta\" value=\"%s\" class=\"sel2\" %s>(<b>inqu�rito conclu�do</b>) %c ", "ENC", $xche, $xtab );
-->
  
 <table  width=800 border=0 >   
	<tr bgcolor="ffffff">
	
<?php

//                                                                         ###############             Submeter Inqu�rito               #################
	if ( $ximp != "IMP"  ) {  // se n�o for impress�o mostra AS NOTAS a text area
			printf("<td ALIGN=CENTER bgcolor=\"caca33\">&nbsp;<br /> <input type=\"button\" value=\"Submeter Inqu�rito\" onclick=\"javascript:ValidaReg(this.form)\"><br />&nbsp;</td></tr>");

	?>
	</TD></TR>
	<td align="left">
                 Notas:<br> 1. Os dados introduzidos s� ser�o aceites depois de premir o bot�o <b><u>Submeter Inqu�rito</u></b>
						<br>2. Pode preencher o inqu�rito por fases.  Para salvaguardar a informa��o j� registada,  prima o bot�o <b><u>Submeter Inqu�rito</u></b>, ap�s o que, poder� continuar a introdu��o/altera��o dos dados.
						<br>3. Se prolongar o tempo de introdu��o dos dados al�m de 30 minutos, prima o bot�o <b><u>Submeter Inqu�rito</u></b>,  ap�s o que, poder� continuar a introdu��o.
						<br>4. Este inqu�rito ficar� dispon�vel on-line, podendo ser consultado/impresso/alterado, durante o per�odo de consulta.
		<br>
		<br>
			<i>A ANMP agradece a sua colabora��o</i>

	<?php
	} else  {
	  printf("<td ALIGN=CENTER> &nbsp;<br /><input type=\"button\" value=\"Imprimir\" onclick=\"javascript:printpage()\"><br />&nbsp; </td></tr>");
	}
  
  
  printf("</span></div></td></tr></table>"); // fim da tabela 2.1

 
	if (strlen($dat) == 0) $dat = $hoje . ' ' . $agora;
	printf("<input style=\"text-align:left\" type=\"text\" name=\"dat\" size=\"18\" value=\"%s\" class=\"sel2\" READONLY>%c",$dat,$xatb);
 
	  
  	printf(" </form>");
	
}	else {
          if ( strlen($werr) > 0 ) {
			    printf("<b>Avisos:</b>%s",$werr); // imprime erros de aviso, caso haja
            }
			printf("<p class=\"sel4\"> >>> <a href=\"inqext01fi.php?tip_mov=%s\"><b>CONTINUAR</b></a></span>","SUP");
 
   }

printf("</span></div></td></tr></table>");  //     fim da tabela principal

?>

<br> [ <a href="/index.php" class="sel4">Sair</a> ]

</div>

 <?php
 //                                                                              ###############             Rodap�               #################
 // include ('xxxxm2.inc');
 // mun101m2("xxxxxxx.php");
 // printf("%s",$tip_mov);

printf("<div class=sel3a><br>Em caso de d�vidas no preenchimento do presente inqu�rito contactar:");
printf("<br>ANMP Coimbra | <br> DJUR da ANMP");
printf("<br>Dr. Lu�s Ramos");
printf("<br> Emails: lramos@anmp.pt");
printf("<br>TELEFONES: 239 40 44 34 ");
printf("</div>");

selinqs($xent); // mostra, caso existam aneoxos e possibilidade de novo

/* *****************************

TESTAR: 
			http://www.anmp.pt/anmp/pro/inq/inqext01fi.php?xmov=NUP&xent=M3360&sido=MUNPCV

*****************************  */

 ?>
 <div class="sel5">
 <hr>
 <br>- (c)ANMP/TI [INQ-1201/2012]
 </div>
  </body>

 </html>
</body></html>