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

$sql1="SELECT id, name, username, email FROM " . $table_prefix . "users WHERE username LIKE 'DUN_%' ORDER BY name";

$result = mysql_query($sql1);
$is=0;
while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
    printf ("<p>ID: %s  Empresa: %s Username: %s E-mail: %s</p>", $row[0], $row["name"],$row["username"],$row["email"]);
	$is++;
}
mysql_free_result($result);
mysql_close($link);	
	echo '<hr> Inseridos:'. $is;
?>
