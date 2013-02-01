package Ficha5_4;
import java.util.ArrayList;
import java.util.Random;

public class Concurso
{
	//lista de jogadores:
	private ArrayList<Jogador> players;
	private int drawnKey;
	//construtor para novo concurso:
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
	//gerar uma key:
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
	//cria um arraylis com os vencedores:
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