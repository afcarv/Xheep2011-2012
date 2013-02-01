package RMIServer;

import Global.*;
import Objects.*;
import RMIClient.*;
import RMIServer.*;
import Servidor.*;
import java.io.IOException;
import java.io.ObjectOutputStream;
import java.util.Enumeration;
import java.util.logging.Level;
import java.util.logging.Logger;
import Global.*;
import RMIClient.*;
import Global.IBetManager;
import Objects.*;
import Servidor.*;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectOutputStream;
import java.rmi.AccessException;
import java.rmi.server.UnicastRemoteObject;
import java.rmi.registry.LocateRegistry;
import java.rmi.NotBoundException;
import java.rmi.RemoteException;
import java.net.MalformedURLException;
import java.net.ServerSocket;
import java.net.Socket;
import java.rmi.registry.Registry;
import java.util.*;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.Properties;

/**
 *
 * @author jlnabais
 * @author afcarv
 * 
 */
public class ServerRMI extends UnicastRemoteObject implements ServerInterface {

    static int defaul_credit;
    static FicheiroDeObjectos fo;
    static Hashtable<String, ObjectOutputStream> onlineUsers;
    static Hashtable<String, User> users;
    static Hashtable<String, BetMatch> apostasRMI;
    static Hashtable<String, BetMatch> apostas;
    static Bets campeonato;
    static ArrayList<User> onlineHTML;
    static IBetManager matches;
    static ArrayList<String> todos;
    static Hashtable<String, ClientInterface> onlineRMI;
    static ArrayList<String> onlineHTMLString;
    static Servidor ss;

    /**
     *
     * @param s
     * @throws RemoteException
     */
    public ServerRMI(Servidor s) throws RemoteException {
        //onlineUsers = s.getOnlineUsers();
        users = s.getUsers();
        apostasRMI = s.getApostasRMI();
        apostas = s.getApostas();
        campeonato = s.getCampeonato();
        matches = s.getMatches();
        onlineUsers = s.getOnlineUsers();
        onlineRMI = s.getOnlineRMI();
        onlineHTML = s.getOnlineHTML();
        onlineHTMLString = s.getOnlineHTMLString();
        fo = s.getFo();
        ss = s;
        todos = new ArrayList<String>();
        s.propriedadesServer();
        init();
    }

    //=======================  MENU LOGIN ==================================================
    /**(1) register
     * 
     * @param data
     * @throws RemoteException
     */
    public boolean register(Mensagem data) throws RemoteException {
        boolean result = false;

        if (!ServerRMI.users.containsKey(((Register) data).getUserName())) {
            ServerRMI.users.put(((Register) data).getUserName(), new User(((Register) data).getUserName(), ((Register) data).getPassword(), ((Register) data).getEmail(), 100));

            ((Register) data).setStatus(true);
            ((Register) data).setMsg("Registado com sucesso");
            this.salva();        //grava ficheiro de objecto
            result = true;


        } else {
            ((Register) data).setStatus(false);
            ((Register) data).setMsg("Ja existe utilizador com esse username");
        }
        return result;
    }

    /** (2) Login
     * @param data
     * @return
     * @throws RemoteException
     */
    public boolean loginDB(Mensagem data, User player) throws RemoteException {

        String username = player.getUserName();
        String password = player.getPassword();
        boolean check = false;


        Collection<User> usernames = users.values();
        //passa a collection de User para um array de User
        User[] usrs = (User[]) usernames.toArray(new User[usernames.size()]);
        for (int i = 0; i < usrs.length; i++) {
            if (usrs[i].getUserName().equals(username) && usrs[i].getPassword().equals(password)) {
                check = true;
                break;
            }
        }

        return check;
    }

    public boolean login(Mensagem data, User player, ClientInterface CI) throws RemoteException {
        String username = player.getUserName();
        String password = player.getPassword();
        boolean check = false;
        //ClientInterface cL = player.getClientInterface();       
        Collection<User> usernames = users.values();
        //passa a collection de User para um array de User
        User[] usrs = (User[]) usernames.toArray(new User[usernames.size()]);
        for (int i = 0; i < usrs.length; i++) {
            if (!onlineRMI.containsKey(username)) {
                if (!onlineUsers.containsKey(username)) {
                    if (!onlineHTMLString.contains(username)) {
                        if (usrs[i].getUserName().equals(username) && usrs[i].getPassword().equals(password)) {
                            check = true;
                            break;
                        }
                    } else {
                        System.out.println("Já logado via HTML!");
                    }

                } else {
                    System.out.println("Já logado via TCP!");
                }

            } else {
                System.out.println("Já logado via RMI!");
            }
        }

        return check;
    }

