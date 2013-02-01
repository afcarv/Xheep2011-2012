package Servidor;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *@author jlnabais
 *@author afcarv
 */

import Global.*;
import Objects.*;
import RMIClient.ClientInterface;
import RMIServer.ServerRMI;
import java.io.File;

import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.SocketTimeoutException;
import java.rmi.RemoteException;
import java.util.ArrayList;
import java.util.Hashtable;
import java.util.Properties;
import java.util.logging.Level;
import java.util.logging.Logger;


public class Servidor {

    static int defaul_credit; // carrega de um ficheiro os creditos por default(100)
    static FicheiroDeObjectos fo;//ficheiro que guarda objectos
    static Hashtable <String, ObjectOutputStream>  onlineUsers;//TCP online
    static Hashtable <String, String>  teste;//TCP online
    static Hashtable<String, User> users;//todos os users registados
    static Hashtable<String, BetMatch> apostasRMI;// apostas dos jogadores RMI
    static Hashtable<String, BetMatch> apostas;// apostas dos jogadores TCP
    static IBetManager matches;// jogos gerados
    static Bets campeonato;//thread bets, que pega no que os users vao ponda nas hastables apostas e apostasRMI e diz-lhes como correu
    static Hashtable<String, ClientInterface> onlineRMI;// users rmi online
    static ServerRMI Srmi;
    static ArrayList<String> onlineHTMLString;
    static ArrayList<User> onlineHTML;
      

    Servidor() {


        propriedadesServer();
        
        users = new Hashtable<String, User>();
        apostasRMI=new Hashtable<String, BetMatch>();
        apostas=new Hashtable<String, BetMatch>();
        matches=new BetManager();
        fo = new FicheiroDeObjectos();
        campeonato=new Bets();
        onlineUsers=  new  Hashtable<String, ObjectOutputStream>();
        teste=  new  Hashtable<String, String>();
        onlineRMI=  new  Hashtable<String, ClientInterface>();
        onlineHTML = new ArrayList<User>();
        onlineHTMLString = new ArrayList<String>();
        

        
    }

    public void start(int chooser) {
        init(chooser);
        salva();
    }

    // ==== hashtable apostas-----------------------------------------------------------------------------------------------
    public static Hashtable<String, BetMatch> getApostas() {
        return apostas;
    }

    public static void setApostas(Hashtable<String, BetMatch> apostas) {
        Servidor.apostas = apostas;
    }

    // ==== arrayList html-----------------------------------------------------------------------------------------------

    public static ArrayList<User> getOnlineHTML() {
        return onlineHTML;
    }


    public static ArrayList<String> getOnlineHTMLString() {
        return onlineHTMLString;
    }



    public static void setOnlineHTML(ArrayList<User> onlineHTML) {
        Servidor.onlineHTML = onlineHTML;
    }

   

    // ==== hashtable apostasRMI-----------------------------------------------------------------------------------------------
    public static void setApostasRMI(Hashtable<String, BetMatch> apostasRMI) {
        Servidor.apostasRMI = apostasRMI;
    }
    public static Hashtable<String, BetMatch> getApostasRMI() {
        return apostasRMI;
    }

    // ====  server rmi -----------------------------------------------------------------------------------------------
    public static ServerRMI getServerRMI(){
        return Srmi;
    }

    public static void setServerRMI(ServerRMI Srmi){
        Servidor.Srmi = Srmi;
    }
    
    // ==== hashtable onlineRMI-----------------------------------------------------------------------------------------------
    public static Hashtable<String, ClientInterface> getOnlineRMI() {
        return onlineRMI;
    }
    public static void setOnlineRMI(Hashtable<String, ClientInterface> onlineRMI) {
        Servidor.onlineRMI = onlineRMI;
    }

    // ==== thread com campeonato-----------------------------------------------------------------------------------------------

    public static Bets getCampeonato() {
        return campeonato;
    }

    public static void setCampeonato(Bets campeonato) {
        Servidor.campeonato = campeonato;
    }


    // ==== ficheiro de ojectos que a carrega users-----------------------------------------------------------------------------------------------
    public static FicheiroDeObjectos getFo() {
        return fo;
    }

    public static void setFo(FicheiroDeObjectos fo) {
        Servidor.fo = fo;
    }

    // ==== object ibetmanager que trata dos jogos-----------------------------------------------------------------------------------------------
    public static IBetManager getMatches() {
        return matches;
    }

    public static void setMatches(IBetManager matches) {
        Servidor.matches = matches;
    }

    // ==== hashtable online Users-----------------------------------------------------------------------------------------------
    public static Hashtable<String, ObjectOutputStream> getOnlineUsers() {
        return onlineUsers;
    }

    public static void setOnlineUsers(Hashtable<String, ObjectOutputStream> onlineUsers) {
        Servidor.onlineUsers = onlineUsers;
    }

