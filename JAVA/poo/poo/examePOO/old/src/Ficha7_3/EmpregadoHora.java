package Ficha7_3;


public class EmpregadoHora extends Empregado
{
	
	EmpregadoHora(String _name, int _number, int _rate)
	{
		super(_name, _number, _rate);
		PayType = "Hora";
	}

	public boolean addDay(int day, int val)
	{
		if (super.addDay(day, val) == false)
			return false;
		
		if (val > 24)
			return false;
		
		earnings.add(new Earning(day, val));
		return true;
	}
}
