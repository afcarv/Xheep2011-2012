<%--
    Document   : MainMenu
    Created on : 20/Nov/2010, 18:09:42
    Author     : jlnabais
--%>

<%@page import="Objects.New"%>
<%@page import="java.util.ArrayList"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="Servidor.User" %>
<%@page import="java.lang.*" %>

<jsp:include page="auth_verification.jsp"></jsp:include>

<html>
    <head>
        <title>B&U-Menu</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <%
                    Servidor.User user = (Servidor.User) session.getAttribute("userinfo");
                    ArrayList<String> gamelist = (ArrayList<String>) session.getAttribute("gamesinfo");
                    ArrayList<String> userlist = (ArrayList<String>) session.getAttribute("userlist");
                    ArrayList<New> notlist = (ArrayList<New>) session.getAttribute("newslist");
        %>
        <table>
            <tr>
                <td>
                    <IMG src="logoMainMenu.png" alt="BetAndUin_MMLogo" height="150" width="75">
                </td>
                <td valign="bottom">
                    <h2><%=user.getUserName()%></h2>
                    <h2>Credits:<%=user.getCredit()%></h2>
                </td>
                <td valign="bottom">
                    <form action="http://localhost:8080/BetAndUin/ResetRMIServlet" method="post">
                        <h2>
                            <input type="submit" value="Reset" size="10">
                        </h2>
                    </form>
                </td>
                <td valign="bottom">
                    <form action="http://localhost:8080/BetAndUin/LogoutRMIServlet" method="post">
                        <h2>
                            <input type="submit" value="Logout" size="10">
                        </h2>
                    </form>
                </td>
            </tr>
        </table>
        <table>
            <td>
                <table align=left border="0">
                    <%
                                int j = 0;
                                for (int i = 0; i < gamelist.size(); i = i + 2) {
                                    out.println("<tr>");
                                    out.println("<form name=\"" + j + "\">");
                                    out.println("<td><input type=\"hidden\" value=\"0\"/></td>");
                                    out.println("<td><input type=\"radio\" name=\"bet\" value=\"1\"><h2>" + gamelist.get(i) + "</h2></input></td>");
                                    out.println("<td><input type=\"radio\" name=\"bet\" value=\"3\"><h2>Draw</h2></input></td>");
                                    out.println("<td><input type=\"radio\" name=\"bet\" value=\"2\"><h2>" + gamelist.get(i + 1) + "</h2></input></td>");
                                    out.println("<td><input type=\"text\" name=\"credit\" size=\"3\"/></td>");
                                    out.println("<td><input type=\"button\" onclick=\"betGame(this.form)\" value=\"Bet\"/></td>");
                                    out.println("</form>");
                                    out.println("</tr>");
                                    j++;
                                }
                    %>
                </table>
            <td>
            <td ROWSPAN=17 align="left" valign="top">
            <h7>
                <div id="chatbox">
                </div>
                <br>
                <h2>Send To:</h2><select id="combobox" name="chat" onChange="MM_jumpMenu('parent',this,0)">
                    <option value="All">All</option>
                    <%
                                for (String i : userlist) {
                    %>
                    <option value=<%=i%>><%=i%></option>
                    <%
                                }
                    %>
                </select>
                <br>
                <input type="text" id="message" size="75">
                <input type="button" onclick="sendMsg()" name="buttonsend" value="Send">
            </h7>
        </td>
        <td ROWSPAN=17 align="left" valign="top">
            <h4>
                Online Users:
            </h4>
            <h2>
                <%
                            for (String i : userlist) {
                                out.println(i);
                                out.println("<br>");
                            }
                %>
            </h2>
        </td>
        <td ROWSPAN=17 align="left" valign="top">
            <h4>
                News:
            </h4>
            <h2>
                <%
                            for (New I : notlist) {
                                String body = I.getHeadline();
                                out.println(body);
                                out.println("<br>");
                            }
                %>
            </h2>
        </td>
    </table>

    <h5>
        <p align="right" valign="bottom">
            afcarv©
            <br>
            jlnabais©
        </p>
    </h5>
</body>
<script type="text/javascript" src="comet.js"> </script>
<script type="text/javascript">

    // Initiate Comet object
    var comet = Comet("http://localhost:8080/BetAndUin/");
    var board = document.getElementById("chatbox");

    // Register with Server for COMET callbacks.
    comet.get("ChatServlet?type=register", function(response) {
        // updates the message board with the new response.
        board.innerHTML = response;
    });

    function sendMsg() {
        var msg = document.getElementById("message").value;
        var dest = document.getElementById("combobox").value;

        if (dest == "All") {
            msg = "allusers\n" + msg;
        }
        else {
            msg = dest + "\n" + msg;
        }

        comet.post("ChatServlet", msg, function(response) {
            // Do Nothing
        })
        // Clears the value of the message element
        document.getElementById('message').value = '';
    }

    function betGame(form)
    {
        var id = form.name;
        var credit = form.credit.value;

        var counter = -1;
        for(var i =0; form.bet.length; i++)
        {
            if(form.bet[i].checked == true)
            {
                counter = i;
                break;
            }
        }

        if(counter!=-1 && credit>0)
        {
            var result = form.bet[counter].value;
            // MATCH ID
            // RESULT
            // VALUE
            var betp = id+"\n"+result+"\n"+credit;

            comet.post("ChatServlet?type=bet", betp, function(response)
            {
                alert(response);
                board.innerHTML = response;
            })
        }
        else{
            alert("Introduza correctamente os parametros da aposta");
        }
    }
    function quitChat() {
        comet.post("ChatServlet?type=exit", '', function(response) {
            // Exits browser
            window.location='about:blank';
        })
    }


    //This makes the browser call the quitChat function before unloading(or closing) the page
    window.onunload = quitChat;
</script>
</html>