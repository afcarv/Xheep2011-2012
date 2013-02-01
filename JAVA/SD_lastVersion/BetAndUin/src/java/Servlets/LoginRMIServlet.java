/**
 *
 * @author jlnabais
 * @author afcarv
 */
package Servlets;

import Objects.Mensagem;
import Objects.New;
import RMIClient.ClientInterface;
import RMIServer.ServerInterface;
import Servidor.User;

import java.io.IOException;
import java.io.ObjectOutputStream;
import java.rmi.AccessException;
import java.rmi.NotBoundException;
import java.rmi.RemoteException;
import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.Hashtable;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.RequestDispatcher;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

public class LoginRMIServlet extends HttpServlet {

    private static final long serialVersionUID = 7018776304205707925L;
    private final String HTML_START = "<html><head></head><body>";
    private final String HTML_END = "</body></html>";
    private Registry registry;
    private ServerInterface rmiServer;
    ArrayList<New> notlist;

    @Override
    public void init() throws ServletException {
        try {
            registry = LocateRegistry.getRegistry(7000);
            rmiServer = (ServerInterface) registry.lookup("betHouse");
        } catch (AccessException e) {
            System.out.println(e.getMessage());
        } catch (RemoteException e) {
            System.out.println(e.getMessage());
        } catch (NotBoundException e) {
            System.out.println(e.getMessage());
        }
        SoccerReader2 scr2 = new SoccerReader2();
        notlist = scr2.getGuardian2("Portugal", "sport");

    }

    @Override
    public void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {

        RequestDispatcher dispatcher = null;
        HttpSession session = request.getSession(true);
        User auth = (User)session.getAttribute("userinfo");

        if(auth != null)
        {
            ServerInterface rmi = (ServerInterface)session.getAttribute("RMIServer");

            Hashtable<String, Servidor.User> users = rmi.getUsers();

            auth = users.get(auth.getUserName());
            
            session.setAttribute("userinfo", auth);
            session.setAttribute("gamesinfo", rmiServer.getHTMLm());
            session.setAttribute("userlist", rmiServer.AllOnline());
            session.setAttribute("newslist", notlist);

            dispatcher = request.getRequestDispatcher("/MainMenu.jsp");
            dispatcher.forward(request, response);
        }
        else
        {

            /* LOGIN DATA *********************************************************/
            String username = request.getParameter("username");
            String password = request.getParameter("password");

            Servidor.User temp = new User(username, password);
            String str = "login from servlet";
            Mensagem msg = new Mensagem(username, str);

            /**********************************************************************/



            if (rmiServer.loginDB(msg, temp))
            {
                //se o utilizador se encontrar na Base de Dados(ou sejá está registado)
                if (loggedByRMI(temp))
                {
                    //se ja estiver logado por RMI
                    dispatcher = request.getRequestDispatcher("/loggedByRMI.jsp");
                } else if (loggedByTCP(temp)) {
                    //se ja estiver logado por TCP
                    dispatcher = request.getRequestDispatcher("/loggedByTCP.jsp");
                } else if (loggedByHTML(temp)) {
                    //se ja estiver logado por HTML
                    dispatcher = request.getRequestDispatcher("/loggedByHTML.jsp");
                } else {


                    Hashtable<String, Servidor.User> users = rmiServer.getUsers();
                    //adiciona o utilizador como logado por HTML
                    rmiServer.addHTMLUser(temp);

                    rmiServer.addHTMLUserString(username);

                    temp = users.get(temp.getUserName());
                    session.setAttribute("userinfo", temp);
                    session.setAttribute("gamesinfo", rmiServer.getHTMLm());
                    session.setAttribute("userlist", rmiServer.AllOnline());
                    session.setAttribute("RMIServer", rmiServer);


                    session.setAttribute("newslist", notlist);

                    dispatcher = request.getRequestDispatcher("/MainMenu.jsp");
                }
            } else {

                dispatcher = request.getRequestDispatcher("/WrongLogin.jsp");
            }
            dispatcher.forward(request, response);
        }
    }

    @Override
    public void doPost(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {
        doGet(request, response);
    }

    private boolean loggedByRMI(User usr) {
        boolean response = false;
        try {
            Hashtable<String, ClientInterface> onlineRMI = rmiServer.getOnlineRMI();
            Enumeration<String> Usr_rmi = onlineRMI.keys();

            while (Usr_rmi.hasMoreElements()) {
                String user = usr.getUserName();
                if (user.equals(Usr_rmi.nextElement())) {
                    response = true;
                    break;
                }
            }
        } catch (RemoteException ex) {
            System.out.println(ex.getMessage());
        }
        return response;
    }

    private boolean loggedByTCP(User usr) {
        boolean response = false;
        //ta a dar bode na linha a seguir...
        ArrayList<String> onlineTCP = null;
        try {
            onlineTCP = rmiServer.getOU();
            for (String a : onlineTCP) {
                if (a.equals(usr.getUserName())) {
                    response = true;
                    break;
                }
            }
        } catch (RemoteException ex) {
            System.out.println(ex.getMessage());
        }

        return response;
    }

    private boolean loggedByHTML(User temp) {
        boolean response = false;
        try {
            ArrayList<User> html_usr = rmiServer.getOnlineHTML();
            for (User user : html_usr) {
                if (user.getUserName().equals(temp.getUserName())) {
                    response = true;
                }
                break;
            }
        } catch (RemoteException ex) {
            Logger.getLogger(LoginRMIServlet.class.getName()).log(Level.SEVERE, null, ex);
        }
        return response;
    }
}