    /**
     *
     * @param Nuser
     * @throws RemoteException
     */
    public void logado(User Nuser) throws RemoteException {

        System.out.println("LOGOU");

        while (Nuser != null && Nuser.getStatus()) {
        }
    }

    //=======================  SHOW LOGIN ==================================================
    /**(1)- credits
     * 
     * @param Player
     * @return
     * @throws RemoteException
     */
    public int credits(User Player) throws RemoteException {
        String u = Player.getUserName();
        System.out.println("-----------------credits-----------------");
        System.out.println("user " + u + "a aceder aos métodos do server");
        User x;
        x = users.get(Player.getUserName());
        int uc = x.getCredit();
        System.out.println(x.getCredit());
        return uc;// devolve user credit
    }

    /**(2)- reset
     *
     * @param Player
     * @return
     * @throws RemoteException
     */
    public String reset(User Player) throws RemoteException {
        String u = Player.getUserName();
        User x;
        x = users.get(Player.getUserName());
        x.setCredit(100);
        String uc = "O seu saldo foi actualizado para:" + x.getCredit();
        return uc;// devolve user credit

    }

    /**(3)- view match
     *
     * @param Player
     * @return
     * @throws RemoteException
     */
    public void view(User Player, ClientInterface CI) throws RemoteException {

        String sV = "";
        sV = campeonato.showMatches();
        String username = Player.getUserName();

        System.out.println("user:" + username);
        try {
            //callback;
            CI.receiveAssinchMsg(sV, username);
        } catch (RemoteException ex) {
            Logger.getLogger(ServerRMI.class.getName()).log(Level.SEVERE, null, ex);
        }


    }

    /**(4)- Bet
     *
     * @param Player
     * @return
     * @throws RemoteException
     */
    public void betGame(String Player, BetMatch bM, ClientInterface CI) throws RemoteException {

        System.out.println("recebeu bM");
        // AQUI RECEBO O USERNAME, ID DO JOGO, VALOR DA APOSTA E RESULTADO DA APOSTA
        int valor = bM.getValor();
        int cr = bM.getCrs();

        System.out.println(" bM conteúdo: valor " + valor + " e creditos " + cr);
        String res;
        // 1º é preciso verificar se o user tem créditos para fazer a sua aposta:
        if (bM.getValor() <= bM.getCrs()) {
            System.out.println("ok, tem creditos suficientes");
            int id = bM.getId();
            int UpdatedCrd = cr - valor;
            // 2º é preciso verificar se o jogo que o user está a tesntar apostar é válido
            System.out.println("ID:" + id);

            synchronized (campeonato) {

                boolean as = campeonato.validaMatche(id);
                if (as) {
                    System.out.println("id válido, actualiza credito do user");
                    users.get(Player).setCredit(UpdatedCrd);

                    //synchronized (apostasRMI) {
                    synchronized (apostas) {
                        System.out.println("insere agora na hashtable");
                        //apostasRMI.put(Player, bM);
                        apostas.put(Player, bM);
                    }

                } else if (!campeonato.validaMatche(id)) {
                    res = "Aposta no jogo [" + id + "] negada porque a ronda já acabou";
                    try {
                        CI.receiveAssinchMsg(res, "[BetServer]");
                    } catch (RemoteException ex) {
                        Logger.getLogger(ServerRMI.class.getName()).log(Level.SEVERE, null, ex);
                    }
                } else {
                    res = "Aposta no jogo [" + id + "] negada porque o valor da aposta é superior ao seu crédito";
                    try {
                        CI.receiveAssinchMsg(res, "[BetServer]");
                    } catch (RemoteException ex) {
                        Logger.getLogger(ServerRMI.class.getName()).log(Level.SEVERE, null, ex);
                    }
                }
            }


        }
        // String nada = null;
        //return nada;

    }

