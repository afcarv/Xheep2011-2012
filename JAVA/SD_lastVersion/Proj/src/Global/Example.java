package Global;

/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */

public class Example {
    public static void main(String[] args){
        IBetManager man = new BetManager();

        System.out.println("========= First Batch of Matches =========");        
        for (IMatch m : man.getMatches()) {
            System.out.println(m);
        }
        System.out.println("========= Results =========");
        String results="";
        for (IMatch m : man.getMatches()) {
            results+=m + ": ";
            switch (man.getResult(m)) {
                case HOME: 
                    results+="1 \n";
                    break;
                case AWAY: 
                    results+="2 \n";
                    break;
                default: 
                    results+="X \n";
                    break;
            }
        }
        System.out.println("======= New Batch of Matches =======");
        man.refreshMatches();
        
        for (IMatch m : man.getMatches()) {
            System.out.println(m.getHomeTeam() + " vs " + m.getAwayTeam());
        }
        
    }
}