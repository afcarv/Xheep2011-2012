package RMIServer;

/**
 *@author jlnabais
 *@author afcarv
 */
import Objects.*;
import RMIClient.ClientInterface;
//import Servidor.Bets;
import Servidor.User;
import java.io.ObjectOutputStream;
import java.rmi.RemoteException;
import java.rmi.Remote;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.Hashtable;

// referências para os métodos definidos no server
public interface ServerInterface extends Remote {

    //----------------- MENU LOGIN----------------------------
    public boolean register(Mensagem data) throws RemoteException;

    public boolean login(Mensagem data, User player, ClientInterface CI) throws RemoteException;

//----------------- SHOW LOGIN----------------------------
    public int credits(User player) throws RemoteException;

    public String reset(User player) throws RemoteException;

    public void view(User playe, ClientInterface CI) throws RemoteException;

    public void betGame(String player, BetMatch bM, ClientInterface CI) throws RemoteException;

    public ArrayList<String> viewOnline(User player) throws RemoteException;

    public void messageS(String msg, String receptor, User player) throws RemoteException;

    public void messageA(String msg, User player) throws RemoteException;

    public boolean lOut(User player) throws RemoteException;

    //------------------- MÉTODOS AUXILIARES --------------------------------
    public String subs(ClientInterface ci, String user) throws RemoteException;

    public Hashtable<String, ObjectOutputStream> getOnlineTCP() throws RemoteException;

    public Hashtable<String, User> getUsers() throws RemoteException;

    public Hashtable<String, ClientInterface> getOnlineRMI() throws RemoteException;

    public ArrayList<String> AllOnline() throws RemoteException;

    public ArrayList<String> getAllOnline() throws RemoteException;

    public void addAllOnline(String valorS) throws RemoteException;

    public boolean loginDB(Mensagem data, User player) throws RemoteException;

    public ArrayList<User> getOnlineHTML() throws RemoteException;

    public ArrayList<String> getOnlineHTMLString() throws RemoteException;

    public void setOnlineHTML(ArrayList<User> onlineHTML) throws RemoteException;

    public void addHTMLUser(User temp) throws RemoteException;

    public void addHTMLUserString(String temp) throws RemoteException;

    public void deleteHTMLUser(int i) throws RemoteException;

    public ArrayList<String> getOU() throws RemoteException;

    public ArrayList<String> getHTMLm() throws RemoteException;

    public int[] getMatchIDs() throws RemoteException;

    public ClientInterface getCI(String nome) throws RemoteException;

    public void addRMIClient(String nome, ClientInterface CI)throws RemoteException;

    public void deleteRMIClient(String usr) throws RemoteException;
}
