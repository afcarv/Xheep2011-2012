package Servidor;

/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
import Global.*;
import Objects.*;
import RMIClient.*;
import Servidor.*;
import java.io.IOException;
import java.io.ObjectOutputStream;
import java.util.Enumeration;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * thread para tratar exclusivamente das apostas
 */
public class Bets extends Thread {

    int id;
    int resul;
    int valor;
    public int oneMinute = 50000;
    BetManager man;

    public Bets() {
        man = new BetManager();
        this.start();
    }

    @Override
    /**
     *  trata Id da partida, result para essa partida e número de créditos envolvidos
     */
    public void run() {
        while (true) {

            try {
                Thread.sleep(oneMinute);

                synchronized (Servidor.apostas) { //nao permitir acesso enquanto trata dos resultados
                    // aqui ficam guardadas todas as chaves , a hashtable apostas (User, BetMatch(username,id,result,valor))
                    Enumeration ps = Servidor.apostas.keys();


                    while (ps.hasMoreElements()) {

                        String apostas_key = ((String) ps.nextElement());
                        //pega de seguida, em cada uma dessas apostas e coloca a informação na variável temporária data
                        BetMatch data = (BetMatch) Servidor.apostas.get(apostas_key);


                        for (IMatch game : man.getMatches()) {
                            //gera jogos e verifica se o ID do jogo do user que esta a analisar neste momento pertence à batch de jogos actual
                            if (data.getId() == Integer.parseInt(game.getCode())) {// id identifica o jogo!

                                
                                int result;
                                switch (man.getResult(game)) {
                                    case HOME:
                                        result = 1;
                                        break;
                                    case AWAY:
                                        result = 2;
                                        break;
                                    default:
                                        result = 3;
                                        break;
                                }

                                int flag = data.getType();
                                System.out.println("--->tye" + flag);
                                if (flag == 1) {// flag do tcp

                                    //String type = Servidor.apostas.g



                                    ObjectOutputStream sc = Servidor.onlineUsers.get(apostas_key);
                                    synchronized (sc) {

                                        System.out.println("tcp");
                                        //7) se a informação que está guardada em data (que vinha no objecto betmatch (que vinha da hashtable apostas)) condizer com o resultado, ultiplica o seu credito por 3
                                        if (data.getResul() == result) {
                                            int tag = data.getType();
                                            int tag2 = data.getCrs();
                                            System.out.println("------ tag::::" + tag);
                                            System.out.println("------ tag::::" + tag2);




                                            // se vencer a aposta a sua aposta é triplicada
                                            Servidor.users.get(apostas_key).setCredit(data.getValor() * 3 + Servidor.users.get(apostas_key).getCredit()); //adiciona o valor ganho ao credito do cliente
                                            try {
                                                data.setMsg(showResults() + "\n\nGanhou a aposta no jogo " + game);

                                                sc.writeObject(data);

                                            } catch (IOException ex) {
                                                Logger.getLogger(Bets.class.getName()).log(Level.SEVERE, null, ex);
                                            }
                                        } else {

                                            try {
                                                data.setMsg(showResults() + "\n\nPerdeu a aposta no jogo " + game);
                                                sc.writeObject(data);
                                            } catch (IOException ex) {
                                                Logger.getLogger(Bets.class.getName()).log(Level.SEVERE, null, ex);
                                            }
                                        }
                                    }


                                }// fim do if TCP apostas

                                else if(flag==2 || flag==3){

                                    System.out.println("RMI");

                                    ClientInterface c = Servidor.onlineRMI.get(apostas_key);

                                    synchronized(c){
                                    if (data.getResul() == result) {
                                        // se vencer a aposta a sua aposta é triplicada
                                        System.out.println("\n\n\n######acertou no resultado");
                                        Servidor.users.get(apostas_key).setCredit(data.getValor() * 3 + Servidor.users.get(apostas_key).getCredit()); //adiciona o valor ganho ao credito do cliente
                                        String us = Servidor.users.get(apostas_key).getUserName();
                                        try {

                                            String res = showResults() + "\n\nCaro "+us+"Ganhou a aposta no jogo " + game;
                                            String nome = data.getEmissor();
                                            ClientInterface aux = Servidor.onlineRMI.get(nome);// get da interface do utilizador para fazer callback
                                            //sc.writeObject(dataRMI);
                                            aux.receiveAssinchMsg(res, nome);



                                        } catch (IOException ex) {
                                            Logger.getLogger(Bets.class.getName()).log(Level.SEVERE, null, ex);
                                        }
                                    } else {

                                    System.out.println("\n\n\n######errou o resultado");
                                        try {
                                            String res2 = showResults() + "\n\nPerdeu a aposta no jogo " + game;
                                            //sc.writeObject(dataRMI);
                                            String nome = data.getEmissor();
                                            ClientInterface aux = Servidor.onlineRMI.get(nome);
                                            aux.receiveAssinchMsg(res2, nome);
                                        } catch (IOException ex) {
                                            Logger.getLogger(Bets.class.getName()).log(Level.SEVERE, null, ex);
                                        }
                                    }
                                }
                                }
                                


                                Servidor.apostas.remove(apostas_key);
                            }
                        }
                    }

                }

                Servidor.apostas.clear();

                refreshRound();




            } catch (InterruptedException ex) {
                Logger.getLogger(Bets.class.getName()).log(Level.SEVERE, null, ex);

            }
        }
    }

    /**
     * mostra partidas
     * @return
     */
    public synchronized String showMatches() {

        String msgs = "========= Matches =========\n\n";
        for (IMatch m : man.getMatches()) {
            msgs += " \n" + "[" + m.getCode() + "] " + m + ": ";
        }
        return msgs;

    }

    /**
     * nova set de matches
     */
    public void refreshRound() {
        this.man.refreshMatches();
    }

    /**
     *verifica se código inserido vale vitória na aposta
     * @param code
     * @return
     */
    public boolean validaMatche(int code) {
        for (IMatch game : man.getMatches()) {
            if (Integer.parseInt(game.getCode()) == code) {
                return true;
            }
        }

        return false;
    }

    /**
     * Mostra golos marcados nos jogos
     * @return
     */
    public synchronized String showResults() {

        String results = "========= Results =========\n\n";
        for (IMatch m : man.getMatches()) {
            results += m + ": ";
            switch (man.getResult(m)) {
                case HOME:
                    results += "1 \n";
                    break;
                case AWAY:
                    results += "2 \n";
                    break;
                default:
                    results += "X \n";
                    break;
            }
        }
        return (results += "\n");

    }

    /**
     *
     * @return
     */
    public BetManager getMan() {
        return man;
    }

    /**
     *
     * @param man
     */
    public void setMan(BetManager man) {
        this.man = man;
    }

     /**
     * mostra partidas
     * @return
     */
    public synchronized String showMatches2() {

        String msgs = "";
        for (IMatch m : man.getMatches()) {
            msgs += m+" vs ";
        }
        //System.out.println("--->"+msgs);
        return msgs;

    }
}
