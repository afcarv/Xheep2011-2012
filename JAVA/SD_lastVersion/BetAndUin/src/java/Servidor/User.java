/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
package Servidor;

import java.io.Serializable;

public class User implements Serializable {

    private String username;
    private String password;
    private String email;
    private boolean status=false;
    private int credit;

    public User( String username, String password, String email, int credit) {
        this.username=username;
        this.password = password;
        this.email = email;
        this.credit = credit;
    }

    public User(String username, String password) {
        this.username=username;
        this.password=password;

    }

    public void setEmail(String email) {
        this.email = email;
    }


    public void setCredit(int credit) {
        this.credit = credit;
    }

    public void setUsername(String userN) {
        this.username = userN;
    }

    public int getCredit() {
        return credit;
    }
    public String getUserName() {
        return this.username;
    }
    public void setStatus(boolean status) {
        this.status = status;
    }
    public boolean getStatus() {
        return status;
    }
   public String getEmail() {
        return email;
    }
   public String getPassword() {
        return password;
    }
    public void setPassword(String password) {
        this.password = password;
    }



}
