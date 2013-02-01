package RMIClient;

import Objects.*;
import RMIServer.ServerInterface;
import Servidor.*;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.rmi.AccessException;
import java.rmi.registry.Registry;
import java.rmi.server.UnicastRemoteObject;
import java.rmi.registry.LocateRegistry;
import java.rmi.NotBoundException;
import java.rmi.RemoteException;
import java.net.MalformedURLException;
import java.net.Socket;
import java.util.ArrayList;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.http.HttpServletResponse;

/**
 *
 * @author jlnabais
 * @author afcarv
 *
 */
public class ClientRMI extends UnicastRemoteObject implements ClientInterface {

    public static void main(String args[]) {
        try {
            ClientRMI cl = new ClientRMI();

        } catch (RemoteException ex) {
            System.out.println("Server offline.");
            System.exit(0);
        } catch (NotBoundException ex) {
            System.out.println("Server unreachable.");
            System.exit(0);
        }
    }
    private static final long serialVersionUID = 1L;
    int rmiport = 7000;
    String hostaname;
    ServerInterface server;
    HttpServletResponse response;


    public ClientRMI() throws RemoteException, NotBoundException {
        try {
            //betHouse -  este nome identifica o objecto que o servidor regustou no registry, para o cliente lhe aceder
            Registry registry = LocateRegistry.getRegistry(7000);
            for (String n : registry.list()) {
                System.out.println("> " + n);
            }
            server = (ServerInterface) registry.lookup("betHouse");
            menu();
        } catch (RemoteException ex) {
            ex.printStackTrace();
            System.out.println("Server offline.");
            System.exit(0);
        }
    }

    public ClientRMI(HttpServletResponse response) throws RemoteException, NotBoundException{
        this.response=response;
    }

