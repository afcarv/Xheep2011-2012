<?php
session_start();

// os parâmetros x... são passados em modo post ao chamar o programa
$email =  $_REQUEST["email"]; 
// $id_inq =  $_REQUEST["id_inq"]; 

// a chave do inquerito vai ser o e-mail
if (strlen($email) == 0 ){
			die('Pedimos desculpa mas o mail '.$email.'<br /> não é válido. Experimenta http://impressoesesolucoes.com/update/update_utf8i.php?email=batata');
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
		$idtab = 'impresso_ISsite.impresso1_user_profiles';
		$idbas = 'impresso_ISsite';	
			
//	( $tip_mov == "SUP" ) {  // Faz select para testar e existência de um registo, passnado-o a update,caso exista
    $sqls="SELECT * FROM $idtab"; // WHERE id='258'";   WHERE email ='$email' AND id_inq ='$id_inq'";
	echo $sqls;
	$ress=mysql_db_query($idbas,$sqls); //
		if ($ress) {
				while( $regs=mysql_fetch_array($ress)) {
				$user_id = $regs["user_id"]; 
				$morada=$regs["profile_value"]; 
				//$name = $regs["name"]; 
				echo '<br>-ID:['. $user_id;
				//echo '<br>-Morada:['. $morada;
				//mb_detect_encoding($name, "UTF-8") == "UTF-8" ? : $name = utf8_encode($name);
				// if(!mb_check_encoding($name, 'UTF-8')) $name = utf8_encode($name); 
				//$name = utf8_encode($name); 
				//$name = utf8_decode($name);
				
				echo '<br> - antes de converter '.$morada;
				
				$morada = utf8_decode($morada);
				
				//$desc = iconv("UTF-8", "ASCII//TRANSLIT", $morada);
				
				echo '<br> - depois de converter '.$morada;
				
				/*
				if ( strlen($morada) > 1 ) {
				$ord = 4;
				$sql3 = "INSERT INTO " . $table_prefix . "user_profiles (user_id,profile_key,profile_value,ordering)   values ('$user_id','profile.morada','$morada','$ord')";
				mysql_query($sql3);
				}
				*/		
				
				echo '<br> Tabela:'.$idtab;
				echo '<br> ID do gajo:'.$user_id;
				
				$sql = " update $idtab set profile_value = '$morada' WHERE user_id ='$user_id' ";
				
				echo '<br> fez update a: '.$morada;
				//echo 'aqui-->'.$morada.'<---';
				echo '<br>--------<br>';
				continue;
				
				//echo 'decode';
				
				//echo ']['.$morada. ']';
				
				
				
				// printf("SQL:%s",$sql);
				$result= mysql_db_query($idbas,$sql);
				$regins=mysql_affected_rows();
				$ni = $regins;
				      if ( $ni > 0 ) {
						printf("<p class=\"sel3i\">%s</p>","sucesso. ");
					   }
			
			
			}
		}


 ?>
   </body>
 </html>