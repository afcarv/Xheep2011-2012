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
	$xacc = "";
 	$urant = "/index.php"; // programa pai
 	$xho = "localhost";
		$xus = "impresso_andre";
		$xpw = "Serv2011";	
		
	include('arrext01.php');	// .... ....
  $liga=mysql_connect($xho,$xus,$xpw);
  if ( !$liga ) {
	prinf("Problema [Erro]!!!");
	printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
}

if (isset($_SESSION["sid_xacc"])) $xacc = $_SESSION["sid_xacc"]; // se há sessão apanha-a
 else $xacc = $_REQUEST["xacc"]; 
 
 
if ( $xacc == "andre" || $xacc == "eliana") {

$_SESSION['sid_xacc'] = $xacc;
} else {
// verificação do acesso

 	if ( isset($_SESSION["sid_usi"])) $usi = $_SESSION["sid_usi"];
 	 		else { echo "Acesso não autorizado E01";
 	 				exit -1;
 	 			}
				

}

// ########################################################################
// OK chegou aqui avança para o programa
// Definições GLOBAIS
	//$idtab = 'munp4.inq1201';
			//$idbas = 'munp4';
			
			$idtab = 'impresso_ISsite.impresso_inqext02';
			$idbas = 'impresso_ISsite';

	$tip_mov = $_REQUEST["tip_mov"];
	include('arrext01.php');	// FAZ SEMPRE !!!! a Definição dos arrais para os registos....
	
	$arsel = array();  
	$arsel =  $_REQUEST["arsel"];
	$xsel =  $_REQUEST["xsel"];
	$xtab=10;
	
// funções locais


//  ################################################################################
// Definições para o HTML ....
 ?>

<html><head>
<title> INQUÉRITO 2012</title>
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
					
					// printf("<br>[$tip_mov|$usi] ");

					printf("</td><td>");
					printf("<div class=\"sel3a\" align=\"center\">INQUÉRITO: Satisfação do cliente| 04-2012");
            printf("</td></TR></TABLE>");
			
			// printf("<table border=1><tr><td valign=top>Dist|RA</td><td valign=top>Município</td>");	 
			printf("<table border=1><tr><td valign=top>Cliente</td><td>Email</td>");	 
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

			if ( $xord == "data") $xord = ' i.dat'; else $xord = ' i.email';
			
			
	   $sql="select  i.dados,i.nom,i.func,i.email,i.dat,i.cod_sta  from $idtab AS i  ORDER BY $xord ";       //        "  where cod_ent = '$xent' ";

			// printf("%s",$sql);

		$numreg = 0;

	 	$result=mysql_db_query($idbas,$sql);
 		if ($result) {
			while( $regis=mysql_fetch_array($result)) {
			// funçao de seleccção
			// funçao de seleccção
			
			$dados = $regis[0];
			$nom = $regis[1];
			$func = $regis[2];
			$email = $regis[3];
			$dat = $regis[4];
			$sta = $regis[5]; // foi preciso localizar a entrada no array porque ha dois cod_sta (no inquérito e na entidade)

			$n = 1;
			$vinq = unserialize($dados);
		
		
		 printf("<tr><td>%s </td><td>%s</td>",$nom,$email);
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
		   //
*/	

 ?>
 
<hr>

	[ <a href="http://www.impressoesesolucoes.com/print_tabela/inq.php?xsel=1">Tudo</a> | 
    <a href="http://www.impressoesesolucoes.com/print_tabela/inq.php?xsel=0">Limpar</a> ]

<br>Seleccione as questões a listar:
<?php
// if ( $tip_mov == "IN" || $tip_mov == "UPD" )  {

	
	printf("<form name=\"frm2\" method=\"POST\" action=\"inq.php\" class=\"sel2\">");
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
 <br> -  (c)Impressões e Soluções/TI [2010] 
 </div>
  </body>

 </html>
</body></html>