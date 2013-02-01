package Ficha7_3;

public class EmpregadoComissao extends Empregado
{
	public int baseSalary;
	
	EmpregadoComissao(String _name, int _number, int _base, int _rate)
	{
		super(_name, _number, _rate);
		baseSalary = _base;
		PayType = "Comissão";
	}

	public boolean addDay(int day, int val)
	{
		if (super.addDay(day, val))
		{
			earnings.add(new Earning(day, val));
			return true;
		}
		return false;
	}
	
	public float getAverage()
	{
		return super.getAverage()*(rate/100);
	}
	
	public int calcMonth()
	{
		return (int)baseSalary+(getTotal()*(rate/100));
	}
}
