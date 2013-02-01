/**
 * 
 * @author afcarv
 * @author jlnabais
 */
package TCPClient;


import Objects.*;
import java.io.EOFException;


import java.io.IOException;
import java.io.ObjectInputStream;
import java.net.Socket;
import java.net.SocketException;
import java.util.logging.Level;
import java.util.logging.Logger;



//Thread para o cliente receber as mensagens 
public class Receive_msg extends Thread{


    ObjectInputStream in;
    Socket s;
    ServerState state;

    public Receive_msg(ObjectInputStream receive,Socket s, ServerState state){
        this.in=receive;
        this.s=s;
        this.state=state;
        this.start();
    }

    /**
     * recebe objectos do servidor e consoante o tipo de objecto, um tipo diferente de opção está a ser tratada
     */
    public void run(){
        int SocketReconnect=0;
        while (true) {// READ FROM SOCKET
            Mensagem data=new Mensagem();
            int serversocket=0;
            if(SocketReconnect%2==0)
                serversocket = 6000;
            else
                serversocket = 6020;
            try {
                synchronized(state){
                    if(s==null)
                        s = new Socket("localhost", serversocket);
                }
                state.setState(true);
                SocketReconnect=0;
                data = (Mensagem) this.in.readObject();
                    synchronized(System.out){
                     //cliente quer ver o seu credito
                        if(data instanceof  Credit){
                            System.out.println("=================|Credtis|===================");
                            System.out.println(((Credit)data).getCredit());
                            System.out.println("---------------------------------------------------");

                        //cliente quer fazer reset do credito(passa a default)
                        }else if(data instanceof  Reset_credit){
                            System.out.println("=================|Reset|===================");
                            System.out.println(((Reset_credit)data).getMsg());
                            System.out.println("---------------------------------------------------");


                        //
                        }else if(data instanceof  ViewMatches){
                                    System.out.println("=================|matches|===================");
                            System.out.println(((ViewMatches)data).getMsg());
                            System.out.println("---------------------------------------------------");

                        //
                        }else if(data instanceof  BetMatch){
                            System.out.println("=================|Bet|===================");
                            System.out.println(((BetMatch)data).getMsg());
                            System.out.println("---------------------------------------------------");

                        //cliente quer ver o users que estão online
                        }else if(data instanceof  OnlineUsers){
                            System.out.println("=================|Online Users|===================");
                            System.out.println(((OnlineUsers)data).getMsg());
                            System.out.println("---------------------------------------------------");

                        //cliente quer enviar mensagem para um determinado user
                        }else if(data instanceof  MessageUser){

                            System.out.println("==============|Recieved Message from "+((MessageUser)data).getEmissor()+"|===================");
                            System.out.println(((MessageUser)data).getMsg());
                            System.out.println("---------------------------------------------------");

                        }else if(data instanceof  MessageAll){
                            System.out.println("=================|Received Message to All|===================");
                            System.out.println(((MessageAll)data).getMsg());
                            System.out.println("---------------------------------------------------");
                            
                        }else if(data instanceof  Logout){
//                            System.out.println("=================|Logout|===================");
  //                          System.out.println(((Logout)data).getMsg());
    //                        System.out.println("---------------------------------------------------");
                        }

                    }

            }catch (SocketException ex){
                s=null;
                state.setState(false);
                if(SocketReconnect<5){
                    System.out.println("Retrying Connection...");
                    SocketReconnect++;
                    try {
                        this.sleep(5000);
                    } catch (InterruptedException ex1) {
                        Logger.getLogger(Receive_msg.class.getName()).log(Level.SEVERE, null, ex1);
                    }
                }
                else{
                    System.out.println("Connection down, retried 5 times!");
                    break;
                }
            }catch (IOException ex) {
                Logger.getLogger(Receive_msg.class.getName()).log(Level.SEVERE, null, ex);
            } catch (ClassNotFoundException ex) {
                Logger.getLogger(Receive_msg.class.getName()).log(Level.SEVERE, null, ex);
            }

            // DISPLAY WHAT WAS READ
            //System.out.println("\nReceived: \nfrom: "+data.getName()+"\nid:"+data.getId()+"\nMensagem: "+data.getMsg());
        }

    }


}
