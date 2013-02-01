<?php
session_start();

// os parâmetros x... são passados em modo post ao chamar o programa
$email =  $_REQUEST["email"]; 
// $id_inq =  $_REQUEST["id_inq"]; 

// a chave do inquerito vai ser o e-mail
if (strlen($email) == 0 ){
			die('Pedimos desculpa mas o mail '.$email.'<br /> não é válido');
			} 

// ao re-chamar o programa, deve fazê-lo com um tipo de movimento (IN,UPD,SEL)		
$tip_mov = $_REQUEST["tip_mov"];

// ########################################################################
// OK chegou aqui avança para o programa
// Definições GLOBAIS

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
		
			
//	( $tip_mov == "SUP" ) {  // Faz select para testar e existência de um registo, passnado-o a update,caso exista


    $sqls="SELECT * FROM $idtab"; // WHERE id='258'";   WHERE email ='$email' AND id_inq ='$id_inq'";
	echo $sqls;
	$ress=mysql_db_query($idbas,$sqls); //
		if ($ress) {
				while( $regs=mysql_fetch_array($ress)) {
				$id = $regs["id"]; 
				$name = $regs["name"]; 
				echo '<br>-ID:['. $id;
				echo '-['. $name;
				//mb_detect_encoding($name, "UTF-8") == "UTF-8" ? : $name = utf8_encode($name);
				// if(!mb_check_encoding($name, 'UTF-8')) $name = utf8_encode($name); 
				//$name = utf8_encode($name); 
				$name = utf8_decode($name);
				echo ']['.$name. ']';
				
				$sql = " update $idtab set name = '$name' WHERE id ='$id' ";
				// printf("SQL:%s",$sql);
				$result= mysql_db_query($idbas,$sql);
				$regins=mysql_affected_rows();
				$ni = $regins;
				      if ( $ni > 0 ) {
						printf("<p class=\"sel3i\">%s</p>","Inquérito actualizado com sucesso. ");
					   }
			
			
			}
		}


 ?>
   </body>
 </html>