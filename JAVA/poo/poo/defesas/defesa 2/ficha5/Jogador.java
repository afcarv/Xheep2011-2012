import java.util.ArrayList;

public class Jogador
{
	protected ArrayList<Integer> bets;
	protected int betLimit;
	
	public String name;
	public int age;
	public int telephone;

	protected void init()
	{
		bets = new ArrayList<Integer>();
		betLimit = 0;
	}
	
	Jogador()
	{
		init();
	}

	Jogador(String _name, int _age, int _telephone)
	{
		init();
		
		name = _name;
		age = _age;
		telephone = _telephone;		
	}

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
	
	
	int getBetCount()
	{
		return bets.size();
	}
	
	void clearBets()
	{
		bets.clear();
	}

}
