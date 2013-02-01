<?php
// variáveis base
//$link = mysql_connect('localhost', 'mysql_user', 'mysql_password');
$table_prefix = 'zmp0o_'; // prefixo da base de dados cinove
$db = 'cinove_1'; // a base de dados cinove
$user = 'jomaus';
$password = 'cinoveh8';
$filecsv = 'teste.csv'; // ficheiro a ler
		
// liga À BASE DE DADOS
$link = mysql_connect('localhost', $user, $password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
	}
echo 'Connected successfully';
mysql_select_db($db);

// ABRE E LÊ O CSV
$row = $is = $nis =0;
if (($handle = fopen($filecsv, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
	        $num = count($data);
        // echo "<p> $num fields in line $row: <br /></p>\n";
		 if ( !is_numeric( $data[0]) ) continue;  // se o DUN não é um número, não é um registo válidfo...
		
        $row++;
		// '$nome','$username','$email',md5('$password'),'$usertypename','$block','$sendmail',
		$nome = $data[2];
		$username = "DUN_". $data[0];	
		$password =  $data[0];
		$email = $data[11];
		$block = '0';
		$sendmail = '0';
		$usertype ='2';
			// $xquer = "SELECT email FROM " . $table_prefix . "users WHERE email='" . $email . "'";   // refsql#1
			// echo $xquer .'<br>';
		
		if (strlen($email) > 5) { // verifica se o e-mail existe na base de dados
		$sql = mysql_query("SELECT email FROM " . $table_prefix . "users WHERE email='" . $email . "'");   // refsql#1
		$num_rows = mysql_num_rows($sql);
			if($num_rows > 0) {
			echo '<p> O e-mail: ' . $email . 'já existia na base de dados ... não foi inserido</p> ';
			$nis++;
			continue;
			}
		} else { // caso não exist e-mail, não vale a pena inserir o registo 
			echo '<p> O e-mail: ' . $email . ' do registo da empresa ' . $nome . 'Não é válido .. não foi inserido</p> ';
			$nis++;
			continue;
			} 
		
		// Insere o registo de utilizador
		$sql1 = "INSERT INTO " . $table_prefix . "users (name,username,email,password,usertype,block,sendEmail,registerDate,lastvisitDate,activation,params) values ('$nome','$username','$email',md5('$password'),'$usertypename','$block','$sendmail', NOW(),'0000-00-00 00:00:00','','')";
		mysql_query($sql1);

		// recupera o user ID (id da tabela users -> variavel $user_id
		$sql2 = "SELECT id FROM " . $table_prefix . "users WHERE username = '$username'";
		$result = mysql_query($sql2);
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		$row = mysql_fetch_row($result);
		$user_id = $row[0]; // o id 
		// insere o registo na tabela user_usergroup_map  
		$sql3 = "INSERT INTO " . $table_prefix . "user_usergroup_map (group_id,user_id) values ('$usertype','$user_id')";
		mysql_query($sql3);
		
		$is++;
		
    }
    fclose($handle);
	}
mysql_close($link);	
	echo '<hr> Inseridos:'. $is;
	echo '<br> Não inseridos:'. $nis;
?>
