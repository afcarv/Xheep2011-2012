package Global;
/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
import java.util.List;

public interface IBetManager {
    public List<IMatch> getMatches();
    public Result getResult(IMatch m);
    public void refreshMatches();
}