package Servlets;

import Objects.BetMatch;
import RMIClient.ClientInterface;
import RMIClient.ClientRMI;
import RMIServer.ServerInterface;
import Servidor.User;
import java.io.IOException;
import java.rmi.NotBoundException;
import java.rmi.RemoteException;
import java.util.Hashtable;
import java.util.Map;
import java.util.Set;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.RequestDispatcher;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.apache.catalina.comet.CometEvent;
import org.apache.catalina.comet.CometProcessor;

/**
 * 
 * @author Andre Lourenco, aglour@student.dei.uc.pt
 */
public class ChatServlet extends HttpServlet implements CometProcessor {

    private static final long serialVersionUID = -7025063881838597634L;
    // The clients Map is used to associate a specific user id with a particular
    // HttpServletResponse object. This way if, later on, we want to send
    // something to the client's socket, we can retrieve the HttpServletResponse.
    private static Map<String, HttpServletResponse> clients = new Hashtable<String, HttpServletResponse>();

    // Method called when a client is registers with the CometProcessor
    private void addClient(String nickName, HttpServletResponse clientResponseObject) {
        ChatServlet.clients.put(nickName, clientResponseObject);
        // TODO 1: Write your code here.
    }

    // Method called after an Exception is thrown when the server tries to write to a client's socket.
    private void removeClient(String nickName, HttpServletRequest request) {
        if (ChatServlet.clients.remove(nickName) != null) {
            // TODO 2: Write your code here
        }
    }

    // Main method that handles all the assynchronous calls to the servlet.
    // Receives a CometEvent object, that might have three types of EventType:
    // - BEGIN (when the connection starts. It is used to initialize variables and register the callback
    // - READ (means that there is data sent by the client available to be processed.
    // - END (happens when the connection is terminated, to clean variables and so on.
    // - ERROR (Happens when some IOException is thrown when writing/reading the connection.
    public void event(CometEvent event) throws IOException, ServletException {

        // request and response exactly like in Servlets
        HttpServletRequest request = event.getHttpServletRequest();
        HttpServletResponse response = event.getHttpServletResponse();

        // Parse the something from "?type=something" in the URL.
        String reqType = request.getParameter("type");

        // Initialize the SESSION and Cache headers.
        HttpSession session = request.getSession();
        String sessionId = session.getId();
        User usr = (User) session.getAttribute("userinfo");
        String nickName = usr.getUserName();
        System.out.println("Nick: " + nickName);
        System.out.println("SESSION: " + sessionId);
        response.setHeader("Pragma", "no-cache");
        response.setHeader("Cache-control", "no-cache");
        // Disabling the cache, means that the browser will _always_ call this code.


        // Let's see which even is being processed right now.
        System.out.println("Event:" + event.getEventType() + ".");

        // Since the "event" method is called for every kind of event, we have to decide what to do
        // based on the Event type. There for we check for all 4 kinds of events: BEGIN, READ, END and ERROR
        if (event.getEventType() == CometEvent.EventType.BEGIN) {
            // A connection is initiliazed

            if (reqType != null) {
                if (reqType.equalsIgnoreCase("register")) {
                    // Register will add the client HttpServletResponse to the callback array and start a streamed response.

                    // This header is sent to keep the connection open, in order to send future updates.
                    response.setHeader("Content-type", "application/octet-stream");

                    // Let's save the HttpServletResponse with the nickName key.
                    //  That response object will act as a callback to the client.

                    //*****************PROJ B&U***************

                    try {
                        //como o cliente HTML não vai ser mais nem menos que um cliente RMI
                        //cirar objecto de callback
                        ClientInterface CI = new ClientRMI(response);
                        //por o objecto de stub na session
                        session.setAttribute("stubobject", CI);
                        //ir buscar o serverRMI
                        ServerInterface rmiServer = (ServerInterface) session.getAttribute("RMIServer");
                        //adicionar cliente à lista RMI(LOGIN)
                        rmiServer.addRMIClient(nickName, CI);
                        //colocar a response na session
                        session.setAttribute("response", response);

                    } catch (RemoteException ex) {
                        Logger.getLogger(ChatServlet.class.getName()).log(Level.SEVERE, null, ex);
                    } catch (NotBoundException ex) {
                        Logger.getLogger(ChatServlet.class.getName()).log(Level.SEVERE, null, ex);
                    }

                }
                else if(reqType.equalsIgnoreCase("bet"))
                {
                    System.out.println("BET");

                    String id = request.getReader().readLine().trim();
                    String result = request.getReader().readLine().trim();
                    String credit = request.getReader().readLine().trim();
                    

                    betGame(id, credit, result, session);
                    event.close();
                }
                else if (reqType.equalsIgnoreCase("exit")) {
                    // if the client wants to quit, we do it.
                    removeClient(nickName, request);
                }
            }
        } else if (event.getEventType() == CometEvent.EventType.READ) {
            // READ event indicates that input data is available
            // The first line read indicates the destination user.
            String dest = request.getReader().readLine().trim();
            // If it is 'allusers',the message should be delivered to all users
            // The second line is the message itself.
            String msg = request.getReader().readLine().trim();

            // For debug purposes
            System.out.println("msg = [" + msg + "] to " + dest);

            if (msg != null && !msg.isEmpty()) {
                if (dest.equals("allusers")) {
                    sendMessageToAll(msg, session, nickName);
                } else {
                    sendMessage(msg, session, nickName, dest);
                }
            }
            event.close();
        } else if (event.getEventType() == CometEvent.EventType.ERROR) {
            // In case of any error, we terminate the connection.
            // The connection remains in cache anyway, and it's later removed
            // when an Exception at write-time is raised.
            event.close();
        } else if (event.getEventType() == CometEvent.EventType.END) {
            // When the clients wants to finish, we do it the same way as above.
            event.close();
        }
    }

