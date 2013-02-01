package Ficha7_3;


import java.util.ArrayList;


public class Main
{
	public static ArrayList<Empregado> list;
	
	public static void main(String args[])
	{
		list = new ArrayList<Empregado>();
		
		// seeding da lista
		list.add(new EmpregadoHora("ana", 1, 15));
		list.add(new EmpregadoHora("daniel", 2, 50));
		list.add(new EmpregadoHora("joao", 6, 1000)); // é o CEO
		
		// o rate a comissão é a percentagem
		list.add(new EmpregadoComissao("luis", 3, 500, 14));
		list.add(new EmpregadoComissao("vitor", 4, 1000, 23));
		list.add(new EmpregadoComissao("pedro", 5, 3500, 50)); // filho do CEO
		
		for(;/*menu loop*/;)
		{
			switch(showMenu())
			{
			case 1:
				listUsers();
				break;
			
			case 2:
				updateDay();
				break;
				
			case 3:
				showUser();
				break;
				
			case 0:
				return;		
				
			default:
				System.out.println("opção invalida");
			}
		}
	}
	
	public static int showMenu()
	{
		
		System.out.println("1. Listar empregados");
		System.out.println("2. Actualizar empregado");
		System.out.println("3. ver empregado");
		System.out.println("--------------------------");
		System.out.println("0. Sair");
		
		return User.readInt();
	}
	
	public static void updateDay()
	{
		Empregado e = null;		
		
		System.out.print("numero: ");
		int number = User.readInt();
		
		// find the user
		for (int i = 0; i < list.size(); i++)
		{
			if (number == list.get(i).number)
			{
				e = list.get(i);
				break;
			}
		}
		
		if (null == e)
		{
			System.out.println("empregado não existe");
			return;
		}

		System.out.print("dia: ");
		int day = User.readInt();
		
		if (e.PayType.equals("Hora"))
		{
			System.out.print("Horas feitas: ");
		}
		else
		{
			System.out.print("Total Vendido: ");
		}
		int val = User.readInt();
		
		
		if (0 == e.getDay(day))
		{
			if(!e.addDay(day, val))
			{
				System.out.println("não addicinado");
			}
		}
		else
		{
			if(!e.updateDay(day, val))
			{
				System.out.println("não atualizado");
			}
		}
		
	}
	
	public static void listUsers()
	{
		for (int i = 0; i < list.size(); i++)
		{
			System.out.println("Empregado: " + list.get(i).name);
			System.out.println("Numero: " + list.get(i).number);
			System.out.println("Ordenado a: " + list.get(i).PayType);
			System.out.println("--------------------------");
		}
	}
	
	public static void showUser()
	{
		Empregado e;
		
		System.out.print("numero: ");
		int number = User.readInt();
		
		for (int i = 0; i < list.size(); i++)
		{
			if (number == list.get(i).number)
			{
				e = list.get(i);
				
				System.out.println("--------------------------");	
				
				System.out.println("nome: " + e.name);
				System.out.println("numero: " + e.number);
				
				System.out.print("trabalhou: " + e.getDaysWorked() + " dias com ");
				System.out.println(e.getTotal() + " " + e.PayType + "s.");
				
				System.out.println("Media por dia: " + e.getAverage());
				
				System.out.println("ordenado: " + e.calcMonth());
				System.out.println("--------------------------");		
				return;
			}
		}
		System.out.println("Empregado não existe.");
	}
}
