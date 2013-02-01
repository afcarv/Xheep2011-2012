package Servidor;
/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
import Global.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class HandleBets extends Thread {

    IBetManager man = new BetManager();
    int delay = 1000; //milliseconds
    public   HandleBets() {
        this.start();
    }



    @Override
    public void run() {
        //ActionListener taskPerformer = new ActionListener() {


    }
}
