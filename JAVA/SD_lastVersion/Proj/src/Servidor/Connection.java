package Servidor;

/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
import Objects.*;
import RMIClient.ClientInterface;
import RMIServer.ServerRMI;

import java.io.EOFException;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.Socket;
import java.rmi.RemoteException;
import java.util.Collection;
import java.util.Enumeration;
import java.util.Hashtable;

import java.util.Scanner;
import java.util.Set;
import java.util.logging.Level;
import java.util.logging.Logger;

//= Thread para tratar de cada canal de comunicacao com um cliente
class Connection extends Thread {

    ObjectInputStream in;
    ObjectOutputStream out;
    Socket clientSocket;
    int thread_number;
    Scanner read;
    FicheiroDeObjectos fo;
    static Hashtable<String, ClientInterface> onlineRMI;
    int default_credit;


    /**
     * 
     * @param aClientSocket
     */
    public Connection(Socket aClientSocket/*,ServerRMI sr*/) {

        fo = new FicheiroDeObjectos();
        this.default_credit = Servidor.defaul_credit;

        try {
            clientSocket = aClientSocket;
            //ServerRMI srmi = sr;
            //onlineRMI = sr.getOnlineRMI2();
            out = new ObjectOutputStream(clientSocket.getOutputStream());
            in = new ObjectInputStream(clientSocket.getInputStream());

            read = new Scanner(System.in);
            this.start();
        } catch (IOException e) {
            System.out.println("Connection:" + e.getMessage());
        }
    }
    //=============================

    @Override
    public void run() {
        // String resposta;
        try {
            while (true) {
                //an echo server
                Mensagem data = new Mensagem();
                User nuser = null;

                try {
                    data = (Mensagem) in.readObject();

                } catch (ClassNotFoundException ex) {
                    Logger.getLogger(Connection.class.getName()).log(Level.SEVERE, null, ex);
                }
//================================================= MENU LOGIN ============================================================0
                //(1) - Register
                if (data instanceof Register) {


                    if (!Servidor.users.containsKey(((Register) data).getUserName())) {
                        Servidor.users.put(((Register) data).getUserName(), new User(((Register) data).getUserName(), ((Register) data).getPassword(), ((Register) data).getEmail(), default_credit));

                        ((Register) data).setStatus(true);
                        ((Register) data).setMsg("Registado com sucesso");
                        Servidor.salva();        //grava ficheiro de objecto
                        sendM(((Register) data));
                    } else {
                        ((Register) data).setStatus(false);
                        ((Register) data).setMsg("Ja existe utilizador com esse username");
                        sendM(((Register) data));
                    }

                    //(2) - Login-----------------------------------------------------------------------------------------------
                } else if (data instanceof Login) {

                    String u = data.getEmissor();
                    nuser = Servidor.users.get(((Login) data).getUserN());     //o utilizador em si
                    /*
                   Set<String> view = Servidor.onlineRMI.keySet();
                   Set<String> view2 = Servidor.onlineUsers.keySet();
                   Set<String> view3 = Servidor.users.keySet();

                   Set<String> view4 = Servidor.teste.keySet();

                    System.out.println("A tentar logar o sujeito:"+u);
                    System.out.println("Lista de online TCP:"+view2);
                    System.out.println("Lista de todos os users:"+view3);
                    System.out.println("Lista de online rmi:"+view);
                    
                                        System.out.println("Nova lista:"+view4);

                    String GETu = "";
                     * 
                     */
                   Object[]view = Servidor.onlineHTML.toArray();

                   // System.out.println("----------------"+view);
                    
                    if(Servidor.onlineRMI.containsKey(u)){
                        ((Login) data).setStatus(false);
                        ((Login) data).setMsg("User já está online via RMI");
                        sendM(((Login) data));
                    }

                    else if(Servidor.onlineHTMLString.contains(u))
                    {
                        ((Login) data).setStatus(false);
                        ((Login) data).setMsg("User já está online via HTML");
                        sendM(((Login) data));
                    }

                    
                    else if(Servidor.users.containsKey(((Login) data).getUserN()) && Servidor.onlineUsers.containsKey(((Login) data).getUserN()) ) {

                        //                        if (Servidor.onlineRMI.containsKey(((Login) data).getUserN())) {
                        ((Login) data).setStatus(false);
                        ((Login) data).setMsg("User já está online via TCP");
                        sendM(((Login) data));

                        //                      }

                        //verifica se esta na lista e faz login
                    } //}
                    else if (Servidor.users.containsKey(((Login) data).getUserN()) && Servidor.users.get(((Login) data).getUserN()).getPassword().equals(((Login) data).getPassword())) {
                        Servidor.users.get(((Login) data).getUserN()).setStatus(true);
                        nuser = Servidor.users.get(((Login) data).getUserN());     //o utilizador em si
                        Servidor.onlineUsers.put(nuser.getUserName(), this.out);

                        ((Login) data).setStatus(true);
                        ((Login) data).setMsg("Login com sucesso");
                        sendM(((Login) data));
                        logado(nuser);
                        //nao faz login porque username ou password estao incorrectos
                    } else {
                        ((Login) data).setStatus(false);
                        ((Login) data).setMsg("Username ou password incorrecto");
                        sendM(((Login) data));
                    }
                }


            }
        } catch (EOFException e) {
            System.out.println("EOF:" + e);
        } catch (IOException e) {
            System.out.println("IO:" + e);
        }
    }
//================================================= show MENU ============================================================0

