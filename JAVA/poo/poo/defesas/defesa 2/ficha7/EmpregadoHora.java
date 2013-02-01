
public class EmpregadoHora extends Empregado {
	EmpregadoHora()
	{
		this.PayType= "Hora";
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
