
import java.util.ArrayList;

public class Main
{

	public static void main(String[] args)
	{
		Concurso c = new Concurso();
		
		// concorrentes fixos
		Trabalhador ana = new Trabalhador("ana", 34, 55510, 1337);
		
		ana.addBet(1234);
		ana.addBet(2345);
		ana.addBet(4567);
		ana.addBet(5678);
		ana.addBet(6789);
		ana.addBet(7890);	
		
		c.addPlayer(ana);
		
		Cliente luis = new Cliente("luis", 12, 5523);
		
		luis.addBet(3743);
		luis.addBet(2245);
		luis.addBet(22333);		
		
		c.addPlayer(luis);
		
		c.drawKey(22333);
		ArrayList<Jogador> winners = c.getWinners();
		
		if (winners.size() < 1)
		{
			System.out.println("Ningu�m ganhou :(");
			return;
		}
		
		for (int i = 0; i < winners.size(); i++)
		{
			System.out.println(winners.get(i).name + " ganhou!");
		}	
	}
}
