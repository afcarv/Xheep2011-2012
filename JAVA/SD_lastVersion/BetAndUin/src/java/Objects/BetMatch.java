/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
package Objects;

import java.io.Serializable;

/**
 *
 * Objecto para a opção Bet - leva a informação do id(jogo), resultado e créditos apostas
 */
public class BetMatch extends Mensagem implements Serializable {

    String msg;
    Boolean status;
    int id;
    int resul;
    int valor;
    int crs;
    int type;// para saber se é tcp, html ou rmi

    public BetMatch(String username, int id, int resul, int valor) {
        super(username);
        this.id = id;
        this.resul = resul;
        this.valor = valor;
    }

    public BetMatch(String username, int id, int resul, int valor, int crs) {
        super(username);
        this.id = id;
        this.resul = resul;
        this.valor = valor;
        this.crs = crs;
    }

     public BetMatch(String username, int id, int resul, int valor, int crs,int type) {
        super(username);
        this.id = id;
        this.resul = resul;
        this.valor = valor;
        this.crs = crs;
        this.type=type;
    }

    public BetMatch(String msg, Boolean status, int valor) {
        this.msg = msg;
        this.status = status;
        this.valor = valor;
    }


    public BetMatch() {
    }

    public void setCrs(int crs) {
        this.crs = crs;
    }

    public int getCrs() {
        return crs;
    }

    public void setType(int type) {
        this.type = type;
    }

    public int getType() {
        return type;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setResul(int resul) {
        this.resul = resul;
    }

    public int getId() {
        return id;
    }

    public int getResul() {
        return resul;
    }

    public String getMsg() {
        return msg;
    }

    public Boolean getStatus() {
        return status;
    }

    public int getValor() {
        return valor;
    }

    public void setMsg(String msg) {
        this.msg = msg;
    }

    public void setStatus(Boolean status) {
        this.status = status;
    }

    public void setValor(int valor) {
        this.valor = valor;
    }
}
