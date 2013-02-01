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
 * Objecto para a opção ver creditos - leva a informação do user que pediu 
 */

public class Credit extends Mensagem implements Serializable {

    int credit;

    public Credit(String username, int credito){
        super(username);
        this.credit=credito;
    }

    public Credit(){}

    public void setCredit(int credit) {
        this.credit = credit;
    }

    public int getCredit() {
        return credit;
    }

}
