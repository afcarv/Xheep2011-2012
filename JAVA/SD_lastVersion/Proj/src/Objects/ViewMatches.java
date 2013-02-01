/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
package Objects;

import java.io.Serializable;

/**
 *
 *  Objecto para tratar da opção 3 viewmatches
 */
public class ViewMatches extends Mensagem implements Serializable{
    Object msg;

    public ViewMatches(String emissor) {
        super(emissor);
    }

    public ViewMatches(String emissor, String msg) {
        super(emissor);
        this.msg = (Object)msg;
    }

    public ViewMatches(Object msg) {
        this.msg = msg;
    }


    public void setMsg(String msg) {
        this.msg = msg;
    }

    public String getMsg() {
        return (String)msg;
    }
    
    /**
     *
     */
    public ViewMatches() {
    }


}
