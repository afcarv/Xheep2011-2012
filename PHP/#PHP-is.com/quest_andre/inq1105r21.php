<?php
session_start();

$xent = $_REQUEST["xent"]; 
$xusi = $_REQUEST["xent"]; // fica o xent no usi
$sido = $_REQUEST["sido"]; 
$xmov = $_REQUEST["xmov"]; 
$ximp = $_REQUEST["ximp"];  // apenas indica que o movimento é de impressão ... bloqueia o botão submeter e altera o ouput de alguns tipos de dados , redio botão e textarea
$limpa= $_REQUEST["limpa"];  // a variável limpa = 1 , permite alterar i status, deixando de estar ENC(encerrado) e permitindo voltar ao normal para alteração
$xidinq = $_REQUEST["xidinq"]; 
$xtiplis= $_REQUEST["xtiplis"]; // variável para controlar se aparece o cabeçalho de ordenação por nome

// NOTAS; trocar inq1105fimxx (xx -mês)(+-95..) inq1105xx (xx)(+-58...) mês..., na linha 577=> $mes = "JULHO";
// alteração de mês +/- lins 323 566
// printf("[===========> %s | %s |  %s | %s ]",$xent,$xusi,$sido,$xmov);

if (strlen($xidinq) == 0) $xidinq = 0;  // se não a aparece fica a zero !!!!
$xtipe = substr($xent,0,1);
$xtipu = substr($sido,0,2);

if ($sido == 'AFCARVALHO' || $sido == 'FMCARVALHO'  || $sido == 'MJLOPES' || $sido == 'ASALVATERRA' ||  $sido == 'JCAEIRO' ||  $sido == 'SFONSECA' || $sido == 'AFERNANDES' || $sido == 'JMACEDO' ) {
			$xusi = $xent = "ANMP";       
            $xoper = "GER";
          } else { // não acedo
            printf("By....%s",$ido);
			exit;
           }			
 

if ( $xusi == "ANMP" ) { // NUP aquando da entrada ................
		// ferra-lhe com os dados
		$_SESSION['sid_usi'] = $xusi;
		$_SESSION['sid_ido'] = $sido;
		$_SESSION['sid_ace'] = 300;
		$_SESSION['sid_ent'] = $xent;
    }
  include('../us/acw1.php');	// .... ....
  $liga=mysql_connect($xho,$xus,$xpw);
  if ( !$liga ) {
	prinf("Problema [mun101DB]!!!");
	printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
}

// verificação do acesso
// include('../us/assoc05.php');

 	if (isset($_SESSION["sid_usi"])) $usi = $_SESSION["sid_usi"];
 	 		else { echo "Acesso não autorizado E01";
 	 				exit -1;
 	 			}
 	if (isset($_SESSION["sid_ido"])) $ido = $sido = $_SESSION["sid_ido"];
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
			$idtab = 'munp4.inq1105';
			$idbas = 'munp4';
			// $eid =  $usi;       // a chave de entrada é o código de utilizador ....ie. MUNXXX
			$xent =  $ident;       // a chave de entrada é o código de entidade, em alguns inquériots pode ser o utilizador(udi) ....
	$tip_mov = $_REQUEST["tip_mov"];
	include('arr1105.php');	// FAZ SEMPRE !!!! a Definição dos arrais para os registos....
	
	$arsel = array();  
	$arsel =  $_REQUEST["arsel"];
	$xsel =  $_REQUEST["xsel"];
	$xo =  $_REQUEST["xo"];
	$xtab=10;
	
// funções locais

