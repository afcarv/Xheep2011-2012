<?php
		session_start();
// os par�metros x... s�o passados em modo post ao chamar o programa

// $id_inq =  $_REQUEST["id_inq"]; 
// if (strlen($id_inq) == 0) $id_inq = 0;  // se n�o a aparece fica a zero !!!!
// controlo de p�ginas
$pagref = $_REQUEST["pagref"];
if ( strlen($pagref) == 0 ) $pagref=1;
$pag=$pagref;

$id_inq = "0"; //inquerito 1, mas tambem pode ser chamado com o id_inq


//###################################  AQUI




// ao re-chamar o programa, deve faz�-lo com um tipo de movimento (IN,UPD,SEL)		
$tip_mov = $_REQUEST["tip_mov"];
if(strlen($tip_mov)==0){
	$tip_mov = "NEW";
}


// ########################################################################
// OK chegou aqui avan�a para o programa
// Defini��es GLOBAIS

// include('acw1.php');	// .... ....
// ou 

include ('listas1.php');

$xho = "localhost";
$xus = "impresso_andre";
$xpw = "Serv2011";

$liga=mysql_connect($xho,$xus,$xpw);

if ( !$liga ) {
	printf("Erro de liga��o � base de dados!");
	printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"3;URL=%s\">",$urant);
}


$idtab = 'impresso_ISsite.impresso_camp';
$idbas = 'impresso_ISsite';



include("inqlayout.css");  // defini��es de layout

//tentativa de fazer um insert � for�a
//$sql = " insert into $idtab  (id_inq, dados, cod_sta, dat_sta, dat, ido, nom, func, email) values ('4','','','', '', '','andre', '', 'andre@s.pt' ) ";
//$result= mysql_db_query($idbas,$sql);

$xtab= 10;
// $xtab= '\n';
// IN e UPD - se for o caso, preenche recebe o array do form com os dados de insert ou update

$id_ref=0;

if ( $tip_mov == "IN" ) {  
	$id = $_REQUEST["id"];
	$nome = $_REQUEST["nome"];
	$apelido = $_REQUEST["apelido"];
	$aniversario = $_REQUEST["aniversario"];
	$opcao = $_REQUEST["opcao"];
	$email = $_REQUEST["email"];
	$dia =$_REQUEST["dia"];
	$mes =$_REQUEST["mes"];
	$id_ref=$_REQUEST["id_ref"];



}


// ########################################################################
// fun��es locais

function enviaPara($email, $nome) 
{
	require_once('php_mailer/class.phpmailer.php');
     	  
    // Inicia a classe PHPMailer
    $mail = new PHPMailer();     
    // Define os dados do servidor e tipo de conex�o
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    $mail->IsSMTP(); // Define que a mensagem ser� SMTP    $mail->Host = "smtp.dominio.net"; // Endere�o do servidor SMTP
    $mail->SMTPAuth = true; // Usa autentica��o SMTP? (opcional)
    $mail->Username = 'geral@impressoesesolucoes.com'; // Usu�rio do servidor SMTP
    $mail->Password = 'Gis2011'; // Senha do servidor SMTP
         // Define o remetente
   // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->From = "geral@impressoesesolucoes.com"; // Seu e-mail
   $mail->FromName = "Impress�es e Solu��es"; // Seu nome
     
   // Define os destinat�rio(s)    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=   
   $mail->AddAddress($email, $nome);//    $mail->AddAddress('ciclano@site.net');
    //$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
    //$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // C�pia Oculta
     
    // Define os dados t�cnicos da Mensagem
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->IsHTML(true); // Define que o e-mail ser� enviado como HTML
   //$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
     
    // Define a mensagem (Texto e Assunto)
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->Subject  = "Campanha Impress�es e Solu��es"; // Assunto da mensagem
	 $mail->Body = '<table width="749" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="749" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="749" height="142"><img src="http://www.impressoesesolucoes.com/aaa/back_1.png" alt="" width="749" height="142" style="display:block"/></td>
      </tr>
      <tr>
        <td><table width="749" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="39"><img src="http://www.impressoesesolucoes.com/aaa/back_10.png" alt="" width="749" height="39" style="display:block"/></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>';
	 $mail->AltBody = "Este � o corpo da mensagem de teste, em Texto Plano! \r\n ";
   // $mail->Body = "Este � o corpo da mensagem de teste, em <b>HTML</b>! <br /> //<img src="http:blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";
   // $mail->AltBody = "Este � o corpo da mensagem de teste, em Texto Plano! \r\n <img src="http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley"> ";
    
    // Define os anexos (opcional)
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
	// Envia o e-mail
	$enviado = $mail->Send();     
    // Limpa os destinat�rios e os anexos
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
} 