    /**
     * 
     * @param Nuser
     */
    public void logado(User Nuser) {

        while (Nuser != null && Nuser.getStatus()) {
            Mensagem data = new Mensagem();

            try {

                data = (Mensagem) in.readObject();

                //(1) - view credits-----------------------------------------------------------------------------------------------
                if (data instanceof Credit) {
                    ((Credit) data).setCredit(Servidor.users.get(Nuser.getUserName()).getCredit());
                    sendM(((Credit) data));


                    //(2) -  reset do credito(passa a default)-----------------------------------------------------------------------------------------------
                } else if (data instanceof Reset_credit) {
                    Nuser.setCredit(default_credit);
                    Servidor.users.get(Nuser.getUserName()).setCredit(default_credit);
                    ((Reset_credit) data).setMsg("O seu credito agora é: " + default_credit);
                    sendM(((Reset_credit) data));


                    //(3) - view matches -----------------------------------------------------------------------------------------------
                } else if (data instanceof ViewMatches) {
                    String msgs = "";

                    //campeonato é a hashtable com os jogos todos
                    msgs = Servidor.campeonato.showMatches();
                    ((ViewMatches) data).setMsg(msgs);
                    sendM(((ViewMatches) data));//cast para msg normal

                    //(4) - bet -----------------------------------------------------------------------------------------------
                } else if (data instanceof BetMatch) {
                    if (((BetMatch) data).getValor() <= Servidor.users.get(((BetMatch) data).getEmissor()).getCredit() && Servidor.campeonato.validaMatche(((BetMatch) data).getId())) {
                        Servidor.users.get(((BetMatch) data).getEmissor()).setCredit(Servidor.users.get(((BetMatch) data).getEmissor()).getCredit() - ((BetMatch) data).getValor());   //subtrai o valor apostado ao credito do cliente
                        int cr = Nuser.getCredit();
                        synchronized (Servidor.apostas) {

                            ((BetMatch) data).setCrs(cr);
                            // se o id do jogo em que vai apostar e valido
                            // se tem creditos suficientes para apostar
                            // >>>>> insere aposta na Hastable apostas---
                            Servidor.apostas.put(((BetMatch) data).getEmissor(), ((BetMatch) data));
                        }
                    } else if (!Servidor.campeonato.validaMatche(((BetMatch) data).getId())) {
                        ((BetMatch) data).setMsg("Aposta no jogo [" + ((BetMatch) data).getId() + "] negada porque a ronda já acabou");
                        sendM((BetMatch) data);

                    } else {
                        ((BetMatch) data).setMsg("Aposta no jogo [" + ((BetMatch) data).getId() + "] negada porque o valor da aposta é superior ao seu crédito");
                        sendM((BetMatch) data);
                    }
                    //(5) cliente quer ver os users que estão online-----------------------------------------------------------------------------------------------
                } else if (data instanceof OnlineUsers) {
                    String mss = "";
                    Enumeration ps = Servidor.getOnlineUsers().keys();
                    while (ps.hasMoreElements()) {
                        String ma = ((String) ps.nextElement());
                        if (!(ma.equals(((OnlineUsers) data).getEmissor()))) {
                            mss += " \n" + ma;
                        }
                    }
                    Enumeration rmiclients = Servidor.getOnlineRMI().keys();
                    while (rmiclients.hasMoreElements()) {
                        String ma = ((String) rmiclients.nextElement());
                        if (!(ma.equals(((OnlineUsers) data).getEmissor()))) {
                            mss += " \n" + ma;
                        }
                    }

                    for(User usr:Servidor.getOnlineHTML()){
                        mss +=" \n " + usr.getUserName();
                    }
                    

                    ((OnlineUsers) data).setMsg(mss);
                    sendM((OnlineUsers) data);

                    // (6) cliente quer enviar mensagem para um determinado user-----------------------------------------------------------------------------------------------
                } else if (data instanceof MessageUser) {
                    if (Servidor.getOnlineUsers().containsKey(((MessageUser) data).getDestinatario())) {
                        Servidor.getOnlineUsers().get(((MessageUser) data).getDestinatario()).writeObject((MessageUser) data);
                        //para o próprio user envia mensagem de sistema
                        ((MessageUser) data).setMsg("Mensagem enviada com sucesso");
                        sendM(((MessageUser) data));

                    } else if (Servidor.getOnlineRMI().containsKey(((MessageUser) data).getDestinatario())) {
                        ClientInterface CI = Servidor.getOnlineRMI().get(((MessageUser) data).getDestinatario());
                        CI.receiveAssinchMsg(((MessageUser) data).getMsg(), ((MessageUser) data).getEmissor());
                    } else {
                        ((MessageUser) data).setMsg("Não foi possivel enviar msg. O user não existe ou não se encontra online");
                        sendM(((MessageUser) data));
                    }

                    // (7) Messafge to all -----------------------------------------------------------------------------------------------
                } else if (data instanceof MessageAll) {

                    Enumeration ps = Servidor.getOnlineUsers().keys();
                    while (ps.hasMoreElements()) {
                        String ma = ((String) ps.nextElement());
                        if (!ma.equals(((MessageAll) data).getEmissor())) {
                            Servidor.getOnlineUsers().get(ma).writeObject((data));
                        }
                    }


                    Collection<ClientInterface> ref_clients = Servidor.getOnlineRMI().values();
                    ClientInterface[] rc = (ClientInterface[]) ref_clients.toArray(new ClientInterface[ref_clients.size()]);

                    ClientInterface CI;
                    for (int i = 0; i < rc.length; i++) {
                        CI = rc[i];
                        CI.receiveAssinchMsg((((MessageAll) data).getMsg()), (((MessageAll) data).getEmissor()));
                    }


                    ((MessageAll) data).setMsg("Mensagem enviada com sucesso");
                    sendM(((MessageAll) data));

                }
                // (8) - logout -----------------------------------------------------------------------------------------------
                else if (data instanceof Logout) {
                    // ((Logout) data).setMsg("Logout com sucesso");
                    Nuser.setStatus(false);
                    Servidor.onlineUsers.remove(Nuser.getUserName());
                    sendM(((Logout) data));
                    Servidor.salva();

                    //this.out.close();
                    // this.in.close();
                    // clientSocket.close();

                    return;
                }

            } catch (IOException ex) {
                return;
                //Logger.getLogger(Connection.class.getName()).log(Level.SEVERE, null, ex);
            } catch (ClassNotFoundException ex) {
                return;
                //Logger.getLogger(Connection.class.getName()).log(Level.SEVERE, null, ex);
            }
            Servidor.salva();
        }

    }

    //
    /**
     *envia msg recebida para tds os clientes
     * @param msg
     */
    void sendM(Mensagem msg) {
        synchronized (this.out) {
            try {
                out.writeObject(msg);
            } catch (IOException ex) {
                Logger.getLogger(Connection.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
}