// SELMUN
 function selent($cod,&$nom,&$dis) {
    $sqls="select * from munp1.entidade where cod ='$cod'";
	$ress=mysql_db_query("munp4",$sqls); //
		if ($ress) {
				$regs=mysql_fetch_array($ress);
				if ( $regs ) {
						$nom  = $regs["nom"];
						$cod_1 = $regs["cod_1"];
						$num_freg = $regs["num_freg"];
						$num_habit = $regs["num_habit"];
						$dis = substr($cod_1,0,2);
					return 1;
				}
					else return 0;
		   }
// printf("vai sair 0");
return 0;
}
// contax(array de busca, início do intevalo, fim do intervalo)
function contax($ix,$vx,$xi,$xf,$noment) {
		$ok=$cox=0;
		// echo "==INI == $xi,$xf ====";
		/* percorre o array vx: 
		se aparece o xi, liga o statutus ok
		se o status está ok e a há conteúdo incrementa o contador cox
		se aparece o fim, sai ...
		*/
		foreach ($ix as $itix => $itlisx) {  // usa o inqx por poder trabalhar resumo de vários items 
			if ( $itix == $xi ) $ok = 1 ;
				 if ( $ok == 1 && strlen($vx[$itix]) > 0) $cox++;
				    // echo "[$noment==INI == $xi,$xf ==$cox=  =]";
					if ( $itix == $xf ) return $cox;
		}
 // printf("vai sair 0");
return $cox;
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

//  ################################################################################
// Definições para o HTML ....
 ?>

<html><head>
<title> INQUÉRITO 1105-2011</title>
<?php
include("inqlayout.css");
?>
</head>

<body>

<?php
$hoje=date('Y-m-d',time());
$agora=date('H:i',time());

// preparativos
// se for tudo 1 ou tudo zeros imprime o nome e o e-mail do artista !!!!

	if( strlen($xsel) == 0) $xsel=0;

	if ( $xsel == 1 ) {  // passa tudo a 1
	foreach ( $inq as $iti => $itlis) {
				$arsel[$iti] = 1;
	 } 
	}
	
	if ( $xsel == 0 ) {  // passa tudo a 0
	foreach ( $inq as $iti => $itlis) {
				$arsel[$iti] = 0;
	 } 
	}

// 	################################ Cabeçalho #####################
		// printf("<b>início do dito !!!!! mov=%s</b>",$tip_mov);

					printf("<div align=\"center\">");
					printf("<table width=780 bgcolor=#ffffff>");
					printf("<tr><td width=15%% valign=top bgcolor=\"ffffff\">");
					printf("<IMG SRC=\"/images/anmp/logo/ANMPL0.gif\" ALT=\"ANMP\"  border=0>");
					// printf("<br>[$tip_mov|$usi] ");

					printf("</td><td>");
					printf("<div class=\"sel3a\" align=\"center\">INQUÉRITO: ENERGIA | 05-2011");
            printf("</td></TR></TABLE>");
			
			// printf("<table border=1><tr><td valign=top>Dist|RA</td><td valign=top>Município</td>");	 
			printf("<table border=1><tr>");	 
			if ( $xtiplis != "0")		printf("<td valign=top>Município</td>");
				else 	printf("<td valign=top><a href=\"http://www.anmp.pt/anmp/pro/inq/inq1105r21.php?xsel=0&sido=%s&xo=%s&xtiplis=0\">%s</a></td>",$sido,"NOME","Município");
				foreach ($inqx as $iti => $itlis) {  // usa o inqx por poder trabalhar resumo de vários items 
					if ( $arsel[$iti] == 1 ) {
				
					if ( strlen($itlis[0] ) > 0 ) printf("<td valign=top>%s</td>", $itlis[0]); // se o elemento 0 está preechido (resumo) coloca-o, se não vai o 1
						else printf("<td valign=top>%s</td>", $itlis[1]);
			 	 }
				}
			if ( $xsel == 0 || $xsel == 1  ) {	
			printf("<td valign=top>%s</td>", "nome");
			printf("<td valign=top>%s</td>", "Contacto");
			printf("<td valign=top>%s</td>", "email");
			printf("<td valign=top><a href=\"http://www.anmp.pt/anmp/pro/inq/inq1105r21.php?xsel=0&sido=%s&xo=%s&xtiplis=0\">%s</a></td>",$sido,"DATA","data");
			}
 
		printf("<td valign=top>%s</td>", "+inf");
		printf("</tr>");

			if ( $xo == "DATA") $xord = ' data DESC'; else $xord = ' nommun';
			
			
	   $sql="select  i.cod_ent,i.dados,i.nom AS nome,i.func,i.email,i.dat AS data,i.cod_sta,e.nom AS nommun from $idtab AS i LEFT JOIN munp1.entidade AS e ON (i.cod_ent=e.cod) ORDER BY $xord ";       //        "  where cod_ent = '$xent' ";

			// printf("%s",$sql);

		$numreg = 0;

	 	$result=mysql_db_query($idbas,$sql);
 		if ($result) {
			while( $regis=mysql_fetch_array($result)) {
			// funçao de seleccção
			// funçao de seleccção
			$cod_ent = $regis[0]; 
			$dados = $regis[1];
			$nom = $regis[2];
			$func = $regis[3];
			$email = $regis[4];
			$dat = $regis[5];
			$sta = $regis[6]; // foi preciso localizar a entrada no array porque ha dois cod_sta (no inquérito e na entidade)

			$n = 1;
			$vinq = unserialize($dados);
		$dis="";
		$k = selent($cod_ent,$noment,$dis);
		// $cod_ent ou $dis	
		 printf("<tr><td>%s</td>",$noment);
		 // printf("Recebido inq%s", count($inq));
				foreach ( $inqx as $iti => $itlis) {
				 if ( $arsel[$iti] == 1)  { // é 1 vai para imprimir !!!
					// se é um elemento do tipo resumo faz o rEsumo(INQX[][4]==RESUMO); senão faz o processo normal ....
					if ( $inqx[$iti][4] == "RESUMO") {
					$ni=contax($inq,$vinq,$inqx[$iti][2],$inqx[$iti][3],$noment); // vai ver se, neste intervalo (i1=$inqx[$iti][2],i2=$inqx[$iti][3], há algum valor significativo
					if ( $ni > 0 ) printf("<td>%s</td>", "SIM"); else printf("<td>&nbsp;</td>"); // se aconteceu alguma coisa, ni > 0 imprime SIM; senão fica em branco ....
					} else {
					  if ( strlen($vinq[$iti] ) == 0) printf("<td>&nbsp;</td>");	
					   else {
						if ( $inq[$iti][2] == "O") { // Se for campo de observações ... mete-lhe os breaks
						$brx = "\n";
						$x = str_replace($brx,"<br>", $vinq[$iti]);
						 printf("<td>%s</td>", $x ); 
					}
					else printf("<td>%s</td>", $vinq[$iti]);  // por defeito sai o valor
				 }
				 }
				 
			   }	 
			 }	
			 
			 if ( $xsel == 0 || $xsel == 1  ) {	// dados gerais
			printf("<td>%s</td>", $nom);
			printf("<td>%s</td>", $func);
			 printf("<td>%s</td>", $email);
			 printf("<td>%s</td>", $dat);
		 }
		 // link para o detalhe 
		 printf("<td><a href=\"inq1105fi.php?xent=%s&sido=%s%s&xmov=%s&ximp=%s\" target=\"_blank\">»»»</a>",$cod_ent,"MUN", $ido,"NUP","IMP");
		 printf("</td>");
		 
		printf("</tr>");
      
		$numreg++;      
			
		 }
		}

		printf("</table>");

		printf("<div align=left> | %s respostas",$numreg);	 

		
		printf("<hr>"); // se existir, usa o array descit

/*   ********** NAO IMPRIME O RESUMO 
		
		  for ( $i=0; $i < count($inq); $i++ ) {
			
				if( strlen($inq[$i][7]) > 0 ) {
				 	printf("|%s-%s<br>", $inq[$i][0],$inq[$i][7]); // descrição alternativa
				}			
				else {
				 printf("|%s-%s<br>", $inq[$i][0],$inq[$i][1]);
			 	}			
		   }
*/	

// http://www.anmp.pt/anmp/pro/inq/inq1105fi.php?xent=M4000&sido=MUMJLOPES&xmov=NUP&ximp=IMP  permite ir buscar, o registi de um município ....


 ?>
 
<hr>
<?php if ( $ximp != "Imprimir") { ?>
	[ <a href="http://www.anmp.pt/anmp/pro/inq/inq1105r21.php?xsel=1&sido=<?php echo $sido?>&xo=<?php echo $xo ?>&xtiplis=0">Tudo</a> |
    <a href="http://www.anmp.pt/anmp/pro/inq/inq1105r21.php?xsel=0&sido=<?php echo $sido?>&xo=<?php echo $xo ?>&xtiplis=0">Limpar</a> ]

	<form name="frm2" method="POST" action="inq1105r21.php" class="sel2">
	<br>Seleccione as questões e prima o botão <input type="submit" name="ximp" value="Imprimir" /> <input type="submit" name="ximp" value="Listar" />
	<table><tr><td>
		<?php
			// printf("<input type=\"hidden\" name=\"ximp\" value=\"%s\">","IMP");
			if( $xo == "DATA" ) $xo2="CHECKED"; else  $xo1="CHECKED"; 
		        printf("Ordenado por  Nome:<input type=\"radio\" name=\"xo\" value=\"%s\" %s >", "NOME", $xo1);
				printf(" | Data:<input type=\"radio\" name=\"xo\" value=\"%s\" %s >", "DATA" , $xo2);

				$kn=0;
				$ki = count($inq);
				foreach ( $inqx as $iti => $itlis) {
				/* o inqx é a vcersão base do inq + ositems resumo que sejam necessários para acumulação de dados ...*/
				$kn++;
				if ( $xsel == 1 || $arsel[$iti] == 1) $xche = "CHECKED"; else $xche = "";
				printf("<br> %s - <input type=\"checkbox\" name=\"arsel[$iti]\" value=\"%s\" %s>%s%c", $iti, "1", $xche,$inqx[$iti][1],$xtab );
				if ( $kn> $ki/3) {
					printf("</td><td>");
					$kn=0;
				}
		} 
	 ?>
	 
	 </td></tr></table>
	   <input type="hidden" name="xsel" value="2">  
	   <input type="hidden" name="sido" value="<?php echo $sido ?>" >  
	   	   
	 
	</form>

	<?php } ?>
	<!-- eset form apenas permite voltar à seleccção com os parâmetros seleccionados ...  -->
	<form name="frm2A" method="POST" action="inq1105r21.php" class="sel2">
	<input type="submit" name="ximp" value="voltar" />
	<input type="hidden" name="xo" value="<?php echo $xo; ?>" >
	<input type="hidden" name="xsel" value="2">  
	<input type="hidden" name="sido" value="<?php echo $sido; ?>" >  
	 	
	<?php
			$kn=0;
				$ki = count($inq);
				foreach ( $inqx as $iti => $itlis) {
				/* o inqx é a vcersão base do inq + ositems resumo que sejam necessários para acumulação de dados ...*/
				$kn++;
				printf("<input type=\"hidden\" name=\"arsel[$iti]\" value=\"%s\">", $arsel[$iti]);
				} 
	 ?>
	 
	</form>

	
<div class="sel5">
 <hr>
 <br> -  (c)ANMP/TI [2011] 
 </div>
  </body>

 </html>
</body></html>