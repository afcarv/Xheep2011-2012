<?php defined('_JEXEC') or die('Restricted access'); 


$image = "logois_p.png";  
$width = 300;
$height = 280;
echo '<center> <img src="'.$image.'" style=width:"' . $width . 'px;height:' . $height . 'px;"></center>';
echo '<tr><td><center><strong>Formulário de Registo Impressões e Soluções,Lda</strong></center></tr></td>';

/**
 *
 * @author afcarv
 */
 
// variáveis de ambiente

//echo "\n TESTE4 \n";

//   Set query DB
$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query->select('MAX(map.group_id) as gid');
$query->from('#__user_usergroup_map as map');
$query->where('map.user_id='.$uid);
$db->setQuery((string)$query);
$message = $db->loadObject();   
$gid = $message->gid;   
//echo "<br />group id: ".$gid;
$groupid = $gid; // The groupid
//db establish
$jconfig = new JConfig();
$db_error = "Mysql error!";
$db_config = mysql_connect( $jconfig->host, $jconfig->user, $jconfig->password ) or die( $db_error );
mysql_select_db( $jconfig->db, $db_config ) or die( $db_error ); 

//Get Joomla DB prefix
$config =& JFactory::getConfig();
$table_prefix = $config->getValue( 'dbprefix' );

$itemid = JRequest::getInt('Itemid', 0); 
$articleId = JRequest::getInt('id', 0);
// printf("%s %s",$sido, $sent );


//echo "\n TESTE3 \n";

// 1. variáveis de input (tipmov é )

$tipmov = JRequest::getVar('tipmov');
$nome = JRequest::getVar('nome');
$apelido = JRequest::getVar('apelido');
$morada = JRequest::getVar('morada');
$telemovel = JRequest::getVar('telemovel');
$email = JRequest::getVar('email');
$codpost = JRequest::getVar('codpost');
$municip = JRequest::getVar('municip');
$sexo = JRequest::getVar('sexo');
$aniversario = JRequest::getVar('aniversario');
//echo "\n TESTE2 \n";
$ximp = 0; // valor inicial 

//echo "\n TESTE7 \n";
 echo ' <hr>[ ' .
 $tipmov . $nome . $apelido. $morada. $telemovel . $email . $codpost . $municip . $sexo. $aniversario .
 '<br>] <center>*Todos os campos são de preenchimento obrigatório. Obrigado</center> <hr> ' ;
 
 //echo "\n TESTE1 \n";
 
 // se o tipmov for nulo vai directo para o form de imput 
 
  // 2. validações
  // 2.1
  if( $tipmov == "IMP") {
  
if ( strlen($nome) < 2 ) {
echo "<br> Por favor indique o Nome ";
 $ximp = 1;
}

if ( strlen($apelido) < 2 ) {
echo 'Por favor indique o Apelido';
 $ximp = 1;
}

if ( strlen($email) < 5 ) {
echo '<br> Por favor indique um endereço de e-mail';
 $ximp = 1;
}

if ( strlen($telemovel) < 9 ) {
echo '<br> Por favor indique um contacto de telemovel';
 $ximp = 1;
}

if ( strlen($morada) < 9 ) {
echo '<br> Por favor indique o seu local de residência';
 $ximp = 1;
}

if ( strlen($codpost) < 9 ) {
echo '<br> Por favor indique o seu código postal';
 $ximp = 1;
}

if ( strlen($municip) < 9 ) {
echo '<br> Por favor indique o município da sua área de residência';
 $ximp = 1;
}

if ( strlen($sexo) < 1 ) {
echo '<br> Por favor indique o seu sexo';
 $ximp = 1;
}

if ( strlen($aniversario) < 9 ) {
echo '<br> Por favor indique o aniversario';
 $ximp = 1;
}
}
// 2.2 - se o ximp fôr 1, ou tipmov nulo, não pode fazer insert, vai para o form 

