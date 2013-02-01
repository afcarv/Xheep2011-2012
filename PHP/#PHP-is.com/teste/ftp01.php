<?php
// Actualiza web ###########################################################################
// passa as três tabelas mysql para o servisdor da web
// ...........                                                
 function uploadmy($nomfile) {
//include('../us/us121.php');  // -->  ficheiro com as varoáveis $ftpx0 = us, $ftpx1 = pw

$ftpx0 = us;
$ftpx1 = pw;

$ftp_server = '81.92.207.154';

$nomfile ="ficheiro01.jpg";

$files0 = '/home/impresso/public_html/teste/calendarios/'. $nomfile ;  // nome do ficheiro
$remote_files0 = '/home/impresso/public_html/teste/calendariosTransporte/'. $nomfile ;  // nome do ficheiro no 43

 If( !file_exists($files0) ) {
 printf ( " Não pode fazer o upload de um ficheiro que não existe %s !!! ", $files0 );
     $erro = 1;
 } 

printf(".................. upload:%s].............. ",$files0);

   //  if ($erro == 0 ) {  // SE não há erros impeditivos faz o upload 
    // Upload do ficheiro
    // set up basic connection
	$ftp_server='81.92.207.154';
	$conn_id2="teste";
	$ftpx0="impresso";
	$ftpx1="1q2W3e4R5t6Y";
	
    $conn_id2 = ftp_connect($ftp_server); // ftp_connect
    // login with username and password
	// ftp_login (identificador da conexão, username, password)
    $login_result = ftp_login($conn_id2, $ftpx0, $ftpx1);  // ftp_login
   echo "us .... $conn_id, $ftpx0, $ftpx1";

   $remote_files0='/home/impresso/public_html/teste/calendariosTransporte/';
   $files0 = '/home/impresso/public_html/teste/calendarios/';
   
    // upload a file - FTP_ASCII -FTP_BINARY
	// ftp_put (identificador, caminho para o ficheiro remoto, caminho para arquivo local, modo de transferência)
    if (ftp_put($conn_id2, $remote_files0, $files0, FTP_BINARY)) {
     echo "successfully uploaded $files0\n";
    } else {
     echo "There was a problem while uploading $files0\n";
    }
    
    // close the connection
    ftp_close($conn_id2);  
    
    // quit é um alias ftp_quit($conn_id2);
    
}
   
 
   
   
   
   
?>