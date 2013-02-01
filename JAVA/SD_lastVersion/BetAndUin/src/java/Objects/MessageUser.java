/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
package Objects;

import java.io.Serializable;
/**
 *
 *  Objecto para comunicação entre users via opção (6) - auxiliar da mensagem
 */
public class MessageUser extends Mensagem implements Serializable{
    String msg;

    public MessageUser(String user_name, String dest_name, String msg) {
        super(user_name,dest_name);
        this.msg = msg;
    }
    public MessageUser() {
    }


    public void setMsg(String msg) {

        this.msg = msg;
    }

    public String getMsg() {
        return msg;
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

    
}
