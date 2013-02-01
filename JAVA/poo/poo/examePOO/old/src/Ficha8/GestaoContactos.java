package Ficha8;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.Calendar;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;

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
	
	public void AdicionaContacto()
	{
		Contacto c = new Contacto();
		//lista auxiliar para guardar o novo contacto:
		ArrayList<Contacto> list = null;
		SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
		
		System.out.println("< Adicionar Contacto>");
		System.out.println("Tipo de contacto? (1-Amigos, 2-Família, 3-Profissional)? ");
		
		int type = User.readInt();
		switch (type)
		{
		case 1:
			list = Amigos;
			break;
		case 2:
			list = Familia;
			break;
		case 3:
			list = Profissional;
			break;
			
		default:
			System.out.println("invalido");
			return;
		}

		
		System.out.print("Nome:");
		c.nome = User.readString();
		// conversão + aniversario:
		for (;;)
		{
			System.out.print("Data de nascimento (DD/MM/YYYY):");
			try {
				c.aniversario = sdf.parse(User.readString());
				break;
			}
			catch (ParseException e)
			{
				System.out.println("Erro: " + e);	
			}
		}
		System.out.print("Sexo:");
		c.sexo = User.readString();
		System.out.print("Profissão:");
		c.profissão = User.readString();
		System.out.print("email:");
		c.email = User.readString();
		
		
		list.add(c);
	}
	
	public void EliminaContacto()
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
	
	public void ListarContactos()
	{
		System.out.println("<<Familia>>");
		for (int i = 0; i < Familia.size(); i++)
		{
			System.out.println(Familia.get(i));
		}
		
		System.out.println("<<Amigos>>");
		for (int i = 0; i < Amigos.size(); i++)
		{
			System.out.println(Amigos.get(i));
		}
		
		System.out.println("<<Profissional>>");
		for (int i = 0; i < Profissional.size(); i++)
		{
			System.out.println(Profissional.get(i));
		}
	}
	
	/*public void ListarVelho()
	{
		
		int older1=0,older2=0,older3=0;
		
		Contacto c = new Contacto();
		
		
		
		System.out.println("<<Familia>>");
		for (int i = 0; i < Familia.size(); i++)
		{

			if(c.idade() > older1){
				older3=c.idade();
			}
		}
		System.out.println(c.idade());
		
		System.out.println("<<Amigos>>");
		for (int i = 0; i < Amigos.size(); i++)
		{
			if(c.idade() > older2){
				older3=c.idade();
			
			}
		}
		
		System.out.println(c.idade());
		System.out.println("<<Profissional>>");
		for (int i = 0; i < Profissional.size(); i++)
		{
			if(c.idade() > older3){
				older3=c.idade();
			}
		}
		System.out.println(c.idade());
	}
	*/
	
	public ArrayList<Contacto> aniversarios()
	{
		
		ArrayList<Contacto> res = new ArrayList<Contacto>();
		Calendar today = Calendar.getInstance();
	
		System.out.println("<Aniversariantes>");
		for (int i = 0; i < Familia.size(); i++)
		{
			Calendar age = Calendar.getInstance();
			age.setTimeInMillis(Familia.get(i).aniversario.getTime());
			
			if ((today.get(Calendar.DAY_OF_YEAR)+7)%365 > age.get(Calendar.DAY_OF_YEAR))
			{
				res.add(Familia.get(i));
			}
			else
			{
				if (age.get(Calendar.DAY_OF_YEAR) >= today.get(Calendar.DAY_OF_YEAR) &&
					age.get(Calendar.DAY_OF_YEAR) <= today.get(Calendar.DAY_OF_YEAR)+7)
				{
					res.add(Familia.get(i));
				}
			}
		}
		
		
		for (int i = 0; i < Amigos.size(); i++)
		{
			Calendar age = Calendar.getInstance();
			age.setTimeInMillis(Amigos.get(i).aniversario.getTime());
			
			if (age.get(Calendar.DAY_OF_YEAR) >= today.get(Calendar.DAY_OF_YEAR) &&
					age.get(Calendar.DAY_OF_YEAR) <= today.get(Calendar.DAY_OF_YEAR)+7)
			{
				res.add(Amigos.get(i));
			}
		}
		for (int i = 0; i < Profissional.size(); i++)
		{
			Calendar age = Calendar.getInstance();
			age.setTimeInMillis(Profissional.get(i).aniversario.getTime());
			
			if (age.get(Calendar.DAY_OF_YEAR) >= today.get(Calendar.DAY_OF_YEAR) &&
					age.get(Calendar.DAY_OF_YEAR) <= today.get(Calendar.DAY_OF_YEAR)+7)
			{
				res.add(Profissional.get(i));
			}
		}
		return res;
	}
}
