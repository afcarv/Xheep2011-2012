package Ficha7_3;

import java.util.ArrayList;

public class Empregado
{
	protected class Earning
	{
		public Earning(int _day, int _val)
		{
			day = _day;
			val = _val;
		}
		//definir variáveis locias:
		public int day;
		public int val;
		
		//método para definir dia e valor:
		public void set(int _day, int _val)
		{
			day = _day;
			val = _val;
		}
	};
	//arraylist para armazenar ganhos:
	protected ArrayList<Earning> earnings;
	
	public String name;
	public int number;
	public int rate;
	public String PayType;
	//constructor:
	Empregado(String _name, int _number, int _rate)
	{
		earnings = new ArrayList<Earning>();
		
		name   = _name;
		number = _number;
		rate   = _rate;
	}
	
	// alínea A
	public boolean addDay(int day, int val)
	{
		if (day < 1 || day > 31)
			return false;
		if (val <= 0)
			return false;
		return true;
	}

	public boolean updateDay(int day, int val)
	{
		if (day < 1 || day > 31)
			return false;		
		if (val <= 0)
			return false;
		//Introdução dos dados:
		for (int i = 0; i < earnings.size(); i++)
		{
			if (earnings.get(i).day == day)
			{
				earnings.get(i).set(day, val);
			}
		}
		return true;
	}
	
	// alínea C
	public int calcMonth()
	{
		return getTotal()*rate;
	}
	// alínea B
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
	//número de dias que trabalhou:
	public int getDaysWorked()
	{
		return earnings.size();
	}
	//contabilidade mensal:
	public int getTotal()
	{
		int sum = 0;
		
		for (int i = 0; i < earnings.size(); i++)
		{
			sum += earnings.get(i).val;
		}
		
		return sum;
	}
	//média:
	public float getAverage()
	{
		if (earnings.isEmpty()) return 0;
		return getTotal()/earnings.size();
	}
}
