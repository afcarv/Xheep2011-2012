import java.util.ArrayList;
import java.util.Random;

public class Concurso
{
	private ArrayList<Jogador> players;
	private int drawnKey;
	
	
	Concurso()
	{
		players = new ArrayList<Jogador>();
		
	}
	
	void addPlayer(Jogador p)
	{
		players.add(p);
	}
	
	boolean removePlayer(Jogador p)
	{		
		for (int i = 0; i < players.size(); i++)
		{
			if (players.get(i).equals(p))
			{
				players.remove(i);
				return true;
			}
		}
		
		return false;	
	}
	
	void clearPlayers()
	{
		players.clear();
	}
	
	int getPlayerCount()
	{
		return players.size();
	}
	
	public void drawKey()
	{
		// http://www.cs.geneseo.edu/~baldwin/reference/random.html
		Random rnd = new Random();
		
		// random number from 0-9999
		drawnKey = rnd.nextInt(10000);
	}
	
	public void drawKey(int key)
	{
		drawnKey = key;
	}
	
	
	public ArrayList<Jogador> getWinners()
	{
		ArrayList<Jogador> winners = new ArrayList<Jogador>();
	
		for (int i = 0; i < players.size(); i++)
		{
			if (players.get(i).inBets(drawnKey))
			{
				winners.add(players.get(i));
			}
		}
				
		return winners;	
	}



}