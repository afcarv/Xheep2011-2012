package Objects;
/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */

import java.io.Serializable;


/**
 *
 * /**
 *
 * Objecto para a opção autenticação que se caracteriza por ter username e password
 */
public class Login extends Mensagem implements Serializable{

    private String password;
    private boolean status=false;
    private String msg;


    public Login(String username, String password) {
        super.emissor = username;
        this.password = password;
    }

    public Login(boolean stat, String msg){

        this.status=stat;
        this.msg=msg;
    }

    public void setMsg(String msg) {
        this.msg = msg;
    }

    public void setStatus(boolean status) {
        this.status = status;
    }

    public String getMsg() {
        return msg;
    }

    public boolean getStatus() {
        return status;
    }
    public Login(){}

    public void setUserName(String usern) {
        super.emissor = usern;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getUserN() {
        return super.emissor;
    }

    public String getPassword() {
        return password;
    }



}
