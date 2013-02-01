/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
package Objects;

import java.io.Serializable;

/**
 *
 *  Objecto para tratar de um reset aos créditos do user
 */
public class Reset_credit extends Mensagem implements Serializable{

    int credit;
    String msg;

    public Reset_credit(int credito){
     this.credit=credito;
    }
    
    public Reset_credit(int credito, String msg){
     this.credit=credito;
    }

    public Reset_credit(String emissor, int credit, String msg) {
        super(emissor);
        this.credit = credit;
        this.msg = msg;
    }
    
    public Reset_credit(String emissor, int credit) {
        super(emissor);
        this.credit = credit;
    }



    public Reset_credit(String emissor) {
        super(emissor);
    }

    public Reset_credit(){}

    public void setCredit(int credit) {

        this.credit = credit;
    }

    public int getCredit() {
        return credit;
    }

    public void setMsg(String msg) {
        this.msg = msg;
    }

    public String getMsg() {
        return msg;
    }

}
