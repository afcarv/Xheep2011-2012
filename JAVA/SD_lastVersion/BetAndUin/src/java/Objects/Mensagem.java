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
 * Objecto para comunicação entre users via opção (6)- message to user 
 */
public class Mensagem implements Serializable{

    protected String emissor;
    protected String destinatario;

      

    

    public Mensagem(String emissor) {
        this.emissor = emissor;
    }

    public Mensagem(String emissor, String dest) {
        this.emissor = emissor;
        this.destinatario=dest;
    }
    public Mensagem(){}
    
    public void setDestinatario(String destinatario) {
        this.destinatario = destinatario;
    }

    public String getDestinatario() {
        return destinatario;
    }

    public String getEmissor() {
        return emissor;
    }

    public void setEmissor(String emissor) {
        this.emissor = emissor;
    }


}