   public static Hashtable<String, String> getteste() {
        return teste;
    }

    public static void setteste(Hashtable<String, String> teste) {
        Servidor.teste = teste;
    }



    // ==== hashtable Users -----------------------------------------------------------------------------------------------
    public static Hashtable<String, User> getUsers() {
        return users;
    }

    public static void setUsers(Hashtable<String, User> users) {
        Servidor.users = users;
    }
   
//================================================================================================================================
    private void init(int serverPort) {
        int numero = 0;

        try {
            
            System.out.println("A Escuta no Porto "+serverPort);
            ServerSocket listenSocket = new ServerSocket(serverPort);
            System.out.println("LISTEN SOCKET=" + listenSocket);
            while (true) {
                Socket clientSocket = listenSocket.accept(); // BLOQUEANTE
                System.out.println("CLIENT_SOCKET (created at accept())=" + clientSocket);
                numero++;



                Connection ts = new Connection(clientSocket/*,Servidor.getServerRMI()*/);//encarregado da leitura

            }
        } catch (IOException e) {
            System.out.println("Listen:" + e.getMessage());
        }
    }



    // carrega ficheiro
    public synchronized void carregafich() {
        try {
            File fich = new File("PlayerDB.dat");  //Cria um objecto do tipo File
            if(fich.exists()){
                fo.abreLeitura("PlayerDB.dat");
                users = (Hashtable<String, User>) fo.leObjecto();
                fo.fechaLeitura();
                System.out.println("Ficheiro carregado com sucesso");
            }
        }catch (IOException ex) {
            Logger.getLogger(Servidor.class.getName()).log(Level.SEVERE, null, ex);
        }catch (ClassNotFoundException ex) {
            Logger.getLogger(Servidor.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    }

    // guarda ficheiro
    public static synchronized void salva(){
        try{
            fo.abreEscrita("PlayerDB.dat");
            fo.escreveObjecto(users);
            fo.fechaEscrita();
        }catch (IOException ex) {
            Logger.getLogger(Servidor.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    
    public void propriedadesServer() {

        Properties properties = new Properties();
        // read properties file.
        try {
            properties.load(new FileInputStream("filename.properties"));
        } catch (IOException e) {
        }

        // Write properties file.
        try {
            properties.store(new FileOutputStream("filename.properties"), null);
        } catch (IOException e) {
        }


        this.defaul_credit = Integer.parseInt(properties.getProperty("credito"));
    }

    
    public static void main(String args[]) {
        int chooser=serverChooser();
        System.out.println("Vai usar a porta " + chooser);
        //se os 2 servidores estiverem activos
        if(chooser==-1)
            return;

        //UDP FAILOVER!!!!
        CardioPulmunarReanimation();
        new Alive();
        
        Servidor s= new Servidor();
        s.carregafich();
         try {
            //System.out.println("RMI Server criado!");
            //servidor RMI
            //ServerRMI sr =  new ServerRMI(s);
            //Servidor.setServerRMI(sr);
             new ServerRMI(s);
            
            salva();
        } catch (RemoteException ex) {
            Logger.getLogger(Servidor.class.getName()).log(Level.SEVERE, null, ex);
        }
        //servidor TCP

        s.start(chooser);
    }

    private static int tryServer(int port) throws IOException {
        Socket primary = null;
        try {
            primary = new Socket("localhost", port);
            ObjectInputStream in = new ObjectInputStream(primary.getInputStream());
            ObjectOutputStream out = new ObjectOutputStream(primary.getOutputStream());
        } catch (IOException ex) {
            //caso não exista servidor na porta 6000 à escuta então devolvo 6000
            if (primary != null) primary.close();
            return port;
        } catch (Exception e) {
            e.printStackTrace();
        }
        return -1;
    }

    private static int serverChooser() {
        try {
            int p;
            if ((p = tryServer(6000)) != -1) return p;
            if ((p = tryServer(6020)) != -1) return p;
            return -1;

        } catch (IOException ex) {
            Logger.getLogger(Servidor.class.getName()).log(Level.SEVERE, null, ex);
        }
        return -1;
    }

    private static void CardioPulmunarReanimation() {
        try {
            DatagramSocket CPR = null;
            CPR = new DatagramSocket(2020);
            //espera 5segundos para ver se algum servidor arranca
            CPR.setSoTimeout(5000);
            while(true){
                byte[] array = new byte["I_AM_ALIVE".getBytes().length];
                DatagramPacket pacoteUDP = new DatagramPacket(array,array.length);
                CPR.receive(pacoteUDP);
            }
        }catch(SocketTimeoutException ex){
            System.out.println("Servidor em baixo, Vou assumir controlo!!!");
        }
        catch (IOException ex) {
            Logger.getLogger(Servidor.class.getName()).log(Level.SEVERE, null, ex);
        }
        finally {
            System.out.println("CRP successfully");
        }
    }
    
}


