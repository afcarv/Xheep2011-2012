/**
 *
 * @author jlnabais
 * @author afcarv
 */

package Servlets;

import Objects.Mensagem;
import Objects.Register;
import RMIServer.ServerInterface;
import Servidor.User;

import java.io.IOException;
import java.rmi.AccessException;
import java.rmi.NotBoundException;
import java.rmi.RemoteException;
import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;
import javax.servlet.RequestDispatcher;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
/**
 *
 * @author jlnabais
 */
public class RegisterRMIServlet extends HttpServlet{
    private static final long serialVersionUID = 7018776304205707925L;
    private final String HTML_START = "<html><head></head><body>";
    private final String HTML_END = "</body></html>";
    private Registry registry;
    private ServerInterface rmiServer;

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
    }

    @Override
    public void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {
        String username = request.getParameter("username");
        String password = request.getParameter("password");
        String email = request.getParameter("email");

        Register aux = new Register(username, password, email);
        
        RequestDispatcher dispatcher = null;
        boolean temp=rmiServer.register(aux);
        if(temp){
            HttpSession session = request.getSession(true);

            session.setAttribute("userReg", aux);

            dispatcher = request.getRequestDispatcher("/RegisterSuccess.jsp");
        } else{

            dispatcher = request.getRequestDispatcher("/RegisterFailure.jsp");
        }
        dispatcher.forward(request, response);

    }
    @Override
    public void doPost(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {
        doGet(request, response);
    }
}
