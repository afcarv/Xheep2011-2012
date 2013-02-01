/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
package Objects;
/**
 *
 * /**
 *
 * Objecto para comunicação entre users via opção  (7)-message to all   : super.destinatario
 */
import java.io.Serializable;

public class MessageAll extends Mensagem implements Serializable{

    String msg;

    public MessageAll() {
    }
    
    public MessageAll(String msg) {
        this.msg = msg;
    }

    public MessageAll(String username, String msg) {
        super(username);
        this.msg = msg;
    }

    public void setDestinatario(String destinatario) {
        super.destinatario = destinatario;
    }

    public void setEmissor(String emissor) {
        super.emissor = emissor;
    }

    public String getDestinatario() {
        return super.destinatario;
    }

    public String getEmissor() {
        return super.emissor;
    }
    public String getMsg() {
        return msg;
    }

    public void setMsg(String msg) {
        this.msg = msg;
    }
    
    

}