// SELINS

function selmax($email) {    
	global $idtab;
	global $idbas;

	$sqls="select max(id) from $idtab where email = '$email'";         
	$ress=mysql_db_query($idbas,$sqls); //                                 
	if ($ress) {                                        
		$regs=mysql_fetch_array($ress);         
		if ( $regs ) {                                
			$id =$regs[0];                
			mysql_free_result($ress);        
			return $id;                            
		}            
		else return 0;        
	}                                
	// printf("vai sair 0");            
	return 0;                                
}  


// quando quero devolver par�metor usar & (ponteiro)
function selinqs($email,$id_inq,&$xid) {

	$k=0;
	global $idtab;
	global $idbas;
	$sqls="SELECT * FROM $idtab WHERE email ='$email' AND id_inq ='$id_inq'";
	$ress=mysql_db_query($idbas,$sqls); //

	if ($ress) {
		while( $regs=mysql_fetch_array($ress)) {
			$xid = $regs["id"]; 
			$k++;
			//printf("<p class=\"sel4\"> >>> <a href=\"inq.php?tip_mov=%s&id=%s\"><b>Rever Inqu�rito</b></a>  |     <a href=\"inq.php?tip_mov=%s&id=%s&ximp=%s\"><b>Imprimir</b></a> </a></p>","SUP",$id,"SUP",$id,"IMP");
		}
	}

	return $k;

}

// SELINS
function vamos($email) {

	global $idtab;
	global $idbas;

	$sqls="SELECT * FROM $idtab WHERE email ='$email' ";
	$result = mysql_db_query($idbas,$sql);
	printf("%s",$result);
	if($result){

		$ress=mysql_fetch_array($result);

		printf("A");

		if($ress)
		{
			printf("ENTROU C�");
		}
		else
		{
			printf("N�O ,,,, ENTROU C�");
		}


	}
	else
	{
		printf("B");
	}


	if ($ress) {
		while( $regs=mysql_fetch_array($ress)) {
			$id = $regs["id"]; 
			//printf("<p class=\"sel4\"> >>> <a href=\"inq.php?tip_mov=%s&id=%s\"><b>Rever Inqu�rito</b></a>  |     <a href=\"inq.php?tip_mov=%s&id=%s&ximp=%s\"><b>Imprimir</b></a> </a></p>","SUP",$id,"SUP",$id,"IMP");
		}
	}

}

// LFDH .... passa o campo iti como hidden // para esconder partes do inqu�rito
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
<title>Campanha:2012</title>
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

	email = formx.elements["email"];
	var arvore = email.value;
	//alert(arvore);
	//alert("olha a �rvore"+arvore);
	checkEmail(arvore);


	document.frm2.submit();
}

function teste(){
	alert("------------");
}

function PagFin(formx) {
	
	email = formx.elements["email"];
	var arvore = email.value;

	checkEmail(arvore);
	document.frm2.submit();
}