    private void sendMessageToAll(String message, HttpSession session, String user_name) {
        try {
            ServerInterface serverRMI = (ServerInterface) session.getAttribute("RMIServer");
            User player = new User(user_name, null);
            serverRMI.messageA(message, player);
        } catch (RemoteException ex) {
            System.out.println(ex.getMessage());
        }
    }

    private void sendMessage(String message, HttpSession session, String user_name, String dest) {
        // This method sends a message to a specific user
        try {
            ServerInterface serverRMI = (ServerInterface) session.getAttribute("RMIServer");
            User player = new User(user_name, null);
            serverRMI.messageS(message, dest, player);
        } catch (RemoteException ex) {
            System.out.println(ex.getMessage());
        }
    }

    private void betGame(String id, String credit, String bet, HttpSession session)
    {
        try
        {
            User temp = (User) session.getAttribute("userinfo");
            ServerInterface rmiServer = (ServerInterface) session.getAttribute("RMIServer");
            ClientInterface CI = (ClientInterface) session.getAttribute("stubobject");
            HttpServletResponse r = (HttpServletResponse)session.getAttribute("response");

            int[] ids = rmiServer.getMatchIDs();
            int int_id = ids[Integer.parseInt(id)];
            int int_credit = Integer.parseInt(credit);
            int int_bet = Integer.parseInt(bet);

            System.out.println("id = " + int_id + " credit = " + int_credit + " bet = " + int_bet);

            BetMatch b = new BetMatch();

            System.out.println("temp.getCredit()" + temp.getCredit());
            b.setId(int_id);
            b.setCrs(temp.getCredit());
            b.setResul(int_bet);
            b.setType(3);
            b.setValor(int_credit);
            b.setEmissor(temp.getUserName());

            rmiServer.betGame(temp.getUserName(), b, CI);

            System.out.println("APOSTADO");
            r.getWriter().println("APOSTADO !!");
            r.getWriter().flush();
        }
        catch (RemoteException ex)
        {
            System.out.println(ex.getMessage());
        }
        catch (IOException ex)
        {
            System.out.println(ex.getMessage());
        }




    }
}
