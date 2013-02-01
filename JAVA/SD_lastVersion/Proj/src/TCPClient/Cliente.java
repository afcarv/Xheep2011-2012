package TCPClient;

/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
import Objects.*;

import java.io.*;
import java.net.Socket;
import java.net.SocketException;
import java.net.SocketTimeoutException;
import java.net.UnknownHostException;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;

//
/**
 *
 * classe principal, com o main, para representar player a aceder à aplicaçao distribuída
 * Esta thread servirá apenas para leitura do que é escrito no teclado pelo player.
 *
 * Paralelamente existirá uma thread para lidar com a comunicação com o servidor
 */
public class Cliente {

    int SocketReconnect;

    /**
     *
     * @param args
     */
    public static void main(String args[]) {
        new Cliente();
    }

    Cliente() {
        SocketReconnect = 0;
        init();
    }

    /**
     *
     * @param print
     */
    public void printString(String print) {
        synchronized (System.out) {
            System.out.println(print);
        }
    }

    /**
     * inicia cliente com porto 6000
     */
    public void init() {


        Socket s = null;
        int serversocket = 0;


        ServerState state = new ServerState(false);
        while (true) {
            if (SocketReconnect % 2 == 0) {
                serversocket = 6000;
            } else {
                serversocket = 6020;
            }
            try {

                synchronized (state) {
                    if (s == null) {
                        s = new Socket("localhost", serversocket);
                    }
                }
                state.setState(true);
                SocketReconnect = 0;
                Scanner read = new Scanner(System.in);
               // System.out.println("OLA!");
                state.in = new ObjectInputStream(s.getInputStream());
                //System.out.println("Cenas");
                ObjectOutputStream out = new ObjectOutputStream(s.getOutputStream());



                //cria novo objecto mensagem para enviar informação ao servidor
                Mensagem msg = new Mensagem();
                // 3o passo

//                menuLogin();

                while (true) {

                    try {
                        int option = 0;
                        //System.out.println("CHEGUEI 2");
                        Mensagem data = new Mensagem();
                        String email = "";
                        System.out.println("\n -----< MyBet-and-Win >-----\n\nSelect an Option: \n"
                                + "(1)-Register;\n(2)-Login;\n(3)-Exit;\n\n>");

                        // lê opção do teclado

                        //---------------------------
                        InputStreamReader input0 = new InputStreamReader(System.in);
                        BufferedReader reader0 = new BufferedReader(input0);

                        String op = reader0.readLine();
                        option = Integer.parseInt(op);

                        switch (option) {

                            //PASSWORD
                            case 1:
                                System.out.println("=================|Registo|===================");
                                data = new Mensagem();

                                System.out.println("Introduza o username a registar:\n> ");
                                String username = read.nextLine();
                                System.out.println("Password: \n> ");
                                String password = read.nextLine();
                                System.out.println("Email: \n> ");
                                email = read.nextLine();



                                Register sc = new Register(username, password, email);
                                out.writeObject(sc);
                                data = (Mensagem) state.in.readObject();

                                if (data instanceof Register && ((Register) data).getStatus()) {
                                    printString(((Register) data).getMsg());
                                } else {
                                    printString(((Register) data).getMsg());
                                }
                                break;


                            //LOGIN
                            case 2:
                                System.out.println("=================|Autenticação|===================");

                                data = new Mensagem();
                                System.out.print("User:\n>");
                                String user_name = read.nextLine();
                                System.out.println("Password:\n ");
                                String pass = read.nextLine();
                                Login ls = new Login(user_name, pass);
                                out.writeObject(ls);


                                data = (Mensagem) state.in.readObject();
                                if (data instanceof Login && ((Login) data).getStatus()) {
                                    printString(((Login) data).getMsg());

                                    //Apartir de aqui começa a trocar mensagem com o servidor
                                    //thread que só recebe mensagens do servidor
                                    state.toString();
                                    new Receive_msg(state.in, s, state);

                                    while (true) {
                                        String nmsg;
                                        synchronized (System.out) {
                                            System.out.println("###############################################");
                                            System.out.println(" --------< MyBet-and-Win>-----------------------");
                                            System.out.println("(1) Credit: shows the current credit of the user.");
                                            System.out.println("(2) Reset: user's credit should default to a certain number of credits (e.g. 100cr).");
                                            System.out.println("(3) View Current Matches");
                                            System.out.println("(4) Bet");
                                            System.out.println("(5) Online Users: shows a list of users who are logged in.");
                                            System.out.println("(6) Message User: sends a message to a specific user.");
                                            System.out.println("(7) Message All: sends a message to all the users.");
                                            System.out.println("(8) Logout.\n>");
                                        }
                                        // lê opção do teclado

                                        //---------------------------
                                        InputStreamReader input1 = new InputStreamReader(System.in);
                                        BufferedReader reader1 = new BufferedReader(input0);

                                        op = reader1.readLine();
                                        option = Integer.parseInt(op);


                                        switch (option) {
                                            case 1:
                                                out.writeObject(new Credit());
                                                break;
                                            case 2:
                                                System.out.println("Tem a certeza que fazer reset \n(y):yes - (n):No");
                                                InputStreamReader input = new InputStreamReader(System.in);
                                                String opt = reader1.readLine();


                                                if (opt.equals("y")) {
                                                    out.writeObject(new Reset_credit());
                                                }
                                                break;
                                            case 3:
                                                out.writeObject(new ViewMatches());
                                                break;
                                            case 4:
                                                System.out.println("Para fazer uma aposta, seleccione o jogo através do [id] e utilize o sistema 1 2 3.");
                                                printString("Introduza o código do jogo\n>");
                                                int cod = read.nextInt();
                                                read.nextLine();
                                                printString("Introduza o resultado(1 a 3):1=Vitória caseira, 2=Vitória Forasteira, 3=Empate \n>");
                                                int resul = read.nextInt();
                                                read.nextLine();
                                                printString("Introduza o valor que aposta\n>");
                                                int value = read.nextInt();
                                                read.nextLine();
                                                //public BetMatch(String username, int id, int resul, int valor, int crs)
                                                BetMatch opt2 = new BetMatch();
                                                opt2.setCrs(value);
                                                opt2.setId(cod);
                                                opt2.setResul(resul);
                                                opt2.setType(1);
                                                opt2.setValor(value);
                                                opt2.setEmissor(user_name);

                                                out.writeObject(opt2);
                                                //    public BetMatch    (String username, int id, int resul, int valor, int crs) {
                                                //out.writeObject(new BetMatch(user_name, cod,         resul,   value,        1));// coloco um 1 no final porque é a flag de tcp para as apostas

                                                break;
                                            case 5:
                                                out.writeObject(new OnlineUsers());
                                                break;
                                            case 6:
                                                printString("Introduza o username do destinatário \n>");
                                                String dest_name = read.nextLine();
                                                printString("Introduza a sua mensagem\n>");
                                                nmsg = read.nextLine();
                                                out.writeObject(new MessageUser(user_name, dest_name, nmsg));
                                                break;
                                            case 7:
                                                printString("Introduza a sua mensagem\n>");
                                                nmsg = read.nextLine();
                                                out.writeObject(new MessageAll(user_name, nmsg));
                                                break;
                                            case 8:
                                                out.writeObject(new Logout());
                                                init();
                                                break;
                                            default:
                                                break;
                                        }
                                        out.reset();
                                        out.flush();
                                    }
                                } else {//se não fizer login
                                    //mensagem de erro
                                    printString(((Login) data).getMsg());
                                }

                                break;

                            default:
                                break;


                        }

                    } catch (Exception e) {
                    }

                    // envia informação ao servidor com objecto referente à opção seleccionada
                    out.reset();
                    out.writeObject(msg);

                }
            } catch (SocketException ex) {
                s = null;
                state.setState(false);
                if (SocketReconnect < 5) {
                    System.out.println("Server down trying to connect...");
                    SocketReconnect++;
                    try {
                        Thread.sleep(5000);
                    } catch (InterruptedException ex1) {
                        Logger.getLogger(Receive_msg.class.getName()).log(Level.SEVERE, null, ex1);
                    }
                } else {
                    System.out.println("Error: Server down!Reconnect failed!Tried to connect 5 times!");
                    break;
                }
            } catch (UnknownHostException e) {
                printString("Sock:" + e.getMessage());
            } catch (EOFException e) {
                printString("EOF:" + e.getMessage());
            } catch (IOException e) {

                printString("IO:" + e.getMessage());

            } finally {
                if (s != null) {
                    try {
                        s.close();
                    } catch (IOException e) {
                        printString("close:" + e.getMessage());
                    }
                }
            }
        }


    }
}