function checkEmail(email) {
	if(email.length > 0)  {
		if (email.indexOf(' ') >= 0)
			alert("Erro: O Endere�o (email) n�o pode conter espa�os. \n Corrija este dado e prima novamente o bot�o Submeter");
		else if (email.indexOf('@') == -1)
			alert("Erro: O Endere�o (email) tem de conter o caracter @. \n Corrija este dado e prima novamente o bot�o Submeter");
	}
	else
	{
		alert("Aviso: Para que este formul�rio seja validado dever� introduzir um endere�o de correio electr�nico.");

		document.frm2.submit();

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
<div class="sel3a" align="center"><span class="sel3i"> Campanha Impress�es e Solu��es
</td></tr></table>
<table width=900 bgcolor=#ffffff>
'; // Cabe�alho!!!
// fim da tabela 1



?>
</span></div></td></tr>
<tr><td colspan=2 class="sel3">
<div class="sel3" align="justify">


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

		// $k = selent($xent,$xmun,$xnumhab);
		$k=1; // este k � martelado !!!!!!!!... deve ser vaidados com e e-mail do cliente ou otro m�todo

//# comentado a 26/03/2012						
//	printf("[=====E06======> %s | %s |  %s | %s ]",$xent,$xmun);
if (  $k == 0 ) {
	// PROBLEMAS COM A IDENTIFICA��O DA Entidade
	echo " Acesso n�o ajustado a este Formul�rio - E07 [$ident| $xnom]";
	exit -1;
}

$erro = 0;
$xct2 = "";   // as (rotina 0211a) e (rotina 0211b) for�am a que se o campo 0211 estiver assinalado com S passe todos os anteriores a nulo....

/*												 VERIFICA��ES ANTES DE INSERT OU UPDATE
 											  (valida campos e caracteres especiais....)
											==============================================	
 */
if ($tip_mov == "IN"   ) {  // SE insert ou update
	// data $vinq[$iti] = $hoje .'/' . $agora;  // data e hora
	//se este email j� existir e for um registo de insert muda para update

	

	$aniversario = $dia .'/'. $mes;	

	$werr ="";
	// excep�es de erro
	if (strlen($nome)==0)
	{
		$werr = "<hr><div class=sel3r  align=left>  - O nome encontra-se por preencher. <b> </b></div>"; // imprime erros de aviso, caso haja
		$erro=1;
	}
	if (strlen($apelido)==0)
	{
		$werr = "<hr><div class=sel3r  align=left>  - O apelido encontra-se por preencher. <b> </b></div>"; // imprime erros de aviso, caso haja
		$erro=1;
	}

	if (strlen($email)==0)
	{
		$werr = "<hr><div class=sel3r  align=left>  - O email encontra-se por preencher. <b> </b></div>"; // imprime erros de aviso, caso haja
		$erro=1;
	}

	if (strlen($aniversario)==0)
	{
		$werr = "<hr><div class=sel3r  align=left>  - O seu anivers�rio encontra-se por preencher. <b> </b></div>"; // imprime erros de aviso, caso haja
		$erro=1;
	}

	if (strlen($opcao)==0)
	{
		$werr = "<hr><div class=sel3r  align=left>  - A op��o de personaliza��o do calend�rio encontra-se por preencher. <b> </b></div>"; // imprime erros de aviso, caso haja
		$erro=1;
	}



	$nome  = str_replace("'","`",$nome);  // troca os apostrofes!!!      --->no sql as entradas s�o separadas por apostrofo portanto, se as pessoas usarem apostrofo troca-se aqui para n�o dar bode
	$apelido = str_replace("'","`",$apelido);  // troca os apostrofes!!!



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

	if ( $ref_mov == "FIN" ) {
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
			printf("<p class=\"sel3i\">%s</p>","Formul�rio actualizado com sucesso. <br>Para Rever/Alterar os dados recebidos, prima Rever. <br><br>Para abandonar o Formul�rio, prima Sair.<br><br><br><br>Obrigado.<br>A equipa da Impress�es e Solu��es, Lda");


			//printf("<p class=\"sel3a\">%s</p>  ","<br> Para Rever/Alterar os dados recebidos, prima <Rever>.");
		}
		// torna o movomento em SEL e limpa o nome, refas e observ.
		$tip_mov = "SEL";
		// limpa os campos ....
		// fun�ao de limpeza
		// $id=$reg=$it=$v1=$v2=$v3=$v4=$v5="";
	}

	// #################
	// INSERT
	if ( $tip_mov == "IN"   ) {  // faz insert....se a ref_mov = FIN
	
	
	//echo "vai inserir";

		$sql = "insert into $idtab  ( nome,apelido,aniversario,email,opcao,date,id_ref) values ('$nome','$apelido','$aniversario', '$email', '$opcao','$data', '$id_ref') ";

		//echo $sql;
		
		
		$result= mysql_db_query($idbas,$sql);

		//se quiser ver o que estou a inserir na base de dados no comando insert
		//echo '<hr>'.$sql;

		// echo mysql_error();
		$regins=mysql_affected_rows();
		$ni = $regins;

		if(id_ref==0)
		{
			//fun��o para ir buscar id
			$id_ref = selmax($email);
		}

		if ( $ni > 0 ) {
			printf("<p class=\"sel3i\">%s</p>","Campanha conclu�da com sucesso");
			
			
			
			
			enviaPara($email, $nome);
			printf("<p class=\"sel3b\">%s</p>","<br><br> Consulte o seu e-mail.<br><br><br><br>Obrigado.<br>A equipa da Impress�es e Solu��es, Lda");
		}

		$tip_mov = "INSER";
		// limpa os campos ....
		// $id=$reg=$it=$v1=$v2=$v3=$v4=$v5="";
	}

}
// fim do if erro=0
else { // se h� erro 
	// mostra o erro !!!
	printf("<p class=\"sel3b\"><hr><b>Erro:<br>%s</b><br>%s<hr></div>",$werr,"Insira dados v�lidos.");
}

//echo " ...... $tip_mov <br>";
if ( $tip_mov == "NEW") $tip_mov = "IN";  // os novos passam aqui a IN ....
//echo " ...... $tip_mov <br>";

//  FROM DE INPUT .... PRINCIPAL -->

if ( $tip_mov == "IN"  )  {



	printf("<form name=\"frm2\" method=\"POST\" action=\"campaign.php\" class=\"sel2\">");
	// o tip_mov �  hidden e apenas mostrado , n�o alterado
	// dados gerais
	printf(" <input type=\"hidden\" name=\"tip_mov\" value=\"%s\">",$tip_mov);
	printf(" <input type=\"hidden\" name=\"id_ref\" value=\"%s\">",$id_ref);
	printf(" <input type=\"hidden\" name=\"id\" value=\"%s\">",$id);


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

	//l� em baixo na linha 756
	
	/*
	
	<tr><td><img src="captcha.php" width="233" height="49"></td></tr>
	<tr><td><input style="text-align:left" type="text" name="captcha" size="60" value="<?php echo $captcha;?>" class="sel2"></td></tr>
*/

	?>

	<!--                                  ######################  CORPO DE INQU�RITO   #############################    -->

	<table border =0>
	<tr><td><strong>Nome: </strong></td><td> <input style="text-align:left" type="text" name="nome" size="60" value="<?php echo $nome;?>" class="sel2"></td></tr>
	<tr><td><strong>Apelido: </strong></td><td> <input style="text-align:left" type="text" name="apelido" size="60" value="<?php echo $apelido;?>" class="sel2"></td></tr>
	<tr><td><strong>E-mail:</strong> </td><td> <input style="text-align:left" type="text" name="email" size="60" value="<?php echo $email;?>" class="sel2" onChange="checkEmail(this.value)">


	
	</td></tr>
	</table>	
	</p>
	
	

	<?php 

			echo '
			<strong>Anivers�rio:</strong>

	<select name="dia">
	<option selected>Dia</option>';
	if ( strlen($dia) == 0) $dia = "1";
	foreach ($dias as $nm1) {
		if ( $dia == $nm1) $sel = "SELECTED"; else $sel = "";
		echo '<option value="' .$nm1. '" '. $sel .'>'.$nm1.'</option>';
	}
	echo '</select>
	<select name="mes">
	<option selected>M�s</option>';
	if ( strlen($mes) == 0) $mes = "Janeiro";
	foreach ($meses as $nm2) {
		if ( $mes == $nm2) $sel = "SELECTED"; else $sel = "";
		echo '<br>';
		echo '<option value="' .$nm2. '" '. $sel .'>'.$nm2.'</option>';
	}
	echo '</select><br><br>';



	// VER AQUI COM ATEN��O
	echo '<strong> Clube de Futebol: </strong>';

	if ( $opcao == "Academica") 
	{ 
		$xche = "CHECKED"; 
	} 
	else
	{ 
		$xche = "";
	}
	printf("<br><tr><td>Academica de Coimbra - OAF <input type=\"radio\" name=\"opcao\" value=\"%s\" %s ></td></tr><br>", "Academica" , $xche);
	
	if ( $opcao == "Porto") 
	{ 
		$xche = "CHECKED"; 
	} 
	else
	{ 
		$xche = "";
	}
	printf("<br><tr><td>F.C.Porto <input type=\"radio\" name=\"opcao\" value=\"%s\" %s ></td></tr><br>", "Porto" , $xche);



	if ( $opcao == "Sporting")
	{
		$xche = "CHECKED";  
	}
	else {
		$xche = "";
	}

	printf("<tr><td>Sporting C.P.<input type=\"radio\" name=\"opcao\" value=\"%s\" %s ></td></tr><br>", "Sporting" , $xche);

	if ( $opcao == "Benfica") 
	{
		$xche = "CHECKED"; 
	} 
	else
	{ 
		$xche = "";

	}
	printf("<tr><td>S.L.Benfica <input type=\"radio\" name=\"opcao\" value=\"%s\" %s ></td></tr><br>", "Benfica" , $xche);

	
	


printf("<br><br><br><br><tr><td><input type=\"button\" value=\"Submeter \" onclick=\"javascript:PagFin(this.form)\"></td></tr>&nbsp;");


echo '</p>	</td></tr>	</table> 	<hr />';


if ( $ximp != "IMP"  ) {  // se n�o for impress�o mostra AS NOTAS a text area

	?></p>

	</td></tr>
	</table>
	
	
	<img src="captcha.php?l=150&a=50&tf=20&ql=5">
<!--
O texto digitado no campo abaixo sera enviado via POST para
o arquivo validar.php que ira vereficar se o que voce digitou � igual
ao que foi gravado na sessao pelo captcha.php
-->
<form action="validar.php" name="form" method="post">
   <input type="text" name="palavra"  />
   <input type="submit" value="Validar Captcha" />
</form>
	
	
	
	
	<?php 
} 


echo '</p>	</td></tr>
</table> 
<hr />';
if ( $ximp != "IMP"  ) {  // se n�o for impress�o mostra AS NOTAS a text area
	?>
	<div align="left">
	Notas:<br> 1. Os dados introduzidos s� ser�o aceites depois de premir o bot�o <b><u>"Submeter Campanha"</u></b>
	<br>2. Esta campanha ficar� dispon�vel on-line.
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




printf(" </form>");
}
	else {
	if ( strlen($werr) > 0 ) {
		printf("<b>Avisos:</b>%s",$werr); // imprime erros de aviso, caso haja
	}
	
	
	$nome = utf8_encode($nome);

	//echo 'estado dos acentos->'.$nome;
	
	$emailA = $email;
	
	//nao pode ter espa�os
	printf("<p class=\"sel4\"> <a href=\"campaign.php?tip_mov=%s&email=%s&id_ref=%s\"><b>Fazer um novo</b></a></span>","NEW",$email,$id_ref);
	
	printf("<p class=\"sel4\"> <a href=\"campaign.php?tip_mov=%s&id_ref=%s\"><b>Fazer para um amigo</b></a></span>","NEW",$id_ref);
	
	printf("<p class=\"sel4\"> <a href=\"contact.php?id_ref=%s&nome=%s&emailA=%s\"><b>Referir a um amigo</b></a></span>",$id_ref,$nome,$emailA);

}


?>


<br> [ <a href="/index.php" class="sel4">Sair</a> ]

       </div>

<?php
		//                                                                              ###############             Rodap�               #################
		// include ('xxxxm2.inc');
		// mun101m2("xxxxxxx.php");
		// printf("%s",$tip_mov);

		printf("<div class=sel3a><br>Em caso de d�vidas contactar:");
printf("<br>Impress�es e Solu��es, Lda");
printf("<br>");
printf("<br>E-mail: geral@impressoesesolucoes.com");
printf("<br>Tel: +351 239 70 11 88");
printf("</div>");
//aqui est� a faltar um argumento


?>
<div class="sel5">
<hr>
<br>- (c)Impress�es e Solu��es,Lda [Campanha00-2012]
                                    </div>
</body>

</html>
</body></html>