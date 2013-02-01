package Objects;

/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
import java.io.Serializable;

/**
 *
 *  Objecto para tratar de um registo de user
 */
public class Register extends Mensagem implements Serializable{
    
    private String email;
    private String password;
    private boolean status=false;
    private String msg;

    public Register(){}

    /**
     * 
     * @param email
     * @param username
     * @param password
     */
    public Register(String username, String password,String email) {
        super.emissor=username;
        this.password=password;
        this.email = email;
    }


    /**
     *
     * @param stat
     * @param msg
     */
    public Register(boolean stat, String msg){

        this.status=stat;
        this.msg=msg;
    }

    public void setStatus(boolean status) {
        this.status = status;
    }

     public void setMsg(String msg) {
        this.msg = msg;
    }


    public String getMsg() {
        return msg;
    }

    public boolean getStatus() {
        return status;
    }
    public void setUserName(String Usern) {
        super.emissor = Usern;
    }
    public String getUserName() {
        return super.emissor;
    }
    
    public void setPassword(String password) {
        this.password = password;
    }
    public String getPassword() {
        return password;
    }
    public void setEmail(String email) {
        this.email = email;
    }
    public String getEmail() {
        return email;
    }

    
}