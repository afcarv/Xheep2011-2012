
package Objects;
/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
import java.io.Serializable;
/**
 *
 *  Objecto para a opção online users - com os nomes dos users online
 */
public class OnlineUsers extends Mensagem implements Serializable{
    Object msg;

    public OnlineUsers(String emissor, String msg) {
        super(emissor);
        this.msg = (Object)msg;
    }


    public OnlineUsers(String username) {
        super(username);
    }

    public String getMsg() {
        return (String)msg;
    }

    public void setMsg(String msg) {
        this.msg = (Object)msg;
    }


    public OnlineUsers() {
    }

    

}