if( $ximp == 0 && $tipmov == "IMP") { // tenta saber se o e-mail já existe
echo "ponto 2";
if (strlen($email) > 5) {	
// verifica se o e-mail existe na base de dados
$sql = mysql_query("SELECT email FROM " . $table_prefix . "users WHERE email='" . $email . "'");   // refsql#1
$num_rows = mysql_num_rows($sql);
if($num_rows == 0){
$email = $email;
$emailexiste = "0"; 
} else {	 
$emailexiste = "1"; //This email already exists in the joomla user db
$ximp = 1; // liga o form 
echo '<br/>
Por favor utilize outro endereço de e-mail, já exite uma conta associada ao email que inseriu.'. $email;
}
}
}
// 3. Passa ao insert
if( $ximp == 0 && $tipmov == "IMP" && $emailexiste == "0") { // tenta fazer o insert
// temos nome , apelido e email, já podemos gerar uma conta!
// na primeira fase, u utilizador é gerado pela função time...
echo "ponto 3";
$username = time();	
$password =  rand(1001, 9999);
$block = '0';
$sendmail = '0';
$usertype ='2';
//$datreg=...;

// Insere o registo de utilizador

$sql1 = "INSERT INTO " . $table_prefix . "users (name,username,email,password,usertype,block,sendEmail,registerDate,lastvisitDate,activation,params) values ('$nome','$username','$email',md5('$password'),'$usertypename','$block','$sendmail', NOW(),'0000-00-00 00:00:00','','')";
mysql_query($sql1);

// recupera o user ID
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

echo '
<hr>
Obrigado '. $nome .
' Agradecemos o seu registo, <br /> a sua conta tem o utlizador:' .
$username . 
' password: ' . $password .
'<hr>';
}