    /**(5)- viewOnline
     *
     * @param Player
     * @return
     * @throws RemoteException
     */
    public ArrayList<String> viewOnline(User Player) throws RemoteException {
        ArrayList<String> Users = new ArrayList<String>();
        Enumeration<String> Usr_tcp = onlineUsers.keys();
        Enumeration<String> Usr_rmi = onlineRMI.keys();
        //ir buscar os utilizadores tcp logados
        while (Usr_tcp.hasMoreElements()) {
            String temp = Usr_tcp.nextElement();
            Users.add(temp);
        }
        //ir buscar os utilizadores rmi logados
        while (Usr_rmi.hasMoreElements()) {
            String temp = Usr_rmi.nextElement();
            Users.add(temp);
        }

        for (User usr : Servidor.getOnlineHTML()) {
            String temp2 = usr.getUserName();
            Users.add(temp2);
        }


        //ordenar por ordem alfabetica a arraylist
        Collections.sort(Users);
        //imprimir todos os utilizadores
        return Users;

    }

    /**(6)- send message
     *
     * @param Player
     * @return
     * @throws RemoteException
     */
    public void messageS(String msg, String receptor, User Player) throws RemoteException {
        // Player é o emissor
        // receptor é o destinatário
        String nome = Player.getUserName();
        ClientInterface CI;
        ObjectOutputStream OOS;
        //se o receptor estiver online
        if (onlineRMI.containsKey(receptor)) {
            CI = onlineRMI.get(receptor);
            try {
                // chama método do cliente por callback com a mensagem string a enviar e o nome do emissor
                CI.receiveAssinchMsg(msg, nome);
            } catch (RemoteException ex) {
                Logger.getLogger(ServerRMI.class.getName()).log(Level.SEVERE, null, ex);
            }
        } else if (onlineUsers.containsKey(receptor)) {
            try {
                OOS = onlineUsers.get(receptor);
                MessageUser data = new MessageUser(nome, receptor, msg);
                OOS.writeObject(data);
            } catch (IOException ex) {
                Logger.getLogger(ServerRMI.class.getName()).log(Level.SEVERE, null, ex);
            }

        } else {
            System.out.println("o receptor indicado não se encontra on-line de momento!");
        }


    }

