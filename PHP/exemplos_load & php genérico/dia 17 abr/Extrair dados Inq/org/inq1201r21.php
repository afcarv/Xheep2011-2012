<?php
session_start();
// Idxentificação ....
// Validações prévias
	$sid_usi="";
 	$sid_idi="";
 	$sid_ido="";
 	$sid_ent="";
 	$usi="";
 	$idi="";
 	$ido="";
 	$ident="";
 	$urant = "/index.php"; // programa pai
 	$urform = "/anmp/pro/inq/inq1201r1.php"; // php recorrente

	include('../us/acw1.php');	// .... ....
  $liga=mysql_connect($xho,$xus,$xpw);
  if ( !$liga ) {
	prinf("Problema [mun101DB]!!!");
	printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
}

if (isset($_SESSION["sid_xacc"])) $xacc = $_SESSION["sid_xacc"]; // se há sessão apanha-a
 else $xacc = $_REQUEST["xacc"]; 
 
 
if ( $xacc == "IPLinq997134abx56" ) {
$usi ="IPL";
$_SESSION['sid_xacc'] = $xacc;
} else {
// verificação do acesso
include('../us/assoc05.php');
 	if ( isset($_SESSION["sid_usi"])) $usi = $_SESSION["sid_usi"];
 	 		else { echo "Acesso não autorizado E01";
 	 				exit -1;
 	 			}
 	if ( isset($_SESSION["sid_ido"])) $ido = $_SESSION["sid_ido"];
 	 		else { echo "Acesso não autorizado E02";
 	 				exit -1;
 	 			}
 	if ( $_SESSION["sid_ace"] < 200) { // 200 é o nível mínimo de entrada
 	 				echo "Acesso não autorizado E03";
 	 				exit -1;
 	 			}
 	if ( isset($_SESSION["sid_ent"])) $ident = $_SESSION["sid_ent"];
 	 			else {
 					// PROBLEMAS COM A IDENTIFICAÇÃO DA ENTIDADE .....
	 				echo "Acesso não autorizado E04";
					exit -1;
 	 			}

			if  ( $ido == 'AFCARVALHO' || $ido == 'FMCARVALHO'  || $ido == 'MJLOPES' || $ido == 'ASALVATERRA' || $ido == 'JCAEIRO'  || $ido == 'SALVES' ) {  // estes utilizadores tem
            $xoper = "GER";
          } else { // não acedo
            printf("By....%s",$ido);
			exit;
            }			
}

// ########################################################################
// OK chegou aqui avança para o programa
// Definições GLOBAIS
			$idtab = 'munp4.inq1201';
			$idbas = 'munp4';
			// $eid =  $usi;       // a chave de entrada é o código de utilizador ....ie. MUNXXX
			$xent =  $ident;       // a chave de entrada é o código de entidade, em alguns inquériots pode ser o utilizador(udi) ....
	$tip_mov = $_REQUEST["tip_mov"];
	include('arr1201.php');	// FAZ SEMPRE !!!! a Definição dos arrais para os registos....
	
	$arsel = array();  
	$arsel =  $_REQUEST["arsel"];
	$xsel =  $_REQUEST["xsel"];
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