// Form para a recolha dos dados 
if ( $ximp == 1 || $tipmov != "IMP" ) {
$tipmov = "IMP"; // variável hidden para acontrolo
$nomebot="Registar";
echo '
<form onsubmit="return validate_form(this);"  action="'.JRoute::_('index.php?option=com_content&view=article&id='.$articleId.'&Itemid='.$itemid).'" method="post" enctype="multipart/form-data">
';
echo '	
<input type="hidden" name="tipmov" value="'. $tipmov .'">
<table bgcolor=#f4f4f4>
<tr> <td><strong>Nome:</strong></td><td>
<tr> <td><input type="text" name="nome" value="'.$nome.'" size="25"> </tr>
<tr> <td><strong>Apelido:</td><td>
<tr> <td><input type="text" name="apelido" value="'.$apelido.'" size="25"> </tr>
<tr> <td><strong>Morada:</strong></td><td>
<tr> <td><input type="text" name="morada" value="'.$morada.'" size="45">  </td></tr>
<tr> <td><strong>Telemóvel: </strong></td></tr>
<tr> <td>(+351)<input type="text" name="telemovel" value="'.$telemovel.'" size="25"> </td></tr>
<tr> <td><strong>Email:</strong></td><td>
<tr> <td><input type="text" name="email" value="'.$email.'" size="45">  </td></tr>
<tr><td valign=top><strong>Município:</strong></strong></td></tr>
<tr> <td>
    <select name="municip">
    <option selected>Seleccione</option>
<option><strong>--------Distrito de Aveiro--------</strong></option>
<option>Águeda</option>
<option>Albergaria-a-Velha</option>
<option>Anadia</option>
<option>	Arouca</option>
	<option>Aveiro</option>
	<option>Castelo de Paiva</option>
	<option>Espinho</option>
<option>	Estarreja</option>
<option>	Santa Maria da Feira</option>
<option>	Ílhavo</option>
<option>	Mealhada</option>
<option>	Murtosa</option>
<option>	Oliveira de Azemeis</option>
<option>	Oliveira do Bairro</option>
<option>	Ovar</option>
<option>	São João da Madeira</option>
<option>	Sever do Vouga</option>
<option>	Vagos</option>
<option>	Vale de Cambra</option>
<option>----Distrito de Beja----</option>
	<option>Aljustrel</option>
<option>	Almodôvar</option>
<option>	Alvito</option>
<option>	Barrancos</option>
<option>	Beja</option>
<option>	Castro Verde</option>
	<option>Cuba</option>
	<option>Ferreira do Alentejo</option>
<option>	Mértola</option>
<option>	Moura</option>
<option>	Odemira</option>
<option>	Ourique</option>
<option>	Serpa</option>
<option>	Vidigueira</option>
<option>----Distrito de Braga----</option>
<option>	Amares</option>
<option>	Barcelos</option>
<option>	Braga</option>
<option>	Cabeceiras de Basto</option>
	<option>Celorico de Basto</option>
<option>	Esposende</option>
<option>	Fafe</option>
<option>	Guimarães</option>
<option>	Póvoa de Lanhoso</option>
<option>	Terras de Bouro</option>
<option>	Vieira do Minho</option>
<option>	Vila Nova de Famalicão</option>
<option>	Vila Verde</option>
<option>	Vizela</option>
<option>----Distrito de Bragança----</option>
	<option>Alfândega da Fé</option>
<option>	Bragança</option>
<option>	Carrazeda de Ansiães</option>
<option>	Freixo de Espada à Cinta</option>
	<option>Macedo de Cavaleiros</option>
<option>	Miranda do Douro</option>
<option>	Mirandela</option>
<option>	Mogadouro</option>
<option>	Moncorvo</option>
<option>	Vila Flor</option>
<option>	Vimioso</option>
<option>	Vinhais</option>
<option>----Distrito de Castelo Branco----</option>
<option>	Belmonte</option>
<option>	Castelo Branco</option>
<option>	Covilhã</option>
<option>	Fundão</option>
<option>	Idanha-a-Nova</option>
<option>	Oleiros</option>
<option>	Penamacôr</option>
<option>	Proença-a-Nova</option>
<option>	Sertã</option>
<option>	Vila de Rei</option>
<option>	Vila Velha de Ródão</option>
<option>----Distrito de Coimbra----</option>
<option>	Arganil</option>
<option>	Cantanhede</option>
<option>	Coimbra</option>
<option>	Condeixa-a-Nova</option>
<option>	Figueira da Foz</option>
<option>	Góis</option>
<option>	Lousã</option>
<option>	Mira</option>
<option>	Miranda do Corvo</option>
<option>	Montemor-o-Velho</option>
<option>	Oliveira do Hospital</option>
<option>	Pampilhosa da Serra</option>
<option>	Penacova</option>
<option>	Penela</option>
<option>	Soure</option>
<option>	Tábua</option>
	<option>Vila Nova de Poiares</option>
<option>----Distrito de Évora----</option>
<option>	Alandroal</option>
<option>	Arraiolos</option>
	<option>Borba</option>
	<option>Estremoz</option>
<option>	Évora</option>
<option>	Montemor-o-Novo</option>
<option>	Mora</option>
<option>	Mourão</option>
<option>	Portel</option>
<option>	Redondo</option>
<option>	Reguengos de Monsaraz</option>
<option>	Vendas Novas</option>
<option>	Viana do Alentejo</option>
<option>	Vila Viçosa</option>
<option>----Distrito de Faro----</option>
<option>	Albufeira</option>
<option>	Alcoutim</option>
<option>	Aljezur</option>
<option>	Castro Marim</option>
<option>	Faro</option>
<option>	Lagoa (Algarve)</option>
<option>	Lagos</option>
<option>	Loulé</option>
<option>	Monchique</option>
<option>	Olhão</option>
<option>	Portimão</option>
<option>	São Brás de Alportel</option>
<option>	Silves</option>
<option>	Tavira</option>
<option>	Vila do Bispo</option>
<option>	Vila Real de Santo António</option>
<option>----Distrito da Guarda----</option>
<option>	Aguiar da Beira</option>
<option>	Almeida</option>
<option>	Celorico da Beira</option>
<option>	Figueira de Castelo Rodrigo</option>
<option>	Fornos de Algodres</option>
<option>	Gouveia</option>
<option>	Guarda</option>
<option>	Manteigas</option>
<option>	Mêda</option>
<option>	Pinhel</option>
<option>	Sabugal</option>
<option>	Seia</option>
<option>	Trancoso</option>
<option>	Vila Nova de Foz Côa</option>
<option>----Distrito de Leiria----</option>
<option>	Alcobaça</option>
<option>	Alvaiázere</option>
	<option>Ansião</option>
	<option>Batalha</option>
	<option>Bombarral</option>
<option>	Caldas da Rainha</option>
<option>	Castanheira de Pera</option>
<option>	Figueiró dos Vinhos</option>
<option>	Leiria</option>
<option>	Marinha Grande</option>
<option>	Nazaré</option>
	<option>Óbidos</option>
<option>	Pedrogão Grande</option>
<option>	Peniche</option>
<option>	Pombal</option>
	<option>Porto de Mós</option>
<option>----Distrito de Lisboa----</option>
<option>	Alenquer</option>
	<option>Amadora</option>
<option>	Arruda dos Vinhos</option>
<option>	Azambuja</option>
<option>	Cadaval</option>
<option>	Cascais</option>
<option>	Lisboa</option>
<option>	Loures</option>
<option>	Lourinhã</option>
<option>	Mafra</option>
<option>	Oeiras</option>
<option>	Sintra</option>
<option>	Sobral de Monte Agraço</option>
<option>	Torres Vedras</option>
<option>	Vila Franca de Xira</option>
<option>	Odivelas</option>
<option>----Distrito de Portalegre----</option>
<option>	Alter do Chão</option>
<option>	Arronches</option>
	<option>Avis</option>
	<option>Campo Maior</option>
	<option>Castelo de Vide</option>
	<option>Crato</option>
	<option>Elvas</option>
	<option>Fronteira</option>
	<option>Gavião</option>
	<option>Marvão</option>
	<option>Monforte</option>
	<option>Nisa</option>
	<option>Ponte de Sôrv
	<option>Portalegre</option>
	<option>Sousel</option>
<option>----Distrito do Porto----</option>
<option>	Amarante</option>
<option>	Baião</option>
<option>	Felgueiras</option>
<option>	Gondomar</option>
<option>	Lousada</option>
<option>	Maia</option>
<option>	Marco de Canaveses</option>
<option>	Matosinhos</option>
	<option>Paços de Ferreira</option>
	<option>Paredes</option>
<option>	Penafiel</option>
<option>	Porto</option>
<option>	Póvoa de Varzim</option>
<option>	Santo Tirso</option>
<option>	Valongo</option>
	<option>Vila do Conde</option>
	<option>Vila Nova de Gaia</option>
<option>	Trofa</option>
<option>----Distrito de Santarém----</option>
<option>	Abrantes</option>
<option>	Alcanena</option>
<option>	Almeirim</option>
<option>	Alpiarça</option>
<option>	Benavente</option>
<option>	Cartaxo</option>
<option>	Chamusca</option>
<option>	Constância</option>
<option>	Coruche</option>
<option>	Entroncamento</option>
<option>	Ferreira do Zêzere</option>
<option>	Golegã</option>
<option>	Mação</option>
<option>	Ourém</option>
<option>	Rio Maior</option>
<option>	Salvaterra de Magos</option>
<option>	Santarem</option>
	<option>Sardoal</option>
<option>	Tomar</option>
<option>	Torres Novas</option>
<option>	Vila Nova da Barquinha</option>
<option>----Distrito de Setúbal----</option>
	<option>Alcácer do Sal</option>
	<option>Alcochete</option>
	<option>Almada</option>
	<option>Barreiro</option>
	<option>Grândola</option>
	<option>Moita</option>
	<option>Montijo</option>
	<option>Palmela</option>
	<option>Santiago do Cacém</option>
	<option>Seixal</option>
	<option>Sesimbra</option>
	<option>Setúbal</option>
	<option>Sines</option>
<option>----Distrito de Viana do Castelo----</option>
	<option>Arcos de Valdevez</option>
	<option>Caminha</option>
	<option>Melgaço</option>
	<option>Monção</option>
	<option>Paredes de Coura</option>
	<option>Ponte da Barca</option>
	<option>Ponte de Lima</option>
	<option>Valença</option>
	<option>Viana do Castelo</option>
	<option>Vila Nova de Cerveira</option>
<option>----Distrito de Vila Real----</option>
	<option>Alijó</option>
	<option>Boticas</option>
	<option>Chaves</option>
	<option>Mesão Frio</option>
	<option>Mondim de Basto</option>
	<option>Montalegre</option>
	<option>Murça</option>
	<option>Peso da Régua</option>
	<option>Ribeira de Pena</option>
	<option>Sabrosa</option>
	<option>Santa Marta de Penaguião</option>
	<option>Valpaços</option>
	<option>Vila Pouca de Aguiar</option>
	<option>Vila Real</option>
<option>----Distrito de Viseu----</option>
	<option>Armamar</option>
	<option>Carregal do Sal</option>
	<option>Castro Daire</option>
	<option>Cinfães</option>
	<option>Lamego</option>
<option>	Mangualde</option>
<option>	Moimenta da Beira</option>
<option>	Mortágua</option>
	<option>Nelas</option>
	<option>Oliveira de Frades</option>
	<option>Penalva do Castelo</option>
	<option>Penedono</option>
<option>	Resende</option>
<option>	São João da Pesqueira</option>
<option>	São Pedro do Sul</option>
<option>	Santa Comba Dão</option>
<option>	Sátão</option>
<option>	Sernancelhe</option>
<option>	Tabuaço</option>
<option>	Tarouca</option>
<option>	Tondela</option>
<option>	Vila Nova de Paiva</option>
<option>	Viseu</option>
	<option>Vouzela</option>
<option>----Distrito dos Açores----</option>
	<option>Angra do Heroísmo</option>
<option>	Calheta (Açores)</option>
<option>	Corvo</option>
<option>	Horta</option>
<option>	Lagoa (Açores)</option>
<option>	Lajes das Flores</option>
<option>	Lajes do Pico</option>
<option>	Madalena</option>
<option>	Nordeste</option>
	<option>Ponta Delgada</option>
	<option>Povoação</option>
	<option>Ribeira Grande</option>
	<option>São Roque do Pico</option>
<option>	Santa Cruz da Graciosa</option>
<option>	Santa Cruz das Flores</option>
<option>	Velas</option>
<option>	Vila do Porto</option>
<option>	Vila Franca do Campo</option>
<option>	Praia da Vitória</option>
<option>----Distrito da Madeira----</option>
<option>	Calheta (Madeira)</option>
<option>	Câmara de Lobos</option>
<option>	Funchal</option>
<option>	Machico</option>
<option>	Ponta do Sol</option>
<option>	Porto Moniz</option>
<option>	Porto Santo</option>
<option>	Ribeira Brava</option>
<option>	Santa Cruz</option>
	<option>Santana</option>
<option>	São Vicente</option>
	
	
    </select>
    </tr>
    </td>


<tr> <td><strong>Código Postal</strong></td><td>
<tr> <td><input type="text" name="codpost1" value="'.$codpost.'" size="2"> <input type="text" name="codpost2" value="'.$codpost.'" size="1"> 
    <select name="codpost">
    <option selected>Seleccione</option>
<option>----Distrito de Aveiro----</option>
<option>Águeda</option>
<option>Albergaria-a-Velha</option>
<option>Anadia</option>
<option>	Arouca</option>
	<option>Aveiro</option>
	<option>Castelo de Paiva</option>
	<option>Espinho</option>
<option>	Estarreja</option>
<option>	Santa Maria da Feira</option>
<option>	Ílhavo</option>
<option>	Mealhada</option>
<option>	Murtosa</option>
<option>	Oliveira de Azemeis</option>
<option>	Oliveira do Bairro</option>
<option>	Ovar</option>
<option>	São João da Madeira</option>
<option>	Sever do Vouga</option>
<option>	Vagos</option>
<option>	Vale de Cambra</option>
<option>----Distrito de Beja----</option>
	<option>Aljustrel</option>
<option>	Almodôvar</option>
<option>	Alvito</option>
<option>	Barrancos</option>
<option>	Beja</option>
<option>	Castro Verde</option>
	<option>Cuba</option>
	<option>Ferreira do Alentejo</option>
<option>	Mértola</option>
<option>	Moura</option>
<option>	Odemira</option>
<option>	Ourique</option>
<option>	Serpa</option>
<option>	Vidigueira</option>
<option>----Distrito de Braga----</option>
<option>	Amares</option>
<option>	Barcelos</option>
<option>	Braga</option>
<option>	Cabeceiras de Basto</option>
	<option>Celorico de Basto</option>
<option>	Esposende</option>
<option>	Fafe</option>
<option>	Guimarães</option>
<option>	Póvoa de Lanhoso</option>
<option>	Terras de Bouro</option>
<option>	Vieira do Minho</option>
<option>	Vila Nova de Famalicão</option>
<option>	Vila Verde</option>
<option>	Vizela</option>
<option>----Distrito de Bragança----</option>
	<option>Alfândega da Fé</option>
<option>	Bragança</option>
<option>	Carrazeda de Ansiães</option>
<option>	Freixo de Espada à Cinta</option>
	<option>Macedo de Cavaleiros</option>
<option>	Miranda do Douro</option>
<option>	Mirandela</option>
<option>	Mogadouro</option>
<option>	Moncorvo</option>
<option>	Vila Flor</option>
<option>	Vimioso</option>
<option>	Vinhais</option>
<option>----Distrito de Castelo Branco----</option>
<option>	Belmonte</option>
<option>	Castelo Branco</option>
<option>	Covilhã</option>
<option>	Fundão</option>
<option>	Idanha-a-Nova</option>
<option>	Oleiros</option>
<option>	Penamacôr</option>
<option>	Proença-a-Nova</option>
<option>	Sertã</option>
<option>	Vila de Rei</option>
<option>	Vila Velha de Ródão</option>
<option>----Distrito de Coimbra----</option>
<option>	Arganil</option>
<option>	Cantanhede</option>
<option>	Coimbra</option>
<option>	Condeixa-a-Nova</option>
<option>	Figueira da Foz</option>
<option>	Góis</option>
<option>	Lousã</option>
<option>	Mira</option>
<option>	Miranda do Corvo</option>
<option>	Montemor-o-Velho</option>
<option>	Oliveira do Hospital</option>
<option>	Pampilhosa da Serra</option>
<option>	Penacova</option>
<option>	Penela</option>
<option>	Soure</option>
<option>	Tábua</option>
	<option>Vila Nova de Poiares</option>
<option>----Distrito de Évora----</option>
<option>	Alandroal</option>
<option>	Arraiolos</option>
	<option>Borba</option>
	<option>Estremoz</option>
<option>	Évora</option>
<option>	Montemor-o-Novo</option>
<option>	Mora</option>
<option>	Mourão</option>
<option>	Portel</option>
<option>	Redondo</option>
<option>	Reguengos de Monsaraz</option>
<option>	Vendas Novas</option>
<option>	Viana do Alentejo</option>
<option>	Vila Viçosa</option>
<option>----Distrito de Faro----</option>
<option>	Albufeira</option>
<option>	Alcoutim</option>
<option>	Aljezur</option>
<option>	Castro Marim</option>
<option>	Faro</option>
<option>	Lagoa (Algarve)</option>
<option>	Lagos</option>
<option>	Loulé</option>
<option>	Monchique</option>
<option>	Olhão</option>
<option>	Portimão</option>
<option>	São Brás de Alportel</option>
<option>	Silves</option>
<option>	Tavira</option>
<option>	Vila do Bispo</option>
<option>	Vila Real de Santo António</option>
<option>----Distrito da Guarda----</option>
<option>	Aguiar da Beira</option>
<option>	Almeida</option>
<option>	Celorico da Beira</option>
<option>	Figueira de Castelo Rodrigo</option>
<option>	Fornos de Algodres</option>
<option>	Gouveia</option>
<option>	Guarda</option>
<option>	Manteigas</option>
<option>	Mêda</option>
<option>	Pinhel</option>
<option>	Sabugal</option>
<option>	Seia</option>
<option>	Trancoso</option>
<option>	Vila Nova de Foz Côa</option>
<option>----Distrito de Leiria----</option>
<option>	Alcobaça</option>
<option>	Alvaiázere</option>
	<option>Ansião</option>
	<option>Batalha</option>
	<option>Bombarral</option>
<option>	Caldas da Rainha</option>
<option>	Castanheira de Pera</option>
<option>	Figueiró dos Vinhos</option>
<option>	Leiria</option>
<option>	Marinha Grande</option>
<option>	Nazaré</option>
	<option>Óbidos</option>
<option>	Pedrogão Grande</option>
<option>	Peniche</option>
<option>	Pombal</option>
	<option>Porto de Mós</option>
<option>----Distrito de Lisboa----</option>
<option>	Alenquer</option>
	<option>Amadora</option>
<option>	Arruda dos Vinhos</option>
<option>	Azambuja</option>
<option>	Cadaval</option>
<option>	Cascais</option>
<option>	Lisboa</option>
<option>	Loures</option>
<option>	Lourinhã</option>
<option>	Mafra</option>
<option>	Oeiras</option>
<option>	Sintra</option>
<option>	Sobral de Monte Agraço</option>
<option>	Torres Vedras</option>
<option>	Vila Franca de Xira</option>
<option>	Odivelas</option>
<option>----Distrito de Portalegre----</option>
<option>	Alter do Chão</option>
<option>	Arronches</option>
	<option>Avis</option>
	<option>Campo Maior</option>
	<option>Castelo de Vide</option>
	<option>Crato</option>
	<option>Elvas</option>
	<option>Fronteira</option>
	<option>Gavião</option>
	<option>Marvão</option>
	<option>Monforte</option>
	<option>Nisa</option>
	<option>Ponte de Sôrv
	<option>Portalegre</option>
	<option>Sousel</option>
<option>----Distrito do Porto----</option>
<option>	Amarante</option>
<option>	Baião</option>
<option>	Felgueiras</option>
<option>	Gondomar</option>
<option>	Lousada</option>
<option>	Maia</option>
<option>	Marco de Canaveses</option>
<option>	Matosinhos</option>
	<option>Paços de Ferreira</option>
	<option>Paredes</option>
<option>	Penafiel</option>
<option>	Porto</option>
<option>	Póvoa de Varzim</option>
<option>	Santo Tirso</option>
<option>	Valongo</option>
	<option>Vila do Conde</option>
	<option>Vila Nova de Gaia</option>
<option>	Trofa</option>
<option>----Distrito de Santarém----</option>
<option>	Abrantes</option>
<option>	Alcanena</option>
<option>	Almeirim</option>
<option>	Alpiarça</option>
<option>	Benavente</option>
<option>	Cartaxo</option>
<option>	Chamusca</option>
<option>	Constância</option>
<option>	Coruche</option>
<option>	Entroncamento</option>
<option>	Ferreira do Zêzere</option>
<option>	Golegã</option>
<option>	Mação</option>
<option>	Ourém</option>
<option>	Rio Maior</option>
<option>	Salvaterra de Magos</option>
<option>	Santarem</option>
	<option>Sardoal</option>
<option>	Tomar</option>
<option>	Torres Novas</option>
<option>	Vila Nova da Barquinha</option>
<option>----Distrito de Setúbal----</option>
	<option>Alcácer do Sal</option>
	<option>Alcochete</option>
	<option>Almada</option>
	<option>Barreiro</option>
	<option>Grândola</option>
	<option>Moita</option>
	<option>Montijo</option>
	<option>Palmela</option>
	<option>Santiago do Cacém</option>
	<option>Seixal</option>
	<option>Sesimbra</option>
	<option>Setúbal</option>
	<option>Sines</option>
<option>----Distrito de Viana do Castelo----</option>
	<option>Arcos de Valdevez</option>
	<option>Caminha</option>
	<option>Melgaço</option>
	<option>Monção</option>
	<option>Paredes de Coura</option>
	<option>Ponte da Barca</option>
	<option>Ponte de Lima</option>
	<option>Valença</option>
	<option>Viana do Castelo</option>
	<option>Vila Nova de Cerveira</option>
<option>----Distrito de Vila Real----</option>
	<option>Alijó</option>
	<option>Boticas</option>
	<option>Chaves</option>
	<option>Mesão Frio</option>
	<option>Mondim de Basto</option>
	<option>Montalegre</option>
	<option>Murça</option>
	<option>Peso da Régua</option>
	<option>Ribeira de Pena</option>
	<option>Sabrosa</option>
	<option>Santa Marta de Penaguião</option>
	<option>Valpaços</option>
	<option>Vila Pouca de Aguiar</option>
	<option>Vila Real</option>
<option>----Distrito de Viseu----</option>
	<option>Armamar</option>
	<option>Carregal do Sal</option>
	<option>Castro Daire</option>
	<option>Cinfães</option>
	<option>Lamego</option>
<option>	Mangualde</option>
<option>	Moimenta da Beira</option>
<option>	Mortágua</option>
	<option>Nelas</option>
	<option>Oliveira de Frades</option>
	<option>Penalva do Castelo</option>
	<option>Penedono</option>
<option>	Resende</option>
<option>	São João da Pesqueira</option>
<option>	São Pedro do Sul</option>
<option>	Santa Comba Dão</option>
<option>	Sátão</option>
<option>	Sernancelhe</option>
<option>	Tabuaço</option>
<option>	Tarouca</option>
<option>	Tondela</option>
<option>	Vila Nova de Paiva</option>
<option>	Viseu</option>
	<option>Vouzela</option>
<option>----Distrito dos Açores----</option>
	<option>Angra do Heroísmo</option>
<option>	Calheta (Açores)</option>
<option>	Corvo</option>
<option>	Horta</option>
<option>	Lagoa (Açores)</option>
<option>	Lajes das Flores</option>
<option>	Lajes do Pico</option>
<option>	Madalena</option>
<option>	Nordeste</option>
	<option>Ponta Delgada</option>
	<option>Povoação</option>
	<option>Ribeira Grande</option>
	<option>São Roque do Pico</option>
<option>	Santa Cruz da Graciosa</option>
<option>	Santa Cruz das Flores</option>
<option>	Velas</option>
<option>	Vila do Porto</option>
<option>	Vila Franca do Campo</option>
<option>	Praia da Vitória</option>
<option>----Distrito da Madeira----</option>
<option>	Calheta (Madeira)</option>
<option>	Câmara de Lobos</option>
<option>	Funchal</option>
<option>	Machico</option>
<option>	Ponta do Sol</option>
<option>	Porto Moniz</option>
<option>	Porto Santo</option>
<option>	Ribeira Brava</option>
<option>	Santa Cruz</option>
	<option>Santana</option>
<option>	São Vicente</option>
	
	
    </select></td></tr>


<tr> <td><strong>Sexo:</strong></td><td> 
<tr> <td>Masculino: <input type="radio" name="sexo" value="M" ';
if ( $sexo == "M") echo "CHECKED";
echo ' > Feminino:<input type="radio" name="sexo" value="F" ';
if ( $sexo == "F") echo "CHECKED";
echo ' ></td></tr>

<tr> <td><strong>Aniversário:</strong></td><td>
<tr> <td><strong><input type="text" name="aniversario" value="'.$aniversario.'" size="15"> (AAAA-MM-DD)</strong></td></tr>
<tr> <td>Código Postal</td><td><input type="text" name="codpost" value="'.$codpost.'" size="45"> <b>9999-999 COIMBRA</b> </td></tr>
<tr> <td><br>Li e aceito os termos de serviço <input type="checkbox" value="Steak" name="food[]"><br /></tr> </td> <br/> 
	
</table>
';	
		printf("<br><br><input type=\"submit\" value=\"%s\">",$nomebot);
		printf("</form>");

}

?> 