    /**(7)- message to all
     *
     * @param Player
     * @return
     * @throws RemoteException
     */
    public void messageA(String msg, User Player) throws RemoteException {
        String nome = Player.getUserName();
        //****enviar para clientes RMI
        //Objecto que guarda a referência do emissor, para não enviar para ele próprio!
        ClientInterface aux = onlineRMI.get(nome);
        //guardar todas as referencias de clientes numa collection, e posteriormente num array
        Collection<ClientInterface> ref_clients = onlineRMI.values();
        ClientInterface[] rc = (ClientInterface[]) ref_clients.toArray(new ClientInterface[ref_clients.size()]);
        ClientInterface CI;
        for (int i = 0; i < rc.length; i++) {
            CI = rc[i];
            if (rc[i] != aux) {
                try {
                    CI.receiveAssinchMsg(msg, nome);
                } catch (RemoteException ex) {
                    Logger.getLogger(ServerRMI.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
        }

        //****enviar para clientes TCP
        //Objecto que guarda a stream do emissor para posteriormente não enviar a menssagem para ele próprio
        ObjectOutputStream aux2 = onlineUsers.get(nome);
        //guarda todos os output's streams dos users logados na collection
        Collection<ObjectOutputStream> OutStreamClients = onlineUsers.values();
        ObjectOutputStream[] oc = (ObjectOutputStream[]) OutStreamClients.toArray(new ObjectOutputStream[OutStreamClients.size()]);
        for (int i = 0; i < oc.length; i++) {
            if (oc[i] != aux2) {
                try {
                    MessageAll data = new MessageAll(msg);
                    oc[i].writeObject(data);
                } catch (IOException ex) {
                    Logger.getLogger(ServerRMI.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
        }
    }

    /**(8)- logout
     *
     * @param Player
     * @return
     * @throws RemoteException
     */
    public boolean lOut(User Player) throws RemoteException {

        boolean devolve = true;
        String devolve1 = "Logout com sucesso";
        Player.setStatus(false);
        ServerRMI.onlineRMI.remove(Player.getUserName());

        ServerRMI.salva();


        return devolve;


    }

    /**
     * core do server
     */
    private void init() {
        ServerRMI s;
        Registry r;



        try {
            r = LocateRegistry.createRegistry(7000);
            //ServerInterface stub = (ServerInterface) UnicastRemoteObject.exportObject(s);
            r.rebind("betHouse", this);




        } catch (RemoteException ex) {
            Logger.getLogger(ServerRMI.class.getName()).log(Level.SEVERE, null, ex);
        }



        int numero = 0;



    }

    // guarda ficheiro
    public static synchronized void salva() {
        try {
            fo.abreEscrita("PlayerDB.dat");
            fo.escreveObjecto(users);
            fo.fechaEscrita();



        } catch (IOException ex) {
            Logger.getLogger(Servidor.class.getName()).log(Level.SEVERE, null, ex);
        }


    }

    public String subs(ClientInterface ci, String user) throws RemoteException {
        String ola = null;

        /**
         * vai pôr o user na hashtable eo     ci
         */
        onlineRMI.put(user, (ClientInterface) ci);



        return ola;




    }

    public Hashtable<String, User> getUsers() throws RemoteException {
        return users;


    }

    public Hashtable<String, ClientInterface> getOnlineRMI() throws RemoteException {
        return onlineRMI;


    }

    public ArrayList<String> getOU() throws RemoteException {
        Enumeration<String> strs = onlineUsers.keys();
        ArrayList<String> aux = Collections.list(strs);


        return aux;




    }

    public Hashtable<String, ObjectOutputStream> getOnlineTCP() throws RemoteException {
        return onlineUsers;


    }

    public static Hashtable<String, ClientInterface> getOnlineRMI2() throws RemoteException {
        return onlineRMI;


    }

    public static void setOnlineRMI2(Hashtable<String, ClientInterface> onlineRMI) {
        ServerRMI.onlineRMI = onlineRMI;


    }

    public ArrayList<User> getOnlineHTML() throws RemoteException {
        return onlineHTML;


    }

    public ArrayList<String> getOnlineHTMLString() throws RemoteException {
        return onlineHTMLString;


    }

    public void setOnlineHTML(ArrayList<User> onlineHTML) throws RemoteException {
        ServerRMI.onlineHTML = onlineHTML;


    }

    public synchronized void addHTMLUser(User temp) throws RemoteException {
        ServerRMI.onlineHTML.add(temp);


    }

    public synchronized void addHTMLUserString(String temp) throws RemoteException {
        ServerRMI.onlineHTMLString.add(temp);


    }

    public synchronized void deleteHTMLUser(int i) throws RemoteException {
        onlineHTML.remove(i);


    }

    public ArrayList<String> getAllOnline() throws RemoteException {
        return todos;


    }

    public void addAllOnline(String valorS) throws RemoteException {
        todos.add(valorS);


    }

    public ArrayList<String> AllOnline() throws RemoteException {
        todos = new ArrayList<String>();
        Enumeration<String> Usr_tcp = onlineUsers.keys();
        Enumeration<String> Usr_rmi = onlineRMI.keys();

        //ir buscar os utilizadores tcp logados

        while (Usr_tcp.hasMoreElements()) {
            String temp = Usr_tcp.nextElement();
            todos.add(temp);
        }
        //ir buscar os utilizadores rmi logados
        while (Usr_rmi.hasMoreElements()) {
            String temp = Usr_rmi.nextElement();
            todos.add(temp);
        }
         //ordenar por ordem alfabetica a arraylist
        Collections.sort(todos);
        //imprimir todos os utilizadores

        return todos;
    }

    public ArrayList<String> getHTMLm() throws RemoteException {

        String recebe = campeonato.showMatches2();
        ArrayList<String> temp = new ArrayList<String>();
        String[] aux = recebe.split(" vs ");



        int j = 0;


        for (String i : aux) {
            temp.add(i.substring(0, i.length()));


        }
        return temp;


    }

    public int[] getMatchIDs() throws RemoteException {
        String recebe = campeonato.showMatches2();
        int[] ids = new int[8];
        int i = 0;

        for (IMatch m : campeonato.getMan().getMatches()) {
            ids[i] = Integer.parseInt(m.getCode());
            i++;
        }
        return ids;
    }

    public ClientInterface getCI(String nome) throws RemoteException {
        ClientInterface aux = onlineRMI.get(nome);
        return aux;
    }

    //Parte Proj2
    public void addRMIClient(String nome, ClientInterface CI) throws RemoteException {
        this.onlineRMI.put(nome, CI);
    }
    public void deleteRMIClient(String usr) throws RemoteException{
        if(onlineRMI.containsKey(usr))
            this.onlineRMI.remove(usr);
    }
}
