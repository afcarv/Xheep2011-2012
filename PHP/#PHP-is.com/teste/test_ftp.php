<?php
   
   include('ftp01.php');    

   $out="ola mundo";
   
uploadmy($out);
// coloca-os no 43 por ftp
//este é uploadmy




   
?>


<table border =0>
<tr><td><strong>ftp</strong> </td><td> <input style="text-align:left" type="text" name="email" size="60" value="<?php include('ftp01.php'); uploadmy("olá mundo");?>" class="sel2" onChange="checkEmail(this.value)">
<tr><td><strong>ftp</strong></td><td><input style="text-align:left" type="text" name="email" size="60" value="<?php include('test_ftp.php'); uploadmy($out);?>" class="sel2" onChange="checkEmail(this.value)">




</table>	
</p>