// SELPARTMUN ... partido maioritário na Câmara Municipal em 2009
 function selpartmun($cod,&$xpar) {

 $sqls="select * from munp3.al2009cm where cod='$cod'";
	$ress=mysql_db_query("munp3",$sqls); //
		if ($ress) {
				$regs=mysql_fetch_array($ress);
				if ( $regs ) {
						$xpar=$regs["part_maior"];
						$mand_tot=$regs["mand_tot"];
						$mand_pre=$regs["mand_maior"];
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

//  ################################################################################
// Definições para o HTML ....
 ?>

<html><head>
<title> INQUÉRITO 1201-2012</title>
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
					printf("<div class=\"sel3a\" align=\"center\">INQUÉRITO: CARACTERIZAÇÃO E DISTRIBUIÇÃO DOS CORPOS DE BOMBEIROS NO MUNICÍPIO E DOS SERVIÇOS MUNICIPAIS DE PROTECÇÃO CIVIL| 06-2011");
            printf("</td></TR></TABLE>");
			
			// printf("<table border=1><tr><td valign=top>Dist|RA</td><td valign=top>Município</td>");	 
			printf("<table border=1><tr><td valign=top>Município</td><td>Distrito</td>");	 
				foreach ($inq as $iti => $itlis) {
					if ( $arsel[$iti] == 1 ) {
				
					if ( strlen($itlis[0] ) > 0 ) printf("<td valign=top>%s</td>", $itlis[0]); // se o elemento 0 está preechido (resumo) coloca-o, se não vai o 1
						else printf("<td valign=top>%s</td>", $itlis[1]);
			 	 }
				}
			if ( $xsel == 0 || $xsel == 1  ) {	
			// printf("<td valign=top>%s</td>", "nome" );
			// printf("<td valign=top>%s</td>", "função");
			// printf("<td valign=top>%s</td>", "email");
			printf("<td valign=top>%s</td>", "data");
			}

		printf("</tr>");

			if ( $xord == "data") $xord = ' i.dat'; else $xord = ' e.nom';
			
			
	   $sql="select  i.cod_ent,i.dados,i.nom,i.func,i.email,i.dat,i.cod_sta  from $idtab AS i LEFT JOIN munp1.entidade AS e ON (i.cod_ent=e.cod) ORDER BY $xord ";       //        "  where cod_ent = '$xent' ";

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
		$xpartcm="";
		$k = selent($cod_ent,$noment,$dis);
		// $k1 =selpartmun($cod_ent,$xpartcm);
		// $cod_ent ou $dis	
		// substr($xpartcm,0,3)
		 printf("<tr><td>%s </td><td>%s</td>",$noment,$dis);
		 // printf("Recebido inq%s", count($inq));
				foreach ( $inq as $iti => $itlis) {
				 if ( $arsel[$iti] == 1)  {
					if ( strlen($vinq[$iti] ) == 0) printf("<td>&nbsp;</td>");	
					else {
						if ( $inq[$iti][2] == "O") { // Se for campo de observações ... mete-lhe os breaks
						$brx = "\n";
						$x = str_replace($brx,"<br>", $vinq[$iti]);
						 printf("<td>%s</td>", $x ); 
					}
					else {
					if ( $inq[$iti][2] == "N") $xal="right"; else $xal="left";
					printf("<td align=\"%s\">%s</td>",$xal, $vinq[$iti]);  // por defeito sai o valor
					}
				 }
			   }	 
			 }	
			 
			 if ( $xsel == 0 || $xsel == 1  ) {	// dados gerais
			// printf("<td>%s</td>", $nom);
			// printf("<td>%s</td>", $func);
			// printf("<td>%s</td>", $email);
			 printf("<td>%s</td>", $dat);
		 }
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

 ?>
 
<hr>

	[ <a href="http://www.anmp.pt/anmp/pro/inq/inq1201r21.php?xsel=1">Tudo</a> | 
    <a href="http://www.anmp.pt/anmp/pro/inq/inq1201r21.php?xsel=0">Limpar</a> ]

<br>Seleccione as questões a listar:
<?php
// if ( $tip_mov == "IN" || $tip_mov == "UPD" )  {

	
	printf("<form name=\"frm2\" method=\"POST\" action=\"inq1201r21.php\" class=\"sel2\">");
	printf("<table><tr><td>");
				$kn=0;
				$ki = count($inq);
				foreach ( $inq as $iti => $itlis) {
				$kn++;
				if ( $xsel == 1 || $arsel[$iti] == 1) $xche = "CHECKED"; else $xche = "";
				//printf("<br> %s.%s - <input type=\"checkbox\" name=\"arsel[$iti]\" value=\"%s\" %s>%s%c", substr($iti,0,1), substr($iti,1,2),"1", $xche,$inq[$iti][1],$xtab );
				printf("<br> <input type=\"checkbox\" name=\"arsel[$iti]\" value=\"%s\" %s>%s%c", "1", $xche,$inq[$iti][1],$xtab );
				if ( $kn> $ki/3) {
					printf("</td><td>");
					$kn=0;
				}
		} 
	 ?>
	 
	 </td></tr></table>
	   <input type="hidden" name="xsel" value="2">  
	 	 	<br /> <input type="submit" name="SubmitListar" value="Listar »»»" />
	 
	</form>

<div class="sel5">
 <hr>
 <br> -  (c)ANMP/TI [2010] 
 </div>
  </body>

 </html>
</body></html>