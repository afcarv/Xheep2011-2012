<%-- 
    Document   : RegisterFailure
    Created on : 21/Nov/2010, 19:01:14
    Author     : jlnabais
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <title>B&U-Register</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <form action="http://localhost:8080/BetAndUin/RegisterRMIServlet" method="post">
            <font size="3" color="#FFFF00" face="Britannic Bold">
                <table>
                    <tr>
                        <td><h1>Username:</h1></td>
                        <td><input type="text" name="username" size="10"</td>
                        <td><h3>Username already registred choose another!</h3></td>
                    </tr>
                    <tr>
                        <td><h1>Password:</h1></td>
                        <td><input type="password" name="password" size="10"></td>
                    </tr>
                    <tr>
                        <td><h1>E-mail:</h1></td>
                        <td><input type="text" name="email" size="10"></td>
                    </tr>
                    <tr>
                        <td><h1>Credits:</h1></td>
                        <td><h1>100</h1></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Register" size="10"></td>
                    </tr>
                </table>
            </font>
        </form>
        <h5>
            <p align="right" valign="bottom">
                afcarv©
                <br>
                jlnabais©
            </p>
        </h5>
    </body>
</html>
