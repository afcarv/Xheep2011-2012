/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
package Objects;

import java.io.Serializable;

/**
 *
 * /**
 *
 * Objecto para a opção lgout com username
 */
public class Logout extends Mensagem implements Serializable{
    Object msg;

    public Logout(String username) {
        super(username);
    }

    public Logout(Object msg) {
        this.msg = msg;
    }


    public String getMsg() {
        return (String)msg;
    }

    public void setMsg(String msg) {
        this.msg = (Object)msg;
    }
    
    public Logout() {
    }

}
