/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package Servidor;

import java.io.IOException;
import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 *@author jlnabais
 *@author afcarv
 *
 */
public class Alive extends Thread{
    Alive(){
     this.start();
    }
    public void run(){

        DatagramSocket CPR=null;
        String enviar="I_AM_ALIVE";
        byte[] strBytes=enviar.getBytes();

        try{
            CPR=new DatagramSocket();
            while(true){
                //envia pacotes de 1 em 1 segundo, ou seja pode ter de mandar 10vezes
                //(tempo de timeout é 10segundos) se a menssagem UDP falhar
                InetAddress host =InetAddress.getByName("localhost");
                int porto = 2020;
                DatagramPacket pacote = new DatagramPacket(strBytes, strBytes.length,host,porto);
                CPR.send(pacote);
                Thread.sleep(500);
            }
        } catch (InterruptedException ex) {
            Logger.getLogger(Alive.class.getName()).log(Level.SEVERE, null, ex);
        }catch (IOException ex) {
            Logger.getLogger(Servidor.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
