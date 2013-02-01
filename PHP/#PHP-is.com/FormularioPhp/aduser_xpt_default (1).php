<?php defined('_JEXEC') or die('Restricted access'); 
// Access check.
if (!JFactory::getUser()->authorise('adduserfrontend.createuser', 'com_adduserfrontend')) 
{
	return JError::raiseWarning(404, JText::_('')); // display nothing because controller already does show that message also
}
?>
<?php
/*
* @Copyright Copyright (C) 2010 - Kim Pittoors
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html 
*/
//Get joomla component system params
$itemid = JRequest::getInt('Itemid', 0); 
$articleId = JRequest::getInt('id', 0);
$app = JFactory::getApplication('site');
$params =  & $app->getParams('com_adduserfrontend');
$operationmode = $params->get( 'operationmode' );
$namemode = $params->get( 'namemode' );  
$setusertype = $params->get( 'setusertype' ); 
$notificationemail = $params->get( 'notificationemail' );
$adminnotificationemail = $params->get( 'adminnotificationemail' );
$usernamemode = $params->get( 'usernamemode' );
if($usernamemode !== '1'){
$unameexist = '0';
} else {
$unameexist = $params->get( 'unameexist' );
}
//Get field of form
$emailexist = $params->get( 'emailexist' );
$passwordmode = $params->get( 'passwordmode' );
$genericemail = $params->get( 'genericemail' );  
//Get user and Groupid
$user   = &JFactory::getUser();
$uid    = $user->get('id');
//echo "user id: ".$uid;
//Set query DB
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
//Clean special chars
function clean_now($text)
{
$text=strtolower($text);
$code_entities_match = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');  
$code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','');
$text = str_replace($code_entities_match, $code_entities_replace, $text);
return $text;
} 
//End clean
//Function to create a random password
function createRandomPassword() {
$chars = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i = 0;
$pass = '' ;
while ($i < 10) {
$num = rand() % 33;
$tmp = substr($chars, $num, 1);
$pass = $pass . $tmp;
$i++;
}	
return $pass;
} // End create password
//Encrypt password for Joomla
function getCryptedPassword($plaintext, $salt = '', $encryption = 'md5-hex', $show_encrypt = false)
{
//Get the salt to use.
$salt = JUserHelper::getSalt($encryption, $salt, $plaintext);
$encrypted = ($salt) ? md5($plaintext.$salt) : md5($plaintext);
return ($show_encrypt) ? '{MD5}'.$encrypted : $encrypted;        
} //END getCryptedPassword
		
