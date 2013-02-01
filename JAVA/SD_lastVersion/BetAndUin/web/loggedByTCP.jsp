<%--
    Document   : WrongLogin
    Created on : 20/Nov/2010, 18:12:04
    Author     : jlnabais
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <title>B&U-WrongLogin</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <center>
            <IMG src="logo_BetAndUin.png" alt="BetAndUin_Logo" height="450" width="275">
            <form action="http://localhost:8080/BetAndUin/LoginRMIServlet" method="post">
                <h3>User already logged by TCP!</h3>
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
                            <td><input type="submit" value="Login" size="10"></td>
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
