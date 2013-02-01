/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package TCPClient;

import java.io.ObjectInputStream;

/**
 *
 * @author jlnabais
 * @author afcarv
 */
public class ServerState {

    boolean state;
    ObjectInputStream in;

    public ObjectInputStream getIn() {
        return in;
    }

    public void setIn(ObjectInputStream in) {
        this.in = in;
    }

    public ServerState(boolean state) {
        this.state = state;
    }

    public boolean isState() {
        return state;
    }

    public void setState(boolean state) {
        this.state = state;
    }
    

}