    /**
     * menu login
     */
    private void menu() {

        int option = 0;
        Scanner read = new Scanner(System.in);
        while (true) {
            try {
                String email = "";
                System.out.println("\n -----< MyBet-and-Win >-----\n\nSelect an Option: \n" + "(1)-Register;\n(2)-Login;\n(3)-Exit;\n\n>");
                // lê opção do teclado
                //---------------------------
                InputStreamReader input0 = new InputStreamReader(System.in);
                BufferedReader reader0 = new BufferedReader(input0);
                String op;

                op = reader0.readLine();

                option = Integer.parseInt(op);

                switch (option) {
                    //PASSWORD
                    case 1:
                        System.out.println("=================|Registo|===================");
                        System.out.println("Introduza o username a registar:\n> ");
                        String username = reader0.readLine();
                        System.out.println("Password: \n> ");
                        String password = reader0.readLine();
                        System.out.println("Email: \n> ");
                        email = reader0.readLine();
                        Register reg = new Register(username, password, email);
                        server.register(reg);
                        break;
                    case 2:
                        System.out.println("=================|Login|===================");
                        System.out.println("Introduza o username para fazer o Login:\n> ");
                        String user = reader0.readLine();
                        System.out.println("Password: \n> ");
                        String pass = reader0.readLine();

                        Login log = new Login(user, pass);

                        User player = new User(user, pass);
                        player.setCredit(100);

                        if (server.login(log, player,(ClientInterface) this)) {
                            this.init((ClientInterface) this, user);
                            showMenu(user, pass, player);
                        }else
                            System.out.println("Falhou autenticação. User já logado ou Username e/ou passowrd incorrectas introduza os dados novamente:");
                        break;
                }
            } catch (IOException ex) {
                Logger.getLogger(ClientRMI.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    /**menu principal onde são evocados todos os métodos
     *
     * @param user
     * @param pass
     */
    private void showMenu(String user, String pass,User Player) {
        String op = null;
        int option = 0;


        User player = new User("", "", "", 0);

        player.setUsername(user);
        player.setPassword(pass);
        while (true) {// uma vez logado e até fazer logout, cada vez que faz uma chamada de método, no final
            // retorna aqui, onde o menu é de novo impresso

            try {
                // uma vez logado e até fazer logout, cada vez que faz uma chamada de método, no final
                // retorna aqui, onde o menu é de novo impresso
                synchronized (System.out) {
                    System.out.println("###############################################");
                    System.out.println(" --------< MyBet-and-Win>-----------------------");
                    System.out.println("(1) Credit: shows the current credit of the user.");
                    System.out.println("(2) Reset: userʼs credit should default to a certain number of credits (e.g. 100cr).");
                    System.out.println("(3) View Current Matches");
                    System.out.println("(4) Bet");
                    System.out.println("(5) Online Users: shows a list of users who are logged in.");
                    System.out.println("(6) Message User: sends a message to a specific user.");
                    System.out.println("(7) Message All: sends a message to all the users.");
                    System.out.println("(8) Logout.\n>");
                }
                // lê opção do teclado
                // lê opção do teclado
                //---------------------------
                InputStreamReader input1 = new InputStreamReader(System.in);
                BufferedReader reader1 = new BufferedReader(input1);
                op = reader1.readLine();
                option = Integer.parseInt(op);

                System.out.println("Hi " + player.getUserName() + ". Here are the result of your call");
                switch (option) {
                    case 1:
                        System.out.println("------ (1) - CREDITS------------------------------------------");
                        int receive = server.credits(player);
                        System.out.println("[Server]>" + receive + " créditos.");
                        System.out.println("-----------------------------------------------------------------");
                        break;

                    case 2:
                        System.out.println("--------(2) - RESET-------------------------------------------------");
                        String receive1 = server.reset(player);
                        System.out.println("[Server]" + receive1 + " créditos.");
                        System.out.println("-----------------------------------------------------------------");
                        break;

                    case 3:
                        System.out.println("-----------(3) - VIEW MATCH-----------------------------------------");
                        server.view(player,this);
                        
                        System.out.println("-----------------------------------------------------------------");
                        break;

                    case 4:

                        int Crs = Player.getCredit();
                        System.out.println("Os seus creditos:"+Crs);
                        
                        System.out.println("--------------- (4) - BET ------------------------------------------");
                        // tenho de preencher objecto do tpo betmatch (String username, int id, int resul, int valor)
                        System.out.println("Para fazer uma aposta, seleccione o jogo através do [id] e utilize o sistema 1 2 3.");
                        System.out.println("Insira o id do jogo em que pretende apostar\n>");
                        String idJogo = reader1.readLine();
                        System.out.println("Insira o número de créditos que pretende apostar\n>");
                        String val = reader1.readLine();
                        System.out.println("Insira a sua aposta para o jogo. (1). Vitória da equipa da casa; (2).Vitória da equipa Visitante; (3).Empate;\n>");
                        String res = reader1.readLine();
                        //--------------------------------------------------------------
                        //gets:
                        String userN = Player.getUserName();
                        
                        // parseints:
                        int id = Integer.parseInt(idJogo);
                        int result = Integer.parseInt(res);
                        int valor = Integer.parseInt(val);

                        /*TCP«««««
                         * BetMatch opt2 = new BetMatch();
                                                opt2.setCrs(value);
                                                opt2.setId(cod);
                                                opt2.setResul(resul);
                                                opt2.setType(1);
                                                opt2.setValor(value);
                                                opt2.setEmissor(user_name);
                                                out.writeObject(opt2);
                         */

                         BetMatch bM = new BetMatch();
                         bM.setType(2);
                         bM.setId(id);
                         bM.setEmissor(userN);
                         bM.setResul(result);
                         bM.setValor(valor);
                         bM.setCrs(Crs);

//objecto: public BetMatch(String username, int id, int resul, int valor, int crs) {

                        // ENVIO--->  username| id do jogo | resultado do jogo| valor a apostar|
                        //BetMatch bM = new BetMatch(userN, id, result, valor, Crs); // chamada em callback equivalente à de tcp

                        server.betGame(userN, bM, this);


                        // ja estou a enviar dados da aposta



                        //preciso de receber


                        //String receive3 = server.betGame(player);
                        //System.out.println("[Server]" + receive3);

                        System.out.println("-----------------------------------------------------------------");
                        break;
                    case 5:
                        System.out.println("----------- (5) - Online -------------------------------------------");
                        ArrayList<String> temp = server.viewOnline(player);
                        for (int i = 0; i < temp.size(); i++) {
                            System.out.println(temp.get(i));
                        }
                        System.out.println("-----------------------------------------------------------------");
                        break;
                    case 6:
                        System.out.println("----------(6)- SEND MESSAGE to user ---------------------------------------------");
                        System.out.println("Insira a mensagem\n>");
                        String msg = reader1.readLine();
                        System.out.println("Insira o destinatário");
                        String receptor = reader1.readLine();

                        // chama message User com mensagem (string) a enviar e receptor que é o destinatario
                        server.messageS(msg, receptor, player);

                        System.out.println("-----------------------------------------------------------------");
                        break;
                    case 7:
                        System.out.println("-----------(7)- SEND MESSAGE TO ALL -----------------------------------------------");
                        System.out.println("Insira a mensagem\n>");
                        String msg1 = reader1.readLine();

                        server.messageA(msg1, player);

                        System.out.println("-----------------------------------------------------------------");
                        break;
                    case 8:
                        System.out.println("--------(8)- Logout----------------------------------------------");
                        server.lOut(player);
                        
                        menu();
                        break;
                }
            } catch (IOException ex) {
                Logger.getLogger(ClientRMI.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    // método de callback para tratar message to all
    public void receiveAssinchMsg(String msg, String emissor) throws RemoteException {
        try {
            //servidor faz callback ao chamar este método com String a enviar e o
            System.out.println("[" + emissor + "]" + msg);
            this.response.getWriter().println("[" + emissor + "]" + msg+"<br/>");
            this.response.getWriter().flush();
        } catch (IOException ex) {
            Logger.getLogger(ClientRMI.class.getName()).log(Level.SEVERE, null, ex);
        }


    }

    private void init(ClientInterface ci, String user) {
        try {
            server.subs((ClientInterface) this, user);
        } catch (RemoteException ex) {
            Logger.getLogger(ClientRMI.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public String messageAll(MessageAll mall) throws RemoteException {

        String emissor = mall.getEmissor();
        String men = mall.getMsg();
        System.out.print("[" + emissor + "] says:" + men);
        return men;
    }

    public String messageUser(MessageAll mall) throws RemoteException {

        String emissor = mall.getEmissor();
        String men = mall.getMsg();
        System.out.print("[" + emissor + "] says:" + men+"<br/>");
        return men;
    }

    public void messageUser(MessageUser objectM) throws RemoteException {
        throw new UnsupportedOperationException("Not supported yet.");
    }
}
