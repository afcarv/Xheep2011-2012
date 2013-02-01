<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>B&U-Login</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <center>
            <IMG src="logo_BetAndUin.png" alt="BetAndUin_Logo" height="450" width="275">
            <form action="http://localhost:8080/BetAndUin/LoginRMIServlet" method="post">
                    <table>
                        <tr valign="top">
                            <td><h1>Username:</h1></td>
                            <td><input type="text" name="username" size="10"</td>
                        </tr>
                        <tr valign="top">
                            <td><h1>Password:</h1></td>
                            <td><input type="password" name="password" size="10"></td>
                        </tr>
                        <tr valign="top">
                            <td><h1><a style="text-decoration:none" href="MenuRegister.jsp">Register!</a></h1></td>
                        </tr>
                        <tr valign="top">
                            <td><input type="submit" value="login" size="10"></td>
                        </tr>
                    </table>
            </form>
        </center>
        <h5>
            <p align="right" valign="bottom">
                afcarv©
                <br>
                jlnabais©
            </p>
        </h5>
    </body>
</html>
