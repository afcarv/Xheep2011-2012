/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package RMIClient;

import java.rmi.RemoteException;
import java.rmi.Remote;
import Objects.*;

/**
 *
 * @author jlnabais
 * @author afcarv
 */
public interface ClientInterface extends Remote {

    public void receiveAssinchMsg(String msg, String emissor) throws RemoteException;

    //Métodos para callback
    public String messageAll(MessageAll mall) throws RemoteException;

    public void messageUser(MessageUser objectM) throws RemoteException;
}
