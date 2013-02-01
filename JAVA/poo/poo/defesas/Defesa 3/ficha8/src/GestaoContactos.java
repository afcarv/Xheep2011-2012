import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;


public class GestaoContactos {
	public ArrayList<Contacto> Familia;
	public ArrayList<Contacto> Amigos;
	public ArrayList<Contacto> Profissional;
	
	GestaoContactos()
	{
		Familia = new ArrayList<Contacto>();
		Amigos = new ArrayList<Contacto>();
		Profissional = new ArrayList<Contacto>();
	}

	public void AdicionaCOntacto()
	{
		
	}
	
	public void EleminaContacto()
	{
		String nome = "";
		
		// pedir nome
		
		for (int i = 0; i < Familia.size(); i++)
		{
			if (Familia.get(i).nome.equals(nome))
			{
				Familia.remove(i);
				return;
			}
		}
		for (int i = 0; i < Amigos.size(); i++)
		{
			if (Amigos.get(i).nome.equals(nome))
			{
				Amigos.remove(i);
				return;
			}
		}
		for (int i = 0; i < Profissional.size(); i++)
		{
			if (Profissional.get(i).nome.equals(nome))
			{
				Profissional.remove(i);
				return;
			}
		}
	}
	
	ArrayList<Contacto> aniversarios()
	{
		ArrayList<Contacto> res = new ArrayList<Contacto>();
		Calendar today = Calendar.getInstance();
	
		for (int i = 0; i < Familia.size(); i++)
		{
			Calendar age = Familia.get(i).aniversario;
			
			if (age.get(Calendar.DAY_OF_YEAR) >= today.get(Calendar.DAY_OF_YEAR) &&
				age.get(Calendar.DAY_OF_YEAR) <= today.get(Calendar.DAY_OF_YEAR)+10)
			{
				res.add(Familia.get(i));
			}
		}
		
		
		for (int i = 0; i < Amigos.size(); i++)
		{
			Calendar age = Amigos.get(i).aniversario;
			
			if (age.get(Calendar.DAY_OF_YEAR) >= today.get(Calendar.DAY_OF_YEAR) &&
					age.get(Calendar.DAY_OF_YEAR) <= today.get(Calendar.DAY_OF_YEAR)+10)
			{
				res.add(Amigos.get(i));
			}
		}
		for (int i = 0; i < Profissional.size(); i++)
		{
			Calendar age = Profissional.get(i).aniversario;
			
			if (age.get(Calendar.DAY_OF_YEAR) >= today.get(Calendar.DAY_OF_YEAR) &&
					age.get(Calendar.DAY_OF_YEAR) <= today.get(Calendar.DAY_OF_YEAR)+10)
			{
				res.add(Profissional.get(i));
			}
		}
		return res;
	}
}