//Handle form
if(isset($_POST['import'])) {
//user helper 
jimport( 'joomla.user.helper' );
if($passwordmode == 0){
$createpassword = createRandomPassword();
$password = getCryptedPassword($createpassword, $salt= '', $encryption= 'md5-hex', $show_encrypt=false);
$showpass = $createpassword;
} else {	
$postpassword  = trim($_POST['password']);
$postpassword = clean_now($postpassword);
$password = getCryptedPassword($postpassword, $salt= '', $encryption= 'md5-hex', $show_encrypt=false);
$showpass = $postpassword;
}
//Getting name from form
if($namemode == 1){
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
} else { //For namemode == 0
$name = trim($_POST['name']);
//Get firstname and lastname
$xname = explode(" ", $name);
$firstname = $xname[0];
//Make lastname
if(!empty($xname[1])) {	
$lastname = $xname[1];	
}
if(!empty($xname[2])) {	
$lastname = $xname[1].' '.$xname[2];	
}
if(!empty($xname[3])) {	
$lastname = $xname[1].' '.$xname[2].' '.$xname[3];	
}
if(!empty($xname[4])) {	
$lastname = $xname[1].' '.$xname[2].' '.$xname[3].' '.$xname[4];	
}
if(!empty($xname[5])) {	
$lastname = $xname[1].' '.$xname[2].' '.$xname[3].' '.$xname[4].' '.$xname[5];	
}
if(!empty($xname[6])) {	
$lastname = $xname[1].' '.$xname[2].' '.$xname[3].' '.$xname[4].' '.$xname[5].' '.$xname[6];	
}
}
$divider = ' ';
if(!empty($lastname)){ //Complete name
$name = $firstname.$divider.$lastname; 
} else {
$name = $firstname;  //if name is one word
}
// Getting the username from the form or creating one based on the name //
if($usernamemode == 1){
$username  = trim($_POST['username']);
$username1 = clean_now($username);
$username = $username1;
} elseif ($usernamemode == 2) {
$username = trim($_POST['email']);
$username1 = $username;
} else {
if(empty($lastname)){ 
$username1 = $firstname; 
} else {
$lastnamesign = substr ($lastname, 0, 1);
$username1 = $firstname . '-' . $lastnamesign;
}
$username1 = str_replace (" ", "-", $username1);
$username1 = strtolower($username1); 
$username = $username1;
}
// get usertype from config //
if($setusertype == "2" || $setusertype == ""){
$usertype = '2'; // Registered //
$usertypename = 'Registered';
}
if($setusertype == "3"){
$usertype = '3'; 
$usertypename = 'Author';
}
if($setusertype == "4"){
$usertype = '4'; 
$usertypename = 'Editor';
}
if($setusertype == "5"){
$usertype = '5'; 
$usertypename = 'Publisher';
}
if($setusertype == "6"){
$custumgroup = $params->get( 'custumgroup' ); 
$usertype = $custumgroup; 
$query = mysql_query("SELECT title FROM " . $table_prefix . "usergroups WHERE id='" . $usertype . "'");
$usertypename =  mysql_result($query, 0, 0);
if($usertypename == ""){
echo '<font color="red">THE GROUPID YOU PROVIDED IS INCORRECT! FIX THIS IN YOUR SETTINGS.</font>';
}
}
//End get usertype from config
//Some other data
$block = '0';
$sendmail = '0';
$addition = rand(0,99); //Avoid Double usernames
//Check if username exists
$sql = mysql_query("SELECT username FROM " . $table_prefix . "users WHERE username='" . $username . "'");
$num_rows = mysql_num_rows($sql);
if($num_rows == 0){
$username = $username;
$usernameexists = "0";
} else {
if ($unameexist == "0") {
$username = $username.$addition;
$usernameline = "" . JText::_('THEUSERNAME') . " <strong>" . $username1 . "</strong> " . JText::_('USERCHANGENAME') . " <strong>" . $username . "</strong><br>";
echo $usernameline;
$usernameexists = "0";
} else {	
$usernameexists = "1";	
//echo 'THE USER EXISTS IN DB';
}
}
if( $genericemail == "1" ) {
// Get Domain
$domain = $_SERVER['HTTP_HOST']; 
$domain = str_replace ("www.", "", $domain);
// Make generic email
$email = $username . '@' . $domain;
$emaildoesexist = "0";  // no double email check here
} else {
$email = trim($_POST['email']);
}
if ($emailexist == "1") {	
//Check if email exists
$sql = mysql_query("SELECT email FROM " . $table_prefix . "users WHERE email='" . $email . "'");
$num_rows = mysql_num_rows($sql);
if($num_rows == 0){
$email = $email;
$emaildoesexist = "0"; 
} else {	 
$emaildoesexist = "1"; //This email already exists in the joomla user db
}
} else {
$emaildoesexist = "0"; //This email already exists in the joomla user db but we dont check for double mails so we let it pass
}	
	
if($usernameexists == "1" || $emaildoesexist == "1") { //Remember input fields
if($namemode == "1"){
setcookie("firstname", $firstname, time()+30); 
setcookie("lastname", $lastname, time()+30); 
} else {
setcookie("name", $name, time()+30); 
}
if( $genericemail !== "1" ) {	
setcookie("email", $email, time()+30); 
}
if( $passwordmode == "1" ) {
setcookie("showpass", $showpass, time()+30); 
}
if($usernamemode == "1"){
setcookie("username", $username, time()+30); 
}
}
if($emaildoesexist == "1") { //Check if email does exist
echo '<script language="JavaScript">
alert ("'.JText::_("EMAILEXISTS").'")
history.go(-1);
</script>';
} else {
if($usernameexists == "1") { // Check if username exists (and is configured not to be renamed)
echo '<script language="JavaScript">
alert ("'.JText::_("USERNAMEEXISTS").'")
history.go(-1);
</script>';
} else {
// When javascript is turned off there is no input field validation //
if($name == "" || $email == "" || $username == "" || $showpass == "") {
echo 'The system has identified you as a spambot';
} else {
if($groupid > 2) { // if at least an author
// Insert record into users
$sql1 = 'INSERT INTO ' . $table_prefix . 'users SET
`name`            = "' . $name . '",
`username`        = "' . $username .'",
`email`           = "' . $email .'",
`password`        = "' . $password .'",
`usertype`        = "' . $usertypename .'",
`block`           = "' . $block .'",
`sendEmail`       = "' . $sendmail . '",
`registerDate`    = NOW(),
`lastvisitDate`   = "0000-00-00 00:00:00",
`activation`      = "",
`params`          = ""';
mysql_query($sql1);
// Get back user's ID
list($user_id) = mysql_fetch_row(mysql_query('SELECT LAST_INSERT_ID()'));
// Insert record into user_usergroup_map
$sql2 = 'INSERT INTO ' . $table_prefix . 'user_usergroup_map SET
`group_id`        = ' . $usertype . ',
`user_id`         = LAST_INSERT_ID()
';
mysql_query($sql2);
// Insert record into Community Builder
if($operationmode == 1){
$sql3 ='INSERT INTO ' . $table_prefix . 'comprofiler SET
`id`                  = "'. $user_id . '",
`user_id`             = "'. $user_id . '",
`firstname`           = "' . $firstname . '",
`lastname`            = "' . $lastname . '",
`hits`                = "0",
`message_last_sent`   = "0000-00-00 00:00:00",
`message_number_sent` = "0",
`approved`            = "1",
`confirmed`           = "1",
`lastupdatedate`      = "0000-00-00 00:00:00",
`banned`              = "0",
`acceptedterms`       = "1"
';
mysql_query($sql3);
} //End CB mode or not
//Get userdata for export
$userdataexport = array (
"username" => "$username",
"email" => "$email",
"name" => "$name",
"password" => "$password",
"id" => "$user_id",
);
//Fire the onAfterStoreUser trigger
JPluginHelper::importPlugin('user');
$dispatcher =& JDispatcher::getInstance();
$dispatcher->trigger('onAfterStoreUser', array($userdataexport, true, true, $this->getError()));
//Start executing plugins
//Fire the onAfterStoreUser trigger for K2 synchronization
$dispatcher->trigger('onAfterStoreUserAuftoK2', array($userdataexport, true, true, $this->getError()));
// End executing plugins
//Flush
flush();
if($operationmode == 1){
echo '<br /><br /><strong>' . JText::_("ADDEDUSERTOJOOMLACB") . '!</strong><br><a href="index.php?option=com_comprofiler&task=userDetails&uid=' . $user_id . '"><strong>' . $username . '</strong></a> ' . JText::_("ADDEDUSERTOJOOMLACBTXT") . '';
}
if($operationmode == 0){
echo '<br /><br /><strong>' . JText::_("ADDEDUSERTOJOOMLA") . '</strong><br><strong>' . $username . '</strong> ' . JText::_("HASBEENADDEDTOJOOMLA") . '';
}

//send notification to added user
if($notificationemail == "1"){
$config =& JFactory::getConfig();
//Send notification email
$fromname = $config->getValue( 'config.fromname' );
$from = $config->getValue( 'config.mailfrom' );
$recipient = $email;
$subject = "".JText::_("YOURDETAILFOR")." ".$_SERVER['HTTP_HOST']."";
$body   = "".JText::_("YOUHAVEBEENADDED")." http://".$_SERVER['HTTP_HOST']."<br>".JText::_("THISMAILCONT")." http://".$_SERVER['HTTP_HOST']."<br>".JText::_("USERNAME").": ".$username."<br>".JText::_("PASSWORD").": ".$showpass."<br>".JText::_("DONOTRESPOND")."
";
//Send notification
JUtility::sendMail($from, $fromname, $recipient, $subject, $body, $mode=1, $cc=null, $bcc=null, $attachment=null, $replyto=null, $replytoname=null);
} 

//send notification to admin
if($adminnotificationemail == "1"){
$config =& JFactory::getConfig();
// Send notification email //
$fromname = $config->getValue( 'config.fromname' );
$from = $config->getValue( 'config.mailfrom' );
$recipient = $from;
$subject = "A new user has been added to ".$_SERVER['HTTP_HOST']."";
$body   = "A new user has been added to ".$_SERVER['HTTP_HOST'].". This is a copy off the emailnotification that this user received:<br>".JText::_("YOUHAVEBEENADDED")." http://".$_SERVER['HTTP_HOST']."<br>".JText::_("THISMAILCONT")." http://".$_SERVER['HTTP_HOST']."<br>".JText::_("USERNAME").": ".$username."<br>".JText::_("PASSWORD").": xxx<br>".JText::_("DONOTRESPOND")."
";
 
// Send notification //
JUtility::sendMail($from, $fromname, $recipient, $subject, $body, $mode=1, $cc=null, $bcc=null, $attachment, $replyto=null, $replytoname=null);
} 

} else {  //End at least an author
echo 'You are not authorised to view this resource. Because you are a registered user, you must be an author at least!';
} //End at least an author
} //End if-else security check -no input field 
} //End if-else double username check
} //End Check if email does exist
} else {
if($groupid > 2) { // if at least an author
	
// show upload form
echo '<script type="text/javascript">  
function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
  {
  alert(alerttxt);return false;
   }
  else
   {
   return true;
   }
  }
}
function validate_form(thisform)
{
with (thisform)
 {'; 
if( $namemode == "1" ) { 
echo 'if (validate_required(firstname,"'. JText::_( 'N0_FIRSTNAME').'")==false) {
firstname.focus();return false;}	
if (validate_required(lastname,"'.JText::_( 'N0_LASTNAME').'")==false) {
lastname.focus();return false;}';
} else {
echo 'if (validate_required(name,"'.JText::_("N0_NAME").'")==false) {
name.focus();return false;}';
}	
if( $genericemail !== "1" ) {	
echo 'if (validate_required(email,"'.JText::_( 'N0_EMAIL').'")==false) {
email.focus();return false;}';
}
if( $usernamemode == "1" ) {
echo 'if (validate_required(username,"'.JText::_( 'N0_USERNAME').'")==false) {
username.focus();return false;}';
}	
if( $passwordmode == "1" ) {
echo'if (validate_required(password,"'.JText::_( 'N0_PASSWORD').'")==false) {
password.focus();return false;}';
}	
echo '}
}
</script>';
echo '<div>
<h1>'.JText::_( 'ADD_USER').':</h1>
<form onsubmit="return validate_form(this);"  action="'.JRoute::_('index.php?option=com_adduserfrontend&Itemid='.$itemid).'" method="post" enctype="multipart/form-data">
<input type="hidden" name="import" value="1" />
<table cellpadding="4px">';
// getting data from cookies if used	 
if(isset($_COOKIE['firstname'])) {
$savedfirstname = $_COOKIE['firstname'];
} else {	
$savedfirstname ="";
}
if(isset($_COOKIE['lastname'])) {
$savedlastname = $_COOKIE['lastname'];
} else {	
$savedlastname ="";
}
if(isset($_COOKIE['name'])) {
$savedname = $_COOKIE['name'];
} else {	
$savedname ="";
}
if(isset($_COOKIE['email'])) {
$savedemail = $_COOKIE['email'];
} else {	
$savedemail ="";
}
if(isset($_COOKIE['username'])) {
$savedusername = $_COOKIE['username'];
} else {	
$savedusername ="";
}
if(isset($_COOKIE['showpass'])) {
$savedshowpass = $_COOKIE['showpass'];
} else {	
$savedshowpass ="";
}
if( $namemode == "1" ) {
echo'<tr>
<td>'.JText::_( 'FIRSTNAME').':</td>
<td><input type="text" name="firstname" value="'.$savedfirstname.'" /></td>
</tr>
<tr>
<td>'.JText::_( 'LASTNAME').':</td>
<td><input type="text" name="lastname" value="'.$savedlastname.'" /></td>
         </tr>';
} else {
echo '<tr>
<td width="130">'.JText::_( 'NAME').':</td>
<td><input type="text" name="name" value="'.$savedname.'" /></td>
</tr>';
}
if( $genericemail !== "1" ) {
echo '<tr>
<td>'.JText::_( 'EMAIL').':</td>
<td><input type="text" name="email" value="'.$savedemail.'" /></td>
</tr>';
}
if( $usernamemode == "1" ) {
echo '<tr>
<td>'.JText::_( 'USERNAME').':</td>
<td><input type="text" name="username" value="'.$savedusername.'" /></td>
</tr>';
}
if( $passwordmode == "1" ) {
	
echo '<tr>
<td>'.JText::_( 'PASSWORD').':</td>
<td><input type="text" name="password" value="'.$savedshowpass.'" /></td>
</tr>';
}
   
echo '<tr>
<td></td>
<td><input type="submit" name="submit" value="'.JText::_( 'ADDNOW').'" /></td>
</tr>
</table>
</form>
</div>';	  
} else {
echo 'You are not authorised to view this resource. Because you are a registered user, you must be an author at least!';
}
}
?>