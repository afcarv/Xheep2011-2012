import java.util.ArrayList;

public class Empregado {
	protected class Earning {
		public Earning(int _day, int _val) {
			day = _day;
			val = _val;
		}
		public int day;
		public int val;
	};
	
	protected ArrayList<Earning> earnings;
	
	public String nome;
	public int numero;
	
	public String PayType;
	
	// ponto A
	public boolean addDay(int day, int val)
	{
		if (day < 1 || day > 31)
			return false;
		
		if (val <= 0)
			return false;
		
		return true;
	}
	
	// ponto C
	public int calcMonth()
	{
		return 0;
	}
	
	// ponto B
	public int getDay(int day)
	{
		for (int i = 0; i < earnings.size(); i++)
		{
			if (earnings.get(i).day == day)
			{
				return earnings.get(i).val;
			}
		}
		return 0;
	}
	
	public int getTotal()
	{
		int sum = 0;
		
		for (int i = 0; i < earnings.size(); i++)
		{
			sum += earnings.get(i).val;
		}
		
		return sum;
	}
	
	public float getAverage()
	{
		return getTotal()/earnings.size();
	}
}
