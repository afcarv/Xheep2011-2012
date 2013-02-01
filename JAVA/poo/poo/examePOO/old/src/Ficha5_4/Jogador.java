package Ficha5_4;
import java.util.ArrayList;

public class Jogador
{
	protected ArrayList<Integer> bets;
	protected int betLimit;
	//características gerais:
	public String name;
	public int age;
	public int telephone;
	
	//método para iniciar execução:
	protected void init()
	{
		bets = new ArrayList<Integer>();
		betLimit = 0;
	}
	//jogador com apostas:
	Jogador()
	{
		init();
	}
	//novo jogador:
	Jogador(String _name, int _age, int _telephone)
	{
		init();
		
		name = _name;
		age = _age;
		telephone = _telephone;		
	}
	//procura jogador:
	boolean equals(Jogador j)
	{
		if (name != j.name) return false;
		if (age != j.age) return false;
		if (telephone != j.telephone) return false;
		
		return true;	
	}
	boolean addBet(int key)
	{
		return makeBet(key);
	}
	//nova aposta:
	boolean makeBet(int key)
	{
		if (bets.size() > betLimit)
			return false;
		
		if ((0 > key) || (key > 9999))
			return false;
			
		bets.add(key);
		return true;
	}
	
	boolean inBets(int key)
	{
		for (int i = 0; i < bets.size(); i++)
		{
			if (bets.get(i) == key)
			{
				return true;
			}
		}
		
		return false;
	}
	//número de apostas:
	int getBetCount()
	{
		return bets.size();
	}
	void clearBets()
	{
		bets.clear();
	}

}
